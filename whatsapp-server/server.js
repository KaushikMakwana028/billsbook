const express = require("express");
const cors = require("cors");
const fs = require("fs");
const path = require("path");
const QRCode = require("qrcode");
const { Client, LocalAuth, MessageMedia } = require("whatsapp-web.js");

const app = express();
const port = Number(process.env.PORT || 3001);
const sessionName = process.env.WA_SESSION_NAME || "billsbook-v2";
const authRoot = path.join(__dirname, ".wwebjs_auth");
const sessionPath = path.join(authRoot, `session-${sessionName}`);

app.use(cors());
app.use(express.json({ limit: "1mb" }));

let client = null;
let initializing = false;
let qrImage = "";
let connected = false;
let connectedNumber = "";
let currentState = "starting";
let lastError = "";
let lastEventAt = null;
let recoveryAttempted = false;

function stampState(state, errorMessage = "") {
    currentState = state;
    lastError = errorMessage;
    lastEventAt = new Date().toISOString();
}

function getStatusPayload() {
    return {
        connected,
        qr: qrImage,
        number: connectedNumber,
        state: currentState,
        error: lastError,
        lastEventAt
    };
}

function uniqueCandidates(values) {
    return [...new Set(values.filter(Boolean))];
}

function buildNumberCandidates(rawNumber) {
    const digits = String(rawNumber || "").replace(/\D+/g, "");
    if (!digits) {
        return [];
    }

    const candidates = [digits];

    if (digits.length === 10) {
        candidates.push("91" + digits);
    }

    if (digits.length === 12 && digits.startsWith("91")) {
        candidates.push(digits.slice(2));
    }

    if (digits.length === 11 && digits.startsWith("0")) {
        candidates.push(digits.slice(1));
        candidates.push("91" + digits.slice(1));
    }

    return uniqueCandidates(candidates);
}

async function resolveNumberId(rawNumber) {
    const candidates = buildNumberCandidates(rawNumber);

    for (const candidate of candidates) {
        const numberId = await client.getNumberId(candidate);
        if (numberId && numberId._serialized) {
            return {
                candidate,
                numberId
            };
        }
    }

    return null;
}

function buildClient() {
    return new Client({
        authStrategy: new LocalAuth({
            clientId: sessionName,
            dataPath: authRoot
        }),
        takeoverOnConflict: true,
        takeoverTimeoutMs: 15000,
        authTimeoutMs: 60000,
        webVersionCache: {
            type: "local"
        },
        puppeteer: {
            headless: true,
            args: ["--no-sandbox", "--disable-setuid-sandbox", "--disable-dev-shm-usage"]
        }
    });
}

async function getBrowserPage() {
    if (!client || !client.pupBrowser) {
        throw new Error("WhatsApp browser is not ready");
    }

    const page = await client.pupBrowser.newPage();
    await page.setViewport({
        width: 1200,
        height: 1800,
        deviceScaleFactor: 2
    });

    return page;
}

function bindClientEvents(instance) {
    instance.on("loading_screen", (percent, message) => {
        stampState("loading", `${message || "Loading"} ${percent || 0}%`);
    });

    instance.on("qr", async (qr) => {
        try {
            qrImage = await QRCode.toDataURL(qr);
            connected = false;
            connectedNumber = "";
            stampState("qr_ready");
            console.log("WhatsApp QR generated");
        } catch (error) {
            stampState("error", error.message || "Failed to generate QR");
        }
    });

    instance.on("authenticated", () => {
        stampState("authenticated");
        console.log("WhatsApp authenticated");
    });

    instance.on("ready", () => {
        connected = true;
        qrImage = "";
        connectedNumber = instance.info && instance.info.wid ? instance.info.wid.user || "" : "";
        stampState("connected");
        console.log("WhatsApp connected");
    });

    instance.on("disconnected", (reason) => {
        connected = false;
        connectedNumber = "";
        qrImage = "";
        stampState("disconnected", String(reason || "Disconnected"));
        console.error("WhatsApp disconnected:", reason);
    });

    instance.on("auth_failure", (message) => {
        connected = false;
        connectedNumber = "";
        qrImage = "";
        stampState("auth_failure", String(message || "Authentication failure"));
        console.error("WhatsApp auth failure:", message);
    });
}

async function destroyClient() {
    if (!client) {
        return;
    }

    try {
        client.removeAllListeners();
        await client.destroy();
    } catch (error) {
        console.error("Failed to destroy client:", error.message || error);
    } finally {
        client = null;
    }
}

async function initializeClient(forceFresh = false) {
    if (initializing) {
        return;
    }

    initializing = true;
    recoveryAttempted = forceFresh ? true : recoveryAttempted;
    stampState(forceFresh ? "resetting" : "initializing");

    try {
        await destroyClient();

        connected = false;
        connectedNumber = "";
        qrImage = "";

        if (forceFresh && fs.existsSync(authRoot)) {
            fs.rmSync(sessionPath, { recursive: true, force: true });
        }

        client = buildClient();
        bindClientEvents(client);

        await client.initialize();
        recoveryAttempted = false;
        if (currentState === "initializing" || currentState === "resetting") {
            stampState("awaiting_qr");
        }
    } catch (error) {
        const errorMessage = error && error.message ? error.message : "WhatsApp initialization failed";
        const lockError = /browser is already running|userDataDir|SingletonLock|session-billsbook/i.test(errorMessage);

        if (lockError && !forceFresh && !recoveryAttempted) {
            recoveryAttempted = true;
            stampState("recovering", "Refreshing WhatsApp session...");
            console.warn("WhatsApp session lock detected. Retrying with a fresh session.");
            initializing = false;
            await initializeClient(true);
            return;
        }

        stampState("error", error.message || "WhatsApp initialization failed");
        console.error("WhatsApp initialization failed:", error);
    } finally {
        initializing = false;
    }
}

app.get("/qr", (req, res) => {
    res.json(getStatusPayload());
});

app.get("/health", (req, res) => {
    res.json({
        status: "ok",
        ...getStatusPayload()
    });
});

app.post("/reset", async (req, res) => {
    await initializeClient(true);
    res.json({
        status: "reset",
        ...getStatusPayload()
    });
});

app.post("/disconnect", async (req, res) => {
    try {
        if (client) {
            try {
                await client.logout();
            } catch (error) {
                console.error("WhatsApp logout failed:", error.message || error);
            }
        }

        await destroyClient();

        if (fs.existsSync(sessionPath)) {
            fs.rmSync(sessionPath, { recursive: true, force: true });
        }

        connected = false;
        connectedNumber = "";
        qrImage = "";
        stampState("disconnected");

        await initializeClient(true);

        res.json({
            status: "disconnected",
            ...getStatusPayload()
        });
    } catch (error) {
        stampState("error", error.message || "Failed to disconnect WhatsApp");
        res.status(500).json({
            status: "error",
            message: error.message || "Failed to disconnect WhatsApp",
            ...getStatusPayload()
        });
    }
});

app.post("/render-invoice", async (req, res) => {
    const html = String(req.body.html || "").trim();
    if (!html) {
        return res.status(422).send("html is required");
    }

    let page = null;

    try {
        page = await getBrowserPage();
        await page.setContent(html, {
            waitUntil: ["domcontentloaded", "networkidle0"],
            timeout: 20000
        });
        await page.addStyleTag({
            content: `
                * { animation: none !important; transition: none !important; }
                body { padding: 0 !important; background: #ffffff !important; }
                .invoice-wrap { margin: 0 auto !important; }
            `
        });
        await page.waitForSelector(".invoice-wrap", { timeout: 10000 });

        const invoiceElement = await page.$(".invoice-wrap");
        if (!invoiceElement) {
            throw new Error("Invoice layout not found");
        }

        const png = await invoiceElement.screenshot({
            type: "png"
        });

        res.setHeader("Content-Type", "image/png");
        return res.send(png);
    } catch (error) {
        console.error("Invoice render failed:", error.message || error);
        return res.status(500).json({
            status: "error",
            message: error.message || "invoice_render_failed"
        });
    } finally {
        if (page) {
            try {
                await page.close();
            } catch (error) {
                console.error("Failed to close invoice render page:", error.message || error);
            }
        }
    }
});

app.post("/send", async (req, res) => {
    if (!connected || !client) {
        return res.json({
            status: "not_connected"
        });
    }

    const number = String(req.body.number || "").replace(/\D+/g, "");
    const message = String(req.body.message || "").trim();
    const mediaPath = String(req.body.media_path || "").trim();
    const mediaCaption = String(req.body.media_caption || "").trim();

    if (!number || !message) {
        return res.status(422).json({
            status: "error",
            message: "number and message are required"
        });
    }

    try {
        const resolvedRecipient = await resolveNumberId(number);

        if (!resolvedRecipient || !resolvedRecipient.numberId || !resolvedRecipient.numberId._serialized) {
            return res.status(422).json({
                status: "error",
                message: "This WhatsApp number is not available."
            });
        }

        if (mediaPath && fs.existsSync(mediaPath)) {
            const media = MessageMedia.fromFilePath(mediaPath);
            await client.sendMessage(resolvedRecipient.numberId._serialized, media, {
                caption: mediaCaption || message
            });

            if (message && mediaCaption !== message) {
                await client.sendMessage(resolvedRecipient.numberId._serialized, message);
            }
        } else {
            await client.sendMessage(resolvedRecipient.numberId._serialized, message);
        }

        return res.json({
            status: "sent",
            recipient: resolvedRecipient.candidate
        });
    } catch (error) {
        stampState("error", error.message || "failed_to_send");
        return res.status(500).json({
            status: "error",
            message: error.message || "failed_to_send"
        });
    }
});

const server = app.listen(port, async () => {
    console.log(`WhatsApp API running on port ${port}`);
    await initializeClient(false);
});

server.on("error", (error) => {
    if (error && error.code === "EADDRINUSE") {
        console.error(`Port ${port} is already in use. Stop the existing process or run with another port.`);
        process.exit(1);
        return;
    }

    console.error("WhatsApp API failed to start:", error);
    process.exit(1);
});

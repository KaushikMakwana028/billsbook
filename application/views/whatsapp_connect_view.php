<div class="page-wrapper">
    <div class="page-content">
        <style>
            .wa-shell {
                max-width: 1240px;
            }

            .wa-card,
            .wa-status-card {
                border: 1px solid #e2e8f0;
                border-radius: 28px;
                background: #fff;
                box-shadow: 0 18px 48px rgba(15, 23, 42, 0.08);
            }

            .wa-card {
                overflow: hidden;
            }

            .wa-banner {
                background: linear-gradient(90deg, #0b5d4f 0%, #25d366 100%);
                color: #fff;
                padding: 1rem 1.5rem;
                font-weight: 700;
            }

            .wa-body {
                padding: 2rem;
            }

            .wa-grid {
                display: grid;
                grid-template-columns: 1.05fr 0.95fr;
                gap: 1.5rem;
            }

            .wa-hero-title {
                font-size: 2rem;
                font-weight: 800;
                color: #0f172a;
            }

            .wa-hero-copy {
                color: #475569;
                margin-top: 0.75rem;
                max-width: 720px;
            }

            .wa-pill {
                display: inline-flex;
                align-items: center;
                gap: 0.45rem;
                padding: 0.55rem 0.95rem;
                border-radius: 999px;
                background: #ecfdf5;
                color: #15803d;
                font-weight: 700;
            }

            .wa-points {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 1rem;
                margin-top: 1.6rem;
            }

            .wa-point {
                border: 1px solid #e2e8f0;
                border-radius: 20px;
                padding: 1rem;
                background: #f8fafc;
            }

            .wa-qr-frame {
                width: 280px;
                height: 280px;
                margin: 0 auto 1rem;
                border-radius: 28px;
                border: 1px solid #dbeafe;
                background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 16px;
                box-shadow: inset 0 0 0 1px #eff6ff;
            }

            .wa-phone-shell {
                border-radius: 34px;
                background: linear-gradient(180deg, #ffffff 0%, #f8fffb 100%);
                padding: 14px;
                border: 1px solid #d6f5e2;
                box-shadow: 0 24px 60px rgba(15, 23, 42, 0.12);
            }

            .wa-phone-inner {
                border-radius: 26px;
                background: linear-gradient(180deg, #f7fffa 0%, #effcf5 100%);
                padding: 1.1rem 1rem 1.25rem;
                border: 1px solid #e1f7ea;
            }

            .wa-mobile-head {
                color: #0f172a;
                font-weight: 700;
                text-align: left;
                margin-bottom: 1rem;
            }

            .wa-mobile-copy {
                color: #4b5563;
                font-size: 0.95rem;
                line-height: 1.5;
                margin-bottom: 1rem;
            }

            .wa-qr-frame img {
                width: 100%;
                height: 100%;
                object-fit: contain;
            }

            .wa-empty {
                color: #64748b;
                text-align: center;
                font-weight: 600;
            }

            .wa-status-chip {
                display: inline-flex;
                align-items: center;
                gap: 0.45rem;
                padding: 0.55rem 0.9rem;
                border-radius: 999px;
                font-weight: 700;
            }

            .wa-status-chip.is-connected {
                background: #dcfce7;
                color: #166534;
            }

            .wa-status-chip.is-waiting {
                background: #fef3c7;
                color: #92400e;
            }

            .wa-status-chip.is-error {
                background: #fee2e2;
                color: #b91c1c;
            }

            .wa-steps {
                border: 1px solid #e2e8f0;
                border-radius: 22px;
                background: #f8fafc;
                padding: 1.2rem;
                margin-top: 1.2rem;
            }

            .wa-link-another {
                margin-top: 1rem;
                border: none;
                background: linear-gradient(90deg, #128c7e 0%, #25d366 100%);
                color: #fff;
                border-radius: 999px;
                padding: 0.9rem 1.35rem;
                font-weight: 700;
                box-shadow: 0 16px 30px rgba(18, 140, 126, 0.22);
            }

            .wa-step + .wa-step {
                margin-top: 1rem;
            }

            .wa-step-label {
                font-size: 0.78rem;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                color: #64748b;
                font-weight: 700;
            }

            @media (max-width: 991.98px) {
                .wa-grid,
                .wa-points {
                    grid-template-columns: 1fr;
                }

                .wa-body {
                    padding: 1.25rem;
                }

                .wa-hero-title {
                    font-size: 1.6rem;
                }

                .wa-qr-frame {
                    width: 240px;
                    height: 240px;
                }

                .wa-phone-shell {
                    max-width: 320px;
                    margin-inline: auto;
                }
            }
        </style>

        <div class="row wa-shell g-4">
            <div class="col-12">
                <div class="wa-card">
                    <div class="wa-banner">Connect once, then invoices can be sent from the linked WhatsApp account.</div>
                    <div class="wa-body">
                        <div class="wa-pill"><i class='bx bxl-whatsapp'></i> WhatsApp Integration</div>
                        <div class="wa-hero-title mt-3">Use your CRM URL for QR and sending flow</div>
                        <div class="wa-hero-copy">
                            Connect WhatsApp once and send invoice messages directly from your linked account.
                            If WhatsApp is not connected, Bills Book will still open the normal WhatsApp share link.
                        </div>

                        <div class="wa-points">
                            <div class="wa-point">
                                <h5 class="mb-2">Quick Setup</h5>
                                <p class="text-muted mb-0">Open this page, scan the QR code, and your WhatsApp is ready for invoice sharing.</p>
                            </div>
                            <div class="wa-point">
                                <h5 class="mb-2">Connected Account</h5>
                                <p class="text-muted mb-0">After scanning, invoice messages are sent from the WhatsApp account you linked here.</p>
                            </div>
                            <div class="wa-point">
                                <h5 class="mb-2">Always Works</h5>
                                <p class="text-muted mb-0">If WhatsApp is not connected, the app automatically falls back to the normal WhatsApp sharing flow.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="wa-status-card">
                    <div class="wa-body">
                        <div class="wa-grid">
                            <div>
                                <h3 class="mb-2">Scan QR to connect WhatsApp</h3>
                                <p class="text-muted mb-0">Open WhatsApp on your phone, go to <strong>Linked devices</strong>, and scan the QR below.</p>

                                <div class="wa-steps">
                                    <div class="wa-step">
                                        <div class="wa-step-label">Step 1</div>
                                        <div>Open WhatsApp on your mobile.</div>
                                    </div>
                                    <div class="wa-step">
                                        <div class="wa-step-label">Step 2</div>
                                        <div>Go to <strong>Linked devices</strong> and choose <strong>Link a device</strong>.</div>
                                    </div>
                                    <div class="wa-step">
                                        <div class="wa-step-label">Step 3</div>
                                        <div>Scan this QR code. After connection, invoices can be shared from the sales page.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <div id="waStatusChip" class="wa-status-chip is-waiting">Checking WhatsApp status...</div>
                                <div class="wa-phone-shell mt-3">
                                    <div class="wa-phone-inner">
                                        <div class="wa-mobile-head">Scan QR code</div>
                                        <div class="wa-mobile-copy">Open WhatsApp on your phone and use Linked devices to scan this QR code.</div>
                                        <div class="wa-qr-frame">
                                            <img id="waQrImage" src="" alt="WhatsApp QR" style="display:none;">
                                            <div id="waQrEmpty" class="wa-empty">Waiting for QR code...</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="fw-semibold" id="waStatusText">Starting status check...</div>
                                <div class="text-muted mt-2" id="waNumberText"></div>
                                <div class="text-danger mt-2" id="waErrorText"></div>
                                <button type="button" id="waDisconnectBtn" class="wa-link-another" style="display:none;">Connect Another WhatsApp</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            (function() {
                var statusUrl = "<?= htmlspecialchars($whatsappStatusUrl ?? '') ?>";
                var statusChip = document.getElementById('waStatusChip');
                var statusText = document.getElementById('waStatusText');
                var numberText = document.getElementById('waNumberText');
                var errorText = document.getElementById('waErrorText');
                var qrImage = document.getElementById('waQrImage');
                var qrEmpty = document.getElementById('waQrEmpty');
                var resetUrl = "<?= htmlspecialchars($whatsappResetUrl ?? '') ?>";
                var disconnectUrl = "<?= htmlspecialchars($whatsappDisconnectUrl ?? '') ?>";
                var disconnectButton = document.getElementById('waDisconnectBtn');
                var busy = false;
                var autoResetAttempted = false;
                var loadingSince = Date.now();
                var lastState = '';

                function setChip(cssClass, text) {
                    statusChip.className = 'wa-status-chip ' + cssClass;
                    statusChip.textContent = text;
                }

                function showUnavailable(message) {
                    setChip('is-waiting', 'Preparing');
                    statusText.textContent = message;
                    numberText.textContent = '';
                    qrImage.style.display = 'none';
                    qrEmpty.style.display = 'block';
                    qrEmpty.textContent = 'Preparing QR code...';
                }

                function updateView(data) {
                    if (data.force_logout && data.logout_url) {
                        window.location.href = data.logout_url;
                        return;
                    }

                    if (data.status !== 'ok') {
                        showUnavailable('Preparing WhatsApp connection...');
                        errorText.textContent = '';
                        return;
                    }

                    errorText.textContent = '';

                    if (data.connected) {
                        setChip('is-connected', 'Connected');
                        statusText.textContent = 'WhatsApp is connected and ready to send invoices.';
                        numberText.textContent = data.number ? ('Connected number: ' + data.number) : '';
                        qrImage.style.display = 'none';
                        qrEmpty.style.display = 'block';
                        qrEmpty.textContent = 'WhatsApp linked successfully.';
                        disconnectButton.style.display = 'inline-block';
                        loadingSince = Date.now();
                        return;
                    }

                    setChip('is-waiting', 'Waiting for scan');
                    numberText.textContent = '';
                    disconnectButton.style.display = 'none';

                    if (data.state === 'qr_ready' && data.qr) {
                        statusText.textContent = 'Scan the QR code using WhatsApp Linked devices.';
                        qrImage.src = data.qr;
                        qrImage.style.display = 'block';
                        qrEmpty.style.display = 'none';
                        loadingSince = Date.now();
                        return;
                    }

                    if (data.state === 'authenticated') {
                        setChip('is-waiting', 'Finishing');
                        statusText.textContent = 'WhatsApp scan accepted. Finishing connection...';
                        qrImage.style.display = 'none';
                        qrEmpty.style.display = 'block';
                        qrEmpty.textContent = 'Finishing connection...';
                        return;
                    } else if (data.state === 'initializing' || data.state === 'awaiting_qr') {
                        statusText.textContent = 'Preparing WhatsApp...';
                    } else if (data.state === 'loading') {
                        setChip('is-waiting', 'Connecting');
                        statusText.textContent = 'Connecting WhatsApp. Please keep your phone online...';
                        qrImage.style.display = 'none';
                        qrEmpty.style.display = 'block';
                        qrEmpty.textContent = 'Connecting WhatsApp...';
                        return;
                    } else if (data.state === 'recovering' || data.state === 'resetting') {
                        showUnavailable('Refreshing WhatsApp connection...');
                        errorText.textContent = '';
                        return;
                    } else if (data.state === 'auth_failure') {
                        showUnavailable('Refreshing WhatsApp connection...');
                        errorText.textContent = '';
                        triggerAutoReset();
                        return;
                    } else if (data.state === 'disconnected') {
                        showUnavailable('Reconnecting WhatsApp...');
                        errorText.textContent = '';
                        triggerAutoReset();
                        return;
                    } else if (data.state === 'error') {
                        showUnavailable('Refreshing WhatsApp connection...');
                        errorText.textContent = '';
                        triggerAutoReset();
                        return;
                    } else {
                        statusText.textContent = 'Generating QR code...';
                    }

                    if ((data.state === 'initializing' || data.state === 'awaiting_qr' || !data.state) && Date.now() - loadingSince > 20000) {
                        triggerAutoReset();
                    }

                    qrImage.style.display = 'none';
                    qrEmpty.style.display = 'block';
                    qrEmpty.textContent = 'Generating QR code...';
                }

                function triggerAutoReset() {
                    if (busy || autoResetAttempted) {
                        return;
                    }

                    autoResetAttempted = true;
                    resetSession();
                }

                function loadStatus() {
                    if (busy) {
                        return;
                    }

                    fetch(statusUrl, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(data) {
                        if (data.state && data.state !== lastState) {
                            lastState = data.state;
                            loadingSince = Date.now();
                        }
                        updateView(data);
                    })
                    .catch(function() {
                        showUnavailable('Preparing WhatsApp connection...');
                        errorText.textContent = '';
                    });
                }

                function resetSession() {
                    if (busy) {
                        return;
                    }

                    busy = true;
                    loadingSince = Date.now();
                    errorText.textContent = '';
                    statusText.textContent = 'Refreshing WhatsApp connection...';
                    numberText.textContent = '';
                    setChip('is-waiting', 'Please wait');

                    fetch(resetUrl, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(data) {
                        updateView(data);
                    })
                    .catch(function() {
                        showUnavailable('Preparing WhatsApp connection...');
                        errorText.textContent = '';
                    })
                    .finally(function() {
                        busy = false;
                        setTimeout(loadStatus, 1500);
                    });
                }

                function disconnectSession() {
                    if (busy) {
                        return;
                    }

                    busy = true;
                    disconnectButton.disabled = true;
                    errorText.textContent = '';
                    setChip('is-waiting', 'Please wait');
                    statusText.textContent = 'Disconnecting WhatsApp...';
                    numberText.textContent = '';

                    fetch(disconnectUrl, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(data) {
                        autoResetAttempted = false;
                        updateView(data);
                    })
                    .catch(function() {
                        errorText.textContent = 'Could not disconnect WhatsApp right now.';
                    })
                    .finally(function() {
                        busy = false;
                        disconnectButton.disabled = false;
                        setTimeout(loadStatus, 1500);
                    });
                }

                disconnectButton.addEventListener('click', disconnectSession);
                loadStatus();
                setInterval(loadStatus, 1000);
                window.addEventListener('focus', loadStatus);
            })();
        </script>
    </div>
</div>

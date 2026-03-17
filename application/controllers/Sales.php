<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sales extends My_Controller
{
    private $whatsappConfig = null;

    public function index()
    {
        $adminId = (int) ($this->admin['user_id'] ?? 0);
        $data = $this->buildBaseData($adminId);
        $filters = [
            'search' => trim((string) $this->input->get('search', true)),
            'date_from' => trim((string) $this->input->get('date_from', true)),
            'date_to' => trim((string) $this->input->get('date_to', true))
        ];
        $data['sales'] = $this->getSales($adminId, $filters);
        $data['filters'] = $filters;
        $data['pageTitle'] = 'Sales';

        $this->load->view('header', $data);
        $this->load->view('sales_view', $data);
        $this->load->view('footer', $data);
    }

    public function add()
    {
        $adminId = (int) ($this->admin['user_id'] ?? 0);
        $data = $this->buildBaseData($adminId);
        $data['products'] = $this->getSellableProducts($adminId);
        $data['pageTitle'] = 'Create Sale';

        $this->load->view('header', $data);
        $this->load->view('sales_add', $data);
        $this->load->view('footer', $data);
    }

    public function whatsapp_connect()
    {
        $adminId = (int) ($this->admin['user_id'] ?? 0);
        $data = $this->buildBaseData($adminId);
        $data['pageTitle'] = 'WhatsApp Connect';
        $data['whatsappStatusUrl'] = base_url('whatsapp/status');
        $data['whatsappResetUrl'] = base_url('whatsapp/reset');
        $data['whatsappDisconnectUrl'] = base_url('whatsapp/disconnect');

        $this->load->view('header', $data);
        $this->load->view('whatsapp_connect_view', $data);
        $this->load->view('footer', $data);
    }

    public function whatsapp_status()
    {
        $response = $this->callWhatsappService('GET', '/qr');
        $serviceBody = is_array($response['body'] ?? null) ? $response['body'] : [];
        $connectedNumber = (string) ($serviceBody['number'] ?? '');
        $serviceState = (string) ($serviceBody['state'] ?? '');
        $forceLogout = false;

        if (!empty($serviceBody['connected'])) {
            $this->session->set_userdata('whatsapp_linked', [
                'linked' => true,
                'number' => $connectedNumber
            ]);
        } else {
            $whatsappLinked = (array) $this->session->userdata('whatsapp_linked');
            if (!empty($whatsappLinked['linked']) && in_array($serviceState, ['disconnected', 'auth_failure'], true)) {
                $forceLogout = true;
                $this->session->unset_userdata('whatsapp_linked');
                $this->session->unset_userdata('admin');
                $this->session->sess_destroy();
            }
        }

        $payload = [
            'status' => !empty($response['ok']) ? 'ok' : 'error',
            'connected' => !empty($serviceBody['connected']),
            'qr' => (string) ($serviceBody['qr'] ?? ''),
            'number' => $connectedNumber,
            'state' => $serviceState,
            'error_detail' => (string) ($serviceBody['error'] ?? ''),
            'last_event_at' => (string) ($serviceBody['lastEventAt'] ?? ''),
            'force_logout' => $forceLogout,
            'logout_url' => $forceLogout ? base_url('logout') : '',
            'message' => !empty($response['ok'])
                ? ''
                : 'WhatsApp service is not running. Start the Node service in whatsapp-server.'
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($payload));
    }

    public function whatsapp_reset()
    {
        $response = $this->callWhatsappService('POST', '/reset');
        $serviceBody = is_array($response['body'] ?? null) ? $response['body'] : [];

        $payload = [
            'status' => !empty($response['ok']) ? 'ok' : 'error',
            'connected' => !empty($serviceBody['connected']),
            'qr' => (string) ($serviceBody['qr'] ?? ''),
            'number' => (string) ($serviceBody['number'] ?? ''),
            'state' => (string) ($serviceBody['state'] ?? ''),
            'error_detail' => (string) ($serviceBody['error'] ?? ''),
            'last_event_at' => (string) ($serviceBody['lastEventAt'] ?? ''),
            'message' => !empty($response['ok'])
                ? 'WhatsApp session reset requested.'
                : 'Unable to reset WhatsApp session from the CRM.'
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($payload));
    }

    public function whatsapp_disconnect()
    {
        $response = $this->callWhatsappService('POST', '/disconnect');
        $serviceBody = is_array($response['body'] ?? null) ? $response['body'] : [];
        $this->session->unset_userdata('whatsapp_linked');

        $payload = [
            'status' => !empty($response['ok']) ? 'ok' : 'error',
            'connected' => !empty($serviceBody['connected']),
            'qr' => (string) ($serviceBody['qr'] ?? ''),
            'number' => (string) ($serviceBody['number'] ?? ''),
            'state' => (string) ($serviceBody['state'] ?? ''),
            'error_detail' => (string) ($serviceBody['error'] ?? ''),
            'last_event_at' => (string) ($serviceBody['lastEventAt'] ?? ''),
            'message' => !empty($response['ok'])
                ? 'WhatsApp disconnected. Scan the new QR code to connect another account.'
                : 'Unable to disconnect WhatsApp right now.'
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($payload));
    }

    public function send_whatsapp($saleId)
    {
        $adminId = (int) ($this->admin['user_id'] ?? 0);
        $sale = $this->getSaleForWhatsapp((int) $saleId, $adminId);

        if (empty($sale)) {
            show_404();
            return;
        }

        $fallbackUrl = $this->buildWhatsappFallbackUrl($sale);
        $responsePayload = [
            'status' => 'error',
            'message' => 'WhatsApp message could not be prepared.',
            'fallback_url' => $fallbackUrl
        ];

        $sendResult = $this->sendSaleInvoiceWhatsapp($sale);
        if ($sendResult['status'] === 'sent') {
            $responsePayload = [
                'status' => 'sent',
                'message' => $sendResult['message'],
                'fallback_url' => '',
                'recipient' => (string) ($sendResult['recipient'] ?? '')
            ];
        } elseif ($sendResult['status'] === 'fallback') {
            $responsePayload = [
                'status' => 'fallback',
                'message' => $sendResult['message'],
                'fallback_url' => $fallbackUrl
            ];
        } else {
            $responsePayload['message'] = $sendResult['message'];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($responsePayload));
    }

    public function customer_lookup()
    {
        $adminId = (int) ($this->admin['user_id'] ?? 0);
        $phone = preg_replace('/\D+/', '', (string) $this->input->get('phone', true));
        $customer = null;

        if ($phone !== '') {
            $customer = $this->db
                ->where('admin_id', $adminId)
                ->where('phone', $phone)
                ->where('isActive', 1)
                ->get('customers')
                ->row_array();
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => $customer ? 'found' : 'not_found',
                'customer' => $customer
            ]));
    }

    public function store()
    {
        $adminId = (int) ($this->admin['user_id'] ?? 0);
        $products = $this->getSellableProducts($adminId);

        $this->form_validation->set_rules('customer_name', 'Customer Name', 'required|trim');
        $this->form_validation->set_rules('customer_phone', 'Customer Phone', 'required|regex_match[/^[0-9]{10,15}$/]');
        $this->form_validation->set_rules('sale_discount', 'Sale Discount', 'trim|callback_valid_discount');

        $productIds = $this->input->post('product_id');
        $quantities = $this->input->post('item_quantity');
        $itemDiscounts = $this->input->post('item_discount');

        $hasValidItems = $this->hasValidItems($productIds, $quantities);
        if ($this->form_validation->run() === false || !$hasValidItems) {
            $data = $this->buildBaseData($adminId);
            $data['products'] = $products;
            $data['pageTitle'] = 'Create Sale';

            if (!$hasValidItems) {
                $data['saleError'] = 'Add at least one product with a valid quantity.';
            }

            $this->load->view('header', $data);
            $this->load->view('sales_add', $data);
            $this->load->view('footer', $data);
            return;
        }

        $saleItems = [];
        $subtotal = 0.0;
        $lineDiscountTotal = 0.0;

        foreach ((array) $productIds as $index => $productId) {
            $productId = (int) $productId;
            $quantity = (int) ($quantities[$index] ?? 0);
            $discountPercent = $this->normalizePercentage((string) ($itemDiscounts[$index] ?? '0'));

            if ($productId <= 0 || $quantity <= 0 || $discountPercent === null) {
                continue;
            }

            $product = $this->getOwnedProduct($productId, $adminId);
            if (empty($product)) {
                $this->session->set_flashdata('error', 'One selected product is invalid.');
                redirect('sales/add');
                return;
            }

            if ((int) ($product['quantity'] ?? 0) < $quantity) {
                $this->session->set_flashdata('error', 'Insufficient stock for ' . $product['name'] . '. Available quantity: ' . (int) ($product['quantity'] ?? 0));
                redirect('sales/add');
                return;
            }

            $lineBase = (float) $product['price'] * $quantity;
            $discount = ($lineBase * $discountPercent) / 100;
            $lineTotal = $lineBase - $discount;

            $subtotal += $lineBase;
            $lineDiscountTotal += $discount;

            $saleItems[] = [
                'product' => $product,
                'quantity' => $quantity,
                'unit_price' => (float) $product['price'],
                'discount_amount' => $discount,
                'line_total' => $lineTotal
            ];
        }

        if (empty($saleItems)) {
            $this->session->set_flashdata('error', 'Add at least one valid item.');
            redirect('sales/add');
            return;
        }

        $saleDiscountPercent = $this->normalizePercentage((string) $this->input->post('sale_discount'));
        if ($saleDiscountPercent === null) {
            $saleDiscountPercent = 0.0;
        }
        $saleDiscount = (max(0, $subtotal - $lineDiscountTotal) * $saleDiscountPercent) / 100;
        $grandTotal = $subtotal - $lineDiscountTotal - $saleDiscount;
        $customerId = $this->findOrCreateCustomer($adminId);
        $invoiceNumber = $this->generateInvoiceNumber($adminId);
        $notes = trim((string) $this->input->post('notes'));
        $saleDateValue = date('Y-m-d H:i:s');

        $this->db->trans_begin();

        $this->db->insert('sales', [
            'admin_id' => $adminId,
            'customer_id' => $customerId,
            'invoice_number' => $invoiceNumber,
            'sale_date' => $saleDateValue,
            'subtotal' => $subtotal,
            'discount_amount' => $lineDiscountTotal + $saleDiscount,
            'grand_total' => $grandTotal,
            'notes' => $notes,
            'invoice_file' => '',
            'created_on' => date('Y-m-d')
        ]);
        $saleId = (int) $this->db->insert_id();

        foreach ($saleItems as $item) {
            $product = $item['product'];

            $this->db->insert('sale_items', [
                'sale_id' => $saleId,
                'product_id' => (int) $product['id'],
                'product_name' => $product['name'],
                'product_image' => $product['image'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'discount_amount' => $item['discount_amount'],
                'line_total' => $item['line_total'],
                'created_on' => date('Y-m-d')
            ]);

            $remainingQuantity = (int) $product['quantity'] - $item['quantity'];
            $this->db
                ->where('id', (int) $product['id'])
                ->where('admin_id', $adminId)
                ->update('product', ['quantity' => $remainingQuantity]);
        }

        $customer = $this->getCustomer($customerId, $adminId);
        $invoiceFile = $this->generateInvoicePreviewImage(
            $invoiceNumber,
            $saleId,
            $customer,
            $saleItems,
            [
                'subtotal' => $subtotal,
                'line_discount_total' => $lineDiscountTotal,
                'sale_discount' => $saleDiscount,
                'grand_total' => $grandTotal,
                'sale_date' => $saleDateValue,
                'notes' => $notes
            ]
        );

        $this->db
            ->where('id', $saleId)
            ->where('admin_id', $adminId)
            ->update('sales', ['invoice_file' => $invoiceFile]);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Sale could not be saved.');
            redirect('sales/add');
            return;
        }

        $this->db->trans_commit();
        $whatsappResult = $this->sendSaleInvoiceWhatsapp([
            'customer_name' => $customer['name'] ?? '',
            'customer_phone' => $customer['phone'] ?? '',
            'invoice_number' => $invoiceNumber,
            'grand_total' => $grandTotal,
            'invoice_file' => $invoiceFile
        ]);

        $this->session->set_flashdata('success', 'Sale saved and invoice generated successfully.');
        $this->session->set_flashdata('whatsapp_notice', $whatsappResult);
        $this->session->set_flashdata('latest_sale_actions', [
            'sale_id' => $saleId,
            'customer_name' => $customer['name'] ?? '',
            'customer_phone' => $customer['phone'] ?? '',
            'invoice_number' => $invoiceNumber,
            'grand_total' => $grandTotal,
            'invoice_file' => $invoiceFile,
            'whatsapp_url' => $this->buildWhatsappFallbackUrl([
                'customer_name' => $customer['name'] ?? '',
                'customer_phone' => $customer['phone'] ?? '',
                'invoice_number' => $invoiceNumber,
                'grand_total' => $grandTotal,
                'invoice_file' => $invoiceFile
            ]),
            'send_whatsapp_url' => base_url('sales/send-whatsapp/' . $saleId),
            'business_contact_number' => $this->buildBusinessWhatsappNumber()
        ]);
        redirect('sales');
    }

    public function download($saleId)
    {
        $adminId = (int) ($this->admin['user_id'] ?? 0);
        $sale = $this->db
            ->where('id', (int) $saleId)
            ->where('admin_id', $adminId)
            ->get('sales')
            ->row_array();

        if (empty($sale) || empty($sale['invoice_file'])) {
            show_404();
            return;
        }

        $filePath = FCPATH . ltrim($sale['invoice_file'], '/');
        if (!is_file($filePath)) {
            show_404();
            return;
        }

        header('Content-Description: File Transfer');
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        header('Content-Type: ' . ($extension === 'png' ? 'image/png' : 'application/octet-stream'));
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    }

    private function buildBaseData(int $adminId): array
    {
        return [
            'userName' => $this->admin['user_name'] ?? ($this->admin['name'] ?? 'Admin'),
            'userEmail' => $this->admin['email'] ?? '',
            'businessName' => $this->admin['business_name'] ?? 'Bills Book',
            'userMobile' => $this->admin['mobile'] ?? '',
            'role' => (!empty($this->admin['role']) && (string) $this->admin['role'] !== '1') ? (string) $this->admin['role'] : 'admin',
            'profileImage' => $this->admin['profile_image'] ?? '',
            'profileUrl' => base_url('profile'),
            'adminId' => $adminId
        ];
    }

    private function getSales(int $adminId, array $filters = []): array
    {
        $query = $this->db
            ->select('sales.*, customers.name AS customer_name, customers.phone AS customer_phone, customers.email AS customer_email, customers.address AS customer_address')
            ->from('sales')
            ->join('customers', 'customers.id = sales.customer_id', 'left')
            ->where('sales.admin_id', $adminId);

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query
                ->group_start()
                ->like('sales.invoice_number', $search)
                ->or_like('customers.name', $search)
                ->or_like('customers.phone', $search)
                ->or_like('customers.email', $search)
                ->group_end();
        }

        if (!empty($filters['date_from'])) {
            $query->where('DATE(sales.sale_date) >=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('DATE(sales.sale_date) <=', $filters['date_to']);
        }

        $sales = $query
            ->order_by('sales.id', 'DESC')
            ->get()
            ->result_array();

        foreach ($sales as &$sale) {
            $sale['whatsapp_url'] = $this->buildWhatsappFallbackUrl($sale);
            $sale['send_whatsapp_url'] = base_url('sales/send-whatsapp/' . (int) ($sale['id'] ?? 0));
        }
        unset($sale);

        return $sales;
    }

    private function getSellableProducts(int $adminId): array
    {
        $products = $this->db
            ->where('admin_id', $adminId)
            ->where('isActive', 1)
            ->order_by('name', 'ASC')
            ->get('product')
            ->result_array();

        foreach ($products as &$product) {
            $product['image_url'] = $this->resolveProductImage((string) ($product['image'] ?? ''));
            $product['quantity'] = (int) ($product['quantity'] ?? 0);
            $product['price'] = (float) ($product['price'] ?? 0);
        }
        unset($product);

        return $products;
    }

    private function getOwnedProduct(int $productId, int $adminId): ?array
    {
        $row = $this->db
            ->where('id', $productId)
            ->where('admin_id', $adminId)
            ->where('isActive', 1)
            ->get('product')
            ->row_array();

        return $row ?: null;
    }

    private function getCustomer(int $customerId, int $adminId): ?array
    {
        $row = $this->db
            ->where('id', $customerId)
            ->where('admin_id', $adminId)
            ->get('customers')
            ->row_array();

        return $row ?: null;
    }

    private function findOrCreateCustomer(int $adminId): int
    {
        $phone = preg_replace('/\D+/', '', (string) $this->input->post('customer_phone'));
        $existing = $this->db
            ->where('admin_id', $adminId)
            ->where('phone', $phone)
            ->where('isActive', 1)
            ->get('customers')
            ->row_array();

        $payload = [
            'name' => trim((string) $this->input->post('customer_name')),
            'phone' => $phone,
            'email' => trim((string) $this->input->post('customer_email')),
            'address' => trim((string) $this->input->post('customer_address'))
        ];

        if (!empty($existing)) {
            $this->db
                ->where('id', (int) $existing['id'])
                ->where('admin_id', $adminId)
                ->update('customers', $payload);

            return (int) $existing['id'];
        }

        $payload['admin_id'] = $adminId;
        $payload['isActive'] = 1;
        $payload['created_on'] = date('Y-m-d');

        $this->db->insert('customers', $payload);
        return (int) $this->db->insert_id();
    }

    private function hasValidItems($productIds, $quantities): bool
    {
        if (!is_array($productIds) || !is_array($quantities)) {
            return false;
        }

        foreach ($productIds as $index => $productId) {
            if ((int) $productId > 0 && (int) ($quantities[$index] ?? 0) > 0) {
                return true;
            }
        }

        return false;
    }

    private function generateInvoiceNumber(int $adminId): string
    {
        $count = (int) $this->db
            ->where('admin_id', $adminId)
            ->count_all_results('sales');

        return 'INV-' . $adminId . '-' . date('Ymd') . '-' . str_pad((string) ($count + 1), 4, '0', STR_PAD_LEFT);
    }

    private function generateInvoicePreviewImage(string $invoiceNumber, int $saleId, ?array $customer, array $items, array $totals): string
    {
        $uploadPath = FCPATH . 'uploads/invoices/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $fileName = strtolower($invoiceNumber) . '-sale-' . $saleId . '.png';
        $absolutePath = $uploadPath . $fileName;
        $viewData = [
            'businessName' => $this->admin['business_name'] ?? 'Bills Book',
            'invoiceNumber' => $invoiceNumber,
            'customer' => $customer,
            'items' => $items,
            'totals' => $totals,
            'saleId' => $saleId
        ];

        $html = $this->load->view('invoice', $viewData, true);
        $pngBinary = $this->renderInvoiceHtmlToPng($html);
        if ($pngBinary === '') {
            return '';
        }

        file_put_contents($absolutePath, $pngBinary);
        return 'uploads/invoices/' . $fileName;
    }

    private function renderInvoiceHtmlToPng(string $html): string
    {
        $config = $this->getWhatsappConfig();
        $baseUrl = rtrim((string) ($config['service_url'] ?? ''), '/');
        if ($baseUrl === '') {
            return '';
        }

        $ch = curl_init($baseUrl . '/render-invoice');
        if ($ch === false) {
            return '';
        }

        $payload = json_encode(['html' => $html]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, (int) ($config['timeout'] ?? 10) + 10);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: image/png',
            'Content-Type: application/json'
        ]);

        $rawBody = curl_exec($ch);
        $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($rawBody === false || $httpCode < 200 || $httpCode >= 300 || $rawBody === '') {
            return '';
        }

        return $rawBody;
    }

    private function resolveProductImage(string $image): string
    {
        if ($image === '') {
            return base_url('assets/images/Product_Default.png');
        }

        if (preg_match('#^https?://#i', $image)) {
            return $image;
        }

        if (strpos($image, 'uploads/') === 0 || strpos($image, 'assets/') === 0) {
            return base_url($image);
        }

        return base_url('uploads/product/' . ltrim($image, '/'));
    }

    public function valid_discount($amount): bool
    {
        if ($this->normalizePercentage((string) $amount) === null) {
            $this->form_validation->set_message('valid_discount', 'The {field} field must be between 0 and 100.');
            return false;
        }

        return true;
    }

    private function normalizePercentage(string $amount): ?float
    {
        $cleaned = trim(str_replace(['%', ' '], '', $amount));
        if ($cleaned === '') {
            return 0.0;
        }

        if (!preg_match('/^\d+(\.\d{1,2})?$/', $cleaned)) {
            return null;
        }

        $value = (float) $cleaned;
        if ($value < 0 || $value > 100) {
            return null;
        }

        return $value;
    }

    private function normalizeAmount(string $amount): ?float
    {
        $cleaned = trim(str_replace([',', ' ', 'Rs.', 'RS.', 'rs.', 'â‚¹'], '', $amount));
        if ($cleaned === '') {
            return 0.0;
        }

        if (!preg_match('/^\d+(\.\d{1,2})?$/', $cleaned)) {
            return null;
        }

        return (float) $cleaned;
    }

    // private function buildWhatsappUrl(array $sale): string
    // {
    //     $phone = preg_replace('/\D+/', '', (string) ($sale['customer_phone'] ?? ''));
    //     if ($phone === '') {
    //         return base_url('sales');
    //     }

    //     if (strlen($phone) === 10) {
    //         $phone = '91' . $phone;
    //     } elseif (strpos($phone, '0') === 0 && strlen($phone) === 11) {
    //         $phone = '91' . substr($phone, 1);
    //     }

    //     $customerName = trim((string) ($sale['customer_name'] ?? 'Customer'));
    //     $invoiceNumber = (string) ($sale['invoice_number'] ?? '');
    //     $invoiceAmount = number_format((float) ($sale['grand_total'] ?? 0), 2);
    //     $invoiceUrl = base_url((string) ($sale['invoice_file'] ?? ''));
    //     $message = "Hi {$customerName},\n"
    //         . "Your invoice {$invoiceNumber} is ready.\n"
    //         . "Amount: Rs. {$invoiceAmount}\n"
    //         . "View invoice: {$invoiceUrl}\n"
    //         . "Thank you for your business.";

    //     return 'https://web.whatsapp.com/send?phone=' . $phone . '&text=' . rawurlencode($message);
    // }

    private function getSaleForWhatsapp(int $saleId, int $adminId): ?array
    {
        $row = $this->db
            ->select('sales.*, customers.name AS customer_name, customers.phone AS customer_phone')
            ->from('sales')
            ->join('customers', 'customers.id = sales.customer_id', 'left')
            ->where('sales.id', $saleId)
            ->where('sales.admin_id', $adminId)
            ->get()
            ->row_array();

        return $row ?: null;
    }

    private function sendSaleInvoiceWhatsapp(array $sale): array
    {
        $phone = $this->normalizeWhatsappPhone((string) ($sale['customer_phone'] ?? ''));
        if ($phone === '') {
            return [
                'status' => 'error',
                'message' => 'Customer phone number is missing or invalid.'
            ];
        }

        $serviceResponse = $this->callWhatsappService('POST', '/send', [
            'number' => $phone,
            'message' => $this->buildWhatsappMessage($sale),
            'media_path' => $this->resolveInvoicePreviewAbsolutePath($sale),
            'media_caption' => $this->buildWhatsappCaption($sale)
        ]);

        if (empty($serviceResponse['ok']) || !is_array($serviceResponse['body'] ?? null)) {
            return [
                'status' => 'fallback',
                'message' => 'WhatsApp service is unavailable. Opening the browser fallback instead.'
            ];
        }

        $status = (string) ($serviceResponse['body']['status'] ?? '');
        if ($status === 'sent') {
            return [
                'status' => 'sent',
                'message' => 'Invoice sent from the connected WhatsApp account.',
                'recipient' => (string) ($serviceResponse['body']['recipient'] ?? $phone)
            ];
        }

        if ($status === 'not_connected') {
            return [
                'status' => 'fallback',
                'message' => 'WhatsApp is not connected, so the invoice was saved but not auto-sent. Link WhatsApp to send automatically.',
                'recipient' => $phone
            ];
        }

        return [
            'status' => 'error',
            'message' => (string) ($serviceResponse['body']['message'] ?? 'WhatsApp service returned an unexpected response.')
        ];
    }

    private function getWhatsappConfig(): array
    {
        if ($this->whatsappConfig !== null) {
            return $this->whatsappConfig;
        }

        $this->config->load('whatsapp', true);
        $config = (array) $this->config->item('whatsapp', 'whatsapp');

        $defaults = [
            'service_url' => 'http://127.0.0.1:3001',
            'timeout' => 10,
            'country_code' => '91'
        ];

        $this->whatsappConfig = array_merge($defaults, $config);
        return $this->whatsappConfig;
    }

    private function callWhatsappService(string $method, string $path, array $payload = []): array
    {
        $config = $this->getWhatsappConfig();
        $baseUrl = rtrim((string) ($config['service_url'] ?? ''), '/');
        if ($baseUrl === '') {
            return ['ok' => false, 'body' => null];
        }

        $url = $baseUrl . '/' . ltrim($path, '/');
        $ch = curl_init($url);
        if ($ch === false) {
            return ['ok' => false, 'body' => null];
        }

        $headers = ['Accept: application/json'];
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
        curl_setopt($ch, CURLOPT_TIMEOUT, (int) ($config['timeout'] ?? 10));

        if (strtoupper($method) !== 'GET') {
            $jsonPayload = json_encode($payload);
            $headers[] = 'Content-Type: application/json';
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPayload);
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $rawBody = curl_exec($ch);
        $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($rawBody === false || $httpCode < 200 || $httpCode >= 300) {
            return [
                'ok' => false,
                'http_code' => $httpCode,
                'error' => $curlError,
                'body' => null
            ];
        }

        $decoded = json_decode($rawBody, true);
        return [
            'ok' => is_array($decoded),
            'http_code' => $httpCode,
            'body' => $decoded
        ];
    }

    private function normalizeWhatsappPhone(string $phone): string
    {
        $phone = preg_replace('/\D+/', '', $phone);
        if ($phone === '') {
            return '';
        }

        $config = $this->getWhatsappConfig();
        $countryCode = preg_replace('/\D+/', '', (string) ($config['country_code'] ?? '91'));
        if (strlen($phone) === 10 && $countryCode !== '') {
            return $countryCode . $phone;
        }

        if (strpos($phone, '0') === 0 && strlen($phone) === 11 && $countryCode !== '') {
            return $countryCode . substr($phone, 1);
        }

        return $phone;
    }

    private function buildWhatsappMessage(array $sale): string
    {
        $customerName = trim((string) ($sale['customer_name'] ?? 'Customer'));
        $invoiceNumber = (string) ($sale['invoice_number'] ?? '');
        $invoiceAmount = number_format((float) ($sale['grand_total'] ?? 0), 2);
        $invoiceUrl = !empty($sale['invoice_file']) ? base_url((string) $sale['invoice_file']) : base_url('sales');
        $supportNumber = $this->buildBusinessWhatsappNumber();

        $message = "Hi {$customerName},\n\n"
            . "Your invoice {$invoiceNumber} is ready.\n"
            . "Amount: Rs. {$invoiceAmount}\n\n"
            . "View Invoice:\n{$invoiceUrl}";

        if ($supportNumber !== '') {
            $message .= "\n\nBusiness Contact Number: {$supportNumber}";
            $message .= "\nSave this number so you can identify our message easily.";
        }

        return $message . "\n\nThank you for your business.";
    }

    private function buildWhatsappCaption(array $sale): string
    {
        $customerName = trim((string) ($sale['customer_name'] ?? 'Customer'));
        $invoiceNumber = (string) ($sale['invoice_number'] ?? '');
        $invoiceAmount = number_format((float) ($sale['grand_total'] ?? 0), 2);

        return "Invoice {$invoiceNumber}\n"
            . "Customer: {$customerName}\n"
            . "Amount: Rs. {$invoiceAmount}";
    }

    private function buildBusinessWhatsappNumber(): string
    {
        $phone = $this->normalizeWhatsappPhone((string) ($this->admin['mobile'] ?? ''));
        if ($phone !== '') {
            return '+' . $phone;
        }

        $config = $this->getWhatsappConfig();
        $fallbackNumber = $this->normalizeWhatsappPhone((string) ($config['fallback_display_number'] ?? ''));
        return $fallbackNumber !== '' ? '+' . $fallbackNumber : '';
    }

    private function isWhatsappConnected(): bool
    {
        $response = $this->callWhatsappService('GET', '/qr');
        $body = is_array($response['body'] ?? null) ? $response['body'] : [];
        return !empty($response['ok']) && !empty($body['connected']);
    }

    private function resolveInvoicePreviewAbsolutePath(array $sale): string
    {
        $invoiceFile = (string) ($sale['invoice_file'] ?? '');
        if ($invoiceFile === '') {
            return '';
        }

        $previewRelative = preg_replace('/\.[^.]+$/', '.png', $invoiceFile);
        if (!is_string($previewRelative) || $previewRelative === '') {
            return '';
        }

        $absolutePath = FCPATH . ltrim($previewRelative, '/');
        return is_file($absolutePath) ? $absolutePath : '';
    }

    private function buildWhatsappFallbackUrl(array $sale): string
    {
        $phone = $this->normalizeWhatsappPhone((string) ($sale['customer_phone'] ?? ''));

        if ($phone == '') {
            return '#';
        }

        return "https://wa.me/{$phone}?text=" . urlencode($this->buildWhatsappMessage($sale));
    }

    public function export()
    {
        $date_from = $this->input->get('date_from');
        $date_to   = $this->input->get('date_to');

        $this->db->select('
        s.invoice_number,
        s.grand_total,
        c.name,
        c.phone,
        c.address
    ');

        $this->db->from('sales s');
        $this->db->join('customers c', 'c.id = s.customer_id', 'left');

        if (!empty($date_from)) {
            $this->db->where('DATE(s.created_on) >=', $date_from);
        }

        if (!empty($date_to)) {
            $this->db->where('DATE(s.created_on) <=', $date_to);
        }

        $sales = $this->db->get()->result_array();

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=sales_export.xls");

        echo "Invoice\tCustomer\tPhone\tAddress\tTotal\n";

        foreach ($sales as $sale) {
            echo $sale['invoice_number'] . "\t";
            echo $sale['name'] . "\t";
            echo "'" . $sale['phone'] . "\t";
            echo $sale['address'] . "\t";
            echo $sale['grand_total'] . "\n";
        }

        exit;
    }
}

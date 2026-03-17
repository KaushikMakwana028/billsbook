<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_Controller extends CI_Controller
{
    public $admin;
    public $provider;
    private $whatsappConfig = null;

    public function __construct()
    {
        parent::__construct();

        // Load common libraries
        $this->load->library(['form_validation', 'session']);
        $this->load->helper(['url', 'form']);
        $this->load->model('general_model');

        // Get admin session
        $this->admin = $this->session->userdata('admin');
        $controller = strtolower((string)$this->router->fetch_class());


        /* -------------------------------------------------------
           LOAD ADMIN ROLE DATA IF MISSING
        ------------------------------------------------------- */

        if (!empty($this->admin) && empty($this->admin['role'])) {

            $adminRow = $this->db
                ->select('role, profile_image, name, business_name, email, address, mobile')
                ->where('id', $this->admin['user_id'])
                ->get('users')
                ->row();

            if ($adminRow) {

                $this->admin['role'] = $adminRow->role ?? 'admin';
                $this->admin['profile_image'] = $adminRow->profile_image ?? null;
                $this->admin['user_name'] = $adminRow->name ?? '';
                $this->admin['business_name'] = $adminRow->business_name ?? '';
                $this->admin['mobile'] = $adminRow->mobile ?? '';
                $this->admin['email'] = $adminRow->email ?? '';
                $this->admin['address'] = $adminRow->address ?? '';

                $this->session->set_userdata('admin', $this->admin);
            }
        }

        /* -------------------------------------------------------
           LOGIN CHECK
        ------------------------------------------------------- */

        if (!$this->admin) {
            redirect('login');
        }

        $this->enforceWhatsappLinkedSession();
    }

    private function enforceWhatsappLinkedSession(): void
    {
        $linkedData = (array) $this->session->userdata('whatsapp_linked');
        if (empty($linkedData['linked'])) {
            return;
        }

        $controller = strtolower((string) $this->router->fetch_class());
        $method = strtolower((string) $this->router->fetch_method());
        $skipChecks = [
            'sales:whatsapp_status',
            'sales:whatsapp_reset',
            'sales:whatsapp_disconnect'
        ];

        if (in_array($controller . ':' . $method, $skipChecks, true)) {
            return;
        }

        $status = $this->callWhatsappService('GET', '/qr');
        $body = is_array($status['body'] ?? null) ? $status['body'] : [];
        $state = (string) ($body['state'] ?? '');

        if (!empty($body['connected'])) {
            return;
        }

        if (in_array($state, ['disconnected', 'auth_failure'], true)) {
            $this->session->unset_userdata('whatsapp_linked');
            $this->session->unset_userdata('admin');
            $this->session->sess_destroy();
            redirect('login');
        }
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
            'timeout' => 5
        ];

        $this->whatsappConfig = array_merge($defaults, $config);
        return $this->whatsappConfig;
    }

    private function callWhatsappService(string $method, string $path): array
    {
        $config = $this->getWhatsappConfig();
        $baseUrl = rtrim((string) ($config['service_url'] ?? ''), '/');
        if ($baseUrl === '' || !function_exists('curl_init')) {
            return ['ok' => false, 'body' => null];
        }

        $ch = curl_init($baseUrl . '/' . ltrim($path, '/'));
        if ($ch === false) {
            return ['ok' => false, 'body' => null];
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
        curl_setopt($ch, CURLOPT_TIMEOUT, (int) ($config['timeout'] ?? 5));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);

        $rawBody = curl_exec($ch);
        $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($rawBody === false || $httpCode < 200 || $httpCode >= 300) {
            return ['ok' => false, 'body' => null];
        }

        $decoded = json_decode($rawBody, true);
        return [
            'ok' => is_array($decoded),
            'body' => $decoded
        ];
    }
}

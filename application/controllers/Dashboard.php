<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once(APPPATH . 'core/My_Controller.php');
class Dashboard extends My_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    public function index()
    {
        $admin = $this->session->userdata('admin');
        $adminId = (int) ($admin['user_id'] ?? 0);
        $profileImage = $admin['profile_image'] ?? '';
        $businessName = trim((string) ($admin['business_name'] ?? ''));

        // Get counts for dashboard
        $categoryCount = $this->db
            ->where('admin_id', $adminId)
            ->where('isActive', 1)
            ->count_all_results('category');

        $productCount = $this->db
            ->where('admin_id', $adminId)
            ->where('isActive', 1)
            ->count_all_results('product');

        $customerCount = $this->db
            ->where('admin_id', $adminId)
            ->where('isActive', 1)
            ->count_all_results('customers');

        $salesCount = $this->db
            ->where('admin_id', $adminId)
            ->count_all_results('sales');

        $salesRevenueRow = $this->db
            ->select_sum('grand_total')
            ->where('admin_id', $adminId)
            ->get('sales')
            ->row_array();

        $lowStockProducts = $this->db
            ->where('admin_id', $adminId)
            ->where('isActive', 1)
            ->where('quantity <=', 5)
            ->order_by('quantity', 'ASC')
            ->order_by('id', 'DESC')
            ->get('product')
            ->result_array();

        $recentSales = $this->db
            ->select('sales.invoice_number, sales.grand_total, sales.sale_date, customers.name AS customer_name')
            ->from('sales')
            ->join('customers', 'customers.id = sales.customer_id', 'left')
            ->where('sales.admin_id', $adminId)
            ->order_by('sales.id', 'DESC')
            ->limit(5)
            ->get()
            ->result_array();

        // Handle profile image
        if (!empty($profileImage) && !preg_match('#^https?://#i', $profileImage)) {
            $profileImage = (strpos($profileImage, 'uploads/') === 0 || strpos($profileImage, 'assets/') === 0)
                ? base_url($profileImage)
                : base_url('uploads/profile/' . ltrim($profileImage, '/'));
        }

        // Prepare data for views
        $data['userName'] = $admin['user_name'] ?? ($admin['name'] ?? 'Admin');
        $data['userEmail'] = $admin['email'] ?? '';
        $data['businessName'] = $businessName !== '' ? $businessName : 'Bills Book';
        $data['role'] = (!empty($admin['role']) && (string) $admin['role'] !== '1')
            ? (string) $admin['role']
            : 'admin';
        $data['profileImage'] = !empty($profileImage)
            ? $profileImage
            : base_url('assets/images/Default.jpg');
        $data['profileUrl'] = base_url('profile');
        $data['pageTitle'] = 'Dashboard';
        $data['categoryCount'] = $categoryCount;
        $data['productCount'] = $productCount;
        $data['customerCount'] = $customerCount;
        $data['salesCount'] = $salesCount;
        $data['salesRevenue'] = (float) ($salesRevenueRow['grand_total'] ?? 0);
        $data['lowStockProducts'] = $lowStockProducts;
        $data['lowStockCount'] = count($lowStockProducts);
        $data['recentSales'] = $recentSales;

        // Load views with data
        $this->load->view('header', $data);
        $this->load->view('dashboard_view', $data);
        $this->load->view('footer');
    }
    

    public function save_privacy_preference()
    {
        header('Content-Type: application/json');

        $postData = json_decode(file_get_contents('php://input'), true);
        $privacyMode = $postData['privacy_mode'] ?? false;

        $privacyValue = $privacyMode ? 1 : 0;

        $user = $this->session->userdata('admin');
        $userId = $user['id'] ?? 0;

        if ($userId > 0) {

            $this->db->where('id', $userId);
            $this->db->update('users', ['privacy_mode' => $privacyValue]);

            $user['privacy_mode'] = $privacyValue;
            $this->session->set_userdata('admin', $user);

            echo json_encode([
                'success' => true,
                'message' => 'Preference saved'
            ]);
        } else {

            echo json_encode([
                'success' => false,
                'message' => 'User ID not found'
            ]);
        }
    }

    public function getSalesChart()
    {
        try {

            $admin = $this->session->userdata('admin');
            $adminId = (int) ($admin['user_id'] ?? 0);

            $filter = $this->input->post('filter') ?: 'week';

            $labels = [];
            $values = [];

            if ($filter === 'day') {

                // 24 hours chart
                for ($i = 0; $i < 24; $i++) {

                    $hourStart = date('Y-m-d') . " $i:00:00";
                    $hourEnd   = date('Y-m-d') . " $i:59:59";

                    $this->db->select_sum('grand_total');
                    $this->db->where('admin_id', $adminId);
                    $this->db->where('sale_date >=', $hourStart);
                    $this->db->where('sale_date <=', $hourEnd);

                    $sale = $this->db->get('sales')->row();

                    $labels[] = $i . ":00";
                    $values[] = (float) ($sale->grand_total ?? 0);
                }
            } elseif ($filter === 'week') {

                // last 7 days
                for ($i = 6; $i >= 0; $i--) {

                    $date = date('Y-m-d', strtotime("-$i days"));

                    $this->db->select_sum('grand_total');
                    $this->db->where('admin_id', $adminId);
                    $this->db->where('DATE(sale_date)', $date);

                    $sale = $this->db->get('sales')->row();

                    $labels[] = date('d M', strtotime($date));
                    $values[] = (float) ($sale->grand_total ?? 0);
                }
            } elseif ($filter === 'month') {

                $days = date('t');

                for ($i = 1; $i <= $days; $i++) {

                    $date = date('Y-m') . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);

                    $this->db->select_sum('grand_total');
                    $this->db->where('admin_id', $adminId);
                    $this->db->where('DATE(sale_date)', $date);

                    $sale = $this->db->get('sales')->row();

                    $labels[] = $i;
                    $values[] = (float) ($sale->grand_total ?? 0);
                }
            } else {

                // yearly
                for ($i = 1; $i <= 12; $i++) {

                    $this->db->select_sum('grand_total');
                    $this->db->where('admin_id', $adminId);
                    $this->db->where('MONTH(sale_date)', $i);
                    $this->db->where('YEAR(sale_date)', date('Y'));

                    $sale = $this->db->get('sales')->row();

                    $labels[] = date('M', mktime(0, 0, 0, $i, 1));
                    $values[] = (float) ($sale->grand_total ?? 0);
                }
            }

            header('Content-Type: application/json');
            echo json_encode([
                'labels' => $labels,
                'values' => $values
            ]);
        } catch (Exception $e) {

            echo json_encode([
                'labels' => ['Error'],
                'values' => [0]
            ]);
        }
    }
}

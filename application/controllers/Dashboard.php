<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends My_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $admin = $this->session->userdata('admin');
        $adminId = (int) ($admin['user_id'] ?? 0);
        $profileImage = $admin['profile_image'] ?? '';
        $businessName = trim((string) ($admin['business_name'] ?? ''));
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

        if (!empty($profileImage) && !preg_match('#^https?://#i', $profileImage)) {
            $profileImage = (strpos($profileImage, 'uploads/') === 0 || strpos($profileImage, 'assets/') === 0)
                ? base_url($profileImage)
                : base_url('uploads/profile/' . ltrim($profileImage, '/'));
        }

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

        $this->load->view('header', $data);
        $this->load->view('dashboard_view', $data);
        $this->load->view('footer', $data);
    }
}

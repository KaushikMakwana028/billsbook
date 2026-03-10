<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends My_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('upload');
    }

    public function index()
    {
        $adminId = (int) ($this->admin['user_id'] ?? 0);
        $data = $this->buildBaseData($adminId);
        $data['products'] = $this->getProducts($adminId);
        $data['pageTitle'] = 'Products';

        $this->load->view('header', $data);
        $this->load->view('product_view', $data);
        $this->load->view('footer', $data);
    }

    public function add()
    {
        $adminId = (int) ($this->admin['user_id'] ?? 0);
        $data = $this->buildBaseData($adminId);
        $data['categories'] = $this->getCategories($adminId);
        $data['pageTitle'] = 'Add Product';

        $this->load->view('header', $data);
        $this->load->view('product_add', $data);
        $this->load->view('footer', $data);
    }

    public function store()
    {
        $adminId = (int) ($this->admin['user_id'] ?? 0);
        $categories = $this->getCategories($adminId);

        $this->form_validation->set_rules('category_id', 'Category', 'required|integer');
        $this->form_validation->set_rules('name', 'Product Name', 'required|trim');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        $this->form_validation->set_rules('price', 'Price', 'required|callback_valid_price');

        if ($this->form_validation->run() === false) {
            $data = $this->buildBaseData($adminId);
            $data['categories'] = $categories;
            $data['pageTitle'] = 'Add Product';
            $this->load->view('header', $data);
            $this->load->view('product_add', $data);
            $this->load->view('footer', $data);
            return;
        }

        $categoryId = (int) $this->input->post('category_id');
        if (!$this->isOwnedCategory($categoryId, $adminId)) {
            $this->session->set_flashdata('error', 'Invalid category selected');
            redirect('product/add');
            return;
        }

        $image = $this->uploadProductImage('product_image');
        if ($image === false) {
            $data = $this->buildBaseData($adminId);
            $data['categories'] = $categories;
            $data['pageTitle'] = 'Add Product';
            $data['productError'] = strip_tags($this->upload->display_errors('', ''));
            $this->load->view('header', $data);
            $this->load->view('product_add', $data);
            $this->load->view('footer', $data);
            return;
        }

        $inserted = $this->db->insert('product', [
            'admin_id' => $adminId,
            'category_id' => $categoryId,
            'name' => trim((string) $this->input->post('name')),
            'description' => trim((string) $this->input->post('description')),
            'price' => $this->normalizePrice((string) $this->input->post('price')),
            'image' => $image,
            'isActive' => 1,
            'created_on' => date('Y-m-d')
        ]);

        if (!$inserted) {
            $dbError = $this->db->error();
            $this->session->set_flashdata('error', !empty($dbError['message']) ? $dbError['message'] : 'Product could not be saved');
            redirect('product/add');
            return;
        }

        $this->session->set_flashdata('success', 'Product added successfully');
        redirect('product');
    }

    public function edit($id)
    {
        $adminId = (int) ($this->admin['user_id'] ?? 0);
        $product = $this->getOwnedProduct((int) $id, $adminId);
        if (empty($product)) {
            $this->session->set_flashdata('error', 'Product not found');
            redirect('product');
            return;
        }

        $data = $this->buildBaseData($adminId);
        $data['categories'] = $this->getCategories($adminId);
        $data['product'] = $product;
        $data['productImageUrl'] = $this->resolveProductImage($product['image'] ?? '');
        $data['pageTitle'] = 'Edit Product';

        $this->load->view('header', $data);
        $this->load->view('product_edit', $data);
        $this->load->view('footer', $data);
    }

    public function update($id)
    {
        $adminId = (int) ($this->admin['user_id'] ?? 0);
        $productId = (int) $id;
        $product = $this->getOwnedProduct($productId, $adminId);
        $categories = $this->getCategories($adminId);

        if (empty($product)) {
            $this->session->set_flashdata('error', 'Product not found');
            redirect('product');
            return;
        }

        $this->form_validation->set_rules('category_id', 'Category', 'required|integer');
        $this->form_validation->set_rules('name', 'Product Name', 'required|trim');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        $this->form_validation->set_rules('price', 'Price', 'required|callback_valid_price');

        if ($this->form_validation->run() === false) {
            $data = $this->buildBaseData($adminId);
            $data['categories'] = $categories;
            $data['product'] = $product;
            $data['productImageUrl'] = $this->resolveProductImage($product['image'] ?? '');
            $data['pageTitle'] = 'Edit Product';
            $this->load->view('header', $data);
            $this->load->view('product_edit', $data);
            $this->load->view('footer', $data);
            return;
        }

        $categoryId = (int) $this->input->post('category_id');
        if (!$this->isOwnedCategory($categoryId, $adminId)) {
            $this->session->set_flashdata('error', 'Invalid category selected');
            redirect('product/edit/' . $productId);
            return;
        }

        $image = $product['image'] ?? '';
        if (!empty($_FILES['product_image']['name'])) {
            $newImage = $this->uploadProductImage('product_image');
            if ($newImage === false) {
                $data = $this->buildBaseData($adminId);
                $data['categories'] = $categories;
                $data['product'] = $product;
                $data['productImageUrl'] = $this->resolveProductImage($product['image'] ?? '');
                $data['pageTitle'] = 'Edit Product';
                $data['productError'] = strip_tags($this->upload->display_errors('', ''));
                $this->load->view('header', $data);
                $this->load->view('product_edit', $data);
                $this->load->view('footer', $data);
                return;
            }
            $image = $newImage;
        }

        $updated = $this->db
            ->where('id', $productId)
            ->where('admin_id', $adminId)
            ->update('product', [
                'category_id' => $categoryId,
                'name' => trim((string) $this->input->post('name')),
                'description' => trim((string) $this->input->post('description')),
                'price' => $this->normalizePrice((string) $this->input->post('price')),
                'image' => $image
            ]);

        if (!$updated) {
            $dbError = $this->db->error();
            $this->session->set_flashdata('error', !empty($dbError['message']) ? $dbError['message'] : 'Product could not be updated');
            redirect('product/edit/' . $productId);
            return;
        }

        $this->session->set_flashdata('success', 'Product updated successfully');
        redirect('product');
    }

    public function delete($id)
    {
        $adminId = (int) ($this->admin['user_id'] ?? 0);
        $productId = (int) $id;
        $product = $this->getOwnedProduct($productId, $adminId);

        if (empty($product)) {
            $this->session->set_flashdata('error', 'Product not found');
            redirect('product');
            return;
        }

        $deleted = $this->db
            ->where('id', $productId)
            ->where('admin_id', $adminId)
            ->update('product', ['isActive' => 0]);

        if (!$deleted) {
            $dbError = $this->db->error();
            $this->session->set_flashdata('error', !empty($dbError['message']) ? $dbError['message'] : 'Product could not be deleted');
            redirect('product');
            return;
        }

        $this->session->set_flashdata('success', 'Product deleted successfully');
        redirect('product');
    }

    private function buildBaseData(int $adminId): array
    {
        return [
            'userName' => $this->admin['user_name'] ?? ($this->admin['name'] ?? 'Admin'),
            'userEmail' => $this->admin['email'] ?? '',
            'businessName' => $this->admin['business_name'] ?? 'Bills Book',
            'role' => (!empty($this->admin['role']) && (string) $this->admin['role'] !== '1') ? (string) $this->admin['role'] : 'admin',
            'profileImage' => $this->admin['profile_image'] ?? '',
            'profileUrl' => base_url('profile'),
            'adminId' => $adminId
        ];
    }

    private function getCategories(int $adminId): array
    {
        return $this->db
            ->where('admin_id', $adminId)
            ->where('isActive', 1)
            ->order_by('name', 'ASC')
            ->get('category')
            ->result_array();
    }

    private function getProducts(int $adminId): array
    {
        return $this->db
            ->select('product.*, category.name AS category_name')
            ->from('product')
            ->join('category', 'category.id = product.category_id', 'left')
            ->where('product.admin_id', $adminId)
            ->where('product.isActive', 1)
            ->order_by('product.id', 'DESC')
            ->get()
            ->result_array();
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

    private function isOwnedCategory(int $categoryId, int $adminId): bool
    {
        return (bool) $this->db
            ->where('id', $categoryId)
            ->where('admin_id', $adminId)
            ->where('isActive', 1)
            ->count_all_results('category');
    }

    private function uploadProductImage(string $fieldName)
    {
        if (empty($_FILES[$fieldName]['name'])) {
            return '';
        }

        $uploadPath = FCPATH . 'uploads/product/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $config = [
            'upload_path' => $uploadPath,
            'allowed_types' => 'jpg|jpeg|png|webp',
            'max_size' => 4096,
            'encrypt_name' => true
        ];

        $this->upload->initialize($config);
        if (!$this->upload->do_upload($fieldName)) {
            return false;
        }

        $uploadData = $this->upload->data();
        return $uploadData['file_name'] ?? '';
    }

    private function resolveProductImage(string $image): string
    {
        if ($image === '') {
            return base_url('assets/images/Default.jpg');
        }

        if (preg_match('#^https?://#i', $image)) {
            return $image;
        }

        if (strpos($image, 'uploads/') === 0 || strpos($image, 'assets/') === 0) {
            return base_url($image);
        }

        return base_url('uploads/product/' . ltrim($image, '/'));
    }

    public function valid_price($price): bool
    {
        $normalizedPrice = $this->normalizePrice((string) $price);

        if ($normalizedPrice === null) {
            $this->form_validation->set_message('valid_price', 'The {field} field must contain only valid numbers.');
            return false;
        }

        return true;
    }

    private function normalizePrice(string $price): ?float
    {
        $cleanedPrice = trim(str_replace([',', ' ', 'Rs.', 'RS.', 'rs.', '₹'], '', $price));

        if ($cleanedPrice === '' || !preg_match('/^\d+(\.\d{1,2})?$/', $cleanedPrice)) {
            return null;
        }

        return (float) $cleanedPrice;
    }
}

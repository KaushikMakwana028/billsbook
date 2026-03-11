<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends My_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('upload');
    }

    public function index()
    {
        $adminId = (int) ($this->admin['user_id'] ?? 0);
        $user = $this->db->where('id', $adminId)->get('users')->row_array();

        if (empty($user)) {
            show_404();
        }

        $data = $this->buildViewData($user);
        $this->load->view('header', $data);
        $this->load->view('profile_view', $data);
        $this->load->view('footer', $data);
    }

    public function update()
    {
        $adminId = (int) ($this->admin['user_id'] ?? 0);
        $user = $this->db->where('id', $adminId)->get('users')->row_array();

        if (empty($user)) {
            show_404();
        }

        $this->form_validation->set_rules('full_name', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('business_name', 'Business Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required|regex_match[/^[0-9]{10}$/]');
        $this->form_validation->set_rules('address', 'Address', 'trim');

        if ($this->form_validation->run() === false) {
            $data = $this->buildViewData($user);
            $this->load->view('header', $data);
            $this->load->view('profile_view', $data);
            $this->load->view('footer', $data);
            return;
        }

        $email = trim((string) $this->input->post('email'));
        $mobile = trim((string) $this->input->post('mobile'));

        $exists = $this->db
            ->group_start()
            ->where('mobile', $mobile)
            ->or_where('email', $email)
            ->group_end()
            ->where('id !=', $adminId)
            ->get('users')
            ->row();

        if ($exists) {
            $data = $this->buildViewData($user);
            $data['profileError'] = 'Mobile or email already registered for another user';
            $this->load->view('header', $data);
            $this->load->view('profile_view', $data);
            $this->load->view('footer', $data);
            return;
        }

        $profileImage = $user['profile_image'] ?? 'assets/images/Default.jpg';

        if (!empty($_FILES['profile_image']['name'])) {
            $uploadPath = FCPATH . 'uploads/profile/';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $config = [
                'upload_path' => $uploadPath,
                'allowed_types' => 'jpg|jpeg|png|webp',
                'max_size' => 2048,
                'encrypt_name' => true
            ];

            $this->upload->initialize($config);

            if (!$this->upload->do_upload('profile_image')) {
                $data = $this->buildViewData($user);
                $data['profileError'] = strip_tags($this->upload->display_errors('', ''));
                $this->load->view('header', $data);
                $this->load->view('profile_view', $data);
                $this->load->view('footer', $data);
                return;
            }

            $uploadData = $this->upload->data();
            $profileImage = $uploadData['file_name'] ?? $profileImage;
        }

        $updateData = [
            'name' => trim((string) $this->input->post('full_name')),
            'business_name' => trim((string) $this->input->post('business_name')),
            'email' => $email,
            'mobile' => $mobile,
            'address' => trim((string) $this->input->post('address')),
            'profile_image' => $profileImage
        ];

        $this->db->where('id', $adminId)->update('users', $updateData);

        $sessionData = $this->admin;
        $sessionData['user_name'] = $updateData['name'];
        $sessionData['business_name'] = $updateData['business_name'];
        $sessionData['email'] = $updateData['email'];
        $sessionData['address'] = $updateData['address'];
        $sessionData['profile_image'] = $updateData['profile_image'];
        $this->session->set_userdata('admin', $sessionData);

        $this->session->set_flashdata('success', 'Profile updated successfully');
        redirect('profile');
    }

    private function buildViewData(array $user): array
    {
        $profileImage = $this->resolveProfileImage($user['profile_image'] ?? '');

        return [
            'user' => $user,
            'userName' => $user['name'] ?? 'Admin',
            'userEmail' => $user['email'] ?? '',
            'businessName' => $user['business_name'] ?? 'Bills Book',
            'role' => (!empty($user['role']) && (string) $user['role'] !== '1') ? (string) $user['role'] : 'admin',
            'profileImage' => $profileImage,
            'profileUrl' => base_url('profile'),
            'pageTitle' => 'Profile'
        ];
    }

    private function resolveProfileImage(string $profileSource): string
    {
        if ($profileSource === '') {
            return base_url('assets/images/Default.jpg');
        }

        if (preg_match('#^https?://#i', $profileSource)) {
            return $profileSource;
        }

        if (strpos($profileSource, 'uploads/') === 0 || strpos($profileSource, 'assets/') === 0) {
            return base_url($profileSource);
        }

        return base_url('uploads/profile/' . ltrim($profileSource, '/'));
    }
}

<?php
namespace App\Controllers;

use App\Models\Staff;

class StaffController extends BaseController {
    public function index() {
        $this->roleCheck(['Admin', 'Principal']);
        $staffModel = new Staff();
        $staff = $staffModel->all();
        $this->view('admin/staff/index', ['title' => 'Staff Management', 'staff' => $staff], 'main');
    }

    public function create() {
        $this->roleCheck(['Admin', 'Principal']);
        $this->view('admin/staff/create', ['title' => 'Add Staff Member'], 'main');
    }

    public function store() {
        $this->roleCheck(['Admin', 'Principal']);
        $this->verifyCsrfToken();

        // Basic validation
        $required = ['full_name', 'email', 'gender', 'contact', 'employment_date', 'employment_type'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                die("Error: Field '$field' is required.");
            }
        }

        // Sanitize
        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

        $staffModel = new Staff();
        $staffModel->create($data);
        $this->redirect('/staff');
    }
}

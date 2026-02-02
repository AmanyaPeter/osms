<?php
namespace App\Controllers;

use App\Models\Finance;
use App\Models\Student;

class FinanceController extends BaseController {
    public function index() {
        $this->roleCheck(['Admin', 'Accountant']);
        $financeModel = new Finance();
        $defaulters = $financeModel->getDefaulters();

        $this->view('admin/finance/index', [
            'title' => 'Finance Overview',
            'defaulters' => $defaulters
        ], 'main');
    }

    public function recordPaymentForm() {
        $this->roleCheck(['Admin', 'Accountant']);
        $studentModel = new Student();
        $students = $studentModel->all();

        $this->view('admin/finance/record_payment', [
            'title' => 'Record Payment',
            'students' => $students
        ], 'main');
    }

    public function storePayment() {
        $this->roleCheck(['Admin', 'Accountant']);
        $this->verifyCsrfToken();

        // Basic validation
        $required = ['student_id', 'amount', 'payment_date', 'payment_method'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                die("Error: Field '$field' is required.");
            }
        }

        // Sanitize
        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

        $financeModel = new Finance();
        $data['recorded_by'] = $_SESSION['user_id'];

        $financeModel->recordPayment($data);
        $this->redirect('/finance');
    }

    public function defaultersReport() {
        $this->roleCheck(['Admin', 'Accountant', 'Principal']);
        $financeModel = new Finance();
        $class_grade = $_GET['class'] ?? null;
        $defaulters = $financeModel->getDefaulters($class_grade);

        $this->view('admin/finance/defaulters', [
            'title' => 'Fee Defaulters Report',
            'defaulters' => $defaulters,
            'selected_class' => $class_grade
        ], 'main');
    }
}

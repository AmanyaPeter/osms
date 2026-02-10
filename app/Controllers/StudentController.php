<?php
namespace App\Controllers;

use App\Models\Student;

class StudentController extends BaseController {
    public function index() {
        $this->roleCheck(['Admin', 'Principal', 'Clerk']);
        $studentModel = new Student();

        $search = $_GET['q'] ?? '';
        $class_grade = $_GET['class'] ?? '';
        $status = $_GET['status'] ?? '';

        $students = $studentModel->all($search, $class_grade, $status);
        $this->view('admin/students/index', [
            'title' => 'Student Management',
            'students' => $students,
            'search' => $search,
            'class_grade' => $class_grade,
            'status' => $status
        ], 'main');
    }

    public function create() {
        $this->roleCheck(['Admin', 'Principal', 'Clerk']);
        $this->view('admin/students/create', ['title' => 'Register Student'], 'main');
    }

    public function store() {
        $this->roleCheck(['Admin', 'Principal', 'Clerk']);
        $this->verifyCsrfToken();

        // Basic validation
        $required = ['full_name', 'date_of_birth', 'gender', 'class_grade', 'guardian_name', 'guardian_contact', 'admission_date'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                die("Error: Field '$field' is required.");
            }
        }

        // Sanitize
        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

        $studentModel = new Student();
        $studentModel->create($data);
        $this->redirect('/students');
    }

    public function show($id) {
        $this->roleCheck(['Admin', 'Principal', 'Clerk', 'Teacher']);
        $studentModel = new Student();
        $student = $studentModel->find($id);
        if (!$student) die("Student not found.");
        $this->view('admin/students/show', ['title' => 'Student Profile', 'student' => $student], 'main');
    }

    public function edit($id) {
        $this->roleCheck(['Admin', 'Principal', 'Clerk']);
        $studentModel = new Student();
        $student = $studentModel->find($id);
        if (!$student) die("Student not found.");
        $this->view('admin/students/edit', ['title' => 'Edit Student', 'student' => $student], 'main');
    }

    public function update($id) {
        $this->roleCheck(['Admin', 'Principal', 'Clerk']);
        $this->verifyCsrfToken();

        // Basic validation
        $required = ['full_name', 'date_of_birth', 'gender', 'class_grade', 'guardian_name', 'guardian_contact', 'admission_date', 'status'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                die("Error: Field '$field' is required.");
            }
        }

        // Sanitize
        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

        $studentModel = new Student();
        $studentModel->update($id, $data);
        $this->redirect("/students/show/{$id}");
    }

    public function delete($id) {
        $this->roleCheck(['Admin', 'Principal']);
        $studentModel = new Student();
        $studentModel->delete($id);
        $this->redirect('/students');
    }
}

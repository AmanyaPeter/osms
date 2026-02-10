<?php
namespace App\Controllers;

use App\Models\Course;

class CourseController extends BaseController {
    public function index() {
        $this->roleCheck(['Admin', 'Principal']);
        $courseModel = new Course();
        $courses = $courseModel->all();
        $this->view('admin/courses/index', ['title' => 'Course Management', 'courses' => $courses], 'main');
    }

    public function create() {
        $this->roleCheck(['Admin', 'Principal']);
        $this->view('admin/courses/create', ['title' => 'Create Course'], 'main');
    }

    public function store() {
        $this->roleCheck(['Admin', 'Principal']);
        $this->verifyCsrfToken();

        // Basic validation
        $required = ['course_code', 'course_name', 'grade_level', 'course_type'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                die("Error: Field '$field' is required.");
            }
        }

        // Sanitize
        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

        $courseModel = new Course();
        $courseModel->create($data);
        $this->redirect('/courses');
    }
}

<?php
namespace App\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Models\Staff;

class HomeController extends BaseController {
    public function index() {
        $this->authCheck();

        $data = [
            'title' => 'Dashboard',
        ];

        switch ($_SESSION['role']) {
            case 'Admin':
            case 'Principal':
                $studentModel = new Student();
                $courseModel = new Course();
                $staffModel = new Staff();
                $data['student_count'] = count($studentModel->all());
                $data['course_count'] = count($courseModel->all());
                $data['staff_count'] = count($staffModel->all());
                $this->view('admin/dashboard', $data, 'main');
                break;
            case 'Teacher':
                $courseModel = new Course();
                $data['my_courses'] = $courseModel->all(); // Simplified
                $this->view('lecturer/dashboard', $data, 'main');
                break;
            case 'Student':
                $this->view('student/dashboard', $data, 'main');
                break;
            default:
                $this->view('admin/dashboard', $data, 'main');
                break;
        }
    }
}

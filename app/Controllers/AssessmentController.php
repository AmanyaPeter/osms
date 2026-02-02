<?php
namespace App\Controllers;

use App\Models\Assessment;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Attendance;

class AssessmentController extends BaseController {
    public function index() {
        $this->roleCheck(['Admin', 'Teacher']);
        $courseModel = new Course();
        $courses = $courseModel->all();
        $this->view('lecturer/assessments/index', ['title' => 'Assessments & Attendance', 'courses' => $courses], 'main');
    }

    public function markAttendance($course_id) {
        $this->roleCheck(['Admin', 'Teacher']);
        $enrollmentModel = new Enrollment();
        $students = $enrollmentModel->getStudentsInCourse($course_id);
        $courseModel = new Course();
        $course = $courseModel->find($course_id);

        $this->view('lecturer/attendance/mark', [
            'title' => 'Mark Attendance',
            'students' => $students,
            'course' => $course,
            'date' => date('Y-m-d')
        ], 'main');
    }

    public function storeAttendance($course_id) {
        $this->roleCheck(['Admin', 'Teacher']);
        $attendanceModel = new Attendance();
        $date = $_POST['date'];
        $records = $_POST['attendance']; // [student_id => status]
        $attendanceModel->recordBulk($course_id, $date, $records, $_SESSION['user_id']);
        $this->redirect('/assessments');
    }

    public function enterGrades($course_id) {
        $this->roleCheck(['Admin', 'Teacher']);
        $assessmentModel = new Assessment();
        $assessments = $assessmentModel->allByCourse($course_id);
        $courseModel = new Course();
        $course = $courseModel->find($course_id);

        $this->view('lecturer/assessments/list', [
            'title' => 'Course Assessments',
            'assessments' => $assessments,
            'course' => $course
        ], 'main');
    }
}

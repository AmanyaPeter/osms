<?php
namespace App\Models;

use App\Models\Database;
use PDO;

class Enrollment {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getStudentsInCourse($course_id) {
        $stmt = $this->db->prepare("SELECT s.* FROM students s
                                    JOIN enrollments e ON s.id = e.student_id
                                    WHERE e.course_id = ? AND s.status = 'Active'");
        $stmt->execute([$course_id]);
        return $stmt->fetchAll();
    }
}

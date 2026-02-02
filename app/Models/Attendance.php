<?php
namespace App\Models;

use App\Models\Database;
use PDO;

class Attendance {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function recordBulk($course_id, $date, $records, $recorded_by) {
        $sql = "INSERT INTO attendance (student_id, course_id, date, status, recorded_by)
                VALUES (?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE status = VALUES(status), recorded_by = VALUES(recorded_by)";
        $stmt = $this->db->prepare($sql);
        foreach ($records as $student_id => $status) {
            $stmt->execute([$student_id, $course_id, $date, $status, $recorded_by]);
        }
        return true;
    }
}

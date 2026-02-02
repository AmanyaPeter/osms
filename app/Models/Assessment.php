<?php
namespace App\Models;

use App\Models\Database;
use PDO;

class Assessment {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function allByCourse($course_id) {
        $stmt = $this->db->prepare("SELECT * FROM assessments WHERE course_id = ? ORDER BY date DESC");
        $stmt->execute([$course_id]);
        return $stmt->fetchAll();
    }

    public function create($data) {
        $sql = "INSERT INTO assessments (course_id, name, type, date, max_score, weight) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$data['course_id'], $data['name'], $data['type'], $data['date'], $data['max_score'], $data['weight']]);
        return $this->db->lastInsertId();
    }

    public function recordGrades($assessment_id, $grades, $recorded_by) {
        $sql = "INSERT INTO submissions (assessment_id, student_id, score, recorded_by)
                VALUES (?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE score = VALUES(score), recorded_by = VALUES(recorded_by)";
        $stmt = $this->db->prepare($sql);
        foreach ($grades as $student_id => $score) {
            $stmt->execute([$assessment_id, $student_id, $score, $recorded_by]);
        }
        return true;
    }
}

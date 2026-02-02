<?php
namespace App\Models;

use App\Models\Database;
use PDO;

class Course {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function all() {
        $stmt = $this->db->query("SELECT * FROM courses ORDER BY grade_level ASC, course_name ASC");
        return $stmt->fetchAll();
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM courses WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $sql = "INSERT INTO courses (course_code, course_name, grade_level, course_type, credits, description, status)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['course_code'],
            $data['course_name'],
            $data['grade_level'],
            $data['course_type'],
            $data['credits'] ?? null,
            $data['description'] ?? null,
            $data['status'] ?? 'Active'
        ]);
        return $this->db->lastInsertId();
    }
}

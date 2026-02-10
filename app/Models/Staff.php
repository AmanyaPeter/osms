<?php
namespace App\Models;

use App\Models\Database;
use PDO;

class Staff {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function all() {
        $stmt = $this->db->query("SELECT * FROM staff ORDER BY full_name ASC");
        return $stmt->fetchAll();
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM staff WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $staff_id = $this->generateStaffId();
        $sql = "INSERT INTO staff (staff_id, full_name, gender, contact, email, national_id, qualification, employment_date, employment_type, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $staff_id,
            $data['full_name'],
            $data['gender'],
            $data['contact'],
            $data['email'],
            $data['national_id'] ?? null,
            $data['qualification'] ?? null,
            $data['employment_date'],
            $data['employment_type'],
            $data['status'] ?? 'Active'
        ]);
        return $this->db->lastInsertId();
    }

    private function generateStaffId() {
        $year = date('Y');
        $stmt = $this->db->query("SELECT COUNT(*) FROM staff WHERE YEAR(created_at) = $year");
        $count = $stmt->fetchColumn();
        return "TEA-{$year}-" . str_pad($count + 1, 4, '0', STR_PAD_LEFT);
    }
}

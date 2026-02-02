<?php
namespace App\Models;

use App\Models\Database;
use PDO;

class Student {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function all($search = '', $class_grade = '', $status = '') {
        $query = "SELECT * FROM students WHERE 1=1";
        $params = [];

        if ($search) {
            $query .= " AND (full_name LIKE ? OR student_id LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }

        if ($class_grade) {
            $query .= " AND class_grade = ?";
            $params[] = $class_grade;
        }

        if ($status) {
            $query .= " AND status = ?";
            $params[] = $status;
        }

        $query .= " ORDER BY full_name ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $student_id = $this->generateStudentId();
        $sql = "INSERT INTO students (student_id, full_name, date_of_birth, gender, class_grade, guardian_name, guardian_contact, guardian_email, address, admission_date, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $student_id,
            $data['full_name'],
            $data['date_of_birth'],
            $data['gender'],
            $data['class_grade'],
            $data['guardian_name'],
            $data['guardian_contact'],
            $data['guardian_email'] ?? null,
            $data['address'] ?? null,
            $data['admission_date'],
            $data['status'] ?? 'Active'
        ]);
        return $this->db->lastInsertId();
    }

    public function update($id, $data) {
        $sql = "UPDATE students SET full_name = ?, date_of_birth = ?, gender = ?, class_grade = ?, guardian_name = ?, guardian_contact = ?, guardian_email = ?, address = ?, admission_date = ?, status = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['full_name'],
            $data['date_of_birth'],
            $data['gender'],
            $data['class_grade'],
            $data['guardian_name'],
            $data['guardian_contact'],
            $data['guardian_email'],
            $data['address'],
            $data['admission_date'],
            $data['status'],
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM students WHERE id = ?");
        return $stmt->execute([$id]);
    }

    private function generateStudentId() {
        $year = date('Y');
        $stmt = $this->db->query("SELECT COUNT(*) FROM students WHERE YEAR(created_at) = $year");
        $count = $stmt->fetchColumn();
        return "STU-{$year}-" . str_pad($count + 1, 4, '0', STR_PAD_LEFT);
    }
}

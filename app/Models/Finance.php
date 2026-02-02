<?php
namespace App\Models;

use App\Models\Database;
use PDO;

class Finance {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getFeeTypes() {
        $stmt = $this->db->query("SELECT * FROM fee_types ORDER BY name ASC");
        return $stmt->fetchAll();
    }

    public function getFeeStructure($class_grade, $academic_year, $term) {
        $stmt = $this->db->prepare("SELECT fs.*, fsi.amount, ft.name as fee_type_name
                                    FROM fee_structure fs
                                    JOIN fee_structure_items fsi ON fs.id = fsi.fee_structure_id
                                    JOIN fee_types ft ON fsi.fee_type_id = ft.id
                                    WHERE fs.class_grade = ? AND fs.academic_year = ? AND fs.term = ?");
        $stmt->execute([$class_grade, $academic_year, $term]);
        return $stmt->fetchAll();
    }

    public function recordPayment($data) {
        $receipt_number = $this->generateReceiptNumber();
        $sql = "INSERT INTO payments (student_id, amount, payment_date, receipt_number, payment_method, recorded_by)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['student_id'],
            $data['amount'],
            $data['payment_date'],
            $receipt_number,
            $data['payment_method'],
            $data['recorded_by']
        ]);
        return $receipt_number;
    }

    public function getStudentPayments($student_id) {
        $stmt = $this->db->prepare("SELECT * FROM payments WHERE student_id = ? ORDER BY payment_date DESC");
        $stmt->execute([$student_id]);
        return $stmt->fetchAll();
    }

    public function getDefaulters($class_grade = null) {
        // This is a complex query. We need to sum expected fees vs paid fees.
        // For simplicity in this offline refactor:
        $sql = "SELECT s.id, s.student_id, s.full_name, s.class_grade,
                (SELECT SUM(fsi.amount) FROM fee_structure fs JOIN fee_structure_items fsi ON fs.id = fsi.fee_structure_id WHERE fs.class_grade = s.class_grade) as total_expected,
                (SELECT SUM(p.amount) FROM payments p WHERE p.student_id = s.id) as total_paid
                FROM students s
                WHERE s.status = 'Active'";

        if ($class_grade) {
            $sql .= " AND s.class_grade = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$class_grade]);
        } else {
            $stmt = $this->db->query($sql);
        }

        return $stmt->fetchAll();
    }

    private function generateReceiptNumber() {
        $year = date('Y');
        $stmt = $this->db->query("SELECT COUNT(*) FROM payments WHERE YEAR(created_at) = $year");
        $count = $stmt->fetchColumn();
        return "REC-{$year}-" . str_pad($count + 1, 6, '0', STR_PAD_LEFT);
    }
}

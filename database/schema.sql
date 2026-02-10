-- Database Schema for Offline School Management System (OSMS)
-- Target: MySQL

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for users
-- ----------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `full_name` VARCHAR(100) NOT NULL,
  `role` ENUM('Admin', 'Principal', 'Teacher', 'Accountant', 'Clerk', 'Student') NOT NULL DEFAULT 'Clerk',
  `status` ENUM('Active', 'Inactive') NOT NULL DEFAULT 'Active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for students
-- ----------------------------
CREATE TABLE IF NOT EXISTS `students` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `student_id` VARCHAR(20) NOT NULL UNIQUE,
  `user_id` INT DEFAULT NULL,
  `full_name` VARCHAR(255) NOT NULL,
  `date_of_birth` DATE NOT NULL,
  `gender` ENUM('Male', 'Female') NOT NULL,
  `class_grade` VARCHAR(10) NOT NULL,
  `guardian_name` VARCHAR(255) NOT NULL,
  `guardian_contact` VARCHAR(20) NOT NULL,
  `guardian_email` VARCHAR(255) DEFAULT NULL,
  `address` TEXT DEFAULT NULL,
  `photo` VARCHAR(255) DEFAULT NULL,
  `medical_conditions` TEXT DEFAULT NULL,
  `admission_date` DATE NOT NULL,
  `status` ENUM('Active', 'Inactive', 'Graduated') NOT NULL DEFAULT 'Active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for staff
-- ----------------------------
CREATE TABLE IF NOT EXISTS `staff` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `staff_id` VARCHAR(20) NOT NULL UNIQUE,
  `user_id` INT DEFAULT NULL,
  `full_name` VARCHAR(255) NOT NULL,
  `date_of_birth` DATE DEFAULT NULL,
  `gender` ENUM('Male', 'Female') NOT NULL,
  `contact` VARCHAR(20) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `national_id` VARCHAR(50) DEFAULT NULL UNIQUE,
  `qualification` VARCHAR(100) DEFAULT NULL,
  `employment_date` DATE DEFAULT NULL,
  `employment_type` ENUM('Permanent', 'Contract', 'Part-time') DEFAULT 'Permanent',
  `salary_encrypted` TEXT DEFAULT NULL,
  `photo` VARCHAR(255) DEFAULT NULL,
  `address` TEXT DEFAULT NULL,
  `status` ENUM('Active', 'On Leave', 'Terminated') NOT NULL DEFAULT 'Active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for courses
-- ----------------------------
CREATE TABLE IF NOT EXISTS `courses` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `course_code` VARCHAR(20) NOT NULL UNIQUE,
  `course_name` VARCHAR(255) NOT NULL,
  `grade_level` VARCHAR(10) NOT NULL,
  `course_type` ENUM('Core', 'Elective', 'Extra-curricular') DEFAULT 'Core',
  `credits` INT DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `status` ENUM('Active', 'Inactive') DEFAULT 'Active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for enrollments
-- ----------------------------
CREATE TABLE IF NOT EXISTS `enrollments` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `student_id` INT NOT NULL,
  `course_id` INT NOT NULL,
  `term` ENUM('Term 1', 'Term 2', 'Term 3') NOT NULL,
  `academic_year` YEAR NOT NULL,
  `enrolled_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `unique_enrollment` (`student_id`, `course_id`, `term`, `academic_year`),
  FOREIGN KEY (`student_id`) REFERENCES `students`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`course_id`) REFERENCES `courses`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for assessments
-- ----------------------------
CREATE TABLE IF NOT EXISTS `assessments` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `course_id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `type` ENUM('Quiz', 'Test', 'Exam', 'Assignment', 'Project') NOT NULL,
  `date` DATE NOT NULL,
  `max_score` INT DEFAULT 100,
  `weight` INT DEFAULT 100,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`course_id`) REFERENCES `courses`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for submissions (Grades)
-- ----------------------------
CREATE TABLE IF NOT EXISTS `submissions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `assessment_id` INT NOT NULL,
  `student_id` INT NOT NULL,
  `score` DECIMAL(5,2) NOT NULL,
  `recorded_by` INT DEFAULT NULL,
  `recorded_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `unique_submission` (`assessment_id`, `student_id`),
  FOREIGN KEY (`assessment_id`) REFERENCES `assessments`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`student_id`) REFERENCES `students`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`recorded_by`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for attendance
-- ----------------------------
CREATE TABLE IF NOT EXISTS `attendance` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `student_id` INT NOT NULL,
  `course_id` INT NOT NULL,
  `date` DATE NOT NULL,
  `status` ENUM('Present', 'Absent', 'Late', 'Excused') NOT NULL DEFAULT 'Present',
  `remarks` TEXT DEFAULT NULL,
  `recorded_by` INT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `unique_attendance` (`student_id`, `course_id`, `date`),
  FOREIGN KEY (`student_id`) REFERENCES `students`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`course_id`) REFERENCES `courses`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`recorded_by`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for audit_logs
-- ----------------------------
CREATE TABLE IF NOT EXISTS `audit_logs` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT DEFAULT NULL,
  `action` VARCHAR(255) NOT NULL,
  `details` TEXT DEFAULT NULL,
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for fee_types
-- ----------------------------
CREATE TABLE IF NOT EXISTS `fee_types` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL UNIQUE,
  `description` TEXT DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for fee_structure
-- ----------------------------
CREATE TABLE IF NOT EXISTS `fee_structure` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `class_grade` VARCHAR(10) NOT NULL,
  `academic_year` YEAR NOT NULL,
  `term` ENUM('Term 1', 'Term 2', 'Term 3') NOT NULL,
  UNIQUE KEY `unique_structure` (`class_grade`, `academic_year`, `term`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for fee_structure_items
-- ----------------------------
CREATE TABLE IF NOT EXISTS `fee_structure_items` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `fee_structure_id` INT NOT NULL,
  `fee_type_id` INT NOT NULL,
  `amount` DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (`fee_structure_id`) REFERENCES `fee_structure`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`fee_type_id`) REFERENCES `fee_types`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for payments
-- ----------------------------
CREATE TABLE IF NOT EXISTS `payments` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `student_id` INT NOT NULL,
  `amount` DECIMAL(10,2) NOT NULL,
  `payment_date` DATE NOT NULL,
  `receipt_number` VARCHAR(50) NOT NULL UNIQUE,
  `payment_method` ENUM('Cash', 'Mobile Money', 'Bank Transfer', 'Cheque') NOT NULL,
  `recorded_by` INT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`student_id`) REFERENCES `students`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`recorded_by`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;

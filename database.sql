-- =================================================================
-- DATABASE SCHEMA: KATUGUNDA SKILLS DEVELOPMENT CENTRE (KSM)
-- VERSION: 1.0 (Offline Production)
-- AUTHOR: Gemini (for KSDC Tech Team)
-- STANDARDS: UVQF / DIT / UBTEB / TVET Act 2025
-- =================================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+03:00"; -- East Africa Time

-- --------------------------------------------------------
-- 1. SETUP & CORE CONFIGURATION
-- --------------------------------------------------------

-- Users Table (RBAC: Admin, Bursar, Registrar, Instructor)
CREATE TABLE `system_users` (
  `user_id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `full_name` VARCHAR(100) NOT NULL,
  `role` ENUM('ADMIN', 'BURSAR', 'REGISTRAR', 'INSTRUCTOR') NOT NULL,
  `department_access` INT(11) DEFAULT NULL COMMENT 'Link to department_id if Instructor',
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Academic Years & Terms
CREATE TABLE `academic_periods` (
  `period_id` INT(11) NOT NULL AUTO_INCREMENT,
  `academic_year` INT(4) NOT NULL COMMENT 'e.g. 2026',
  `term` ENUM('TERM_1', 'TERM_2', 'TERM_3', 'RECESS_TERM') NOT NULL,
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  `is_current` TINYINT(1) DEFAULT 0,
  PRIMARY KEY (`period_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 2. ACADEMIC STRUCTURE (UVQF STANDARD)
-- --------------------------------------------------------

-- Departments (e.g., Automotive, Building)
CREATE TABLE `departments` (
  `dept_id` INT(11) NOT NULL AUTO_INCREMENT,
  `dept_code` VARCHAR(10) NOT NULL UNIQUE COMMENT 'e.g. MECH, AGRI',
  `dept_name` VARCHAR(100) NOT NULL,
  `hod_name` VARCHAR(100) DEFAULT NULL,
  PRIMARY KEY (`dept_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Courses / Trades
CREATE TABLE `courses` (
  `course_id` INT(11) NOT NULL AUTO_INCREMENT,
  `dept_id` INT(11) NOT NULL,
  `course_name` VARCHAR(150) NOT NULL,
  `course_code` VARCHAR(20) NOT NULL UNIQUE,
  `level` ENUM('UCPC', 'NC', 'NON_FORMAL', 'SHORT_COURSE') NOT NULL,
  `duration_months` INT(3) NOT NULL,
  PRIMARY KEY (`course_id`),
  FOREIGN KEY (`dept_id`) REFERENCES `departments`(`dept_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Competency Modules (The actual units taught)
CREATE TABLE `modules` (
  `module_id` INT(11) NOT NULL AUTO_INCREMENT,
  `course_id` INT(11) NOT NULL,
  `module_code` VARCHAR(20) NOT NULL COMMENT 'DIT/UBTEB Code',
  `module_title` VARCHAR(200) NOT NULL,
  `credits` INT(2) DEFAULT 3,
  PRIMARY KEY (`module_id`),
  FOREIGN KEY (`course_id`) REFERENCES `courses`(`course_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 3. STUDENT MANAGEMENT (ENROLLMENT)
-- --------------------------------------------------------

CREATE TABLE `students` (
  `student_id` INT(11) NOT NULL AUTO_INCREMENT,
  `student_reg_no` VARCHAR(50) NOT NULL UNIQUE COMMENT 'KSDC/2026/NF/001',
  `lin_number` VARCHAR(20) DEFAULT NULL COMMENT 'Learner ID Number (MoES)',
  `nin_number` VARCHAR(20) DEFAULT NULL COMMENT 'National ID',
  `first_name` VARCHAR(50) NOT NULL,
  `surname` VARCHAR(50) NOT NULL,
  `gender` ENUM('MALE', 'FEMALE') NOT NULL,
  `dob` DATE NOT NULL,
  `village` VARCHAR(100) DEFAULT NULL,
  `district` VARCHAR(50) DEFAULT 'Bunyangabu',
  `parent_contact` VARCHAR(20) DEFAULT NULL,
  `track_type` ENUM('FORMAL', 'NON_FORMAL') NOT NULL,
  `enrollment_date` DATE DEFAULT CURRENT_DATE,
  `status` ENUM('ACTIVE', 'DROPOUT', 'GRADUATED', 'SUSPENDED') DEFAULT 'ACTIVE',
  `photo_path` VARCHAR(255) DEFAULT 'default_avatar.png',
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Mapping Student to a Course for a Specific Year
CREATE TABLE `student_enrollments` (
  `enrollment_id` INT(11) NOT NULL AUTO_INCREMENT,
  `student_id` INT(11) NOT NULL,
  `course_id` INT(11) NOT NULL,
  `period_id` INT(11) NOT NULL,
  `is_repeating` TINYINT(1) DEFAULT 0,
  PRIMARY KEY (`enrollment_id`),
  FOREIGN KEY (`student_id`) REFERENCES `students`(`student_id`) ON DELETE RESTRICT,
  FOREIGN KEY (`course_id`) REFERENCES `courses`(`course_id`) ON DELETE RESTRICT,
  FOREIGN KEY (`period_id`) REFERENCES `academic_periods`(`period_id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 4. FINANCIAL MODULE (BURSAR)
-- --------------------------------------------------------

-- Fee Structure (Defines how much to pay)
CREATE TABLE `fee_structures` (
  `structure_id` INT(11) NOT NULL AUTO_INCREMENT,
  `course_id` INT(11) NOT NULL,
  `period_id` INT(11) NOT NULL,
  `category` ENUM('PRIVATE', 'GOVT', 'PARTNER') NOT NULL,
  `amount_tuition` DECIMAL(10, 2) NOT NULL DEFAULT 0,
  `amount_functional` DECIMAL(10, 2) NOT NULL DEFAULT 0,
  `amount_assessment` DECIMAL(10, 2) NOT NULL DEFAULT 0 COMMENT 'DIT/UBTEB Fee',
  PRIMARY KEY (`structure_id`),
  FOREIGN KEY (`course_id`) REFERENCES `courses`(`course_id`) ON DELETE CASCADE,
  FOREIGN KEY (`period_id`) REFERENCES `academic_periods`(`period_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Payments (The Ledger)
CREATE TABLE `payments` (
  `payment_id` INT(11) NOT NULL AUTO_INCREMENT,
  `receipt_no` VARCHAR(20) NOT NULL UNIQUE,
  `student_id` INT(11) NOT NULL,
  `period_id` INT(11) NOT NULL,
  `amount_paid` DECIMAL(10, 2) NOT NULL,
  `payment_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `payment_method` ENUM('CASH', 'BANK_SLIP', 'MOBILE_MONEY', 'SPONSORSHIP') NOT NULL,
  `paid_by` VARCHAR(100) DEFAULT 'SELF',
  `recorded_by_user` INT(11) NOT NULL,
  `notes` TEXT DEFAULT NULL,
  PRIMARY KEY (`payment_id`),
  FOREIGN KEY (`student_id`) REFERENCES `students`(`student_id`) ON DELETE RESTRICT,
  FOREIGN KEY (`period_id`) REFERENCES `academic_periods`(`period_id`) ON DELETE RESTRICT,
  FOREIGN KEY (`recorded_by_user`) REFERENCES `system_users`(`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sponsorships (Tracking WHH / JESE Funds)
CREATE TABLE `sponsorships` (
  `sponsorship_id` INT(11) NOT NULL AUTO_INCREMENT,
  `sponsor_name` VARCHAR(100) NOT NULL COMMENT 'e.g. Welthungerhilfe',
  `student_id` INT(11) NOT NULL,
  `total_allocation` DECIMAL(10, 2) NOT NULL,
  `used_amount` DECIMAL(10, 2) DEFAULT 0,
  `startup_kit_eligible` TINYINT(1) DEFAULT 0,
  PRIMARY KEY (`sponsorship_id`),
  FOREIGN KEY (`student_id`) REFERENCES `students`(`student_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 5. GRADING & ASSESSMENT (CBET)
-- --------------------------------------------------------

CREATE TABLE `assessment_records` (
  `record_id` INT(11) NOT NULL AUTO_INCREMENT,
  `student_id` INT(11) NOT NULL,
  `module_id` INT(11) NOT NULL,
  `period_id` INT(11) NOT NULL,
  `score_practical` DECIMAL(5, 2) DEFAULT 0 COMMENT 'Out of 60%',
  `score_theory` DECIMAL(5, 2) DEFAULT 0 COMMENT 'Out of 40%',
  `final_mark` DECIMAL(5, 2) GENERATED ALWAYS AS (`score_practical` + `score_theory`) STORED,
  `competency_status` ENUM('C', 'NYC') GENERATED ALWAYS AS (IF(`final_mark` >= 60, 'C', 'NYC')) STORED,
  `instructor_remarks` TEXT DEFAULT NULL,
  `entered_by` INT(11) NOT NULL,
  `entry_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`record_id`),
  UNIQUE KEY `unique_student_module` (`student_id`, `module_id`, `period_id`),
  FOREIGN KEY (`student_id`) REFERENCES `students`(`student_id`) ON DELETE RESTRICT,
  FOREIGN KEY (`module_id`) REFERENCES `modules`(`module_id`) ON DELETE RESTRICT,
  FOREIGN KEY (`entered_by`) REFERENCES `system_users`(`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 6. VIEWS (FOR REPORTS & EXPORT)
-- --------------------------------------------------------

-- View for Student Financial Clearance (Bursar Dashboard)
CREATE VIEW `view_financial_status` AS
SELECT 
    s.student_id,
    s.student_reg_no,
    CONCAT(s.first_name, ' ', s.surname) AS full_name,
    fs.amount_tuition + fs.amount_functional + fs.amount_assessment AS total_fees,
    IFNULL(SUM(p.amount_paid), 0) AS total_paid,
    (fs.amount_tuition + fs.amount_functional + fs.amount_assessment) - IFNULL(SUM(p.amount_paid), 0) AS balance,
    CASE 
        WHEN ((fs.amount_tuition + fs.amount_functional + fs.amount_assessment) - IFNULL(SUM(p.amount_paid), 0)) <= 0 THEN 'CLEARED'
        ELSE 'PENDING'
    END AS clearance_status
FROM students s
JOIN student_enrollments se ON s.student_id = se.student_id
JOIN fee_structures fs ON se.course_id = fs.course_id AND se.period_id = fs.period_id
LEFT JOIN payments p ON s.student_id = p.student_id AND se.period_id = p.period_id
GROUP BY s.student_id, se.period_id;

-- --------------------------------------------------------
-- 7. SEED DATA (INITIAL SETUP)
-- --------------------------------------------------------

-- Default Admin User (Password: admin123 - You must hash this in PHP!)
INSERT INTO `system_users` (`username`, `password_hash`, `full_name`, `role`) VALUES
('admin', '$2y$10$abcdefg...', 'System Administrator', 'ADMIN');

-- Sample Departments
INSERT INTO `departments` (`dept_code`, `dept_name`) VALUES 
('AGRI', 'Agriculture'),
('MECH', 'Automotive Mechanics'),
('BLDG', 'Building & Construction'),
('TAIL', 'Tailoring & Design');

-- Sample Courses
INSERT INTO `courses` (`dept_id`, `course_name`, `course_code`, `level`, `duration_months`) VALUES
(2, 'National Certificate in Automotive Mechanics', 'NCAM', 'NC', 24),
(4, 'Certificate in Tailoring', 'UCPC-TAIL', 'UCPC', 12);

COMMIT;

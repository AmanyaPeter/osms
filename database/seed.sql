-- Seed Data for OSMS
-- Default Passwords are all 'admin123' -> $2y$10$mC7GDUByhjL2A99yP/J2O.tG9F6mBwE3mQpL6WJ6Wz6P6Z6Z6Z6Z6 (Wait, better use a real one)
-- Using $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi which is 'password'

SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` (`username`, `password`, `full_name`, `role`, `status`) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'System Administrator', 'Admin', 'Active'),
('teacher1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'John Mugisha', 'Teacher', 'Active'),
('teacher2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Sarah Namutebi', 'Teacher', 'Active'),
('student1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Peter Okello', 'Student', 'Active');

-- ----------------------------
-- Records of staff
-- ----------------------------
INSERT INTO `staff` (`staff_id`, `user_id`, `full_name`, `gender`, `contact`, `email`, `national_id`, `qualification`, `employment_date`, `employment_type`) VALUES
('TEA-2026-0001', 2, 'John Mugisha', 'Male', '0770000001', 'john.mugisha@school.ug', 'CM1234567890', 'Degree', '2020-01-15', 'Permanent'),
('TEA-2026-0002', 3, 'Sarah Namutebi', 'Female', '0770000002', 'sarah.nam@school.ug', 'CF0987654321', 'Masters', '2021-05-10', 'Permanent');

-- ----------------------------
-- Records of students
-- ----------------------------
INSERT INTO `students` (`student_id`, `user_id`, `full_name`, `date_of_birth`, `gender`, `class_grade`, `guardian_name`, `guardian_contact`, `admission_date`) VALUES
('STU-2026-0001', 4, 'Peter Okello', '2012-04-12', 'Male', 'P5', 'James Okello', '0700112233', '2024-02-01');

-- ----------------------------
-- Records of courses
-- ----------------------------
INSERT INTO `courses` (`course_code`, `course_name`, `grade_level`, `course_type`, `credits`) VALUES
('MATH-P5', 'Mathematics', 'P5', 'Core', 5),
('ENG-P5', 'English', 'P5', 'Core', 5),
('SCI-P5', 'Science', 'P5', 'Core', 4),
('SST-P5', 'Social Studies', 'P5', 'Core', 4);

-- ----------------------------
-- Records of enrollments
-- ----------------------------
INSERT INTO `enrollments` (`student_id`, `course_id`, `term`, `academic_year`) VALUES
(1, 1, 'Term 1', 2026),
(1, 2, 'Term 1', 2026),
(1, 3, 'Term 1', 2026),
(1, 4, 'Term 1', 2026);

-- ----------------------------
-- Records of fee_types
-- ----------------------------
INSERT INTO `fee_types` (`name`, `description`) VALUES
('Tuition', 'Standard tuition fee'),
('Lunch', 'Daily school lunch'),
('Uniform', 'School uniform set');

-- ----------------------------
-- Records of fee_structure
-- ----------------------------
INSERT INTO `fee_structure` (`class_grade`, `academic_year`, `term`) VALUES
('P5', 2026, 'Term 1');

-- ----------------------------
-- Records of fee_structure_items
-- ----------------------------
INSERT INTO `fee_structure_items` (`fee_structure_id`, `fee_type_id`, `amount`) VALUES
(1, 1, 300000.00),
(1, 2, 50000.00),
(1, 3, 20000.00);

-- ----------------------------
-- Records of payments
-- ----------------------------
INSERT INTO `payments` (`student_id`, `amount`, `payment_date`, `receipt_number`, `payment_method`, `recorded_by`) VALUES
(1, 150000.00, '2026-02-01', 'REC-2026-000001', 'Cash', 1);

SET FOREIGN_KEY_CHECKS = 1;

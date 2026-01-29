# **Offline School Management System (OSMS)**
## **Product Requirements Document (PRD)**

**Version:** 1.0  
**Date:** January 25, 2026  
**Project Type:** Desktop Application (Offline)  
**Target Users:** Ugandan Schools  
**Platform:** Windows Desktop (Single Computer)

---

## **1. EXECUTIVE SUMMARY**

### **1.1 Product Overview**
The Offline School Management System (OSMS) is a standalone desktop application designed to manage all academic, administrative, and financial operations for Ugandan schools. The system operates entirely offline on a single computer, optimized for low-resource environments (4GB RAM minimum).

### **1.2 Business Objectives**
- Digitize student records and academic management
- Automate fee tracking and payment processing
- Generate report cards and academic reports automatically
- Eliminate paper-based record keeping
- Provide reliable system that works without internet connectivity

### **1.3 Success Metrics**
- System runs smoothly on 4GB RAM computer
- Database backup success rate: 100% (daily)
- User can open application with single click
- All reports generate in under 5 seconds
- Zero data loss during power outages

---

## **2. TECHNICAL STACK**

| Layer | Technology | Version | Justification |
|-------|-----------|---------|---------------|
| **Database** | SQLite | 3.x | Single file, no server needed, crash-resistant |
| **Backend** | Python Django | 5.0+ | Built-in admin, ORM, mature framework |
| **Desktop Wrapper** | PyWebView | 5.0+ | Native desktop experience, simple user launch |
| **Background Tasks** | APScheduler | 3.10+ | Automated backups, scheduled tasks |
| **Encryption** | cryptography | 42.0+ | Secure sensitive student data |
| **PDF Generation** | ReportLab | 4.1+ | Report cards, receipts, transcripts |
| **Excel Export** | openpyxl | 3.1+ | Financial reports, data exports |
| **Image Processing** | Pillow | 10.2+ | Student photos, document uploads |

---

## **3. SYSTEM ARCHITECTURE**

### **3.1 Deployment Architecture**

```
Single Computer Deployment:
┌─────────────────────────────────────────────┐
│  School Computer (Windows 10/11, 4GB RAM)  │
│                                             │
│  ┌───────────────────────────────────────┐ │
│  │  Desktop Executable                   │ │
│  │  "School Management System.exe"       │ │
│  │  (PyWebView Wrapper)                  │ │
│  └─────────────────┬─────────────────────┘ │
│                    │ Auto-launches         │
│                    ▼                       │
│  ┌───────────────────────────────────────┐ │
│  │  Django Application Server            │ │
│  │  (localhost:8000)                     │ │
│  │  - Admin Interface                    │ │
│  │  - Student Management                 │ │
│  │  - Academic Module                    │ │
│  │  - Finance Module                     │ │
│  │  - Reports Generation                 │ │
│  └─────────────────┬─────────────────────┘ │
│                    │                       │
│                    ▼                       │
│  ┌───────────────────────────────────────┐ │
│  │  SQLite Database                      │ │
│  │  C:/SchoolData/school.db              │ │
│  │  - All tables, relationships          │ │
│  └───────────────────────────────────────┘ │
│                                             │
│  ┌───────────────────────────────────────┐ │
│  │  File Storage (Local)                 │ │
│  │  C:/SchoolData/media/                 │ │
│  │  - students/photos/                   │ │
│  │  - documents/                         │ │
│  │  - reports/pdf/                       │ │
│  │  - receipts/                          │ │
│  └───────────────────────────────────────┘ │
│                                             │
│  ┌───────────────────────────────────────┐ │
│  │  Background Scheduler (APScheduler)   │ │
│  │  - Daily backup (2:00 AM)             │ │
│  │  - Weekly reports                     │ │
│  └───────────────────────────────────────┘ │
│                                             │
│  ┌───────────────────────────────────────┐ │
│  │  USB Backup Drive (D:/ or E:/)        │ │
│  │  /SchoolBackups/                      │ │
│  │    - daily_backup_YYYY-MM-DD.db       │ │
│  │    - media_backup_YYYY-MM-DD/         │ │
│  └───────────────────────────────────────┘ │
└─────────────────────────────────────────────┘
```

### **3.2 Application Layers**

```
┌──────────────────────────────────────┐
│     PRESENTATION LAYER               │
│  (PyWebView Desktop Window)          │
│  - User Interface (HTML/CSS/JS)      │
│  - Bootstrap 5 Framework             │
│  - Responsive forms and tables       │
└──────────────┬───────────────────────┘
               │
               ▼
┌──────────────────────────────────────┐
│     BUSINESS LOGIC LAYER             │
│  (Django Views & Business Logic)     │
│  - Student Management                │
│  - Academic Operations               │
│  - Financial Processing              │
│  - Report Generation                 │
│  - User Authentication               │
└──────────────┬───────────────────────┘
               │
               ▼
┌──────────────────────────────────────┐
│     DATA ACCESS LAYER                │
│  (Django ORM Models)                 │
│  - Student, Teacher, Course          │
│  - Enrollment, Attendance, Grade     │
│  - Fee, Payment, Receipt             │
│  - Timetable, User, Role             │
└──────────────┬───────────────────────┘
               │
               ▼
┌──────────────────────────────────────┐
│     DATABASE LAYER                   │
│  (SQLite Database)                   │
│  - Normalized schema                 │
│  - Foreign key constraints           │
│  - Indexed primary keys              │
└──────────────────────────────────────┘
```

---

## **4. USER ROLES & PERMISSIONS**

### **4.1 User Roles**

| Role | Description | Access Level |
|------|-------------|--------------|
| **Admin** | System administrator, full access | All modules, all permissions |
| **Principal** | School head, oversight | View all, approve reports |
| **Teacher** | Academic staff | Mark attendance, enter grades, view students |
| **Accountant** | Financial officer | Fee management, payment processing |
| **Data Clerk** | Data entry staff | Student registration, basic updates |

### **4.2 Permission Matrix**

| Function | Admin | Principal | Teacher | Accountant | Clerk |
|----------|-------|-----------|---------|------------|-------|
| Manage Users | ✅ | ❌ | ❌ | ❌ | ❌ |
| Register Students | ✅ | ✅ | ❌ | ❌ | ✅ |
| Edit Student Info | ✅ | ✅ | ❌ | ❌ | ✅ |
| Delete Students | ✅ | ✅ | ❌ | ❌ | ❌ |
| Enroll Students | ✅ | ✅ | ✅ | ❌ | ✅ |
| Mark Attendance | ✅ | ✅ | ✅ | ❌ | ❌ |
| Enter Grades | ✅ | ✅ | ✅ | ❌ | ❌ |
| Generate Report Cards | ✅ | ✅ | ✅ | ❌ | ❌ |
| Record Payments | ✅ | ✅ | ❌ | ✅ | ❌ |
| View Financial Reports | ✅ | ✅ | ❌ | ✅ | ❌ |
| Manage Timetable | ✅ | ✅ | ✅ | ❌ | ❌ |
| System Backup | ✅ | ❌ | ❌ | ❌ | ❌ |
| View Audit Logs | ✅ | ✅ | ❌ | ❌ | ❌ |

---

## **5. FUNCTIONAL REQUIREMENTS**

### **5.1 User Authentication & Authorization**

#### **FR-AUTH-001: User Login**
- **Description:** Users must log in with username and password
- **Acceptance Criteria:**
  - Login form with username and password fields
  - "Remember me" checkbox (session persistence)
  - Password masked by default
  - Invalid credentials show error message
  - Successful login redirects to dashboard
  - Maximum 3 failed attempts locks account for 15 minutes
- **Priority:** Critical

#### **FR-AUTH-002: Password Management**
- **Description:** Users can change their passwords
- **Acceptance Criteria:**
  - Current password verification required
  - New password must be minimum 8 characters
  - Password confirmation field must match
  - Password hashed using Django's PBKDF2 algorithm
  - Success message displayed after change
- **Priority:** High

#### **FR-AUTH-003: Role-Based Access Control**
- **Description:** User permissions based on assigned role
- **Acceptance Criteria:**
  - Each user assigned one primary role
  - Navigation menu shows only permitted modules
  - Unauthorized access attempts logged and blocked
  - 403 error page for unauthorized actions
- **Priority:** Critical

---

### **5.2 Student Management Module**

#### **FR-STU-001: Student Registration**
- **Description:** Register new students with complete information
- **Input Fields:**
  - Student ID (auto-generated, format: STU-YYYY-NNNN)
  - Full Name (required)
  - Date of Birth (required, date picker)
  - Gender (dropdown: Male/Female)
  - Class/Grade (dropdown: P1-P7 or S1-S6)
  - Guardian Name (required)
  - Guardian Contact (required, phone validation)
  - Guardian Email (optional)
  - Home Address (text area)
  - Student Photo (image upload, max 2MB, JPG/PNG)
  - Medical Conditions (optional, text area)
  - Previous School (optional)
  - Admission Date (required, defaults to today)
  - Student Status (dropdown: Active/Inactive/Graduated)
- **Validation Rules:**
  - Phone: 10 digits, Uganda format (07XX XXX XXX)
  - Email: Valid email format
  - Photo: Max 2MB, JPG/PNG only
  - Age: Between 3-25 years
- **Business Logic:**
  - Student ID auto-generated on save
  - Duplicate phone number warning (not blocking)
  - Photo automatically resized to 300x300px
- **Acceptance Criteria:**
  - Form validates all required fields
  - Success message: "Student registered successfully"
  - Redirect to student detail page after save
  - Photo thumbnail visible on form
- **Priority:** Critical

#### **FR-STU-002: Student Search & Filter**
- **Description:** Search and filter student records
- **Search Criteria:**
  - Student ID (exact match)
  - Name (partial match, case-insensitive)
  - Class (dropdown filter)
  - Status (dropdown: Active/Inactive/Graduated/All)
  - Guardian Contact (partial match)
- **Display:**
  - Table with columns: Photo, ID, Name, Class, Guardian, Contact, Status
  - Pagination (25 students per page)
  - Sort by: Name, ID, Class, Date (ascending/descending)
  - Export to Excel button
- **Acceptance Criteria:**
  - Search results update without page reload (AJAX)
  - Empty state message: "No students found"
  - Search executes on Enter key
- **Priority:** High

#### **FR-STU-003: Student Profile View**
- **Description:** View complete student information
- **Display Sections:**
  - Personal Information (photo, name, DOB, gender, ID)
  - Guardian Information (name, contact, email, address)
  - Academic Information (current class, enrollment date, status)
  - Attendance Summary (present %, absent %, late %)
  - Grade Summary (current term average, position)
  - Fee Status (total due, paid, balance)
  - Recent Activity (last 10 activities)
- **Actions:**
  - Edit Student button (if permitted)
  - Print Profile button (PDF)
  - View Full Attendance (link)
  - View Full Grades (link)
  - View Fee History (link)
- **Acceptance Criteria:**
  - Page loads in under 2 seconds
  - All data displays correctly
  - Print generates clean PDF
- **Priority:** High

#### **FR-STU-004: Student Update**
- **Description:** Edit existing student information
- **Editable Fields:** Same as registration (except Student ID)
- **Validation:** Same as registration
- **Business Logic:**
  - Changes logged in audit trail
  - Modified by user and timestamp recorded
  - Status change from Active to Graduated prompts confirmation
- **Acceptance Criteria:**
  - Confirmation message before saving
  - Success message: "Student updated successfully"
  - Changes immediately visible
- **Priority:** High

#### **FR-STU-005: Student Deletion**
- **Description:** Soft delete student records (admin only)
- **Business Logic:**
  - Soft delete (set is_deleted=True, retain data)
  - Cannot delete student with unpaid fees (warning)
  - Cannot delete student with current enrollment (warning)
  - Deletion logged with reason
- **Acceptance Criteria:**
  - Confirmation dialog: "Are you sure? This action cannot be undone."
  - Reason field required
  - Success message: "Student deleted successfully"
  - Deleted students hidden from default view
  - Admin can view deleted students in archive
- **Priority:** Medium

#### **FR-STU-006: Bulk Student Import**
- **Description:** Import multiple students from Excel file
- **File Format:**
  - Excel (.xlsx)
  - Template downloadable from system
  - Required columns: Name, DOB, Gender, Class, Guardian Name, Guardian Contact
  - Optional columns: Email, Address, Medical Conditions
- **Validation:**
  - Validate all rows before import
  - Show validation errors with row numbers
  - Partial import not allowed (all or nothing)
- **Acceptance Criteria:**
  - Template download button
  - File upload with preview (first 10 rows)
  - Validation report before import
  - Progress bar during import
  - Success summary: "50 students imported successfully"
- **Priority:** Low

---

### **5.3 Teacher Management Module**

#### **FR-TEA-001: Teacher Registration**
- **Description:** Register teaching staff
- **Input Fields:**
  - Teacher ID (auto-generated, format: TEA-YYYY-NNNN)
  - Full Name (required)
  - Date of Birth (required)
  - Gender (dropdown: Male/Female)
  - Contact Phone (required, validation)
  - Email (required, unique)
  - National ID (required, unique)
  - Qualification (dropdown: Certificate/Diploma/Degree/Masters/PhD)
  - Subject Specialization (multi-select)
  - Employment Date (required)
  - Employment Type (dropdown: Permanent/Contract/Part-time)
  - Salary (decimal, optional, encrypted)
  - Photo (image upload, max 2MB)
  - Address (text area)
  - Emergency Contact (phone)
  - Status (dropdown: Active/On Leave/Terminated)
- **Validation:**
  - Email unique check
  - National ID unique check
  - Phone: Uganda format
- **Acceptance Criteria:**
  - Teacher ID auto-generated
  - Success message displayed
  - Redirect to teacher detail page
- **Priority:** High

#### **FR-TEA-002: Teacher Assignment**
- **Description:** Assign teachers to courses/subjects
- **Fields:**
  - Teacher (dropdown)
  - Course (dropdown)
  - Class (dropdown)
  - Term (dropdown: Term 1/2/3)
  - Year (auto-filled, current year)
- **Business Logic:**
  - One teacher can teach multiple courses
  - One course in a class can have only one teacher per term
  - Warning if teacher has >6 courses
- **Acceptance Criteria:**
  - Duplicate assignment blocked
  - Success message displayed
  - Assignment visible on teacher profile
- **Priority:** High

#### **FR-TEA-003: Teacher Timetable View**
- **Description:** View teacher's weekly schedule
- **Display:**
  - Weekly grid (Monday-Friday)
  - Time slots (8:00 AM - 5:00 PM)
  - Class, Subject for each slot
  - Print timetable button
- **Acceptance Criteria:**
  - Color-coded by subject
  - Free periods clearly shown
  - Conflicts highlighted in red
- **Priority:** Medium

---

### **5.4 Course Management Module**

#### **FR-COU-001: Course Creation**
- **Description:** Create academic courses/subjects
- **Input Fields:**
  - Course Code (required, unique, format: MATH-S1, ENG-P5)
  - Course Name (required, e.g., "Mathematics", "English")
  - Grade Level (dropdown: P1-P7, S1-S6)
  - Course Type (dropdown: Core/Elective/Extra-curricular)
  - Credit Hours (integer, optional)
  - Description (text area, optional)
  - Status (dropdown: Active/Inactive)
- **Validation:**
  - Course code must be unique
  - Course name + grade level combination must be unique
- **Acceptance Criteria:**
  - Course code auto-suggested (subject initials + grade)
  - Success message displayed
  - Active courses shown in dropdowns
- **Priority:** High

#### **FR-COU-002: Course Listing**
- **Description:** View all courses
- **Display:**
  - Table: Code, Name, Level, Teacher, Enrolled Students, Status
  - Filter by: Level, Type, Status
  - Sort by: Code, Name, Level
  - Search by name or code
- **Acceptance Criteria:**
  - Pagination (50 courses per page)
  - Export to Excel
  - Click row to view details
- **Priority:** Medium

---

### **5.5 Enrollment Module**

#### **FR-ENR-001: Student Enrollment**
- **Description:** Enroll students in courses
- **Input Fields:**
  - Student (searchable dropdown with type-ahead)
  - Academic Year (dropdown: 2024, 2025, 2026...)
  - Term (dropdown: Term 1/2/3)
  - Class (dropdown: P1-P7, S1-S6)
  - Courses (multi-select checkboxes, filtered by class)
  - Enrollment Date (defaults to today)
- **Business Logic:**
  - Student can only be enrolled in one class per term
  - Cannot enroll if student has unpaid fees >50,000 UGX (warning, not blocking)
  - Auto-select all core courses for the class
  - Allow selection of elective courses
- **Validation:**
  - Cannot enroll in past terms
  - Duplicate enrollment blocked
- **Acceptance Criteria:**
  - Type-ahead search for student (by name or ID)
  - Core courses pre-selected
  - Warning for fee arrears
  - Success message: "Student enrolled successfully"
  - Enrollment record created for each course
- **Priority:** Critical

#### **FR-ENR-002: Bulk Enrollment**
- **Description:** Enroll entire class at once
- **Input:**
  - Class (dropdown)
  - Academic Year (dropdown)
  - Term (dropdown)
  - Students (multi-select, shows all students in that class)
- **Business Logic:**
  - Enroll selected students in all core courses
  - Skip students already enrolled (show warning)
- **Acceptance Criteria:**
  - Select all/deselect all checkboxes
  - Preview before enrolling
  - Progress bar during enrollment
  - Summary: "25 students enrolled in 8 courses each"
- **Priority:** Medium

#### **FR-ENR-003: Enrollment Status View**
- **Description:** View enrollment status for a term
- **Display:**
  - Table: Student, Class, Courses (count), Enrollment Date, Status
  - Filter by: Class, Status (Active/Dropped/Completed)
  - Summary statistics: Total enrolled, by class
- **Acceptance Criteria:**
  - Export to Excel
  - Click student to view details
- **Priority:** Low

---

### **5.6 Attendance Module**

#### **FR-ATT-001: Mark Daily Attendance**
- **Description:** Teachers mark student attendance
- **Input:**
  - Date (defaults to today, can select past 7 days)
  - Course (dropdown, filtered by teacher's courses)
  - Class (auto-filled from course)
  - Student list (all enrolled students)
  - Status for each student (radio: Present/Absent/Late/Excused)
- **Business Logic:**
  - Cannot mark attendance for future dates
  - Cannot mark attendance for dates >7 days ago (admin can override)
  - Previous attendance editable for 24 hours
  - Default status: Present (for quick marking)
- **UI/UX:**
  - Student list with photos
  - Quick select: Mark All Present button
  - Color coding: Green=Present, Red=Absent, Yellow=Late, Blue=Excused
  - Auto-save every 30 seconds (draft)
- **Acceptance Criteria:**
  - Page loads in under 2 seconds
  - Submit attendance button
  - Success message: "Attendance marked for 30 students"
  - Cannot submit without marking all students
- **Priority:** Critical

#### **FR-ATT-002: Attendance Report (Student)**
- **Description:** View individual student attendance
- **Input:**
  - Student (searchable dropdown)
  - Term (dropdown)
  - Academic Year (dropdown)
- **Display:**
  - Summary: Total Days, Present, Absent, Late, Excused, Attendance %
  - Calendar view showing color-coded days
  - List view: Date, Course, Status
  - Chart: Attendance trend over term
- **Acceptance Criteria:**
  - Print report button (PDF)
  - Export to Excel
  - Attendance % calculated correctly
- **Priority:** High

#### **FR-ATT-003: Attendance Report (Class)**
- **Description:** View class attendance summary
- **Input:**
  - Class (dropdown)
  - Date Range (start date, end date)
  - Course (dropdown, optional filter)
- **Display:**
  - Table: Student, Total Days, Present %, Absent %, Late %
  - Sort by attendance % (ascending/descending)
  - Highlight students with <75% attendance (red)
- **Acceptance Criteria:**
  - Export to Excel
  - Print class attendance sheet
  - Filter by low attendance (<75%)
- **Priority:** Medium
FR-ATT-004: Daily Attendance Summary
Description: Principal's daily overview
Input:
Date (defaults to today)
Display:
School-wide attendance %
By class: Class, Total Students, Present, Absent, Attendance %
Students absent >3 consecutive days (alert list)
Acceptance Criteria:
Refreshes automatically every hour
Export summary to PDF
Click class to see details
Priority: Low
5.7 Grading Module
FR-GRA-001: Enter Student Grades
Description: Teachers enter assessment scores
Input:
Course (dropdown, teacher's courses)
Class (auto-filled)
Assessment Type (dropdown: Quiz/Test/Mid-term/Final Exam/Assignment)
Assessment Name (text, e.g., "Week 3 Quiz")
Total Marks (integer, e.g., 100)
Date (date picker)
Weight % (integer, contribution to final grade)
Student scores (table with student name, score input)
Validation:
Score cannot exceed total marks
Score must be numeric
Weight % total per course cannot exceed 100% (warning)
UI/UX:
Student list with photos
Bulk enter same score option
Tab/Enter navigation between score fields
Auto-save every 60 seconds
Visual indicators: >80% (green), 50-80% (yellow), <50% (red)
Acceptance Criteria:
Submit scores button
Success message: "Scores entered for 28 students"
Scores editable for 48 hours
Priority: Critical
FR-GRA-002: Grade Calculation
Description: System calculates final grades
Business Logic:
Final Score = Σ(Assessment Score × Weight %) / 100
Letter Grade Assignment (Uganda system):
80-100: D1 (Distinction 1)
70-79: D2 (Distinction 2)
60-69: C3 (Credit 3)
50-59: C4 (Credit 4)
45-49: C5 (Credit 5)
40-44: C6 (Credit 6)
35-39: P7 (Pass 7)
30-34: P8 (Pass 8)
0-29: F9 (Fail 9)
Aggregate Score = Average of best 8 subjects (for S4/S6)
Acceptance Criteria:
Grades recalculated automatically when scores updated
Calculation visible on student profile
Grade breakdown shows all assessments
Priority: High
FR-GRA-003: Generate Report Cards
Description: Generate termly report cards
Input:
Student (individual or bulk by class)
Term (dropdown)
Academic Year (dropdown)
Report Card Contents:
School header (logo, name, address)
Student information (name, class, ID)
Term and year
Subject-wise performance table:
Subject | BOT (Beginning of Term) | MOT (Mid Term) | EOT (End of Term) | Final | Grade | Remarks
Class average per subject
Student's overall average
Class position / Total students
Attendance summary
Teacher's comments
Head teacher's comments
Next term begins (date)
Fee balance (if any)
Business Logic:
BOT, MOT, EOT scores pulled from assessments
Final = weighted average
Position calculated by overall average
Cannot generate if EOT scores missing
Output:
PDF format
Printable A4 size
School watermark
Acceptance Criteria:
Generates in under 5 seconds per report
Bulk generation with progress bar
Download all as ZIP file (for class)
Print button
Priority: Critical
FR-GRA-004: Grade Analytics
Description: Visualize grade distribution and trends
Input:
Class (dropdown)
Subject (dropdown)
Term (dropdown)
Display:
Bar chart: Grade distribution (D1, D2, C3, etc.)
Line chart: Class average trend over terms
Top 10 students table
Bottom 10 students table (for intervention)
Subject-wise performance comparison
Acceptance Criteria:
Interactive charts (hover for details)
Export charts as images
Print analytics report
Priority: Low
5.8 Fee Management Module
FR-FEE-001: Fee Structure Setup
Description: Define fee structure by class
Input:
Academic Year (dropdown)
Term (dropdown)
Class (dropdown)
Fee Items:
Item Name (text, e.g., "Tuition", "Lunch", "Uniform")
Amount (decimal, UGX)
Mandatory (checkbox)
Due Date (date picker)
Business Logic:
Fee structure set once per term per class
All students in class assigned this structure automatically
Can modify structure, applies to new enrollments only
Acceptance Criteria:
Add/remove fee items dynamically
Total fee displayed
Save structure button
Success message displayed
Priority: High
FR-FEE-002: Student Fee Assignment
Description: Assign fees to students
Business Logic:
Auto-assigned when student enrolled (based on class fee structure)
Manual adjustment allowed (scholarships, discounts)
Fee record created with status: Unpaid
Manual Override:
Student (dropdown)
Fee Items (editable amounts)
Discount % (optional)
Reason (text, if discount applied)
Acceptance Criteria:
Auto-assignment happens on enrollment
Manual override logged
Fee balance calculated correctly
Priority: High
FR-FEE-003: Record Fee Payment
Description: Process student fee payments
Input:
Student (searchable dropdown with type-ahead)
Payment Date (defaults to today)
Amount Paid (decimal, UGX)
Payment Method (dropdown: Cash/Mobile Money/Bank Transfer/Cheque)
Reference Number (text, required for Mobile Money/Bank/Cheque)
Received By (auto-filled, current user)
Display Before Payment:
Student name and class
Total fee due for term
Amount already paid
Balance remaining
Fee breakdown table
Business Logic:
Payment reduces balance
Overpayment allowed (credit carried forward)
Payment cannot be negative
Fee status updated:
Balance = 0: Paid
0 < Balance < Total: Partially Paid
Balance = Total: Unpaid
Receipt Generation:
Auto-generate receipt number (format: REC-YYYY-NNNNNN)
Print receipt immediately (PDF)
Receipt contains:
School header
Receipt number
Date and time
Student name, class, ID
Amount paid (in words and figures)
Payment method
Balance remaining
Received by (name and signature)
Acceptance Criteria:
Receipt prints immediately
Success message: "Payment recorded successfully"
Balance updates in real-time
Payment logged in audit trail
Priority: Critical
FR-FEE-004: Fee Defaulters Report
Description: Identify students with unpaid fees
Input:
Class (dropdown, optional)
Balance > Amount (filter, e.g., >50,000 UGX)
Term (dropdown)
Display:
Table: Student, Class, Total Due, Paid, Balance, Days Overdue
Sort by: Balance (high to low), Days Overdue
Highlight >30 days overdue (red)
Actions:
Send reminder (print letter)
Export to Excel
Print defaulter list
Acceptance Criteria:
Real-time calculation
Filter and sort functional
Export includes all fields
Priority: High
FR-FEE-005: Payment History
Description: View all payments for a student
Input:
Student (dropdown)
Date Range (optional filter)
Display:
Table: Receipt No., Date, Amount, Method, Received By
Total amount paid
Current balance
Download all receipts (ZIP)
Acceptance Criteria:
Click receipt number to view/print
Export to Excel
Running balance column
Priority: Medium
FR-FEE-006: Financial Summary Report
Description: Accountant's overview
Input:
Date Range (start date, end date)
Class (optional filter)
Payment Method (optional filter)
Display:
Total fees due (all students)
Total collected
Total outstanding
- Collection rate %
  - By payment method breakdown (Cash, Mobile Money, etc.)
  - By class breakdown
  - Top 5 payers
  - Charts: Collection trend, Payment methods pie chart
- **Acceptance Criteria:**
  - Export to Excel
  - Print report (PDF)
  - Charts included in PDF
- **Priority:** High

---

### **5.9 Timetable Module**

#### **FR-TIM-001: Create Class Timetable**
- **Description:** Generate weekly timetable for a class
- **Input:**
  - Class (dropdown)
  - Academic Year (dropdown)
  - Term (dropdown)
  - Time slots (configurable):
    - Period 1: 8:00-9:00 AM
    - Period 2: 9:00-10:00 AM
    - Break: 10:00-10:30 AM
    - Period 3: 10:30-11:30 AM
    - Period 4: 11:30-12:30 PM
    - Lunch: 12:30-1:30 PM
    - Period 5: 1:30-2:30 PM
    - Period 6: 2:30-3:30 PM
  - Weekly grid: Day (Mon-Fri) × Period
  - Each cell: Course (dropdown), Teacher (auto-filled from course assignment)
- **Validation:**
  - Teacher cannot be in two places at same time (conflict detection)
  - Course must be assigned to a teacher
  - All core courses must appear in timetable (warning if missing)
- **UI/UX:**
  - Drag-and-drop functionality (optional, nice-to-have)
  - Color-coded by subject
  - Conflict highlighting (red border)
- **Acceptance Criteria:**
  - Save timetable button
  - Conflicts shown before saving
  - Success message displayed
  - Print timetable (PDF, A4 landscape)
- **Priority:** Medium

#### **FR-TIM-002: View Teacher Timetable**
- **Description:** Teacher's personal schedule
- **Input:**
  - Teacher (auto-filled for logged-in teacher, dropdown for admin)
  - Week (date range)
- **Display:**
  - Weekly grid showing all classes
  - Free periods highlighted
  - Total periods per week
  - Print button
- **Acceptance Criteria:**
  - Color-coded by class
  - Conflicts shown (if any)
  - Export to PDF
- **Priority:** Medium

#### **FR-TIM-003: Master Timetable**
- **Description:** School-wide timetable view
- **Input:**
  - Academic Year
  - Term
- **Display:**
  - Tabbed view by class
  - Summary: Total periods per subject
  - Teacher workload summary
- **Acceptance Criteria:**
  - Switch between classes easily
  - Export all timetables (single PDF)
  - Identify under-utilized teachers
- **Priority:** Low

---

### **5.10 Reporting & Analytics Module**

#### **FR-REP-001: Academic Performance Report**
- **Description:** School-wide academic summary
- **Input:**
  - Term (dropdown)
  - Academic Year (dropdown)
  - Class (optional filter)
- **Display:**
  - Overall school average
  - By class averages
  - Subject performance comparison
  - Grade distribution chart
  - Top 20 students (school-wide)
  - Improvement/decline trends
- **Acceptance Criteria:**
  - Interactive charts
  - Export to PDF (with charts)
  - Print button
- **Priority:** Medium

#### **FR-REP-002: Student Progress Report**
- **Description:** Individual student performance over time
- **Input:**
  - Student (dropdown)
  - Date Range (start term, end term)
- **Display:**
  - Line chart: Average score trend
  - Position trend
  - Subject-wise performance table
  - Attendance correlation
  - Recommendations
- **Acceptance Criteria:**
  - Shows at least 3 terms of data
  - Export to PDF
  - Share with parent (print)
- **Priority:** Low

#### **FR-REP-003: Teacher Performance Report**
- **Description:** Evaluate teacher effectiveness
- **Input:**
  - Teacher (dropdown)
  - Term (dropdown)
- **Display:**
  - Courses taught
  - Average class performance per course
  - Pass rate (>50%)
  - Comparison with school average
  - Attendance marking compliance
- **Acceptance Criteria:**
  - Export to PDF
  - Admin only access
  - Anonymized for privacy
- **Priority:** Low

#### **FR-REP-004: Fee Collection Report**
(Covered in FR-FEE-006)

#### **FR-REP-005: Attendance Summary Report**
(Covered in FR-ATT-003, FR-ATT-004)

---

### **5.11 System Administration Module**

#### **FR-ADM-001: User Management**
- **Description:** Admin creates and manages user accounts
- **Input:**
  - Username (unique, required)
  - Full Name (required)
  - Email (unique, required)
  - Password (required, min 8 chars)
  - Role (dropdown: Admin/Principal/Teacher/Accountant/Clerk)
  - Status (dropdown: Active/Inactive)
  - Linked Entity:
    - If role=Teacher: Link to Teacher record
    - If role=Accountant: No link needed
- **Business Logic:**
  - Username must be unique
  - Email must be unique
  - Teacher users automatically linked to their teacher record
  - Password hashed before storage
- **Acceptance Criteria:**
  - User list with search and filter
  - Edit user button
  - Deactivate user button (soft delete)
  - Reset password button (admin only)
- **Priority:** High

#### **FR-ADM-002: System Settings**
- **Description:** Configure system parameters
- **Settings:**
  - School Information:
    - School Name
    - Address
    - Phone
    - Email
    - Logo (image upload)
    - Motto
  - Academic Calendar:
    - Current Academic Year
    - Current Term
    - Term Start/End Dates (Term 1, 2, 3)
    - Holidays
  - Grading System:
    - Grade boundaries (customizable)
    - Pass mark (default: 50%)
  - Fee Settings:
    - Late payment penalty % (optional)
    - Grace period (days)
  - Backup Settings:
    - Backup time (default: 2:00 AM)
    - Backup location (USB drive path)
    - Retention period (days, default: 30)
- **Acceptance Criteria:**
  - Save settings button
  - Changes take effect immediately
  - School logo appears on all reports
- **Priority:** High

#### **FR-ADM-003: Database Backup**
- **Description:** Backup database and files
- **Automated Backup:**
  - Runs daily at configured time (default: 2:00 AM)
  - Copies database file (school.db)
  - Copies media folder (photos, documents)
  - Saves to USB drive with date stamp
  - Retains last 30 backups (configurable)
  - Deletes backups older than retention period
- **Manual Backup:**
  - Admin can trigger backup anytime
  - Select destination (USB path)
  - Progress bar shown
  - Success/failure notification
- **Backup File Structure:**
  ```
  D:/SchoolBackups/
  ├── 2026-01-25/
  │   ├── school.db
  │   └── media/
  ├── 2026-01-24/
  │   ├── school.db
  │   └── media/
  ```
- **Acceptance Criteria:**
  - Backup completes without errors
  - Backup log file created
  - Email notification on failure (if configured)
  - Restore functionality (admin can restore from backup)
- **Priority:** Critical

#### **FR-ADM-004: Audit Log**
- **Description:** Track all user actions
- **Logged Actions:**
  - User login/logout
  - Student create/update/delete
  - Fee payment recorded
  - Grades entered/updated
  - Settings changed
  - Backup created
  - Failed login attempts
- **Log Entry Contains:**
  - Timestamp
  - User (username)
  - Action (e.g., "Student Created")
  - Entity (e.g., "Student: John Doe - STU-2026-0001")
  - IP Address (localhost)
  - Status (Success/Failure)
- **Display:**
  - Table with all logs
  - Filter by: User, Action, Date Range, Status
  - Search by entity
  - Pagination (100 per page)
  - Export to Excel
- **Acceptance Criteria:**
  - All critical actions logged
  - Logs cannot be edited/deleted (except by purge after 1 year)
  - Real-time logging
- **Priority:** Medium

#### **FR-ADM-005: Data Import/Export**
- **Description:** Bulk data operations
- **Export:**
  - Students (Excel/CSV)
  - Teachers (Excel/CSV)
  - Grades (Excel/CSV)
  - Fee Records (Excel/CSV)
  - Attendance (Excel/CSV)
  - Filter by class, term, date range
- **Import:**
  - Students (Excel template)
  - Fee Payments (Excel template)
  - Grades (Excel template)
  - Validation before import
  - Error report with row numbers
- **Acceptance Criteria:**
  - Download templates available
  - Export includes all fields
  - Import validates data structure
  - Partial imports not allowed
- **Priority:** Low

#### **FR-ADM-006: System Health Dashboard**
- **Description:** Monitor system status
- **Display:**
  - Database size (MB)
  - Media folder size (MB)
  - Total users (active/inactive)
  - Total students (active)
  - Last backup (date/time, status)
  - Disk space available
  - System uptime
  - Recent errors (last 10)
- **Alerts:**
  - Backup failed (red)
  - Disk space low (<10% free) (yellow)
  - Database size >500MB (yellow)
- **Acceptance Criteria:**
  - Real-time updates
  - Color-coded alerts
  - Click alert for details
- **Priority:** Low

---

### **5.12 Dashboard (Landing Page)**

#### **FR-DASH-001: Admin Dashboard**
- **Description:** Admin landing page after login
- **Widgets:**
  - Welcome message (Good morning, [Name])
  - Quick Stats:
    - Total Students (active)
    - Total Teachers (active)
    - Total Fee Collected (current term)
    - Fee Collection Rate (%)
    - Overall Attendance (today)
  - Recent Activities (last 10 actions from audit log)
  - Alerts:
    - Backup failed
    - Low disk space
    - Students with >3 days consecutive absence
  - Quick Actions:
    - Register Student
    - Record Payment
    - Backup Database
    - View Reports
  - Charts:
    - Enrollment trend (last 6 terms)
    - Fee collection trend (current year)
- **Acceptance Criteria:**
  - Loads in under 3 seconds
  - Data refreshes on page load
  - Clickable widgets link to relevant pages
- **Priority:** Medium

#### **FR-DASH-002: Teacher Dashboard**
- **Description:** Teacher landing page
- **Widgets:**
  - Welcome message
  - My Courses (list with student count)
  - Today's Timetable
  - Quick Actions:
    - Mark Attendance
    - Enter Grades
    - View My Timetable
  - Reminders:
    - Grades pending entry
    - Attendance not marked (today)
- **Acceptance Criteria:**
  - Personalized to logged-in teacher
  - Links functional
- **Priority:** Medium

#### **FR-DASH-003: Accountant Dashboard**
- **Description:** Accountant landing page
- **Widgets:**
  - Welcome message
  - Quick Stats:
    - Total Collected (today)
    - Total Collected (this week)
    - Total Collected (this term)
    - Outstanding Balance (all students)
  - Recent Payments (last 10)
  - Fee Defaulters (top 10 by balance)
  - Quick Actions:
    - Record Payment
    - View Defaulters
    - Generate Financial Report
- **Acceptance Criteria:**
  - Real-time stats
  - Click stats for detailed reports
- **Priority:** Medium

---

## **6. NON-FUNCTIONAL REQUIREMENTS**

### **6.1 Performance**

#### **NFR-PERF-001: Application Launch Time**
- **Requirement:** Application window opens within 5 seconds
- **Measurement:** Time from double-click to login page visible
- **Target:** ≤5 seconds on 4GB RAM computer

#### **NFR-PERF-002: Page Load Time**
- **Requirement:** All pages load within 2 seconds
- **Measurement:** Time from click to page fully rendered
- **Target:** ≤2 seconds for data pages with up to 100 records

#### **NFR-PERF-003: Report Generation**
- **Requirement:** Report cards generate quickly
- **Measurement:** Time from clicking "Generate" to PDF ready
- **Target:**
  - Single report card: ≤3 seconds
  - Class report cards (40 students): ≤60 seconds

#### **NFR-PERF-004: Database Query Performance**
- **Requirement:** Database queries respond quickly
- **Measurement:** Query execution time
- **Target:**
  - Simple queries (SELECT with WHERE): <100ms
  - Complex queries (JOINs): <500ms
  - Reports with aggregations: <2 seconds

#### **NFR-PERF-005: Concurrent Operations**
- **Requirement:** System handles multiple operations smoothly (even though single user, multiple windows possible)
- **Target:** Support up to 5 simultaneous operations without lag

### **6.2 Reliability**

#### **NFR-REL-001: System Uptime**
- **Requirement:** System available during school hours (7 AM - 6 PM)
- **Target:** 99% uptime during operational hours
- **Acceptable Downtime:** Planned maintenance during weekends

#### **NFR-REL-002: Data Integrity**
- **Requirement:** No data loss during unexpected shutdown
- **Implementation:**
  - SQLite WAL (Write-Ahead Logging) mode enabled
  - Auto-save drafts (attendance, grades) every 30 seconds
  - Transaction rollback on errors
- **Target:** Zero data loss from power outages

#### **NFR-REL-003: Backup Reliability**
- **Requirement:** Automated backups succeed consistently
- **Target:** 100% backup success rate
- **Monitoring:** Log backup status, alert on failure

#### **NFR-REL-004: Error Recovery**
- **Requirement:** System recovers gracefully from errors
- **Implementation:**
  - User-friendly error messages (no technical jargon)
  - Automatic retry for failed operations (up to 3 attempts)
  - Error logging for debugging
- **Target:** No system crashes requiring restart

### **6.3 Usability**

#### **NFR-USE-001: Learning Curve**
- **Requirement:** New users productive within 2 hours of training
- **Target:** 90% of tasks completable without help after 2-hour session
- **Implementation:**
  - Intuitive navigation
  - Clear labels
  - Inline help text
  - User manual (PDF)

#### **NFR-USE-002: User Interface Consistency**
- **Requirement:** Consistent UI across all modules
- **Standards:**
  - Same color scheme (school colors)
  - Same button styles
  - Same form layouts
  - Same table formats
  - Same navigation structure

#### **NFR-USE-003: Accessibility**
- **Requirement:** Usable by non-technical staff
- **Implementation:**
  - Large buttons (min 40px height)
  - Clear fonts (min 14px)
  - High contrast colors
  - No complex terminology
  - Confirmation dialogs for destructive actions

#### **NFR-USE-004: Error Messages**
- **Requirement:** Clear, actionable error messages
- **Standards:**
  - No technical codes (e.g., not "Error 500")
  - Plain English explanation
  - Suggested action to fix
  - Example: "Phone number must be 10 digits. You entered 9 digits. Please check and try again."

#### **NFR-USE-005: Mobile-Friendly (Future)**
- **Requirement:** UI works on tablets (future enhancement)
- **Target:** Responsive design for screens ≥768px width
- **Priority:** Low (Phase 2)

### **6.4 Security**

#### **NFR-SEC-001: Authentication**
- **Requirement:** Strong user authentication
- **Implementation:**
  - Username + password required
  - Passwords hashed (PBKDF2, 100,000 iterations)
  - Session timeout after 4 hours of inactivity
  - Account lockout after 3 failed attempts (15-minute lockout)

#### **NFR-SEC-002: Authorization**
- **Requirement:** Role-based access control enforced
- **Implementation:**
  - Every action checks user permission
  - Unauthorized access returns 403 error
  - Audit log records access attempts

#### **NFR-SEC-003: Data Encryption**
- **Requirement:** Sensitive data encrypted at rest
- **Encrypted Fields:**
  - National IDs
  - Teacher salaries
  - Guardian contacts
  - Medical information
- **Algorithm:** AES-256 encryption (cryptography library)

#### **NFR-SEC-004: Password Policy**
- **Requirement:** Strong password requirements
- **Rules:**
  - Minimum 8 characters
  - At least 1 uppercase letter
  - At least 1 number
  - Cannot be same as username
  - Password change every 90 days (optional, recommended)

#### **NFR-SEC-005: Audit Trail**
- **Requirement:** All actions logged for accountability
- **Logged Information:**
  - Who (user)
  - What (action)
  - When (timestamp)
  - Where (IP address, always localhost)
  - Status (success/failure)
- **Retention:** 1 year

#### **NFR-SEC-006: Data Backup Security**
- **Requirement:** Backups protected
- **Implementation:**
  - USB drive stored in locked cabinet
  - Backup files read-only after creation
  - Optional: Backup encryption (AES-256)

### **6.5 Maintainability**

#### **NFR-MAIN-001: Code Quality**
- **Requirement:** Clean, documented code
- **Standards:**
  - Django best practices
  - PEP 8 style guide (Python)
  - Docstrings for all functions
  - Comments for complex logic
  - Meaningful variable names

#### **NFR-MAIN-002: Modularity**
- **Requirement:** Loosely coupled modules
- **Implementation:**
  - Django apps per module (students, academics, finance, etc.)
  - Reusable components
  - Clear separation of concerns

#### **NFR-MAIN-003: Database Schema**
- **Requirement:** Normalized, well-designed schema
- **Standards:**
  - 3rd Normal Form (3NF)
  - Foreign keys with cascades
  - Indexes on frequently queried fields
  - No redundant data

#### **NFR-MAIN-004: Logging**
- **Requirement:** Comprehensive logging for debugging
- **Logs:**
  - Application errors (auto-logged)
  - Database errors (auto-logged)
  - User actions (audit log)
  - Backup operations
- **Log Levels:** DEBUG, INFO, WARNING, ERROR, CRITICAL
- **Storage:** Log files in logs/ folder, rotated daily

#### **NFR-MAIN-005: Update Mechanism**
- **Requirement:** Easy updates to new versions
- **Implementation:**
  - Version number displayed in UI
  - Database migrations (Django migrations)
  - Update script provided
  - Backward compatibility maintained

### **6.6 Scalability**

#### **NFR-SCAL-001: Student Capacity**
- **Requirement:** Support up to 2,000 students
- **Target:** No performance degradation up to 2,000 student records

#### **NFR-SCAL-002: Data Growth**
- **Requirement:** Handle 5 years of historical data
- **Estimated Size:**
  - Students: 2,000 × 5 years = 10,000 records
  - Attendance: 2,000 students × 200 days × 5 years = 2,000,000 records
  - Grades: 2,000 students × 10 subjects × 5 assessments × 5 years = 500,000 records
  - Total DB size estimate: <1GB
- **Target:** System performs well with up to 1GB database

#### **NFR-SCAL-003: Archive Old Data**
- **Requirement:** Archive data older than 5 years (optional feature)
- **Implementation:**
  - Export old data to Excel/CSV
  - Soft delete from database (move to archive table)
  - Free up space

### **6.7 Portability**

#### **NFR-PORT-001: Operating System**
- **Requirement:** Runs on Windows
- **Target:** Windows 10 and above (64-bit)
- **Future:** Linux support (Phase 2)

#### **NFR-PORT-002: Hardware Requirements**
- **Minimum:**
  - Processor: Intel Core i3 or equivalent
  - RAM: 4GB
  - Storage: 10GB free space
  - Display: 1280×720 resolution
- **Recommended:**
  - Processor: Intel Core i5 or above
  - RAM: 8GB
  - Storage: 20GB free space (for backups)
  - Display: 1920×1080 resolution

#### **NFR-PORT-003: Deployment**
- **Requirement:** Single executable deployment (no complex installation)
- **Implementation:**
  - PyInstaller to create standalone .exe
  - All dependencies bundled
  - No Python installation required on end-user machine
  - One-click installation

### **6.8 Compatibility**

#### **NFR-COMP-001: Browser Engine**
- **Requirement:** Consistent rendering across browsers
- **Implementation:**
  - PyWebView uses system's default browser engine
  - Test on: Chrome (Chromium), Edge (Chromium)
  - Fallback to basic HTML/CSS if advanced features unavailable

#### **NFR-COMP-002: Database Compatibility**
- **Requirement:** SQLite version compatibility
- **Target:** SQLite 3.35+ (Python 3.9+ includes this)

### **6.9 Localization** (Future Enhancement)

#### **NFR-LOC-001: Language Support**
- **Requirement:** English language (Phase 1)
- **Future:** Luganda, Swahili support (Phase 2)
- **Implementation:** Django i18n framework

#### **NFR-LOC-002: Currency**
- **Requirement:** Uganda Shillings (UGX)
- **Format:** UGX 50,000 (no decimals, comma-separated thousands)

#### **NFR-LOC-003: Date Format**
- **Requirement:** DD/MM/YYYY (Uganda standard)
- **Display:** 25/01/2026

---

## **7. DATA MODEL**

### **7.1 Entity Relationship Diagram**

```
Student ||--o{ Enrollment : "enrolls in"
Student ||--o{ Attendance : "has"
Student ||--o{ Grade : "receives"
Student ||--o{ Fee : "pays"

Teacher ||--o{ CourseAssignment : "teaches"

Course ||--o{ Enrollment : "has"
Course ||--o{ Attendance : "records"
Course ||--o{ Grade : "assesses"
Course ||--o{ Timetable : "scheduled in"

CourseAssignment }o--|| Course : "for"
CourseAssignment }o--|| Teacher : "by"

Class ||--o{ Student : "contains"
Class ||--o{ Course : "offers"
Class ||--o{ Timetable : "follows"

Fee }o--|| Student : "belongs to"
Payment }o--|| Fee : "reduce
- term, academic_year

#### **Table: fees**
| Field | Type | Constraints | Description |
|-------|------|-------------|-------------|
| id | INTEGER | PRIMARY KEY, AUTO_INCREMENT | Unique fee ID |
| student_id | INTEGER | FOREIGN KEY (students.id) NOT NULL | Student |
| term | VARCHAR(10) | NOT NULL | Term 1/2/3 |
| academic_year | INTEGER | NOT NULL | 2024, 2025, etc. |
| total_amount | DECIMAL(10,2) | NOT NULL | Total fee for term |
| amount_paid | DECIMAL(10,2) | DEFAULT 0.00 | Total paid |
| balance | DECIMAL(10,2) | GENERATED (total_amount - amount_paid) | Remaining balance |
| status | VARCHAR(20) | NOT NULL | Unpaid/Partially Paid/Paid |
| discount_percentage | DECIMAL(5,2) | DEFAULT 0.00 | Discount applied |
| discount_reason | TEXT | NULL | Scholarship, etc. |
| due_date | DATE | NOT NULL | Payment deadline |
| created_at | DATETIME | DEFAULT NOW() | Record creation |
| updated_at | DATETIME | DEFAULT NOW() ON UPDATE | Last payment |

**Indexes:**
- student_id
- status
- term, academic_year

#### **Table: fee_items**
| Field | Type | Constraints | Description |
|-------|------|-------------|-------------|
| id | INTEGER | PRIMARY KEY, AUTO_INCREMENT | Unique item ID |
| fee_id | INTEGER | FOREIGN KEY (fees.id) NOT NULL | Parent fee |
| item_name | VARCHAR(100) | NOT NULL | Tuition/Lunch/Uniform |
| amount | DECIMAL(10,2) | NOT NULL | Item amount |
| is_mandatory | BOOLEAN | DEFAULT TRUE | Required or optional |

**Indexes:**
- fee_id

#### **Table: payments**
| Field | Type | Constraints | Description |
|-------|------|-------------|-------------|
| id | INTEGER | PRIMARY KEY, AUTO_INCREMENT | Unique payment ID |
| receipt_number | VARCHAR(20) | UNIQUE, NOT NULL | REC-YYYY-NNNNNN |
| fee_id | INTEGER | FOREIGN KEY (fees.id) NOT NULL | Fee record |
| student_id | INTEGER | FOREIGN KEY (students.id) NOT NULL | Student (denormalized) |
| amount | DECIMAL(10,2) | NOT NULL | Amount paid |
| payment_method | VARCHAR(20) | NOT NULL | Cash/Mobile Money/Bank/Cheque |
| reference_number | VARCHAR(50) | NULL | Transaction ref |
| payment_date | DATE | NOT NULL | Date of payment |
| received_by | INTEGER | FOREIGN KEY (users.id) | User who recorded |
| notes | TEXT | NULL | Additional notes |
| created_at | DATETIME | DEFAULT NOW() | Record creation |

**Indexes:**
- receipt_number (UNIQUE)
- fee_id
- student_id
- payment_date

#### **Table: timetables**
| Field | Type | Constraints | Description |
|-------|------|-------------|-------------|
| id | INTEGER | PRIMARY KEY, AUTO_INCREMENT | Unique timetable ID |
| class | VARCHAR(10) | NOT NULL | P1-P7, S1-S6 |
| course_id | INTEGER | FOREIGN KEY (courses.id) NOT NULL | Course |
| teacher_id | INTEGER | FOREIGN KEY (teachers.id) NOT NULL | Teacher |
| day_of_week | VARCHAR(10) | NOT NULL | Monday-Friday |
| period_number | INTEGER | NOT NULL | 1-6 |
| start_time | TIME | NOT NULL | 8:00, 9:00, etc. |
| end_time | TIME | NOT NULL | 9:00, 10:00, etc. |
| term | VARCHAR(10) | NOT NULL | Term 1/2/3 |
| academic_year | INTEGER | NOT NULL | 2024, 2025, etc. |
| created_at | DATETIME | DEFAULT NOW() | Record creation |

**Indexes:**
- UNIQUE(class, day_of_week, period_number, term, academic_year)
- teacher_id, day_of_week, period_number (for conflict detection)

#### **Table: settings**
| Field | Type | Constraints | Description |
|-------|------|-------------|-------------|
| id | INTEGER | PRIMARY KEY, AUTO_INCREMENT | Unique setting ID |
| key | VARCHAR(50) | UNIQUE, NOT NULL | Setting identifier |
| value | TEXT | NOT NULL | Setting value |
| description | TEXT | NULL | Human-readable description |
| updated_at | DATETIME | DEFAULT NOW() ON UPDATE | Last update |

**Sample Settings:**
- school_name
- school_address
- school_phone
- school_email
- school_logo_path
- current_academic_year
- current_term
- term1_start_date
- term1_end_date
- term2_start_date
- term2_end_date
- term3_start_date
- term3_end_date
- backup_time
- backup_path
- pass_mark
- late_fee_penalty_percentage

#### **Table: audit_logs**
| Field | Type | Constraints | Description |
|-------|------|-------------|-------------|
| id | INTEGER | PRIMARY KEY, AUTO_INCREMENT | Unique log ID |
| user_id | INTEGER | FOREIGN KEY (users.id) NULL | User who performed action |
| action | VARCHAR(100) | NOT NULL | "Student Created", "Payment Recorded" |
| entity_type | VARCHAR(50) | NOT NULL | Student, Teacher, Fee, etc. |
| entity_id | INTEGER | NULL | ID of affected record |
| details | TEXT | NULL | JSON with before/after values |
| ip_address | VARCHAR(45) | NULL | IP (always 127.0.0.1) |
| status | VARCHAR(20) | NOT NULL | Success/Failure |
| timestamp | DATETIME | DEFAULT NOW() | When action occurred |

**Indexes:**
- user_id
- timestamp
- entity_type, entity_id

---

## **8. USER INTERFACE SPECIFICATIONS**

### **8.1 UI Framework & Design System**

#### **Technology:**
- **HTML5** + **CSS3** (Bootstrap 5)
- **JavaScript** (jQuery for AJAX, minimal custom JS)
- **Icons:** Bootstrap Icons or Lucide Icons
- **Fonts:** System fonts (Arial, Segoe UI)

#### **Color Scheme:**
```
Primary Color:    #1976D2 (Blue - trust, professionalism)
Secondary Color:  #388E3C (Green - success, growth)
Accent Color:     #F57C00 (Orange - attention, action)
Danger Color:     #D32F2F (Red - errors, warnings)
Background:       #F5F5F5 (Light gray)
Text:             #212121 (Dark gray, high contrast)
Borders:          #E0E0E0 (Light gray)
```

#### **Typography:**
```
Headings: Segoe UI, 18-24px, Bold
Body Text: Segoe UI, 14px, Regular
Labels: Segoe UI, 13px, Semibold
Buttons: Segoe UI, 14px, Semibold
```

### **8.2 Layout Structure**

```
┌─────────────────────────────────────────────────┐
│  Header (School Logo, Name, Logout)            │
├──────────────┬──────────────────────────────────┤
│              │                                  │
│  Sidebar     │  Main Content Area               │
│  Navigation  │                                  │
│              │  Page Title                      │
│  - Dashboard │  Breadcrumbs                     │
│  - Students  │                                  │
│  - Teachers  │  [Content]                       │
│  - Academics │                                  │
│  - Finance   │                                  │
│  - Reports   │                                  │
│  - Settings  │                                  │
│              │                                  │
│              │                                  │
│              │                                  │
├──────────────┴──────────────────────────────────┤
│  Footer (Version, Copyright)                    │
└─────────────────────────────────────────────────┘
```

### **8.3 Key UI Screens**

#### **8.3.1 Login Screen**
```
┌──────────────────────────────┐
│                              │
│     [School Logo]            │
│                              │
│   School Management System   │
│                              │
│   ┌────────────────────┐    │
│   │ Username           │    │
│   └────────────────────┘    │
│                              │
│   ┌────────────────────┐    │
│   │ Password  [👁]      │    │
│   └────────────────────┘    │
│                              │
│   [x] Remember me            │
│                              │
│   [ Login Button ]           │
│                              │
│   Forgot Password?           │
│                              │
│   v1.0.0                     │
└──────────────────────────────┘
```

**Elements:**
- Centered on screen
- School logo (150×150px)
- Clean white card on light background
- Password toggle (show/hide)
- Error messages in red below form

#### **8.3.2 Dashboard (Admin)**
```
┌─────────────────────────────────────────────────┐
│  Good morning, John! 👋                         │
├─────────────────────────────────────────────────┤
│  Quick Stats                                    │
│  ┌────────┐  ┌────────┐  ┌────────┐  ┌────────┐│
│  │  500   │  │   25   │  │50,000K │  │  95%   ││
│  │Students│  │Teachers│  │Collected│  │Attend. ││
│  └────────┘  └────────┘  └────────┘  └────────┘│
├─────────────────────────────────────────────────┤
│  Recent Activities          │  Quick Actions    │
│  ┌─────────────────────┐   │  ┌───────────────┐│
│  │ John paid 50,000    │   │  │Register Student││
│  │ 10 min ago          │   │  ├───────────────┤│
│  │                     │   │  │Record Payment  ││
│  │ Mary enrolled S1    │   │  ├───────────────┤│
│  │ 1 hour ago          │   │  │Backup Database ││
│  │                     │   │  └───────────────┘│
│  │ ...                 │   │                   │
│  └─────────────────────┘   │                   │
├─────────────────────────────────────────────────┤
│  Enrollment Trend (Chart)                       │
│  [Line Chart: Last 6 Terms]                     │
└─────────────────────────────────────────────────┘
```

#### **8.3.3 Student Registration Form**
```
Page Title: Register New Student

┌─────────────────────────────────────────────────┐
│  Personal Information                           │
├─────────────────────────────────────────────────┤
│  Student ID:  [Auto-generated]     Photo: [📷]  │
│                                          ┌─────┐│
│  Full Name: *  [________________]        │     ││
│                                          │Photo││
│  Date of Birth: * [DD/MM/YYYY]           │     ││
│                                          └─────┘│
│  Gender: * [▼ Select]                           │
│                                                 │
│  Class: * [▼ P1-P7, S1-S6]                      │
├─────────────────────────────────────────────────┤
│  Guardian Information                           │
├─────────────────────────────────────────────────┤
│  Guardian Name: * [________________]            │
│                                                 │
│  Guardian Contact: * [07XX XXX XXX]             │
│                                                 │
│  Guardian Email: [________________] (Optional)  │
│                                                 │
│  Address: [___________________________]         │
│           [___________________________]         │
├─────────────────────────────────────────────────┤
│  Additional Information                         │
├─────────────────────────────────────────────────┤
│  Medical Conditions: (Optional)                 │
│  [_______________________________________]      │
│                                                 │
│  Previous School: [________________] (Optional) │
│                                                 │
│  Admission Date: * [DD/MM/YYYY]                 │
│                                                 │
│  Status: [▼ Active] (Default)                   │
├─────────────────────────────────────────────────┤
│  [Cancel]                  [Register Student]   │
└─────────────────────────────────────────────────┘
```

**Validation Indicators:**
- Red border + error message for invalid fields
- Green checkmark for valid fields
- Required fields marked with *

#### **8.3.4 Student List**
```
Page Title: Students

Search: [🔍_______________]  Class: [▼ All]  Status: [▼ Active]  [+ New Student]

┌─────────────────────────────────────────────────────────────────────┐
│ Photo │ Student ID     │ Name        │ Class │ Guardian │ Contact  │
├─────────────────────────────────────────────────────────────────────┤
│  👤   │ STU-2026-0001  │ John Doe    │ S1    │ Jane Doe │ 0701...  │
│  👤   │ STU-2026-0002  │ Mary Smith  │ P5    │ Bob Smith│ 0702...  │
│  ...  │ ...            │ ...         │ ...   │ ...      │ ...      │
└─────────────────────────────────────────────────────────────────────┘

Showing 1-25 of 500    [< Prev]  [1] [2] [3] ... [20]  [Next >]

[Export to Excel]
```

**Interactions:**
- Click row → View student profile
- Hover row → Highlight
- Sort columns by clicking header

#### **8.3.5 Mark Attendance**
```
Page Title: Mark Attendance

Date: [25/01/2026]  Course: [Mathematics - S1]  Class: S1 (Auto-filled)

[Mark All Present]

┌─────────────────────────────────────────────────────────────────────┐
│ Photo │ Student ID     │ Name        │ Present │ Absent │ Late │ Excused │
├─────────────────────────────────────────────────────────────────────┤
│  👤   │ STU-2026-0001  │ John Doe    │   ○     │   ○    │  ○   │   ○     │
│  👤   │ STU-2026-0002  │ Mary Smith  │   ●     │   ○    │  ○   │   ○     │
│  ...  │ ...            │ ...         │   ...   │   ...  │ ...  │  ...    │
└─────────────────────────────────────────────────────────────────────┘

Auto-saving... ✓ Last saved: 10:35 AM

[Cancel]                                      [Submit Attendance]
```

**Features:**
- Radio buttons for status
- Default: Present (pre-selected)
- Auto-save every 30 seconds
- Color coding: Green (Present), Red (Absent), Yellow (Late), Blue (Excused)

#### **8.3.6 Fee Payment**
```
Page Title: Record Fee Payment

Student: [🔍 Type to search...]

[After selecting student: John Doe - STU-2026-0001 - S1]

┌─────────────────────────────────────────────────┐
│  Fee Summary                                    │
├─────────────────────────────────────────────────┤
│  Total Fee (Term 1, 2026): UGX 150,000          │
│  Amount Paid:                UGX 50,000          │
│  Balance:                    UGX 100,000         │
│                                                 │
│  Breakdown:                                     │
│  - Tuition:     UGX 100,000                     │
│  - Lunch:       UGX  30,000                     │
│  - Uniform:     UGX  20,000                     │
├─────────────────────────────────────────────────┤
│  Payment Details                                │
├─────────────────────────────────────────────────┤
│  Amount: * [____________] UGX                   │
│                                                 │
│  Payment Method: * [▼ Select]                   │
│  - Cash                                         │
│  - Mobile Money                                 │
│  - Bank Transfer                                │
│  - Cheque                                       │
│                                                 │
│  Reference Number: [____________] (if applicable)│
│                                                 │
│  Payment Date: * [25/01/2026]                   │
│                                                 │
│  Notes: [___________________________] (Optional)│
├─────────────────────────────────────────────────┤
│  [Cancel]              [Record Payment & Print] │
└─────────────────────────────────────────────────┘
```

**Auto-calculations:**
- New balance shown in real-time
- Warning if overpayment
- Receipt auto-downloads on submit

#### **8.3.7 Report Card (PDF Output)**
```
┌─────────────────────────────────────────────────┐
│  [School Logo]    SCHOOL NAME                   │
│                   Address, Phone, Email         │
├─────────────────────────────────────────────────┤
│           STUDENT REPORT CARD                   │
│           Term 1, 2026                          │
├─────────────────────────────────────────────────┤
│  Student: John Doe                              │
│  Class: S1            Student ID: STU-2026-0001 │
├─────────────────────────────────────────────────┤
│  Subject    │ BOT │ MOT │ EOT │Final│Grade│Rmks│
├─────────────────────────────────────────────────┤
│  Mathematics│ 75  │ 80  │ 85  │ 82  │ D1  │Exc │
│  English    │ 70  │ 72  │ 78  │ 75  │ D2  │V.Good│
│  Science    │ ...  ...  ...  ...  ...  ...     │
│  ...        │ ...  ...  ...  ...  ...  ...     │
├─────────────────────────────────────────────────┤
│  Overall Average: 78.5     Position: 5/40       │
├─────────────────────────────────────────────────┤
│  Attendance: 95% (190/200 days)                 │
├─────────────────────────────────────────────────┤
│  Class Teacher's Comment:                       │
│  John has shown excellent progress this term... │
│                                                 │
│  Head Teacher's Comment:                        │
│  Keep up the good work.                         │
│                                                 │
│  Next Term Begins: 15/04/2026                   │
│                                                 │
│  Fee Balance: UGX 50,000                        │
├─────────────────────────────────────────────────┤
│  Teacher Signature: ________  HT Signature: ____│
└─────────────────────────────────────────────────┘
```

---

## **9. DEPLOYMENT & INSTALLATION**

### **9.1 Packaging**

#### **Build Process:**
1. **PyInstaller Configuration:**
```bash
pyinstaller --onefile \
           --windowed \
           --name "School Management System" \
           --icon school.ico \
           --add-data "media;media" \
           --add-data "templates;templates" \
           --add-data "static;static" \
           main.py
```

2. **Output:**
   - Single executable: `School Management System.exe` (~50-80MB)
   - No Python installation required on target machine
   - All dependencies bundled

#### **Installer Creation (Optional):**
- Use **Inno Setup** to create Windows installer
- Installer features:
  - Welcome screen
  - License agreement
  - Installation directory selection (default: `C:\Program Files\OSMS`)
  - Desktop shortcut creation
  - Start menu shortcut
  - Uninstaller

### **9.2 Installation Steps**

#### **For End User:**
1. Copy `School Management System.exe` to Desktop
2. Double-click to run
3. First run:
   - System creates `C:\SchoolData\` folder
   - Initializes database (`school.db`)
   - Creates default admin user:
     - Username: `admin`
     - Password: `admin123` (must change on first login)
4. Login screen appears
5. Change default password
6. Configure school settings

#### **Data Folder Structure:**
```
C:\SchoolData\
├── school.db               (SQLite database)
├── media/
│   ├── students/
│   │   └── photos/
│   ├── teachers/
│   │   └── photos/
│   ├── reports/
│   └── receipts/
├── backups/               (If no USB, local backup)
└── logs/
    ├── app.log
    ├── error.log
    └── audit.log
```

### **9.3 USB Backup Configuration**

#### **Setup:**
1. Insert USB drive (recommended: 32GB+)
2. System Settings → Backup
3. Select USB drive path (e.g., `D:\`, `E:\`)
4. System creates `SchoolBackups/` folder on USB
5. Configure backup time (default: 2:00 AM)
6. Test backup

#### **Backup Schedule:**
- **Daily:** Full database + media files
- **Retention:** 30 days (configurable)
- **Naming:** `backup_YYYY-MM-DD/`

### **9.4 System Requirements Check**

**Application performs check on startup:**
```
Checking System Requirements...
✓ Windows 10/11 detected
✓ RAM: 4GB available
✓ Disk Space: 15GB free
✓ Display: 1280x720 resolution
✓ All requirements met!
```

**If requirements not met:**
- Warning dialog shown
- User can proceed at own risk
- Performance degradation expected

### **9.5 Update Mechanism**

#### **Manual Updates (Phase 1):**
1. Download new version: `School_System_v1.1.0.exe`
2. Close running application
3. Replace old .exe with new .exe
4. Run new version
5. System auto-detects database schema changes
6. Runs Django migrations automatically
7. Backup created before migration

#### **Auto-Update (Phase 2 - Future):**
- Check for updates on startup
- Download update in background
- Prompt user to install
- One-click update

---

## **10. TESTING REQUIREMENTS**

### **10.1 Unit Testing**

#### **Backend (Django) Tests:**
- **Models:** Validation, constraints, methods
- **Views:** Business logic, permissions
- **Forms:** Validation rules
- **Utilities:** Grade calculation, fee calculation

**Coverage Target:** >80% code coverage

**Test Framework:** Django's built-in TestCase

### **10.2 Integration Testing**

#### **Scenarios:**
1. **Student Enrollment Flow:**
   - Register student → Enroll in courses → Verify enrollment records

2. **Attendance Marking:**
   - Teacher logs in → Selects course → Marks attendance → Verify database records

3. **Fee Payment:**
   - Record payment → Generate receipt → Verify fee bala
| 5 | Enrollment Module | - Student enrollment<br>- Bulk enrollment<br>- Enrollment status |
| 6 | Attendance Module | - Mark attendance UI<br>- Attendance reports<br>- Auto-save functionality |
| 7 | Grading Module | - Enter grades UI<br>- Grade calculation logic<br>- Grade analytics |
| 8 | Report Cards | - Report card template<br>- PDF generation<br>- Bulk generation |

**Milestone Delivery:** Complete academic workflow operational

### **Phase 3: Finance & Reporting (Weeks 9-11)**

| Week | Milestone | Deliverables |
|------|-----------|--------------|
| 9 | Fee Management | - Fee structure setup<br>- Fee assignment<br>- Payment recording<br>- Receipt generation |
| 10 | Financial Reports | - Defaulters report<br>- Payment history<br>- Financial summary |
| 11 | Timetable & Additional Reports | - Timetable management<br>- Academic reports<br>- Dashboards |

**Milestone Delivery:** Full system functional

### **Phase 4: System Integration & Testing (Weeks 12-14)**

| Week | Milestone | Deliverables |
|------|-----------|--------------|
| 12 | System Administration | - Settings module<br>- Backup system<br>- Audit logging<br>- Data import/export |
| 13 | PyWebView Integration | - Desktop wrapper functional<br>- Auto-start Django<br>- Executable build |
| 14 | Testing | - Unit tests<br>- Integration tests<br>- Bug fixes |

**Milestone Delivery:** Testable application build

### **Phase 5: UAT & Documentation (Weeks 15-16)**

| Week | Milestone | Deliverables |
|------|-----------|--------------|
| 15 | User Acceptance Testing | - UAT with school staff<br>- Bug fixes<br>- UI refinements |
| 16 | Documentation & Deployment | - User manual<br>- Technical documentation<br>- Training materials<br>- Final build delivery |

**Milestone Delivery:** Production-ready system

---

## **13. ASSUMPTIONS & CONSTRAINTS**

### **13.1 Assumptions**

1. **Hardware:**
   - School has at least one computer (4GB RAM minimum)
   - Computer has USB port for backup
   - UPS available for power backup

2. **Software:**
   - Computer runs Windows 10 or above
   - No antivirus blocking executable

3. **Users:**
   - At least one staff member has basic computer skills
   - Users willing to attend 2-hour training session
   - Users can read and write English

4. **Environment:**
   - Power available during school hours (7 AM - 6 PM)
   - Computer accessible to authorized staff
   - Secure location for computer (locked office)

5. **Data:**
   - School has basic student records (names, contacts)
   - Fee structure defined by school
   - Grading system follows Uganda curriculum

### **13.2 Constraints**

1. **Technical Constraints:**
   - Offline only (no internet required)
   - Single computer deployment
   - SQLite database (not multi-user database)
   - Windows only (no Mac/Linux in Phase 1)

2. **Functional Constraints:**
   - No SMS notifications (requires internet)
   - No parent portal (requires internet/multi-device)
   - No real-time multi-user access (single computer)
   - No cloud sync

3. **Resource Constraints:**
   - 4GB RAM hardware limitation
   - Development time: 12-16 weeks
   - Budget constraints (no paid services)

4. **Regulatory Constraints:**
   - Must comply with Uganda Data Protection Act
   - Student data privacy must be maintained
   - No sharing of student data outside school

---

## **14. RISKS & MITIGATION**

| Risk | Impact | Probability | Mitigation Strategy |
|------|--------|-------------|---------------------|
| **Power outages during use** | High | High | - Enable SQLite WAL mode<br>- Auto-save every 30 seconds<br>- Recommend UPS |
| **Data loss (no backup)** | Critical | Medium | - Automated daily backups<br>- Manual backup option<br>- Alert if backup fails |
| **USB drive failure** | High | Low | - Support multiple backup locations<br>- Local backup folder<br>- Weekly verification |
| **User forgets password** | Medium | Medium | - Admin password reset feature<br>- Security questions (Phase 2) |
| **Corrupt database** | Critical | Low | - Database integrity checks on startup<br>- Restore from backup option |
| **Insufficient training** | Medium | Medium | - Comprehensive user manual<br>- Quick reference guide<br>- In-app help text |
| **Computer hardware failure** | High | Low | - Regular backups to USB<br>- Document recovery process |
| **Software bugs** | Medium | Medium | - Thorough testing (unit, integration, UAT)<br>- Bug reporting mechanism |
| **Resistance to change** | Medium | Medium | - User involvement in UAT<br>- Highlight benefits<br>- Gradual adoption |
| **Inaccurate data entry** | Medium | High | - Validation rules<br>- Confirmation dialogs<br>- Audit trail |

---

## **15. SUCCESS CRITERIA**

### **15.1 Technical Success Criteria**

- [ ] Application installs with single executable
- [ ] All modules functional (100% features working)
- [ ] No critical bugs in production
- [ ] Performance targets met (page loads <2s)
- [ ] Automated backups working (100% success rate)
- [ ] Data integrity maintained (zero data loss)
- [ ] Security tests passed (authentication, authorization)

### **15.2 User Success Criteria**

- [ ] User training completed (>90% attendance)
- [ ] User acceptance rate >90%
- [ ] Users can complete tasks without assistance (>80% of time)
- [ ] User satisfaction rating >4/5
- [ ] Reduced time for student registration (50% improvement)
- [ ] Reduced time for report card generation (70% improvement)
- [ ] Fee tracking accuracy >95%

### **15.3 Business Success Criteria**

- [ ] All student records digitized (100%)
- [ ] Report cards generated for all students (100%)
- [ ] Fee collection tracking operational
- [ ] Attendance recorded daily (>95% compliance)
- [ ] Data backup routine established
- [ ] System adopted by all relevant staff
- [ ] Return on investment achieved (time savings, accuracy)

---

## **16. SUPPORT & MAINTENANCE**

### **16.1 Support Channels**

1. **User Manual:** First point of reference
2. **Quick Reference Guide:** Laminated card for desk
3. **In-App Help:** Tooltips and help text
4. **Developer Contact:** Email/phone for critical issues

### **16.2 Maintenance Schedule**

**Daily:**
- Automated database backup (2:00 AM)

**Weekly:**
- Verify backup integrity
- Review audit logs for anomalies

**Monthly:**
- Database optimization (VACUUM command)
- Clear old audit logs (>1 year)

**Quarterly:**
- Software updates (if available)
- Security audit
- User feedback review

**Annually:**
- Full system review
- Archive old data (>5 years)
- Hardware assessment

### **16.3 Bug Reporting**

**Process:**
1. User identifies issue
2. Document: What happened? When? Steps to reproduce?
3. Contact developer (email with screenshot)
4. Developer investigates
5. Fix provided (update executable)
6. User installs update
7. User verifies fix

---

## **17. FUTURE ENHANCEMENTS (Phase 2)**

**Phase 2 features (not in initial scope):**

1. **Multi-Computer Network Access:**
   - Central server, multiple client computers
   - WiFi access from tablets/phones
   - Teacher mobile app for attendance

2. **SMS Notifications:**
   - Fee payment reminders
   - Absence notifications
   - Report card availability

3. **Parent Portal:**
   - View student attendance
   - View grades
   - Pay fees online (mobile money integration)

4. **Advanced Analytics:**
   - Predictive analytics (students at risk)
   - Teacher performance trends
   - Financial forecasting

5. **Cloud Backup:**
   - Google Drive/Dropbox integration
   - Automated cloud sync (when internet available)

6. **Biometric Attendance:**
   - Fingerprint scanner integration
   - Faster, more accurate attendance

7. **Library Management:**
   - Book inventory
   - Student checkouts
   - Overdue notifications

8. **Transport Management:**
   - Bus routes
   - Student assignments
   - Driver tracking

9. **Hostel Management:**
   - Room assignments
   - Boarding fees
   - Hostel attendance

10. **Alumni Tracking:**
    - Graduated student database
    - Alumni engagement

---

## **18. APPENDIX**

### **18.1 Glossary**

| Term | Definition |
|------|------------|
| **BOT** | Beginning of Term (assessment) |
| **MOT** | Middle of Term (assessment) |
| **EOT** | End of Term (assessment) |
| **UGX** | Uganda Shillings (currency) |
| **CRUD** | Create, Read, Update, Delete (operations) |
| **ORM** | Object-Relational Mapping (database abstraction) |
| **UAT** | User Acceptance Testing |
| **PDF** | Portable Document Format |
| **CSV** | Comma-Separated Values (file format) |
| **API** | Application Programming Interface |
| **UPS** | Uninterruptible Power Supply |

### **18.2 Sample Data Requirements**

**For Testing/Demo:**
- 100 sample students (various classes)
- 10 sample teachers
- 15 sample courses
- 3 terms of attendance data
- 3 terms of grade data
- Fee records with payments

### **18.3 UML Diagrams**

(Reference Section 2 of original overview document for all UML diagrams)

### **18.4 Contact Information**

**Developer Contact:**
- Name: [To be filled]
- Email: [To be filled]
- Phone: [To be filled]

**School Contact:**
- School Name: [To be filled]
- Primary Contact: [To be filled]
- Phone: [To be filled]

---

## **DOCUMENT APPROVAL**

| Role | Name | Signature | Date |
|------|------|-----------|------|
| **School Representative** | __________ | __________ | ______ |
| **Developer** | __________ | __________ | ______ |
| **Project Manager** (if applicable) | __________ | __________ | ______ |

---

**END OF PRODUCT REQUIREMENTS DOCUMENT**

**Version:** 1.0  
**Total Pages:** [This PRD]  
**Last Updated:** January 29, 2026
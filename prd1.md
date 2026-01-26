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


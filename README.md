# Offline School Management System (OSMS)

OSMS is a standalone desktop application designed to manage academic, administrative, and financial operations for Ugandan schools. It is built using Django and wrapped in PyWebView for a native desktop experience, optimized for offline use on a single computer.

## 🚀 Key Features

### 👤 User Authentication & RBAC
- **Multi-role Support:** Admin, Principal, Teacher, Accountant, and Data Clerk.
- **Role-Based Access Control (RBAC):** Permissions are strictly enforced across all modules based on user roles.
- **Audit Logging:** Every critical action (student registration, deletions, grade changes, financial transactions) is logged for accountability.

### 🎓 Student Management
- **Registration & Profiles:** Complete student record keeping including photos (auto-resized).
- **Bulk Import:** Support for importing student data from Excel (.xlsx) files.
- **Academic Summary:** Student profiles display attendance percentages, average grades, and fee balances.

### 👩‍🏫 Teacher Management
- **Profile Management:** Detailed records for teaching staff.
- **Salary Encryption:** Sensitive salary data is encrypted in the database using the `cryptography` library.
- **Weekly Timetable:** Automated timetable generation and printable views for teachers.

### 📚 Academic & Enrollment
- **Bulk Enrollment:** Quickly enroll entire classes into their respective courses.
- **Attendance Tracking:** Efficient bulk attendance marking interface.
- **Grade Management:** Record and track student performance across various assessment types.
- **Reports:** Generate individual student attendance reports and class-wide summaries.

### 💰 Finance Module
- **Fee Management:** Track fee structures and student payments.
- **Receipt Generation:** Automatic PDF receipt generation for every payment made.
- **Financial Reporting:** View total collections and individual payment histories.

## 🛠 Tech Stack
- **Backend:** Python / Django 5.0
- **Frontend:** Bootstrap 5 (Responsive UI)
- **Desktop Wrapper:** PyWebView 5.0
- **Database:** SQLite 3 (Single file, crash-resistant)
- **PDF Engine:** ReportLab
- **Excel Processing:** OpenPyXL
- **Image Processing:** Pillow

## 📥 Installation

1. **Clone the repository:**
   ```bash
   git clone <repository-url>
   cd osms
   ```

2. **Install dependencies:**
   ```bash
   pip install -r requirements.txt
   ```

3. **Initialize the Database:**
   ```bash
   python manage.py makemigrations core
   python manage.py migrate
   ```

4. **Create an Admin User:**
   ```bash
   python manage.py createsuperuser
   ```

## 🏃‍♂️ Running the Application

To launch the desktop application:
```bash
python main.py
```

## 🛡 Security & Reliability
- **Offline First:** Operates entirely without internet, ensuring data privacy and availability.
- **Data Encryption:** Sensitive financial and personal data is encrypted.
- **Data Hygiene:** Includes a `.gitignore` to prevent build artifacts and local databases from being committed.

## 📄 License
This project is proprietary and developed for Ugandan Schools.

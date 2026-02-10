# Offline School Management System (OSMS) - PHP Refactor

This project is a clean, fast, and offline-capable education management system refactored from Django to PHP. It is designed for low-bandwidth and offline school environments in Uganda.

## Features
- **Role-Based Access Control (RBAC):** Admin, Principal, Teacher, Clerk, and Student roles.
- **Student Management:** Full CRUD operations, registration, and profile views.
- **Staff Management:** Track teaching and non-teaching staff.
- **Academic Management:** Course creation and student enrollment.
- **Finance Management:** Student fee structures, payment recording, and defaulter reports.
- **Attendance & Grading:** Bulk attendance marking and assessment tracking.
- **Offline-First:** No external CDNs used; all assets (Tailwind CSS, Alpine.js) are local.
- **Clean UI:** Utility-first styling with Tailwind CSS and light interactivity with Alpine.js.

## Tech Stack
- **Backend:** PHP (Vanilla with PDO)
- **Database:** MySQL
- **Frontend:** HTML5, Tailwind CSS, Alpine.js
- **Routing:** Custom single-entry point router (`public/index.php`)

## Folder Structure
```
project-root/
│
├── public/                 # Web server root
│   ├── index.php           # Entry point
│   └── assets/             # CSS, JS, Images
│
├── app/
│   ├── Controllers/        # Business logic
│   ├── Models/             # Data access (PDO)
│   ├── Views/              # Layouts and templates
│   └── Core/               # Router and core classes
│
├── routes/
│   └── web.php             # Route definitions
│
├── database/
│   ├── schema.sql          # MySQL Schema
│   └── seed.sql            # Sample data
│
└── storage/
    └── uploads/            # Student/Staff photos
```

## Setup Instructions for School Labs (XAMPP/WAMP)

1. **Install XAMPP:** Download and install XAMPP with PHP 8.x and MySQL.
2. **Clone/Copy Project:** Place the project folder in `C:\xampp\htdocs\osms`.
3. **Database Setup:**
   - Open phpMyAdmin (`http://localhost/phpmyadmin`).
   - Create a new database named `osms_db`.
   - Import `database/schema.sql` and `database/seed.sql`.
4. **Configuration:**
   - Update `app/Models/Database.php` with your MySQL credentials if they differ from default (root/no password).
5. **Launch:**
   - Start Apache and MySQL in XAMPP Control Panel.
   - Access the system at `http://localhost/osms/public/`.

## Role Login Flows (Default)
- **Admin:** `admin` / `password`
- **Teacher:** `teacher1` / `password`
- **Student:** `student1` / `password`

## System Overview
The system follows a Model-View-Controller (MVC) architecture. All requests are routed through `public/index.php`, which dispatches them to the appropriate controller based on the definitions in `routes/web.php`. Database interactions use prepared statements via PDO to ensure security against SQL injection.

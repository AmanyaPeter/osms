<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'OSMS'; ?></title>
    <link rel="stylesheet" href="/assets/css/tailwind.min.css">
    <script defer src="/assets/js/alpine.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: true }">
        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'w-64' : 'w-20'" class="bg-blue-800 text-white transition-all duration-300 flex flex-col">
            <div class="p-4 flex items-center justify-between border-b border-blue-700">
                <span x-show="sidebarOpen" class="text-xl font-bold">OSMS</span>
                <button @click="sidebarOpen = !sidebarOpen" class="text-white focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
            </div>
            <nav class="flex-grow mt-4">
                <a href="/" class="flex items-center p-4 hover:bg-blue-700 transition-colors">
                    <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span x-show="sidebarOpen">Dashboard</span>
                </a>

                <?php if (in_array($_SESSION['role'], ['Admin', 'Principal', 'Clerk'])): ?>
                <a href="/students" class="flex items-center p-4 hover:bg-blue-700 transition-colors">
                    <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span x-show="sidebarOpen">Students</span>
                </a>
                <?php endif; ?>

                <?php if (in_array($_SESSION['role'], ['Admin', 'Principal', 'Accountant'])): ?>
                <a href="/finance" class="flex items-center p-4 hover:bg-blue-700 transition-colors">
                    <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span x-show="sidebarOpen">Finance</span>
                </a>
                <?php endif; ?>

                <?php if (in_array($_SESSION['role'], ['Admin', 'Principal'])): ?>
                <a href="/staff" class="flex items-center p-4 hover:bg-blue-700 transition-colors">
                    <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span x-show="sidebarOpen">Staff</span>
                </a>
                <a href="/courses" class="flex items-center p-4 hover:bg-blue-700 transition-colors">
                    <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    <span x-show="sidebarOpen">Courses</span>
                </a>
                <?php endif; ?>

                <?php if (in_array($_SESSION['role'], ['Admin', 'Teacher'])): ?>
                <a href="/assessments" class="flex items-center p-4 hover:bg-blue-700 transition-colors">
                    <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    <span x-show="sidebarOpen">Assessments</span>
                </a>
                <a href="/attendance" class="flex items-center p-4 hover:bg-blue-700 transition-colors">
                    <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span x-show="sidebarOpen">Attendance</span>
                </a>
                <?php endif; ?>

                <a href="/logout" class="flex items-center p-4 hover:bg-red-700 transition-colors mt-auto">
                    <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span x-show="sidebarOpen">Logout</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-grow flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white shadow-sm p-4 flex justify-between items-center">
                <div class="flex items-center">
                    <h2 class="text-xl font-semibold text-gray-800"><?php echo $title ?? 'Dashboard'; ?></h2>
                </div>
                <div class="flex items-center">
                    <span class="mr-4 text-gray-600">Welcome, <strong><?php echo $_SESSION['full_name']; ?></strong> (<?php echo $_SESSION['role']; ?>)</span>
                    <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                        <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                    </div>
                </div>
            </header>

            <!-- Main Scrollable Area -->
            <main class="flex-grow overflow-y-auto p-6">
                <?php if (isset($flash_success)): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        <?php echo $flash_success; ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($flash_error)): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <?php echo $flash_error; ?>
                    </div>
                <?php endif; ?>

                <?php echo $content; ?>
            </main>

            <!-- Footer -->
            <footer class="bg-white p-4 border-t border-gray-200 text-center text-gray-500 text-sm">
                &copy; 2026 Offline School Management System. All rights reserved.
            </footer>
        </div>
    </div>
</body>
</html>

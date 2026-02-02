<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-600">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-semibold uppercase">Total Students</p>
                <p class="text-3xl font-bold text-gray-800"><?php echo $student_count ?? 0; ?></p>
            </div>
        </div>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-600">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-semibold uppercase">Total Staff</p>
                <p class="text-3xl font-bold text-gray-800"><?php echo $staff_count ?? 0; ?></p>
            </div>
        </div>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-purple-600">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-semibold uppercase">Total Courses</p>
                <p class="text-3xl font-bold text-gray-800"><?php echo $course_count ?? 0; ?></p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-2 gap-4">
            <a href="/students/create" class="flex flex-col items-center p-4 bg-gray-50 rounded hover:bg-gray-100 transition">
                <span class="text-blue-600 mb-2"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg></span>
                <span class="text-sm font-medium">New Student</span>
            </a>
            <a href="/staff/create" class="flex flex-col items-center p-4 bg-gray-50 rounded hover:bg-gray-100 transition">
                <span class="text-green-600 mb-2"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg></span>
                <span class="text-sm font-medium">Add Staff</span>
            </a>
            <a href="/courses/create" class="flex flex-col items-center p-4 bg-gray-50 rounded hover:bg-gray-100 transition">
                <span class="text-purple-600 mb-2"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg></span>
                <span class="text-sm font-medium">New Course</span>
            </a>
            <a href="/students" class="flex flex-col items-center p-4 bg-gray-50 rounded hover:bg-gray-100 transition">
                <span class="text-yellow-600 mb-2"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></span>
                <span class="text-sm font-medium">Search</span>
            </a>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-lg font-bold text-gray-800 mb-4">System Status</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                <span class="text-gray-600">Database Connection</span>
                <span class="text-green-600 font-bold">Online</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                <span class="text-gray-600">Server Time</span>
                <span class="text-gray-800 font-mono"><?php echo date('Y-m-d H:i'); ?></span>
            </div>
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                <span class="text-gray-600">Active Academic Year</span>
                <span class="text-blue-600 font-bold">2026</span>
            </div>
        </div>
    </div>
</div>

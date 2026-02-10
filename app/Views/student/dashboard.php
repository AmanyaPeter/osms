<div class="bg-white p-8 rounded-lg shadow-md mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Welcome, <?php echo $_SESSION['full_name']; ?>!</h1>
    <p class="text-gray-500">Academic Year: 2026 | Term: Term 1</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">My Enrolled Courses</h3>
        <div class="space-y-4">
            <div class="p-4 bg-gray-50 rounded-lg">
                <h4 class="font-bold text-gray-800">Mathematics</h4>
                <p class="text-sm text-gray-600">MATH-P5 | Teacher: John Mugisha</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-lg">
                <h4 class="font-bold text-gray-800">English</h4>
                <p class="text-sm text-gray-600">ENG-P5 | Teacher: Sarah Namutebi</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Recent Grades</h3>
        <p class="text-gray-500 italic">No recent grades available.</p>
    </div>
</div>

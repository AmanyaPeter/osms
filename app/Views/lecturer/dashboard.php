<div class="bg-white p-8 rounded-lg shadow-md mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Hello, <?php echo $_SESSION['full_name']; ?>!</h1>
    <p class="text-gray-500 italic">"Teaching is the one profession that creates all other professions."</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">My Courses</h3>
        <div class="space-y-4">
            <?php foreach ($my_courses as $course): ?>
                <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                    <div>
                        <h4 class="font-bold text-blue-900"><?php echo $course['course_name']; ?></h4>
                        <p class="text-sm text-blue-700"><?php echo $course['course_code']; ?> | Grade: <?php echo $course['grade_level']; ?></p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="/attendance/mark/<?php echo $course['id']; ?>" class="bg-white text-blue-600 border border-blue-600 px-3 py-1 rounded text-sm font-semibold hover:bg-blue-600 hover:text-white transition">
                            Attendance
                        </a>
                        <a href="/assessments/course/<?php echo $course['id']; ?>" class="bg-blue-600 text-white px-3 py-1 rounded text-sm font-semibold hover:bg-blue-700 transition">
                            Grades
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Quick Reminders</h3>
        <ul class="space-y-3">
            <li class="flex items-start">
                <span class="text-yellow-500 mr-2">●</span>
                <span>Mark attendance for <strong>Mathematics - P5</strong> today.</span>
            </li>
            <li class="flex items-start">
                <span class="text-blue-500 mr-2">●</span>
                <span>Upload Mid-term test results by Friday.</span>
            </li>
        </ul>
    </div>
</div>

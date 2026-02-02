<div class="bg-white rounded-lg shadow-md p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Assessments & Attendance</h1>
    <p class="text-gray-600 mb-8">Select a course to manage attendance or enter grades.</p>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($courses as $course): ?>
            <div class="border rounded-lg p-6 hover:shadow-lg transition duration-200 bg-blue-50">
                <h3 class="text-xl font-bold text-blue-900 mb-2"><?php echo htmlspecialchars($course['course_name']); ?></h3>
                <p class="text-sm text-blue-700 mb-4"><?php echo $course['course_code']; ?> | <?php echo $course['grade_level']; ?></p>
                <div class="flex flex-col space-y-2">
                    <a href="/attendance/mark/<?php echo $course['id']; ?>" class="bg-white text-blue-600 border border-blue-600 px-4 py-2 rounded text-center font-semibold hover:bg-blue-600 hover:text-white transition">
                        Mark Attendance
                    </a>
                    <a href="/assessments/course/<?php echo $course['id']; ?>" class="bg-blue-600 text-white px-4 py-2 rounded text-center font-semibold hover:bg-blue-700 transition">
                        Manage Assessments
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

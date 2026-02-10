<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Mark Attendance</h1>
            <p class="text-gray-500"><?php echo $course['course_name']; ?> (<?php echo $course['course_code']; ?>) - <?php echo $course['grade_level']; ?></p>
        </div>
        <a href="/assessments" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">Back</a>
    </div>

    <form action="/attendance/store/<?php echo $course['id']; ?>" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
        <div class="mb-6 max-w-xs">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="date">Date</label>
            <input type="date" name="date" id="date" value="<?php echo $date; ?>" required class="w-full border rounded px-3 py-2">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="p-3 font-semibold text-gray-700">Student Name</th>
                        <th class="p-3 font-semibold text-gray-700">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3"><?php echo htmlspecialchars($student['full_name']); ?></td>
                        <td class="p-3">
                            <div class="flex space-x-4">
                                <label class="flex items-center">
                                    <input type="radio" name="attendance[<?php echo $student['id']; ?>]" value="Present" checked class="mr-2"> Present
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="attendance[<?php echo $student['id']; ?>]" value="Absent" class="mr-2"> Absent
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="attendance[<?php echo $student['id']; ?>]" value="Late" class="mr-2"> Late
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="attendance[<?php echo $student['id']; ?>]" value="Excused" class="mr-2"> Excused
                                </label>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-8 flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-8 rounded transition duration-200">
                Submit Attendance
            </button>
        </div>
    </form>
</div>

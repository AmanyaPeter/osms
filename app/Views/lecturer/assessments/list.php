<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Assessments</h1>
            <p class="text-gray-500"><?php echo htmlspecialchars($course['course_name']); ?> (<?php echo $course['course_code']; ?>)</p>
        </div>
        <a href="/assessments" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">Back</a>
    </div>

    <div class="mb-8">
        <h3 class="text-lg font-bold text-gray-700 mb-4">Existing Assessments</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="p-3 font-semibold text-gray-700">Date</th>
                        <th class="p-3 font-semibold text-gray-700">Name</th>
                        <th class="p-3 font-semibold text-gray-700">Type</th>
                        <th class="p-3 font-semibold text-gray-700">Max Score</th>
                        <th class="p-3 font-semibold text-gray-700">Weight</th>
                        <th class="p-3 font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($assessments as $assessment): ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3"><?php echo $assessment['date']; ?></td>
                        <td class="p-3 font-medium"><?php echo htmlspecialchars($assessment['name']); ?></td>
                        <td class="p-3"><?php echo $assessment['type']; ?></td>
                        <td class="p-3"><?php echo $assessment['max_score']; ?></td>
                        <td class="p-3"><?php echo $assessment['weight']; ?>%</td>
                        <td class="p-3">
                            <a href="#" class="text-blue-600 hover:underline">Enter Grades</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($assessments)): ?>
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500 italic">No assessments created yet.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="border-t pt-8">
        <h3 class="text-lg font-bold text-gray-700 mb-4">Create New Assessment</h3>
        <form action="/assessments/store" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                <input type="text" name="name" required class="w-full border rounded px-3 py-2" placeholder="e.g. Mid-term Exam">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Type</label>
                <select name="type" required class="w-full border rounded px-3 py-2">
                    <option value="Quiz">Quiz</option>
                    <option value="Test">Test</option>
                    <option value="Exam">Exam</option>
                    <option value="Assignment">Assignment</option>
                    <option value="Project">Project</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Date</label>
                <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" required class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Max Score</label>
                <input type="number" name="max_score" value="100" required class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Weight (%)</label>
                <input type="number" name="weight" value="20" required class="w-full border rounded px-3 py-2">
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded w-full">
                    Create Assessment
                </button>
            </div>
        </form>
    </div>
</div>

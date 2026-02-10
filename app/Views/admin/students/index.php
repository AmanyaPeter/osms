<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Students</h1>
        <a href="/students/create" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200">
            + Register Student
        </a>
    </div>

    <!-- Filters -->
    <form action="/students" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-1" for="q">Search</label>
            <input type="text" name="q" value="<?php echo htmlspecialchars($search); ?>" placeholder="Name or ID" class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-1" for="class">Class</label>
            <select name="class" class="w-full border rounded px-3 py-2">
                <option value="">All Classes</option>
                <?php foreach (['P1','P2','P3','P4','P5','P6','P7','S1','S2','S3','S4','S5','S6'] as $c): ?>
                    <option value="<?php echo $c; ?>" <?php echo $class_grade == $c ? 'selected' : ''; ?>><?php echo $c; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-1" for="status">Status</label>
            <select name="status" class="w-full border rounded px-3 py-2">
                <option value="">All Statuses</option>
                <option value="Active" <?php echo $status == 'Active' ? 'selected' : ''; ?>>Active</option>
                <option value="Inactive" <?php echo $status == 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
                <option value="Graduated" <?php echo $status == 'Graduated' ? 'selected' : ''; ?>>Graduated</option>
            </select>
        </div>
        <div class="flex items-end">
            <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded w-full">
                Filter
            </button>
        </div>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="p-3 font-semibold text-gray-700">Student ID</th>
                    <th class="p-3 font-semibold text-gray-700">Name</th>
                    <th class="p-3 font-semibold text-gray-700">Class</th>
                    <th class="p-3 font-semibold text-gray-700">Guardian</th>
                    <th class="p-3 font-semibold text-gray-700">Status</th>
                    <th class="p-3 font-semibold text-gray-700 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                <tr class="border-b hover:bg-gray-50 transition duration-150">
                    <td class="p-3"><?php echo $student['student_id']; ?></td>
                    <td class="p-3 font-medium"><?php echo htmlspecialchars($student['full_name']); ?></td>
                    <td class="p-3"><?php echo $student['class_grade']; ?></td>
                    <td class="p-3"><?php echo htmlspecialchars($student['guardian_name']); ?></td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold <?php echo $student['status'] == 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                            <?php echo $student['status']; ?>
                        </span>
                    </td>
                    <td class="p-3 text-right space-x-2">
                        <a href="/students/show/<?php echo $student['id']; ?>" class="text-blue-600 hover:underline">View</a>
                        <a href="/students/edit/<?php echo $student['id']; ?>" class="text-indigo-600 hover:underline">Edit</a>
                        <?php if ($_SESSION['role'] == 'Admin'): ?>
                        <a href="/students/delete/<?php echo $student['id']; ?>" class="text-red-600 hover:underline" onclick="return confirm('Are you sure?')">Delete</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($students)): ?>
                <tr>
                    <td colspan="6" class="p-8 text-center text-gray-500 italic">No students found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

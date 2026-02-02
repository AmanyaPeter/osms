<div class="bg-white rounded-lg shadow-md p-6 max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Student: <?php echo htmlspecialchars($student['full_name']); ?></h1>

    <form action="/students/update/<?php echo $student['id']; ?>" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="full_name">Full Name *</label>
            <input type="text" name="full_name" id="full_name" value="<?php echo htmlspecialchars($student['full_name']); ?>" required class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="date_of_birth">Date of Birth *</label>
            <input type="date" name="date_of_birth" id="date_of_birth" value="<?php echo $student['date_of_birth']; ?>" required class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="gender">Gender *</label>
            <select name="gender" id="gender" required class="w-full border rounded px-3 py-2">
                <option value="Male" <?php echo $student['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo $student['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
            </select>
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="class_grade">Class/Grade *</label>
            <select name="class_grade" id="class_grade" required class="w-full border rounded px-3 py-2">
                <?php foreach (['P1','P2','P3','P4','P5','P6','P7','S1','S2','S3','S4','S5','S6'] as $c): ?>
                    <option value="<?php echo $c; ?>" <?php echo $student['class_grade'] == $c ? 'selected' : ''; ?>><?php echo $c; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="guardian_name">Guardian Name *</label>
            <input type="text" name="guardian_name" id="guardian_name" value="<?php echo htmlspecialchars($student['guardian_name']); ?>" required class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="guardian_contact">Guardian Contact *</label>
            <input type="text" name="guardian_contact" id="guardian_contact" value="<?php echo htmlspecialchars($student['guardian_contact']); ?>" required class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="guardian_email">Guardian Email</label>
            <input type="email" name="guardian_email" id="guardian_email" value="<?php echo htmlspecialchars($student['guardian_email']); ?>" class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="admission_date">Admission Date *</label>
            <input type="date" name="admission_date" id="admission_date" value="<?php echo $student['admission_date']; ?>" required class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="status">Status *</label>
            <select name="status" id="status" required class="w-full border rounded px-3 py-2">
                <option value="Active" <?php echo $student['status'] == 'Active' ? 'selected' : ''; ?>>Active</option>
                <option value="Inactive" <?php echo $student['status'] == 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
                <option value="Graduated" <?php echo $student['status'] == 'Graduated' ? 'selected' : ''; ?>>Graduated</option>
            </select>
        </div>
        <div class="md:col-span-2">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="address">Address</label>
            <textarea name="address" id="address" class="w-full border rounded px-3 py-2" rows="3"><?php echo htmlspecialchars($student['address']); ?></textarea>
        </div>

        <div class="md:col-span-2 flex justify-end space-x-4 mt-4">
            <a href="/students/show/<?php echo $student['id']; ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-6 rounded">Cancel</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">Update Student</button>
        </div>
    </form>
</div>

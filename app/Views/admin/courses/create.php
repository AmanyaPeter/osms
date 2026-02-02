<div class="bg-white rounded-lg shadow-md p-6 max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Create New Course</h1>

    <form action="/courses/store" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="course_code">Course Code *</label>
            <input type="text" name="course_code" id="course_code" placeholder="e.g. MATH-P5" required class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="course_name">Course Name *</label>
            <input type="text" name="course_name" id="course_name" placeholder="e.g. Mathematics" required class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="grade_level">Grade Level *</label>
            <select name="grade_level" id="grade_level" required class="w-full border rounded px-3 py-2">
                <?php foreach (['P1','P2','P3','P4','P5','P6','P7','S1','S2','S3','S4','S5','S6'] as $c): ?>
                    <option value="<?php echo $c; ?>"><?php echo $c; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="course_type">Course Type *</label>
            <select name="course_type" id="course_type" required class="w-full border rounded px-3 py-2">
                <option value="Core">Core</option>
                <option value="Elective">Elective</option>
                <option value="Extra-curricular">Extra-curricular</option>
            </select>
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="credits">Credits</label>
            <input type="number" name="credits" id="credits" class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="status">Status</label>
            <select name="status" id="status" class="w-full border rounded px-3 py-2">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
        </div>
        <div class="md:col-span-2">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Description</label>
            <textarea name="description" id="description" class="w-full border rounded px-3 py-2" rows="3"></textarea>
        </div>

        <div class="md:col-span-2 flex justify-end space-x-4 mt-4">
            <a href="/courses" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-6 rounded">Cancel</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">Save Course</button>
        </div>
    </form>
</div>

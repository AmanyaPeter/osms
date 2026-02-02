<div class="bg-white rounded-lg shadow-md p-6 max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Add New Staff Member</h1>

    <form action="/staff/store" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="full_name">Full Name *</label>
            <input type="text" name="full_name" id="full_name" required class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email *</label>
            <input type="email" name="email" id="email" required class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="gender">Gender *</label>
            <select name="gender" id="gender" required class="w-full border rounded px-3 py-2">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="contact">Contact Number *</label>
            <input type="text" name="contact" id="contact" required class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="national_id">National ID</label>
            <input type="text" name="national_id" id="national_id" class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="qualification">Qualification</label>
            <input type="text" name="qualification" id="qualification" class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="employment_date">Employment Date *</label>
            <input type="date" name="employment_date" id="employment_date" value="<?php echo date('Y-m-d'); ?>" required class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="employment_type">Employment Type *</label>
            <select name="employment_type" id="employment_type" required class="w-full border rounded px-3 py-2">
                <option value="Permanent">Permanent</option>
                <option value="Contract">Contract</option>
                <option value="Part-time">Part-time</option>
            </select>
        </div>

        <div class="md:col-span-2 flex justify-end space-x-4 mt-4">
            <a href="/staff" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-6 rounded">Cancel</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">Save Staff Member</button>
        </div>
    </form>
</div>

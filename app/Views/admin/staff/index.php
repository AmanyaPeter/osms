<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Staff Members</h1>
        <a href="/staff/create" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            + Add Staff
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="p-3 font-semibold text-gray-700">Staff ID</th>
                    <th class="p-3 font-semibold text-gray-700">Name</th>
                    <th class="p-3 font-semibold text-gray-700">Contact</th>
                    <th class="p-3 font-semibold text-gray-700">Email</th>
                    <th class="p-3 font-semibold text-gray-700">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($staff as $member): ?>
                <tr class="border-b hover:bg-gray-50 transition duration-150">
                    <td class="p-3"><?php echo $member['staff_id']; ?></td>
                    <td class="p-3 font-medium"><?php echo htmlspecialchars($member['full_name']); ?></td>
                    <td class="p-3"><?php echo htmlspecialchars($member['contact']); ?></td>
                    <td class="p-3"><?php echo htmlspecialchars($member['email']); ?></td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                            <?php echo $member['status']; ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

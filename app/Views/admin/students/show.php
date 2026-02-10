<div class="bg-white rounded-lg shadow-md p-6 max-w-4xl mx-auto">
    <div class="flex justify-between items-start mb-6">
        <div class="flex items-center">
            <div class="w-24 h-24 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-3xl font-bold mr-6">
                <?php echo strtoupper(substr($student['full_name'], 0, 1)); ?>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-800"><?php echo htmlspecialchars($student['full_name']); ?></h1>
                <p class="text-gray-500">ID: <?php echo $student['student_id']; ?> | Class: <?php echo $student['class_grade']; ?></p>
            </div>
        </div>
        <div class="space-x-2">
            <a href="/students/edit/<?php echo $student['id']; ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                Edit Profile
            </a>
            <a href="/students" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">
                Back
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-t pt-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">Personal Information</h2>
            <div class="space-y-3">
                <p><span class="font-bold text-gray-600">Full Name:</span> <?php echo htmlspecialchars($student['full_name']); ?></p>
                <p><span class="font-bold text-gray-600">Gender:</span> <?php echo $student['gender']; ?></p>
                <p><span class="font-bold text-gray-600">Date of Birth:</span> <?php echo $student['date_of_birth']; ?></p>
                <p><span class="font-bold text-gray-600">Admission Date:</span> <?php echo $student['admission_date']; ?></p>
                <p><span class="font-bold text-gray-600">Status:</span>
                    <span class="px-2 py-1 rounded-full text-xs font-semibold <?php echo $student['status'] == 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                        <?php echo $student['status']; ?>
                    </span>
                </p>
            </div>
        </div>
        <div>
            <h2 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">Guardian Information</h2>
            <div class="space-y-3">
                <p><span class="font-bold text-gray-600">Name:</span> <?php echo htmlspecialchars($student['guardian_name']); ?></p>
                <p><span class="font-bold text-gray-600">Contact:</span> <?php echo htmlspecialchars($student['guardian_contact']); ?></p>
                <p><span class="font-bold text-gray-600">Email:</span> <?php echo htmlspecialchars($student['guardian_email'] ?? 'N/A'); ?></p>
                <p><span class="font-bold text-gray-600">Address:</span> <?php echo nl2br(htmlspecialchars($student['address'] ?? 'N/A')); ?></p>
            </div>
        </div>
    </div>
</div>

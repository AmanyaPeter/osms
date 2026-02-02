<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Fee Defaulters Report</h1>
        <a href="/finance" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">Back</a>
    </div>

    <form action="/finance/defaulters" method="GET" class="flex items-end space-x-4 mb-8">
        <div class="flex-grow max-w-xs">
            <label class="block text-gray-700 text-sm font-bold mb-1" for="class">Filter by Class</label>
            <select name="class" class="w-full border rounded px-3 py-2">
                <option value="">All Classes</option>
                <?php foreach (['P1','P2','P3','P4','P5','P6','P7','S1','S2','S3','S4','S5','S6'] as $c): ?>
                    <option value="<?php echo $c; ?>" <?php echo ($selected_class == $c) ? 'selected' : ''; ?>><?php echo $c; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded transition">
            Generate Report
        </button>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="p-3 font-semibold text-gray-700">Student ID</th>
                    <th class="p-3 font-semibold text-gray-700">Full Name</th>
                    <th class="p-3 font-semibold text-gray-700">Class</th>
                    <th class="p-3 font-semibold text-gray-700">Total Due</th>
                    <th class="p-3 font-semibold text-gray-700">Paid</th>
                    <th class="p-3 font-semibold text-gray-700">Balance</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $defaulter_count = 0;
                foreach ($defaulters as $d):
                    $balance = $d['total_expected'] - $d['total_paid'];
                    if ($balance > 0):
                        $defaulter_count++;
                ?>
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="p-3"><?php echo $d['student_id']; ?></td>
                    <td class="p-3 font-medium"><?php echo htmlspecialchars($d['full_name']); ?></td>
                    <td class="p-3"><?php echo $d['class_grade']; ?></td>
                    <td class="p-3"><?php echo number_format($d['total_expected']); ?></td>
                    <td class="p-3 text-green-600"><?php echo number_format($d['total_paid']); ?></td>
                    <td class="p-3 text-red-600 font-bold"><?php echo number_format($balance); ?></td>
                </tr>
                <?php
                    endif;
                endforeach; ?>
                <?php if ($defaulter_count === 0): ?>
                <tr>
                    <td colspan="6" class="p-8 text-center text-gray-500 italic">No defaulters found for the selected criteria.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

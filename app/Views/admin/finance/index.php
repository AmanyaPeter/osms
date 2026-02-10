<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Finance Management</h1>
        <div class="space-x-2">
            <a href="/finance/payment" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition">
                Record Payment
            </a>
            <a href="/finance/defaulters" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                Defaulters Report
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
            <h3 class="text-lg font-bold text-blue-900 mb-2">Total Collection Summary</h3>
            <p class="text-3xl font-bold text-blue-600">UGX <?php
                $total = array_sum(array_column($defaulters, 'total_paid'));
                echo number_format($total);
            ?></p>
            <p class="text-sm text-blue-700 mt-2">Total amount collected from all active students.</p>
        </div>
        <div class="bg-red-50 p-6 rounded-lg border border-red-200">
            <h3 class="text-lg font-bold text-red-900 mb-2">Outstanding Balance</h3>
            <p class="text-3xl font-bold text-red-600">UGX <?php
                $outstanding = array_sum(array_column($defaulters, 'total_expected')) - $total;
                echo number_format($outstanding);
            ?></p>
            <p class="text-sm text-red-700 mt-2">Total fees yet to be collected.</p>
        </div>
    </div>

    <h3 class="text-xl font-bold text-gray-800 mb-4">Recent Payment Overview</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="p-3 font-semibold text-gray-700">Student</th>
                    <th class="p-3 font-semibold text-gray-700">Class</th>
                    <th class="p-3 font-semibold text-gray-700">Expected</th>
                    <th class="p-3 font-semibold text-gray-700">Paid</th>
                    <th class="p-3 font-semibold text-gray-700">Balance</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (array_slice($defaulters, 0, 10) as $d): ?>
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3"><?php echo htmlspecialchars($d['full_name']); ?></td>
                    <td class="p-3"><?php echo $d['class_grade']; ?></td>
                    <td class="p-3"><?php echo number_format($d['total_expected']); ?></td>
                    <td class="p-3 text-green-600 font-semibold"><?php echo number_format($d['total_paid']); ?></td>
                    <td class="p-3 text-red-600 font-semibold"><?php echo number_format($d['total_expected'] - $d['total_paid']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

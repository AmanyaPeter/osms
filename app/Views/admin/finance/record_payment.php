<div class="bg-white rounded-lg shadow-md p-6 max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Record Student Payment</h1>

    <form action="/finance/payment" method="POST" class="space-y-4">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="student_id">Select Student *</label>
            <select name="student_id" id="student_id" required class="w-full border rounded px-3 py-2">
                <option value="">-- Choose Student --</option>
                <?php foreach ($students as $student): ?>
                    <option value="<?php echo $student['id']; ?>"><?php echo htmlspecialchars($student['full_name']); ?> (<?php echo $student['student_id']; ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="amount">Amount (UGX) *</label>
            <input type="number" name="amount" id="amount" required class="w-full border rounded px-3 py-2" placeholder="e.g. 50000">
        </div>

        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="payment_date">Payment Date *</label>
            <input type="date" name="payment_date" id="payment_date" value="<?php echo date('Y-m-d'); ?>" required class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="payment_method">Payment Method *</label>
            <select name="payment_method" id="payment_method" required class="w-full border rounded px-3 py-2">
                <option value="Cash">Cash</option>
                <option value="Mobile Money">Mobile Money</option>
                <option value="Bank Transfer">Bank Transfer</option>
                <option value="Cheque">Cheque</option>
            </select>
        </div>

        <div class="flex justify-end space-x-4 mt-6">
            <a href="/finance" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-6 rounded">Cancel</a>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded">Record & Print Receipt</button>
        </div>
    </form>
</div>

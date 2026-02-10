<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Fee Structures</h1>
        <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
            + Define New Structure
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach (['P1','P2','P3','P4','P5','P6','P7','S1','S2','S3','S4','S5','S6'] as $class): ?>
            <div class="border rounded-lg p-4 bg-gray-50">
                <h3 class="text-lg font-bold text-gray-800 mb-2">Class <?php echo $class; ?></h3>
                <p class="text-sm text-gray-600 mb-4">Term 1, 2026</p>
                <div class="text-sm space-y-1 mb-4">
                    <div class="flex justify-between"><span>Tuition:</span> <span>300,000</span></div>
                    <div class="flex justify-between"><span>Lunch:</span> <span>50,000</span></div>
                </div>
                <button class="w-full bg-white border border-blue-600 text-blue-600 py-1 rounded hover:bg-blue-600 hover:text-white transition">
                    Edit Structure
                </button>
            </div>
        <?php endforeach; ?>
    </div>
</div>

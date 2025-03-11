<?php
include('includes/header.php');
include('includes/components/sidebar.php');

$nocReasons = [
    'travel' => 'Travel',
    'visa_application' => 'Visa Application',
    'mortgage_application' => 'Mortgage Application',
    'credit_card_application' => 'Credit Card Application',
    'debit_card_application' => 'Debit Card Application',
    'bank_account_opening' => 'Bank Account Opening'
];
?>

<div class="p-10 flex-1 bg-gray-100">
    <div class="bg-white rounded-lg shadow-lg max-w-2xl mx-auto overflow-hidden">
        <div class="p-8">
            <h2 class="text-2xl font-semibold text-gray-800 text-center mb-6">
                No Objection Certificate (NOC)
            </h2>

            <form id="nocForm" action="download.php" method="post" class="space-y-6">
                <input type="hidden" name="documentType" value="noc">

                <!-- Salary Input -->
                <div class="form-group">
                    <label for="currentSalaryNoc" class="block text-gray-600 text-sm font-medium mb-2">
                        Current Salary (AED)
                    </label>
                    <input
                        type="number"
                        id="currentSalaryNoc"
                        name="currentSalaryNoc"
                        placeholder="Enter your current salary"
                        min="0"
                        step="0.01"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all"
                        required>
                </div>

                <!-- Address To Input -->
                <div class="form-group">
                    <label for="addressToNoc" class="block text-gray-600 text-sm font-medium mb-2">
                        Address To
                    </label>
                    <input
                        type="text"
                        id="addressToNoc"
                        name="addressToNoc"
                        placeholder="Enter the recipient's name/organization"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all"
                        required>
                </div>

                <!-- Country Input -->
                <div class="form-group">
                    <label for="country" class="block text-gray-600 text-sm font-medium mb-2">
                        Country
                    </label>
                    <input
                        type="text"
                        id="country"
                        name="country"
                        placeholder="Enter relevant country"
                        value="UAE"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all"
                        required>
                </div>

                <!-- NOC Reason Select -->
                <div class="form-group">
                    <label for="nocReason" class="block text-gray-600 text-sm font-medium mb-2">
                        NOC Reason
                    </label>
                    <select
                        name="nocReason"
                        id="nocReason"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all"
                        required>
                        <option value="">Select Reason</option>
                        <?php foreach ($nocReasons as $value => $label): ?>
                            <option value="<?= htmlspecialchars($value) ?>">
                                <?= htmlspecialchars($label) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Travel Dates (Hidden by default) -->
                <div id="travelDates" class="space-y-6 hidden">
                    <div class="form-group">
                        <label for="startDate" class="block text-gray-600 text-sm font-medium mb-2">
                            Travel Start Date
                        </label>
                        <input
                            type="date"
                            id="startDate"
                            name="startDate"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                    </div>

                    <div class="form-group">
                        <label for="endDate" class="block text-gray-600 text-sm font-medium mb-2">
                            Travel End Date
                        </label>
                        <input
                            type="date"
                            id="endDate"
                            name="endDate"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-4">
                    <button
                        type="submit"
                        class="bg-[#0c372a] text-white py-2.5 px-6 rounded-lg font-medium hover:bg-[#156b54] active:bg-[#0f4a3c] transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Generate Certificate
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('nocForm');
        const nocReason = document.getElementById('nocReason');
        const travelDates = document.getElementById('travelDates');
        const startDate = document.getElementById('startDate');
        const endDate = document.getElementById('endDate');

        // Handle NOC reason changes
        nocReason.addEventListener('change', () => {
            const isTravel = nocReason.value === 'travel';
            travelDates.classList.toggle('hidden', !isTravel);

            // Update required attributes
            [startDate, endDate].forEach(input => {
                input.required = isTravel;
            });
        });

        // Form validation
        form.addEventListener('submit', (e) => {
            const salary = document.getElementById('currentSalaryNoc').value;

            if (salary <= 0) {
                e.preventDefault();
                alert('Please enter a valid salary amount.');
                return;
            }

            if (nocReason.value === 'travel') {
                const start = new Date(startDate.value);
                const end = new Date(endDate.value);

                if (start > end) {
                    e.preventDefault();
                    alert('End date must be after start date.');
                    return;
                }
            }
        });

        // Real-time salary input validation
        document.getElementById('currentSalaryNoc').addEventListener('input', (e) => {
            const value = e.target.value;
            if (value < 0) {
                e.target.value = 0;
            }
        });
    });
</script>

<?php include 'includes/footer.php'; ?>
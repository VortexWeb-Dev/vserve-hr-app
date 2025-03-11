<?php
include('includes/header.php');
include('includes/components/sidebar.php');
?>

<div class="p-10 flex-1 bg-gray-100">
    <div class="bg-white rounded-lg shadow-lg max-w-2xl mx-auto overflow-hidden">
        <!-- Form Container -->
        <div class="p-8">
            <h2 class="text-2xl font-semibold text-gray-800 text-center mb-6">Salary Certificate</h2>

            <form action="download.php" method="post" class="space-y-6" id="salaryCertForm">
                <input type="hidden" name="documentType" value="salary_certificate">

                <!-- Salary Input -->
                <div class="form-group">
                    <label for="currentSalary" class="block text-gray-600 text-sm font-medium mb-2">
                        Current Salary (AED)
                    </label>
                    <input
                        type="number"
                        id="currentSalary"
                        name="currentSalary"
                        placeholder="Enter your current salary"
                        min="0"
                        step="0.01"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all"
                        required>
                </div>

                <!-- Address To Input -->
                <div class="form-group">
                    <label for="addressTo" class="block text-gray-600 text-sm font-medium mb-2">
                        Address To
                    </label>
                    <input
                        type="text"
                        id="addressTo"
                        name="addressTo"
                        placeholder="Enter the recipient's name/organization"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all"
                        required>
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
        const form = document.getElementById('salaryCertForm');

        // Form validation and submission handling
        form.addEventListener('submit', (e) => {
            const salary = document.getElementById('currentSalary').value;
            const addressTo = document.getElementById('addressTo').value;

            if (!salary || !addressTo) {
                e.preventDefault();
                alert('Please fill in all required fields.');
                return;
            }

            if (salary <= 0) {
                e.preventDefault();
                alert('Please enter a valid salary amount.');
                return;
            }
        });

        // Real-time salary input validation
        document.getElementById('currentSalary').addEventListener('input', (e) => {
            const value = e.target.value;
            if (value < 0) {
                e.target.value = 0;
            }
        });
    });
</script>

</body>

</html>
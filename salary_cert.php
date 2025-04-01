<?php
include('includes/header.php');
include('includes/components/sidebar.php');
?>

<div class="p-10 flex-1 bg-gray-100">
    <div class="bg-white rounded-lg shadow-lg max-w-2xl mx-auto overflow-hidden">
        <div class="p-8">
            <h2 class="text-2xl font-semibold text-gray-800 text-center mb-6">Salary Certificate</h2>
            <form action="download.php" method="post" class="space-y-6" id="salaryCertForm">
                <input type="hidden" name="documentType" value="salary_certificate">

                <!-- Total Gross Salary -->
                <div class="form-group">
                    <label for="salary" class="block text-gray-600 text-sm font-medium mb-2">Total Gross Salary (AED)</label>
                    <input type="number" id="salary" name="salary" placeholder="Enter total gross salary" min="0" step="0.01" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Employee Name -->
                <div class="form-group">
                    <label for="fullName" class="block text-gray-600 text-sm font-medium mb-2">Employee Name</label>
                    <input type="text" id="fullName" name="fullName" placeholder="Enter employee name" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Designation -->
                <div class="form-group">
                    <label for="designation" class="block text-gray-600 text-sm font-medium mb-2">Designation</label>
                    <input type="text" id="designation" name="designation" placeholder="Enter designation" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Emirates ID -->
                <div class="form-group">
                    <label for="emiratesId" class="block text-gray-600 text-sm font-medium mb-2">Emirates ID</label>
                    <input type="text" id="emiratesId" name="emiratesId" placeholder="Enter Emirates ID" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Joining Date -->
                <div class="form-group">
                    <label for="dateOfJoining" class="block text-gray-600 text-sm font-medium mb-2">Joining Date</label>
                    <input type="date" id="dateOfJoining" name="dateOfJoining" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Employment Type -->
                <div class="form-group">
                    <label for="employmentType" class="block text-gray-600 text-sm font-medium mb-2">Employment Type</label>
                    <input type="text" id="employmentType" name="employmentType" placeholder="e.g., Permanent, Contract" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Company Name -->
                <div class="form-group">
                    <label for="companyName" class="block text-gray-600 text-sm font-medium mb-2">Company Name</label>
                    <input type="text" id="companyName" name="companyName" placeholder="Enter company name" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Company Address -->
                <div class="form-group">
                    <label for="companyAddress" class="block text-gray-600 text-sm font-medium mb-2">Company Address</label>
                    <textarea id="companyAddress" name="companyAddress" placeholder="Enter company address" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <!-- Contact Information -->
                <div class="form-group">
                    <label for="contactInformation" class="block text-gray-600 text-sm font-medium mb-2">Contact Information</label>
                    <input type="text" id="contactInformation" name="contactInformation" placeholder="Enter contact information" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-[#0c372a] text-white py-2.5 px-6 rounded-lg font-medium hover:bg-[#156b54] active:bg-[#0f4a3c] transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Generate Salary Certificate
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('salaryCertForm');
        form.addEventListener('submit', (e) => {
            const salary = document.getElementById('salary').value;
            if (salary <= 0) {
                e.preventDefault();
                alert('Please enter a valid salary amount.');
            }
        });
        document.getElementById('salary').addEventListener('input', (e) => {
            if (e.target.value < 0) e.target.value = 0;
        });
    });
</script>

<?php include('includes/footer.php'); ?>
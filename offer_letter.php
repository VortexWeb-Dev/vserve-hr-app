<?php
include('includes/header.php');
include('includes/components/sidebar.php');
?>

<div class="p-10 flex-1 bg-gray-100">
    <div class="bg-white rounded-lg shadow-lg max-w-2xl mx-auto overflow-hidden">
        <div class="p-8">
            <h2 class="text-2xl font-semibold text-gray-800 text-center mb-6">
                Offer Letter
            </h2>

            <form id="offerLetterForm" action="download.php" method="post" class="space-y-6">
                <!-- Indicate the document type -->
                <input type="hidden" name="documentType" value="offer_letter">

                <!-- Full Name -->
                <div class="form-group">
                    <label for="fullName" class="block text-gray-600 text-sm font-medium mb-2">Full Name</label>
                    <input type="text" id="fullName" name="fullName" placeholder="Enter full name" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Offer Valid Until -->
                <div class="form-group">
                    <label for="offerValidityDate" class="block text-gray-600 text-sm font-medium mb-2">Offer Valid Until</label>
                    <input type="date" id="offerValidityDate" name="offerValidityDate" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Expected Joining Date -->
                <div class="form-group">
                    <label for="expectedJoiningDate" class="block text-gray-600 text-sm font-medium mb-2">Expected Joining Date</label>
                    <input type="date" id="expectedJoiningDate" name="expectedJoiningDate" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Signed At (Location) -->
                <div class="form-group">
                    <label for="signatureLocation" class="block text-gray-600 text-sm font-medium mb-2">Signed At (Location)</label>
                    <input type="text" id="signatureLocation" name="signatureLocation" placeholder="Enter signing location" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Signature Date -->
                <div class="form-group">
                    <label for="signatureDate" class="block text-gray-600 text-sm font-medium mb-2">Signature Date</label>
                    <input type="date" id="signatureDate" name="signatureDate" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-[#0c372a] text-white py-2.5 px-6 rounded-lg font-medium hover:bg-[#156b54] active:bg-[#0f4a3c] transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Generate Offer Letter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
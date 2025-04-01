<?php
// Configuration
$navLinks = [
    'salary_cert.php' => ['Salary Certificate', 'fas fa-money-check-alt'],
    'noc_cert.php' => ['NOC Certificate', 'fas fa-file-alt'],
    'offer_letter.php' => ['Offer Letter', 'fas fa-file-signature'],
    'https://vserve.bitrix24.in/bizproc/processes/20/view/0/' => ['Leave Application', 'fas fa-calendar-check', '_blank']
];

$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!-- Sidebar for Desktop -->
<div class="sidebar bg-[#0c372a] text-white min-h-screen hidden md:flex flex-col justify-between w-max" id="sidebar">
    <div class="p-6">
        <h1 class="font-bold mb-8 text-white text-center hover:text-gray-300">
            <a href="index.php" class="flex flex-col">
                <span class="text-xl">VSERVE REAL ESTATE - HR</span>
            </a>
        </h1>

        <ul class="flex flex-col gap-2">
            <?php foreach ($navLinks as $link => $data): ?>
                <li>
                    <a href="<?= $link ?>"
                        class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 <?= ($currentPage === $link) ? 'bg-gray-700' : '' ?>"
                        <?= isset($data[2]) ? 'target="' . $data[2] . '"' : '' ?>>
                        <i class="<?= $data[1] ?> mr-2"></i> <?= $data[0] ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="p-6 text-sm text-gray-400 text-center">
        ©<?= date('Y') ?> - <a href="https://vortexweb.cloud/" target="_blank">VortexWeb</a>
    </div>
</div>

<!-- Mobile Menu Toggle -->
<div class="md:hidden flex flex-col justify-between w-max">
    <button id="toggleSidebar" class="p-4">
        <i id="menuIcon" class="fas fa-bars hover:text-gray-500"></i>
    </button>
</div>

<!-- Mobile Overlay -->
<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-[999] hidden"></div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const elements = {
            toggleButton: document.getElementById('toggleSidebar'),
            sidebar: document.getElementById('sidebar'),
            overlay: document.getElementById('overlay'),
            menuIcon: document.getElementById('menuIcon')
        };

        function toggleMenu(show) {
            elements.sidebar.classList.toggle('hidden', !show);
            elements.overlay.classList.toggle('hidden', !show);
            elements.menuIcon.classList.toggle('fa-times', show);
            elements.menuIcon.classList.toggle('fa-bars', !show);
        }

        elements.toggleButton.addEventListener('click', () => {
            const isHidden = elements.sidebar.classList.contains('hidden');
            toggleMenu(isHidden);
        });

        elements.overlay.addEventListener('click', () => toggleMenu(false));
    });
</script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

<?php
session_start();
if (!isset($_SESSION['user'])) {
    // Redirect to login if the user is not logged in
    header("Location: login.php");
    exit();
}
?>

<!-- Left Sidebar -->
<div class="left-sidebar" id="sidebar">
    <!-- Toggle Button -->
    <button class="toggle-btn" onclick="toggleSidebar()">
        <i id="toggle-icon" class="fas fa-bars"></i>
    </button>

    <!-- Sidebar scroll -->
    <div class="scroll-sidebar">
        <?php
            $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Admin';
        ?>

        <!-- Admin Photo -->
        <div class="admin-photo text-center py-4">
            <h5 class="mt-2"><?php echo htmlspecialchars($username); ?></h5>
        </div>

        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul class="list-unstyled">
                <li class="nav-label">Home</li>
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">
                        <i class="fas fa-tachometer-alt"></i><span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="nav-label">Management</li>
                <li class="nav-item">
                    <a class="nav-link" href="../homestay/view_homestay.php">
                        <i class="fas fa-bed"></i><span class="hide-menu">View Homestays</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../booking/bookings_list.php">
                        <i class="fas fa-calendar-check"></i><span class="hide-menu">View Bookings</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../user/users_list.php">
                        <i class="fas fa-user"></i><span class="hide-menu">View Users</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../logout.php">
                        <i class="fas fa-sign-out-alt"></i><span class="hide-menu">Log Out</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../../index.php">
                        <i class="fas fa-home"></i><span class="hide-menu">Home Page</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</div>
<!-- End Left Sidebar -->

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById("sidebar");
        const toggleIcon = document.getElementById("toggle-icon");

        // Toggle the 'collapsed' class
        sidebar.classList.toggle("collapsed");

        // Update the icon depending on the sidebar state
        if (sidebar.classList.contains("collapsed")) {
            toggleIcon.classList.remove("fa-bars");
            toggleIcon.classList.add("fa-times");
        } else {
            toggleIcon.classList.remove("fa-times");
            toggleIcon.classList.add("fa-bars");
        }
    }
</script>
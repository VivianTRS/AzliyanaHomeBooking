<?php
session_start();
if (!isset($_SESSION['user'])) {
    // Redirect to login if the user is not logged in
    header("Location: login.php");
    exit();
}
?>

<?php
// Include database connection
include('../includes/config.php');

// Fetch Total Homestays
$homestayQuery = "SELECT COUNT(*) as total_homestays FROM tbl_homestays";
$homestayResult = mysqli_query($conn, $homestayQuery) or die(mysqli_error($conn));
$homestayData = mysqli_fetch_assoc($homestayResult);
$totalHomestays = $homestayData['total_homestays'];

// Fetch Total Bookings
$bookingQuery = "SELECT COUNT(*) as total_bookings FROM tbl_bookings";
$bookingResult = mysqli_query($conn, $bookingQuery);

if ($bookingResult && mysqli_num_rows($bookingResult) > 0) {
    $bookingData = mysqli_fetch_assoc($bookingResult);
    $totalBookings = $bookingData['total_bookings'];
} else {
    $totalBookings = 0; // Default value if no bookings
}

// Initialize $allTimeIncome to avoid warnings
$allTimeIncome = 0.00;

// Fetch All-Time Total Income in MYR
$totalIncomeQuery = "SELECT SUM(total_amount) as all_time_income FROM tbl_bookings";
$totalIncomeResult = mysqli_query($conn, $totalIncomeQuery);

if ($totalIncomeResult && mysqli_num_rows($totalIncomeResult) > 0) {
    $totalIncomeData = mysqli_fetch_assoc($totalIncomeResult);
    $allTimeIncome = $totalIncomeData['all_time_income'] ?? 0.00;
} else {
    // Handle error if needed
    $allTimeIncome = 0.00; // Default value if no income
}

// Fetch Recent Bookings
$recentBookingsQuery = " SELECT 
        tbl_bookings.booking_id, 
        tbl_homestays.name_homestay AS homestay_name, 
        tbl_bookings.check_in_date, 
        tbl_bookings.check_out_date, 
        tbl_bookings.total_amount
    FROM 
        tbl_bookings 
    JOIN 
        tbl_homestays 
    ON 
        tbl_bookings.homestay_id = tbl_homestays.homestay_id";
$recentBookingsResult = mysqli_query($conn, $recentBookingsQuery) or die(mysqli_error($conn));

// Fetch Events for FullCalendar
$bookingEventsQuery = "SELECT tbl_bookings.check_in_date AS start, 
    tbl_bookings.check_out_date AS end, 
    tbl_homestays.name_homestay AS title FROM tbl_bookings 
    JOIN tbl_homestays ON tbl_bookings.homestay_id = tbl_homestays.homestay_id";
$bookingEventsResult = mysqli_query($conn, $bookingEventsQuery) or die(mysqli_error($conn));

$events = [];
while ($row = mysqli_fetch_assoc($bookingEventsResult)) {
    // Calculate duration in days
    $startTimestamp = strtotime($row['start']);
    $endTimestamp = strtotime($row['end']);
    $durationInDays = ($endTimestamp - $startTimestamp) / (60 * 60 * 24); // Convert seconds to days

    $events[] = [
        'timeZone' => 'Asia/Kuala_Lumpur',
        'title' => $row['title'],
        'start' => $row['start'],
        'End' => $row['end'] 
    ];
}
$eventsJson = json_encode($events);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
    
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/web-component@6.1.15/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.15/index.global.min.js'></script>
    <script src="js/dashboard.js"></script>


</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-actions">
            <!-- <img src="images/profile.jpg" alt="<?php echo htmlspecialchars($adminName); ?>" class="admin-profile-pic"> -->
            <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar">
        <ul>
            <li><a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="homestay/view_homestay.php"><i class="fas fa-bed"></i> Homestays</a></li>
            <li><a href="booking/bookings_list.php"><i class="fas fa-calendar-check"></i> Bookings</a></li>
            <li><a href="user/users_list.php"><i class="fas fa-user"></i> Users</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            <li><a href="../index.php"><i class="fas fa-home"></i> Home Page</a></li>
        </ul>
    </aside>

    <!-- Main Dashboard Area -->
    <main class="dashboard">
        <!-- Statistics -->
        <section class="stats">
            <div class="stat-card">
                <h3>Total Homestays</h3>
                <p><?php echo $totalHomestays; ?></p>
            </div>

            <div class="form-group">
                <label for="income-period-year">Select Year:</label>
                <select id="income-period-year" name="income_period_year" class="form-control">
                    <option value="all">All Years</option>
                    <?php
                    // Populate the combo box with years
                    $yearMonthQuery = "SELECT DISTINCT DATE_FORMAT(check_in_date, '%Y') AS year FROM tbl_bookings ORDER BY year DESC";
                    $yearMonthResult = mysqli_query($conn, $yearMonthQuery) or die(mysqli_error($conn));
                    while ($row = mysqli_fetch_assoc($yearMonthResult)) {
                        echo '<option value="' . $row['year'] . '">' . $row['year'] . '</option>';
                    }
                    ?>
                </select>

                <label for="income-period-month">Select Month:</label>
                <select id="income-period-month" name="income_period_month" class="form-control">
                    <option value="all">All Months</option>
                    <?php
                    // Populate the combo box with months (1-12)
                    for ($i = 1; $i <= 12; $i++) {
                        $monthName = date("F", mktime(0, 0, 0, $i, 1));
                        echo '<option value="' . str_pad($i, 2, '0', STR_PAD_LEFT) . '">' . $monthName . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="stat-card">
                <h3>Total Bookings</h3>
                <p class="total-bookings"><?php echo $totalBookings; ?></p>
            </div>

            <div class="stat-card">
                <h3>Total Income</h3>
                <p class="total-income">MYR <?php echo number_format($allTimeIncome, 2); ?></p>
            </div>

            <div class="calendar-container">
                <div id="calendar"></div>
            </div>
        </section>

        <!-- Recent Bookings -->
        <section class="recent-bookings">
            <h3>Recent Bookings</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Homestay</th>
                        <th>Check-in Date</th>
                        <th>Check-out Date</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($recentBookingsResult)): ?>
                        <tr>
                            <td><?php echo $row['homestay_name']; ?></td>
                            <td><?php echo $row['check_in_date']; ?></td>
                            <td><?php echo $row['check_out_date']; ?></td>
                            <td><?php echo $row['total_amount']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </main>

    <!-- Store JSON data for calendar events -->
    <script type="application/json" id="events-data"><?php echo $eventsJson; ?></script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
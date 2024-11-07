document.addEventListener('DOMContentLoaded', function() {
    var yearSelect = document.getElementById('income-period-year');
    var monthSelect = document.getElementById('income-period-month');

    function updateStatsAndBookings() {
        var year = yearSelect.value;
        var month = monthSelect.value;

        // Fetch stats data
        fetch('fetch_stats.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ year: year, month: month })
        })
        .then(response => response.json())
        .then(data => {
            // Update the stat cards with the new data
            document.querySelector('.total-bookings').textContent = data.total_bookings;
            document.querySelector('.total-income').textContent = 'MYR ' + parseFloat(data.total_income).toFixed(2);
        })
        .catch(error => console.error('Error fetching stats:', error));

        // Fetch recent bookings data
        fetch('fetch_recent_bookings.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ year: year, month: month })
        })
        .then(response => response.json())
        .then(data => {
            const bookingsTableBody = document.querySelector('.recent-bookings tbody');
            bookingsTableBody.innerHTML = ''; // Clear existing rows
            data.recent_bookings.forEach(booking => {
                bookingsTableBody.innerHTML += `
                    <tr>
                        <td>${booking.homestay_name}</td>
                        <td>${booking.check_in_date}</td>
                        <td>${booking.check_out_date}</td>
                        <td>${booking.total_amount}</td>
                    </tr>
                `;
            });
        })
        .catch(error => console.error('Error fetching recent bookings:', error));
    }

    // Event listeners for the year and month selectors
    yearSelect.addEventListener('change', updateStatsAndBookings);
    monthSelect.addEventListener('change', updateStatsAndBookings);

    // Initialize FullCalendar
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: JSON.parse(document.getElementById('events-data').textContent)
    });
    calendar.render();
});

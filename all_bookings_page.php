<?php
include 'manage_turf_process.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Bookings</title>
    <link rel="stylesheet" href="all_booking_page_style.css">
</head>

<body>
    <div class="recent_bookings">
        <h2>All Bookings</h2>
        <?php
        //For recent bookings
        $recent_bookings_sql = "SELECT * FROM bookings b INNER JOIN users u ON b.user_id = u.id WHERE turf_id = ? ORDER BY booking_date DESC, booking_time DESC";
        $stmt_bookings = $conn->prepare($recent_bookings_sql);
        $stmt_bookings->bind_param("i", $turf_id);
        $stmt_bookings->execute();
        $recent_bookings = $stmt_bookings->get_result();
        ?>
        <?php if ($recent_bookings->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Booked By</th>
                        <th>Number</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($booking = $recent_bookings->fetch_assoc()): ?>
                        <tr>
                            <td> <?= $booking['booking_date'] ?> </td>
                            <td> <?= $booking['booking_time'] ?> </td>
                            <td> <?= $booking['name'] ?> </td>
                            <td> <?= $booking['number'] ?> </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No bookings found!</p>
        <?php endif; ?>
    </div>
</body>

</html>
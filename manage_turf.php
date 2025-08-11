<?php
include 'manage_turf_process.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Turf</title>
    <link rel="stylesheet" href="manage_turf_style.css">
</head>

<body>
    <div class="top_bar">
        <div class="header">
            <h1>Manage Turf</h1>
        </div>
        <div class="turf_info">
            <p><?= htmlspecialchars($turf['name']) ?> - <?= htmlspecialchars($turf['location']) ?></p>
        </div>
        <div id="logout-button">
            <a href="logout.php" class="logout-button">Logout</a>
        </div>
    </div>

    <div class="welcome-msg">
        <h3 class="welcome-message">Welcome Back, <?php echo $_SESSION["user_name"] ?>!</h3>
    </div>


    <div class="ratings">
        <h2>Turf Rating</h2>
        <?php
        //fetch ratings info
        $ratings_sql = "SELECT AVG(rating) as avg_rating, COUNT(*) as total_ratings 
               FROM ratings 
               WHERE turf_id = ?";
        $ratings_stmt = $conn->prepare($ratings_sql);
        $ratings_stmt->bind_param("i", $turf_id);
        $ratings_stmt->execute();
        $ratings_result = $ratings_stmt->get_result();
        $ratings = $ratings_result->fetch_assoc();
        ?>
        <p>Rating: <?= number_format($ratings['avg_rating'], 1) ?></p>
        <br>
        <p>Total Number of Ratings: <?= $ratings['total_ratings'] ?></p>
    </div>
    <div class="turf_visibility">
        <h2>Turf Visibility</h2>
        <p>Current status:
            <span class="<?= $turf['visibility'] ? 'status-available' : 'status-booked' ?>">
                <?= $turf['visibility'] ? 'Visible to users' : 'Hidden from users' ?>
            </span>
        </p>
        <br>
        <form method="POST">
            <button type="submit" name="toggle_visibility" class="btn">
                <?= $turf['visibility'] ? 'Hide Turf' : 'Make Visible' ?>
            </button>
        </form>
    </div>

    <div class="hourly_rate">
        <h2>Hourly rate</h2>
        <p>Current hourly rate:
            <span>
                <?= $turf['hourly_rate'] ?>
            </span> taka
        </p>
        <br>
        <label>Set new hourly rate</label>
        <form method="POST">
            <input type="number" name="new_hourly_rate" step="50" required>
            <button type="submit" name="set_hourly_rate" class="btn">
                Set Hourly Rate
            </button>
        </form>
    </div>

    <div class="custom_book">
        <h2>Custom Book</h2>
        <form method="POST">
            <div class="form-group">
                <label for="custom_name">Customer Name</label>
                <input type="text" id="custom_name" name="custom_name" required>
            </div>
            <div class="form-group">
                <label for="custom_number">Phone Number</label>
                <input type="text" id="custom_number" name="custom_number" required>
            </div>
            <div class="form-group">
                <label id="select_date">Select Date</label>
                <input type="date" id="select_date" name="select_date" required>
            </div>
            <div class="form-group">
                <label id="select_time">Choose a time slot:</label>
                <select id=" select_time" name="select_time" required>
                    <option value="9:00 AM - 10:00 AM">9:00 AM - 10:00 AM</option>
                    <option value="10:00 AM - 11:00 AM">10:00 AM - 11:00 AM</option>
                    <option value="11:00 AM - 12:00 PM">11:00 AM - 12:00 PM</option>
                    <option value="12:00 PM - 1:00 PM">12:00 PM - 1:00 PM</option>
                    <option value="1:00 PM - 2:00 PM">1:00 PM - 2:00 PM</option>
                    <option value="2:00 PM - 3:00 PM">2:00 PM - 3:00 PM</option>
                    <option value="3:00 PM - 4:00 PM">3:00 PM - 4:00 PM</option>
                    <option value="4:00 PM - 5:00 PM">4:00 PM - 5:00 PM</option>
                    <option value="5:00 PM - 6:00 PM">5:00 PM - 6:00 PM</option>
                    <option value="6:00 PM - 7:00 PM">6:00 PM - 7:00 PM</option>
                    <option value="7:00 PM - 8:00 PM">7:00 PM - 8:00 PM</option>
                    <option value="8:00 PM - 9:00 PM">8:00 PM - 9:00 PM</option>
                    <option value="9:00 PM - 10:00 PM">9:00 PM - 10:00 PM</option>
                    <option value="10:00 PM - 11:00 PM">10:00 PM - 11:00 PM</option>
                    <option value="11:00 PM - 12:00 AM">11:00 PM - 12:00 AM</option>
                </select>
            </div>
            <button type="submit" name="book_slot" class="btn">Book Slot</button>
            <?php if (!empty($error)): ?>
                <p style="color: red; font-weight: bold; text-align: center;"><?php echo $error; ?></p>
            <?php endif; ?>
        </form>
    </div>
    <div class="change_availability">
        <h2>Change Availability</h2>
        <form method="POST">
            <div class="form-group">
                <label id="select_date">Select Date</label>
                <input type="date" id="select_date" name="select_date" required>
            </div>
            <div class="form-group">
                <label id="select_time">Choose a time slot:</label>
                <select id=" select_time" name="select_time" required>
                    <option value="9:00 AM - 10:00 AM">9:00 AM - 10:00 AM</option>
                    <option value="10:00 AM - 11:00 AM">10:00 AM - 11:00 AM</option>
                    <option value="11:00 AM - 12:00 PM">11:00 AM - 12:00 PM</option>
                    <option value="12:00 PM - 1:00 PM">12:00 PM - 1:00 PM</option>
                    <option value="1:00 PM - 2:00 PM">1:00 PM - 2:00 PM</option>
                    <option value="2:00 PM - 3:00 PM">2:00 PM - 3:00 PM</option>
                    <option value="3:00 PM - 4:00 PM">3:00 PM - 4:00 PM</option>
                    <option value="4:00 PM - 5:00 PM">4:00 PM - 5:00 PM</option>
                    <option value="5:00 PM - 6:00 PM">5:00 PM - 6:00 PM</option>
                    <option value="6:00 PM - 7:00 PM">6:00 PM - 7:00 PM</option>
                    <option value="7:00 PM - 8:00 PM">7:00 PM - 8:00 PM</option>
                    <option value="8:00 PM - 9:00 PM">8:00 PM - 9:00 PM</option>
                    <option value="9:00 PM - 10:00 PM">9:00 PM - 10:00 PM</option>
                    <option value="10:00 PM - 11:00 PM">10:00 PM - 11:00 PM</option>
                    <option value="11:00 PM - 12:00 AM">11:00 PM - 12:00 AM</option>
                </select>
            </div>
            <button type="submit" name="toggle_status" class="btn">Make Unavailable</button>
            <?php if (!empty($error2)): ?>
                <p style="color: red; font-weight: bold; text-align: center;"><?php echo $error2; ?></p>
            <?php endif; ?>
        </form>
    </div>
    <div class="recent_bookings">
        <h2>Recent Bookings</h2>
        <?php
        //For recent bookings
        $recent_bookings_sql = "SELECT * FROM bookings b INNER JOIN users u ON b.user_id = u.id WHERE turf_id = ? ORDER BY  booking_id DESC LIMIT 15";
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
    <div class="all_bookings">
        <h2>All Bookings</h2>
        <form method="POST">
            <button type="submit" name="see_all_bookings" class="btn">See All Bookings</button>
        </form>
    </div>
</body>

</html>
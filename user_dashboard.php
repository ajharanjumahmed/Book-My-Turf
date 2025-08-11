<?php
include 'user_dashboard_process.php';
if (!isset($_SESSION["user_id"])) //if the user is not logged in
{
    header("Location: login.php"); //redirect to the login page
    exit(); //stop running the script
}
?>

<?php
    $user_id = $_SESSION['user_id'];
    $status_sql = "SELECT status FROM users where id = ?";
    $status_stmt = $conn->prepare($status_sql);
    $status_stmt->bind_param("i", $user_id);
    $status_stmt->execute();
    $status_result = $status_stmt->get_result();
    $status = $status_result->fetch_assoc();

    if($status['status']!='active'){
        header("Location: not_verified.php");
        exit();
    }
?>

<?php
    $user_id = $_SESSION['user_id'];
    $name_sql = "SELECT name FROM users where id = ?";
    $name_stmt = $conn->prepare($name_sql);
    $name_stmt->bind_param("i", $user_id);
    $name_stmt->execute();
    $name_result = $name_stmt->get_result();
    $user_name = $name_result->fetch_assoc(); 
?>

<?php
    $search_result = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="user_dashboard_style.css">
    <title>User Dashboard</title>
</head>

<body>
    <div class="header">
        <h1>User Dashboard</h1>
        <a href="logout.php">Logout</a>
    </div>
    <div class="welcome-msg">
        <h2>Welcome Back, <?php echo $user_name['name']; ?>!</h2>
        <br>
    </div>
    <div class="card">
        <h2>Edit Profile</h2>
        <form method="POST">
            <button class="btn" name="edit_profile">Edit</button>
        </form>
    </div>
    <div class="card">
        <h2>Search Turfs</h2>
        <form method="POST">
            <div class="form_group">
                <label>Select a date:</label>
                <input type="date" id="select_date" name="select_date" required>
            </div>
            <div class="form_group">
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
            <div class="form_group">
                <label class="label">Zone:</label>
                <select id=" select_time" name="select_zone" required>
                    <option value="Inside Sylhet City">Inside Sylhet City Corporation</option>
                    <option value="Outside Sylhet City">Outside Sylhet City Corporation</option>
                </select>
            </div>
            <div class="form_group">
                <button type="submit" name="search_turf" class="btn">Search Turfs</button>
            </div>
        </form>

        <?php
        //for search turf
        if (isset($_POST['search_turf'])) {
            $date = $_POST['select_date'];
            $time = $_POST['select_time'];
            $zone = $_POST['select_zone'];

            $search_sql = "SELECT t.*, (SELECT AVG(rating) FROM ratings WHERE turf_id = t.id) as avg_rating FROM turfs t WHERE t.zone = ? AND t.is_verified = TRUE AND t.visibility = TRUE AND 
                    NOT EXISTS (
                        SELECT 1 
                        FROM bookings b 
                        WHERE b.turf_id = t.id 
                        AND b.booking_date = ? 
                        AND b.booking_time = ?
                        AND (b.is_booked = 1 OR b.is_available = 0)
                    ) ORDER BY avg_rating DESC";
            $stmt = $conn->prepare($search_sql);
            $stmt->bind_param("sss", $zone, $date, $time);
            $stmt->execute();
            $search_result = $stmt->get_result();
        }
        ?>

        <?php if ($search_result != null && $search_result->num_rows == 0): ?>
            <p style="color: #6c757d;"><i><?= "No turfs are available for this slot" ?></i></p>
        <?php endif; ?>

        <?php if ($search_result != null && $search_result->num_rows > 0): ?>
            <div class="available_turfs">  
            <h3>Available Turfs</h3>
            <p><strong>Search Date: </strong> <i><?= $_POST['select_date'] ?></i><br><strong>Search Time: </strong> <i><?= $_POST['select_time'] ?></i><br><strong>Zone: </strong><i><?= $_POST['select_zone'] ?></i></p>
                <div class="turf_cards">
                    <?php while ($turf = $search_result->fetch_assoc()): ?>
                        <div class="turf_card">
                            <img src="<?= $turf['image'] ?>" alt="turf image">  
                            <h3><?= $turf['name'] ?></h3>
                            <form method="post">
                                <input type="hidden" name="turf_id" value="<?= $turf['id'] ?>">
                                <input type="hidden" name="turf_name" value="<?= $turf['name'] ?>">
                                <input type="hidden" name="booking_date" value="<?= $date ?>">
                                <input type="hidden" name="booking_time" value="<?= $time ?>">

                                <p> Location: <?= $turf['location'] ?></p>
                                <p> Hourly Rate: <?= $turf['hourly_rate'] ?> taka</p>

                                <?php if ($turf['avg_rating']): ?>
                                    <p class="rating">Rating: <?= number_format($turf['avg_rating'], 1) ?> </p>
                                <?php else: ?>
                                    <p class="rating">Rating: <i style="color: #6c757d;">No ratings yet</i></p>
                                <?php endif; ?>

                                <button type="submit" name="book_turf" class="book-turf-btn">
                                    Book Now
                                </button>
                            </form>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="card">
        <div class="recent_bookings">
            <h2>Recent Bookings</h2>
            <?php
            //For recent bookings
            $recent_bookings_sql = "SELECT * FROM bookings b INNER JOIN turfs t ON b.turf_id = t.id WHERE b.user_id = ? AND b.is_booked = 1 ORDER BY booking_id DESC";
            $stmt_bookings = $conn->prepare($recent_bookings_sql);
            $stmt_bookings->bind_param("i", $_SESSION['user_id']);
            $stmt_bookings->execute();
            $recent_bookings = $stmt_bookings->get_result();
            ?>
            <?php if ($recent_bookings->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Turf Name</th>
                            <th>Turf Location</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($booking = $recent_bookings->fetch_assoc()): ?>
                            <tr>
                                <td> <?= $booking['booking_date'] ?> </td>
                                <td> <?= $booking['booking_time'] ?> </td>
                                <td> <?= $booking['name'] ?> </td>
                                <td> <?= $booking['location'] ?> </td>
                                <td>
                                    <?php
                                    // Check if user has already rated this turf
                                    $check_rating_sql = "SELECT id FROM ratings 
                                                    WHERE user_id = ? AND turf_id = ?";
                                    $stmt = $conn->prepare($check_rating_sql);
                                    $stmt->bind_param("ii", $_SESSION['user_id'], $booking['turf_id']);
                                    $stmt->execute();
                                    $has_rated = $stmt->get_result()->num_rows > 0;
                                    ?>
                                    
                                    <?php if (!$has_rated): //if not rated ?>
                                        <form method="POST" class="rating-form">
                                            <input type="hidden" name="turf_id" value="<?= $booking['turf_id'] ?>">
                                            <input type="number" name="rating" min="1" max="5" step="0.5"
                                                placeholder="1-5" required>
                                            <button type="submit" name="submit_rating" class="btn">Rate</button>
                                        </form>
                                    <?php else: ?>
                                        <span style="color: #27ae60;">Rated</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No bookings found!</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
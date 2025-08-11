<?php
session_start(); //start the session
include "db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') // If not logged in or not an admin
{
    header("Location: login.php");
    exit();
}

//set the default values
$user_result = $turf_result = null;
$search_user_number = $search_turf_name = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") //if the form is submitted
{
    if (isset($_POST["search_user"])) //if search user button is pressed
    {
        $search_user_number = $_POST['user_number']; //store the input number of form
        //Fetch the data from  database
        $sql = "SELECT id, name, email, number,  role, status FROM users WHERE number = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $search_user_number);
        $stmt->execute();
        $user_result = $stmt->get_result();
    }

    if (isset($_POST["search_turf"])) //if search turf button is pressed
    {
        $search_turf_name = $_POST["turf_name"];
        $sql = "SELECT * FROM turfs WHERE name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $search_turf_name);
        $stmt->execute();
        $turf_result = $stmt->get_result();
    }
}

//Fetch pending registration turfs from the database
$sql = "SELECT id, name, location FROM turfs WHERE is_verified = 0";
$pending_turfs = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_dashboard_style.css">
    <title>Admin Dashboard</title>
</head>

<body>
    <div class="text">
        <div class="header">
            <h1 class="title">Admin Dashboard</h1>
            <div id="submit-button">
                <a href="logout.php" class="logout-button">Logout</a>
            </div>
        </div>
        <h3 class="welcome-message">Welcome Back, <?php echo $_SESSION["user_name"] ?>!</h3>
    </div>
    <div class="container">
        <div class="search-user">
            <h2>Search User</h2>
            <form method="POST" class="form">
                <label>Number</label>
                <input type="text" name="user_number" placeholder="Enter user's number" required>
                <button type="submit" name="search_user">Search User</button>
            </form>
            <?php if ($user_result): ?>
                <?php if ($user_result->num_rows > 0): ?>
                    <?php $user = $user_result->fetch_assoc() ?>
                    <div class="user-search-result">
                        <h3>User Details</h3>
                        <hr>
                        <p><strong>Name: </strong><?php echo $user["name"] ?> </p>
                        <p><strong>Email: </strong><?php echo $user["email"] ?> </p>
                        <p><strong>Role: </strong><?php echo $user["role"] ?> </p>
                        <p><strong>Status: </strong><?php echo $user["status"] ?> </p>
                    </div>
                    <div class="action-buttons">
                        <form action="toggle_user_status.php" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $user["id"] ?>">
                            <button type="submit">
                                <?php echo $user["status"] == "active" ? "Block User" : "Unblock User" ?>
                            </button>
                        </form>
                    </div>
                <?php else: ?>
                    <p id="no-user">No user found with number: <?php echo $search_user_number ?></p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <div class="search-turf">
            <h2>Search Turf</h2>
            <form method="POST" class="form">
                <label>Turf Name</label>
                <input type="text" name="turf_name" placeholder="Enter turf name" required>
                <button type="submit" name="search_turf">Search Turf</button>
            </form>
            <?php if ($turf_result): ?>
                <?php if ($turf_result->num_rows > 0): ?>
                    <?php while ($turf = $turf_result->fetch_assoc()): ?>
                        <div class="turf-search-result">
                            <h3>Turf Details</h3>
                            <hr>
                            <p><strong>Turf Name: </strong><?= $turf["name"] ?></p>
                            <p><strong>Location: </strong><?= $turf["location"] ?></p>
                            <p><strong>Zone: </strong><?= $turf["zone"] ?></p>
                            <p><strong>Hourly rate: </strong><?= $turf["hourly_rate"] ?> taka</p>
                            <p><strong>Status: </strong><?= $turf["is_verified"] ? "Verified" : "Not Verified" ?></p>

                        </div>
                        <div class="action-buttons">
                            <form action="toggle_turf_verification.php" method="POST">
                                <input type="hidden" name="turf_id" value="<?php echo $turf["id"] ?>">
                                <button type="submit">
                                    <?= $turf["is_verified"] ? "Unverify Turf" : "Verify Turf" ?>
                                </button>
                            </form>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p id="no-user">No turf found with name: <?php echo $search_turf_name ?></p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <div class="pending-turf">
            <h2>Pending Turf Registrations</h2>
            <?php if ($pending_turfs->num_rows > 0): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Turf Name</th>
                            <th>Location</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($pturf = $pending_turfs->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $pturf["name"] ?></td>
                                <td><?php echo $pturf["location"] ?></td>
                                <td>
                                    <div class="button-group">
                                        <form action="approve_turf.php" method="POST">
                                            <input type="hidden" name="pturf_id" value="<?= $pturf['id'] ?>">
                                            <button class="approve-buttons" type="submit" style="background-color: green;">Approve</button>
                                        </form>
                                        <form action="reject_turf.php" method="POST">
                                            <input type="hidden" name="pturf_id" value="<?= $pturf['id'] ?>">
                                            <button class="reject-buttons" type="submit" style="background-color: red;">Reject</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p id="no-pending">No pending turf registrations for approval</p>
            <?php endif; ?>
        </div>
    </div>

</body>

</html>
<?php

require_once("auth.php");
require_once("config.php");

// Get user data from database
$user_id = $_SESSION['USERID'];
$userQuery = $conn->prepare("SELECT * FROM usertable WHERE user_id = ?");
$userQuery->bind_param("i", $user_id);
$userQuery->execute();
$userResult = $userQuery->get_result();
$user = $userResult->fetch_assoc();

// Get booking history
$bookingQuery = $conn->prepare("
    SELECT b.booking_id, r.room_name AS room, b.start_date, b.start_time 
    FROM booking b 
    JOIN room r ON b.room_id = r.room_id 
    WHERE b.lecturer_id = ? 
    ORDER BY b.start_date DESC, b.start_time DESC
");
$bookingQuery->bind_param("i", $user_id);
$bookingQuery->execute();
$bookings = $bookingQuery->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f9f9f9;
            padding: 20px;
        }

        .profile {
            background: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            max-width: 800px;
            margin: auto;
        }

        h2 {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .info p {
            margin: 8px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #eee;
        }

        .actions a {
            margin-right: 10px;
        }

        .future {
            background-color: #e6f7ff;
        }
    </style>
</head>
<body>

<?php if(isset($_GET["updated"])): ?>
    <p style="text-align: center;">Update successful.<p>
<?php endif; ?>

<div class="profile">
    <h2>User Profile</h2>
    <div class="info">
        <p><strong>User ID:</strong> <?= htmlspecialchars($user['user_id']) ?></p>
        <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
        <p><strong>Full Name:</strong> <?= htmlspecialchars($user['full_name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone']) ?></p>
        <p><strong>Role:</strong> <?= htmlspecialchars($user['role']) ?></p>
        <p><a href="user-profile.php?update=1">Update profile</a></p>
    </div>

    <!-- <h3>Booking History</h3>
    <table>
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Room</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        // <?php
        // foreach ($bookings as $booking) {
        //     $bookingTime = strtotime($booking['start_date'] . ' ' . $booking['start_time']);
        //     $isFuture = $bookingTime > time();

        //     echo "<tr" . ($isFuture ? " class='future'" : "") . ">";
        //     echo "<td>{$booking['booking_id']}</td>";
        //     echo "<td>{$booking['room']}</td>";
        //     echo "<td>{$booking['start_date']}</td>";
        //     echo "<td>{$booking['start_time']}</td>";
        //     echo "<td>" . ($isFuture ? "Upcoming" : "Completed") . "</td>";
        //     echo "<td class='actions'>";
        //     if ($isFuture) {
        //         echo "<a href='edit-booking.php?id={$booking['booking_id']}'>Edit</a>";
        //         echo "<a href='delete-booking.php?id={$booking['booking_id']}' onclick='return confirm(\"Are you sure?\");'>Delete</a>";
        //     } else {
        //         echo "-";
        //     }
        //     echo "</td></tr>";
        // }
        // ?>
        </tbody>
    </table> -->
</div>

<?php if(isset($_GET["update"])): ?>
    <div class="profile">
        <h2>Update</h2>
        <table style="border: none;">
            <form method="post" action="update_profile.php">
            <tr style="border: none;">
                <td style="border: none;">New Username:</td>
                <td style="border: none;"> <input type="text" name="newusername" value=<?php echo $user['username']; ?>></td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;">New Email:</td>
                <td style="border: none;"> <input type="text" name="newemail" value=<?php echo $user['email']; ?>></td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;">New Phone:</td>
                <td style="border: none;"> <input type="text" name="newphone" value=<?php echo $user['phone']; ?>></td>
            </tr>
            <tr>
                <td style="border: none;"><input type="submit" name="submit" value="Update"></td>
            </tr>
            <form>
        </table>
    </div>
<?php endif; ?>

</body>
</html>
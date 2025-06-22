<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get user data from database
$user_id = $_SESSION['user_id'];
$userQuery = $conn->prepare("SELECT * FROM user WHERE user_id = ?");
$userQuery->bind_param("i", $user_id);
$userQuery->execute();
$userResult = $userQuery->get_result();
$user = $userResult->fetch_assoc();

// Get booking history
$bookingQuery = $conn->prepare("
    SELECT b.booking_id, r.room_name AS room, b.date, b.start_time 
    FROM booking b 
    JOIN room r ON b.room_id = r.room_id 
    WHERE b.user_id = ? 
    ORDER BY b.date DESC, b.start_time DESC
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

<div class="profile">
    <h2>User Profile</h2>
    <div class="info">
        <p><strong>User ID:</strong> <?= htmlspecialchars($user['user_id']) ?></p>
        <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
        <p><strong>Full Name:</strong> <?= htmlspecialchars($user['full_name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone']) ?></p>
        <p><strong>Role:</strong> <?= htmlspecialchars($user['role']) ?></p>
    </div>

    <h3>Booking History</h3>
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
        <?php
        foreach ($bookings as $booking) {
            $bookingTime = strtotime($booking['date'] . ' ' . $booking['time']);
            $isFuture = $bookingTime > time();

            echo "<tr" . ($isFuture ? " class='future'" : "") . ">";
            echo "<td>{$booking['id']}</td>";
            echo "<td>{$booking['room']}</td>";
            echo "<td>{$booking['date']}</td>";
            echo "<td>{$booking['time']}</td>";
            echo "<td>" . ($isFuture ? "Upcoming" : "Completed") . "</td>";
            echo "<td class='actions'>";
            if ($isFuture) {
                echo "<a href='edit-booking.php?id={$booking['id']}'>Edit</a>";
                echo "<a href='delete-booking.php?id={$booking['id']}' onclick='return confirm(\"Are you sure?\");'>Delete</a>";
            } else {
                echo "-";
            }
            echo "</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

</body>
</html>
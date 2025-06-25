<?php
require_once('config.php');

$sql = "INSERT INTO user (username, password, full_name, email, role, phone)
VALUES('admin1', 'pass123', 'Alice Admin', 'alice@uni.edu', 'admin', '0111234567');";
$sql .= "INSERT INTO user (username, password, full_name, email, role, phone)
VALUES('admin2', 'pass456', 'Bob Admin', 'bob@uni.edu', 'admin', '0123456789');";
$sql .= "INSERT INTO user (username, password, full_name, email, role, phone)
VALUES('lect1', 'abc123', 'Dr. Lim', 'lim@uni.edu', 'lecturer', '0101111222');";
$sql .= "INSERT INTO user (username, password, full_name, email, role, phone)
VALUES('lect2', 'abc456', 'Ms. Wong', 'wong@uni.edu', 'lecturer', '0103333444');";
$sql .= "INSERT INTO user (username, password, full_name, email, role, phone)
VALUES('manager1', 'mgr123', 'Mr. Tan', 'tan@uni.edu', 'space_manager', '0198888999');";
if(mysqli_multi_query($conn, $sql)) {
    echo "User records inserted successfully.";
} else {
    echo "Error inserting user record: " . mysqli_error($conn);
}
while (mysqli_more_results($conn)) {
    mysqli_next_result($conn);
}

$sql = "INSERT INTO room (room_name, type, size)
VALUES('Lab A1', 'lab', 30);";
$sql .= "INSERT INTO room (room_name, type, size)
VALUES ('Lecture Hall B', 'lecture', 100);";
$sql .= "INSERT INTO room (room_name, type, size)
VALUES ('Computer Lab C', 'lab', 25);";
$sql .= "INSERT INTO room (room_name, type, size)
VALUES ('Seminar Room D', 'lecture', 50);";
$sql .= "INSERT INTO room (room_name, type, size)
VALUES ('Innovation Space E', 'lab', 20);";
if(mysqli_multi_query($conn, $sql)) {
    echo "Room records inserted successfully.";
} else {
    echo "Error inserting room record: " . mysqli_error($conn);
}
while (mysqli_more_results($conn)) {
    mysqli_next_result($conn);
}

$sql = "INSERT INTO booking (room_id, user_id, date, start_time, end_time, purpose, status)
VALUES(1, 3, '2025-06-20', '10:00:00', '12:00:00', 'Java Lab', 'pending');";
$sql .= "INSERT INTO booking (room_id, user_id, date, start_time, end_time, purpose, status)
VALUES(2, 4, '2025-06-21', '09:00:00', '11:00:00', 'Guest Lecture', 'approved');";
$sql .= "INSERT INTO booking (room_id, user_id, date, start_time, end_time, purpose, status)
VALUES(3, 3, '2025-06-22', '14:00:00', '16:00:00', 'Tutorial Session', 'rejected');";
$sql .= "INSERT INTO booking (room_id, user_id, date, start_time, end_time, purpose, status)
VALUES(4, 4, '2025-06-23', '08:00:00', '10:00:00', 'Seminar Practice', 'pending');";
$sql .= "INSERT INTO booking (room_id, user_id, date, start_time, end_time, purpose, status)
VALUES(5, 3, '2025-06-24', '11:00:00', '13:00:00', 'Project Discussion', 'approved');";
if(mysqli_multi_query($conn, $sql)) {
    echo "Booking records inserted successfully.";
} else {
    echo "Error inserting booking record: " . mysqli_error($conn);
}
while (mysqli_more_results($conn)) {
    mysqli_next_result($conn);
}

$sql ="INSERT INTO activity_log (user_id, action)
VALUES(1, 'login');";
$sql .= "INSERT INTO activity_log (user_id, action)
VALUES(3, 'submit booking');";
$sql .= "INSERT INTO activity_log (user_id, action)
VALUES(5, 'approve booking');";
$sql .= "INSERT INTO activity_log (user_id, action)
VALUES(2, 'edit user');";
$sql .= "INSERT INTO activity_log (user_id, action)
VALUES(4, 'view booking status');";
if(mysqli_multi_query($conn, $sql)) {
    echo "Activity log records inserted successfully.";
} else {
    echo "Error inserting activity log record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
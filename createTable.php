<?php
require_once('config.php');

$sql = "CREATE TABLE IF NOT EXISTS user (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(30) NOT NULL,
    full_name VARCHAR(100),
    email VARCHAR(50),
    role ENUM('admin','lecturer','space_manager') NOT NULL,
    phone VARCHAR(15),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)";
if(mysqli_query($conn, $sql)) {
    echo "Table user created successfully.";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

$sql = "CREATE TABLE IF NOT EXISTS room (
    room_id INT AUTO_INCREMENT PRIMARY KEY,
    room_name VARCHAR(60),
    type VARCHAR(30),
    size INT
)";
if(mysqli_query($conn, $sql)) {
    echo "Table room created successfully.";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

$sql = "CREATE TABLE IF NOT EXISTS room_condition (
    condition_id INT AUTO_INCREMENT PRIMARY KEY,
    room_id INT,
    description VARCHAR(100),
    reported_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (room_id) REFERENCES room(room_id) ON DELETE CASCADE
)";
if(mysqli_query($conn, $sql)) {
    echo "Table room_condition created successfully.";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

$sql = "CREATE TABLE IF NOT EXISTS room_equipment (
    equipment_id INT AUTO_INCREMENT PRIMARY KEY,
    room_id INT,
    equipment_name VARCHAR(50),
    quantity INT,
    equipment_condition BOOLEAN,
    FOREIGN KEY (room_id) REFERENCES room(room_id) ON DELETE CASCADE
)";
if(mysqli_query($conn, $sql)) {
    echo "Table room_equipment created successfully.";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

$sql = "CREATE TABLE IF NOT EXISTS booking (
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    room_id INT,
    user_id INT,
    date DATE,
    start_time TIME,
    end_time TIME,
    purpose VARCHAR(200),
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    FOREIGN KEY (room_id) REFERENCES room(room_id),
    FOREIGN KEY (user_id) REFERENCES user(user_id)
)";
if(mysqli_query($conn, $sql)) {
    echo "Table booking created successfully.";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

$sql = "CREATE TABLE IF NOT EXISTS activity_log (
    activity_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action VARCHAR(100),
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(user_id)
)";
if(mysqli_query($conn, $sql)) {
    echo "Table activity_log created successfully.";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

$sql = "CREATE TABLE feedback (
    feedback_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    satisfaction ENUM('very_satisfied', 'satisfied', 'neutral', 'dissatisfied', 'very_dissatisfied'),
    resolved BOOLEAN,
    professionalism ENUM('excellent', 'good', 'average', 'poor'),
    improvement TEXT,
    comments TEXT,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(user_id)
)";

if(mysqli_query($conn, $sql)) {
    echo "Table feedback created successfully.";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
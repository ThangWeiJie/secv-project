<?php
    require_once('config.php');
    require('auth.php');

    if(isset($_GET['LOGOUT'])) {

        $activityMessage = "User logged out";
        $fetchedUserID = $_SESSION["USERID"];
        $activityQuery = "INSERT INTO activity_log(user_id, action_description) VALUES (?, ?)";
        $stmt = $conn->prepare($activityQuery);
        $stmt->bind_param("is", $fetchedUserID, $activityMessage);
        $stmt->execute();

        session_destroy();
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
    * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Inter', sans-serif; }

    body { background-color: #f4f7fb; color: #333; }

    header {
      background: url(classroom.jpg) no-repeat center center/cover;
      height: 350px;
      color: white;
      text-align: center;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    header h1 {
      font-size: 3em;
      margin-bottom: 10px;
      text-shadow: 1px 1px 5px rgba(0,0,0,0.3);
    }

    header p {
      font-size: 1.2em;
    }

    nav {
      background-color: #1e3a8a;
      padding: 15px;
      text-align: center;
    }

    nav a {
      color: white;
      margin: 0 15px;
      text-decoration: none;
      font-weight: 500;
    }

    nav a:hover {
      text-decoration: underline;
    }

    .section {
      max-width: 1100px;
      margin: 50px auto;
      padding: 20px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    .section h2 {
      margin-bottom: 20px;
      color: #1e3a8a;
    }

    .card-container {
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
    }

    .card {
      flex: 1;
      min-width: 250px;
      background: #f1f5f9;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .card h3 {
      margin-bottom: 10px;
      color: #1e3a8a;
    }

    footer {
      text-align: center;
      padding: 20px;
      background-color: #1e3a8a;
      color: white;
      margin-top: 40px;
    }
    .section {
        max-width: 800px;
        margin: 50px auto;
        padding: 20px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        text-align: center;
    }

    .intro-text {
        font-size: 16px;
        margin-bottom: 20px;
        color: #334155;
        line-height: 1.6;
    }

    .numbered-rules {
        counter-reset: rule-counter;
        list-style: none;
        padding-left: 0;
        margin-left: 0;
        font-size: 16px;
        line-height: 1.8;
        color: #1e293b;
        text-align: left; /* keep list items left-aligned inside centered box */
        display: inline-block;
    }

    .numbered-rules > li {
        counter-increment: rule-counter;
        margin-bottom: 20px;
        position: relative;
        padding-left: 30px;
    }

    .numbered-rules > li::before {
        content: counter(rule-counter) ".";
        position: absolute;
        left: 0;
        font-weight: bold;
        color: #1e3a8a;
    }

    .sub-rules {
        list-style-type: disc;
        margin-top: 10px;
        margin-left: 20px;
        color: #475569;
        font-size: 15px;
    }

    .nav-links {
    display: flex;
    justify-content: center;
    gap: 80px;
    margin-bottom: 10px;
  }
  .nav-links a {
    margin: 0;
  }
  .admin-label,
.space-manager-label {
  color:rgb(255, 255, 255); 
  font-size: 1.5em;
  margin-bottom: 24px; 
  text-align: center;
}

  </style>
</head>
<body>
    <header>
    <h1>Welcome to Space Booking</h1>
    <p>Manage room and lab bookings for your institution</p>
    </header>
    
    <nav>
    <?php if($_SESSION["ROLE"] == "admin"): ?>
        <h1 class="admin-label">You are an admin</h1>
        <div class="nav-links">
        <a href="user-profile.php">Profile</a> 
        <a href="admin/manage_users.php">Manage users</a> 
        <a href="admin/activity_log.php">View activity log</a> 
        <a href="Homepage.php?LOGOUT=1">Logout</a>
        </div>
    <?php endif; ?>
    <?php if($_SESSION["ROLE"] == "lecturer"): ?>
      <div class="nav-links">
        <a href="user-profile.php">Profile</a> 
        <a href="lecturer/my_bookings.php">Own bookings</a> 
        <a href="lecturer/feedback.html">Feedback Form</a> 
        <a href="lecturer/booking.php">Booking Application</a> 
        <a href="availableRoom.php">Browse Available Rooms</a>
        <a href="Homepage.php?LOGOUT=1">Logout</a>  
        </div>
    <?php endif; ?>
    <?php if($_SESSION["ROLE"] == "space_manager"): ?>
        <h1 class="space-manager-label">You are a space manager</h1>
        <div class="nav-links">
        <a href="user-profile.php">Profile</a> 
        <a href="manager/approvals.php">Approvals</a> 
        <a href="manager/manage_room.php">Room management</a>
        <a href="manager/booking_report.php">Booking report</a>
        <a href="manager/view_feedback.php">View feedback</a>
        <a href="Homepage.php?LOGOUT=1">Logout</a>
        </div>
    <?php endif; ?>
    </nav>

    <div class="section">
  <h2>General Booking Rules</h2>
  <ol class="numbered-rules">
    <li>Campus users can only access the online room booking service while on campus.</li>
    <li>The booking of rooms is based on a <strong>First-Come-First-Served</strong> basis.</li>
    <li>All room reservations require approval from the room administrator.</li>
    <li>Room use is limited according to the <strong>allowed capacity</strong> stated in the room descriptions.</li>
    <li>
      The following are <strong>prohibited</strong> inside discussion rooms:
      <ul class="sub-rules">
        <li>Removal of chairs or other furniture.</li>
        <li>Altering or tampering with equipment settings, which may disrupt scheduled activities.</li>
        <li>Vandalizing room furniture, multimedia equipment, or facilities.</li>
        <li>Gambling, karaoke, or movie-watching activities.</li>
        <li>Leaving personal belongings unattended.</li>
        <li>Food and drinks are not allowed, <strong>except plain drinking water</strong>.</li>
      </ul>
    </li>
    <li>Users are reminded to <strong>cancel or release the room</strong> if there is a change in schedule.</li>
  </ol>
</div>


  <div class="section">
    <h2>Features</h2>
    <div class="card-container">
      <div class="card">
        <h3>Quick Booking</h3>
        <p>Easily reserve rooms and labs with our fast booking form.</p>
      </div>
      <div class="card">
        <h3>Approval System</h3>
        <p>Bookings are reviewed and approved by the space manager.</p>
      </div>
      <div class="card">
        <h3>Personal Dashboard</h3>
        <p>View your upcoming bookings and history in one place.</p>
      </div>
    </div>
  </div>

<div class="section">
    <h2>Need Help?</h2>
    <p>If you face any issues with booking or login, please contact the admin or visit your profile to update your information.</p>
  </div>

  <footer>
    &copy; 2025 Space Booking Management System. All Rights Reserved.
  </footer>
</body>
</html>
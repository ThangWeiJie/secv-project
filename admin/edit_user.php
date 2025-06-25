<?php
require_once('../auth.php');
require_once('../config.php');
$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $conn->prepare("UPDATE usertable SET full_name=?, email=?, role=?, phone=? WHERE user_id=?");
    $stmt->bind_param("ssssi", $_POST['full_name'], $_POST['email'], $_POST['role'], $_POST['phone'], $id);
    $stmt->execute();

    $activityMessage = "User updated";
    $fetchedUserID = $_SESSION["USERID"];
    $activityQuery = "INSERT INTO activity_log(user_id, action_description) VALUES (?, ?)";
    $stmt = $conn->prepare($activityQuery);
    $stmt->bind_param("is", $fetchedUserID, $activityMessage);
    $stmt->execute();

    header("Location: manage_users.php");
    exit();
}

$result = $conn->query("SELECT * FROM usertable WHERE user_id=$id");
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8fafc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: white;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h1 {
            text-align: center;
            color: #1e40af;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: #1e293b;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
        }

        button {
            margin-top: 20px;
            width: 100%;
            padding: 10px;
            background-color: #1e40af;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        button:hover {
            background-color: #2563eb;
        }

        .back-link {
            display: block;
            margin-top: 15px;
            text-align: center;
            color: #1e40af;
            text-decoration: none;
            font-weight: bold;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h1>Edit User</h1>
    <form method="POST">
        <label>Full Name:</label>
        <input name="full_name" value="<?= htmlspecialchars($user['full_name']) ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <label>Role:</label>
        <select name="role" required>
            <option <?= $user['role'] == 'admin' ? 'selected' : '' ?>>admin</option>
            <option <?= $user['role'] == 'lecturer' ? 'selected' : '' ?>>lecturer</option>
            <option <?= $user['role'] == 'space_manager' ? 'selected' : '' ?>>space_manager</option>
        </select>

        <label>Phone:</label>
        <input name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>

        <button type="submit">Update</button>
    </form>
    <a href="manage_users.php" class="back-link">&#8592; Back to User Management</a>
</div>

</body>
</html>

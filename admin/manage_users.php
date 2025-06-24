<?php
require_once('../config.php');
require_once('../auth.php');
if (!isset($_SESSION['ROLE']) || $_SESSION['ROLE'] !== 'admin') {
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    header("Location: ../login.php");
    exit();
}

// Search logic
if (isset($_GET['search']) && $_GET['search'] !== '') {
    $search = $conn->real_escape_string($_GET['search']);
    $result = $conn->query("SELECT * FROM usertable WHERE username LIKE '%$search%'");
} else {
    $result = $conn->query("SELECT * FROM usertable");
}
$message = "Are you sure you want to delete this user?";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <style>
        body {
            background-color: #add8e6;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .manage-users-container {
            background: #fff;
            padding: 24px;
            border: 1px solid #ccc;
            max-width: 900px;
            margin: 40px auto 0 auto;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        }
        h2 {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            color: #1e3a8a;
            text-align: center;
        }
        .search-form {
            text-align: center;
            margin-bottom: 20px;
        }
        .search-form input[type="text"] {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
            width: 200px;
        }
        .search-form button {
            padding: 8px 16px;
            border-radius: 4px;
            border: none;
            background: #1e3a8a;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            margin-left: 5px;
            transition: background 0.2s;
        }
        .search-form button:hover {
            background: #2563eb;
        }
        .search-form a {
            margin-left: 10px;
            color: #2563eb;
            text-decoration: none;
            font-weight: bold;
        }
        .search-form a:hover {
            text-decoration: underline;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            background: #f8fafc;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 12px 10px;
            text-align: left;
        }
        th {
            background: #1e3a8a;
            color: #fff;
        }
        tr:nth-child(even) {
            background: #f0f6ff;
        }
        .actions a {
            margin-right: 10px;
            color: #2563eb;
            text-decoration: none;
            font-weight: bold;
        }
        .actions a:hover {
            text-decoration: underline;
        }
        .add-user-btn {
            display: inline-block;
            margin: 20px 0 0 0;
            background: #1e3a8a;
            color: #fff;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 1em;
            transition: background 0.2s;
        }
        .add-user-btn:hover {
            background: #2563eb;
        }
        .return-home-btn {
            position: fixed;
            right: 30px;
            bottom: 30px;
            background: #1e3a8a;
            color: #fff;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 1em;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: background 0.2s;
            text-align: center;
            z-index: 100;
        }
        .return-home-btn:hover {
            background: #2563eb;
        }
        .center {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="manage-users-container">
    <h2>User Management</h2>
    <form method="get" class="search-form">
        <input type="text" name="search" placeholder="Search username..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
        <button type="submit">Search</button>
        <?php if(isset($_GET['search']) && $_GET['search'] !== ''): ?>
            <a href="manage_users.php">Clear</a>
        <?php endif; ?>
    </form>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['user_id']) ?></td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= htmlspecialchars($row['role']) ?></td>
            <td class="actions">
                <a href='edit_user.php?id=<?= $row['user_id'] ?>'>Edit</a> | 
                <a href='delete_user.php?id=<?= $row['user_id'] ?>' onclick='return confirm("<?= $message ?>");'>Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <div class="center">
        <a href='add_user.php' class='add-user-btn'>Add New User</a>
    </div>
</div>
<a href="../Homepage.php" class="return-home-btn">&#8592; Return Home</a>
</body>
</html>
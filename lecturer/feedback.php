<?php
require_once('config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "<p>You must be logged in to submit feedback.</p>";
    exit();
}

if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id'];
    $satisfaction = $_POST['satisfaction'] ?? '';
    $resolved = isset($_POST['resolved']) ? 1 : 0;
    $professionalism = $_POST['professionalism'] ?? '';
    $improvement = trim($_POST['improvement'] ?? '');
    $comments = trim($_POST['comments'] ?? '');

    $errors = [];

    if (empty($satisfaction)) $errors[] = "Please select satisfaction level.";
    if (empty($professionalism)) $errors[] = "Please rate professionalism.";

    echo "<h2>";
    echo empty($errors) ? "✅ Thanks for your feedback!" : "❌ Please correct the following errors:";
    echo "</h2>";

    if (!empty($errors)) {
        echo "<ul style='color:red;'>";
        foreach ($errors as $error) {
            echo "<li>" . htmlspecialchars($error) . "</li>";
        }
        echo "</ul>";
        echo '<a href="javascript:history.back()">[Back]</a>';
    } else {
        $stmt = $conn->prepare("INSERT INTO feedback (user_id, satisfaction, resolved, professionalism, improvement, comments) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isisss", $user_id, $satisfaction, $resolved, $professionalism, $improvement, $comments);

        if ($stmt->execute()) {
            echo "<h3>🎉 Feedback submitted successfully!</h3>";
            echo "<a href='homepage.php'>← Back to Home</a>";
        } else {
            echo "<h3 style='color:red;'>Database error: " . $stmt->error . "</h3>";
        }
        $stmt->close();
    }
} else {
    echo "<p>No form submitted.</p>";
}


echo "<h3>📋 All Feedback Submissions</h3>";
$sql = "SELECT f.*, u.username FROM feedback f 
        JOIN user u ON f.user_id = u.user_id 
        ORDER BY f.submitted_at DESC";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    echo "<table border='1' cellpadding='6'>
            <tr>
                <th>Username</th>
                <th>Satisfaction</th>
                <th>Resolved?</th>
                <th>Professionalism</th>
                <th>Improvement</th>
                <th>Comments</th>
                <th>Submitted At</th>
            </tr>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>" . htmlspecialchars($row['username']) . "</td>
                <td>" . htmlspecialchars($row['satisfaction']) . "</td>
                <td>" . ($row['resolved'] ? 'Yes' : 'No') . "</td>
                <td>" . htmlspecialchars($row['professionalism']) . "</td>
                <td>" . nl2br(htmlspecialchars($row['improvement'])) . "</td>
                <td>" . nl2br(htmlspecialchars($row['comments'])) . "</td>
                <td>" . $row['submitted_at'] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No feedback submitted yet.</p>";
}

$conn->close();
?>

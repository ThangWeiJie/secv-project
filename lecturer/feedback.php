<?php
require_once('../config.php');
session_start();

if (!isset($_SESSION['USERID'])) {
    echo "<p>You must be logged in to submit feedback.</p>";
    exit();
}

if (isset($_POST['submit'])) {
    $user_id = $_SESSION['USERID'];
    $satisfaction = $_POST['satisfaction'] ?? '';
    $resolved = isset($_POST['resolved']) ?? '';
    $professionalism = $_POST['professionalism'] ?? '';
    $improvement = trim($_POST['improvement'] ?? '');
    $comments = trim($_POST['comments'] ?? '');

    $errors = [];

    if (empty($satisfaction)) $errors[] = "Please select satisfaction level.";
    if (empty($professionalism)) $errors[] = "Please rate professionalism.";

    if (!empty($errors)) {
        echo "<h2 style='color:red;'>❌ Please correct the following errors:</h2>";
        echo "<ul style='color:red;'>";
        foreach ($errors as $error) {
            echo "<li>" . htmlspecialchars($error) . "</li>";
        }
        echo "</ul>";
        echo '<a href="javascript:history.back()">[Back]</a>';
    } else {
        $stmt = $conn->prepare("INSERT INTO feedback (user_id, satisfaction, resolved, professionalism, improvement, comments) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $user_id, $satisfaction, $resolved, $professionalism, $improvement, $comments);

        if ($stmt->execute()) {
            echo "<h3>🎉 Thanks for your feedback!</h3>";
            echo "<p><strong>Satisfaction:</strong> " . htmlspecialchars($satisfaction) . "</p>";
            echo "<p><strong>Resolved:</strong> " . htmlspecialchars($resolved_input) . "</p>";
            echo "<p><strong>Professionalism:</strong> " . htmlspecialchars($professionalism) . "</p>";
            echo "<a href='../Homepage.php'>← Back to Home</a>";
        } else {
            echo "<h3 style='color:red;'>Database error: " . $stmt->error . "</h3>";
        }
        $stmt->close();
    }
} else {
    echo "<p>No form submitted.</p>";
}

$conn->close();
?>

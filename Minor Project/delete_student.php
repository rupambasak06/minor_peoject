<?php
// delete_student.php - Delete a student (and all their marks via cascade)
require_once 'config.php';
if (!isset($_SESSION['logged_in'])) {
    header("Location: dashboard.php");
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header("Location: dashboard.php");
    exit;
}

// Confirm deletion (via GET parameter 'confirm')
if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
    $delete = $pdo->prepare("DELETE FROM students WHERE id = ?");
    if ($delete->execute([$id])) {
        // Redirect with success message (optional)
        header("Location: dashboard.php?msg=deleted");
    } else {
        header("Location: dashboard.php?msg=error");
    }
    exit;
}

// If confirm not set, show a confirmation page (optional)
// But we already have a JavaScript confirm in the dashboard, so we can just redirect with confirm=yes
// For safety, we redirect to dashboard if not confirmed
header("Location: dashboard.php");
exit;
?>
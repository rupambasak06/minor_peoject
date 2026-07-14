<?php
// get_data.php - Chart Data API
header('Content-Type: application/json');
require_once 'config.php';

$action = $_GET['action'] ?? '';

try {
    if ($action == 'subject_avg') {
        $stmt = $pdo->query("
            SELECT s.subject_name, COALESCE(AVG(m.marks_obtained), 0) as avg_marks 
            FROM subjects s
            LEFT JOIN marks m ON m.subject_id = s.id
            GROUP BY s.id
        ");
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($data);
        exit;
    }

    if ($action == 'stats') {
        $totalStudents = $pdo->query("SELECT COUNT(*) FROM students")->fetchColumn();
        $totalSubjects = $pdo->query("SELECT COUNT(*) FROM subjects")->fetchColumn();
        $avgMarks = $pdo->query("SELECT COALESCE(AVG(marks_obtained), 0) FROM marks")->fetchColumn();
        
        $pass = $pdo->query("SELECT COUNT(*) FROM marks WHERE marks_obtained >= 40")->fetchColumn();
        $fail = $pdo->query("SELECT COUNT(*) FROM marks WHERE marks_obtained < 40")->fetchColumn();
        
        echo json_encode([
            'total_students' => (int)$totalStudents,
            'total_subjects' => (int)$totalSubjects,
            'avg_marks' => round((float)$avgMarks, 2),
            'pass' => (int)$pass,
            'fail' => (int)$fail
        ]);
        exit;
    }

    echo json_encode(['error' => 'Invalid action']);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
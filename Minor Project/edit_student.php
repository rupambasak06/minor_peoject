<?php
// edit_student.php - Edit Student Info and Marks
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

$message = '';
$error = '';

// Fetch student details
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch();
if (!$student) {
    header("Location: dashboard.php");
    exit;
}

// Fetch existing marks for this student
$marks_stmt = $pdo->prepare("
    SELECT m.id, m.marks_obtained, s.id as subject_id, s.subject_name
    FROM marks m
    JOIN subjects s ON m.subject_id = s.id
    WHERE m.student_id = ?
");
$marks_stmt->execute([$id]);
$existing_marks = $marks_stmt->fetchAll();

// Fetch all subjects for dropdown (if adding new marks)
$subjects = $pdo->query("SELECT * FROM subjects ORDER BY subject_name")->fetchAll();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update student info
    if (isset($_POST['update_student'])) {
        $name = trim($_POST['name']);
        $class = trim($_POST['class']);
        $semester = trim($_POST['semester']);
        if (!empty($name) && !empty($class)) {
            $update = $pdo->prepare("UPDATE students SET name=?, class=?, semester=? WHERE id=?");
            if ($update->execute([$name, $class, $semester, $id])) {
                $message = "✅ Student info updated successfully!";
                // Refresh student data
                $stmt->execute([$id]);
                $student = $stmt->fetch();
            } else {
                $error = "❌ Failed to update student.";
            }
        } else {
            $error = "Name and Class are required.";
        }
    }

    // Update individual marks
    if (isset($_POST['update_marks'])) {
        foreach ($_POST['marks'] as $mark_id => $new_marks) {
            if (is_numeric($new_marks) && $new_marks >= 0 && $new_marks <= 100) {
                $update_mark = $pdo->prepare("UPDATE marks SET marks_obtained = ? WHERE id = ?");
                $update_mark->execute([$new_marks, $mark_id]);
            }
        }
        $message = "✅ Marks updated successfully!";
        // Refresh marks list
        $marks_stmt->execute([$id]);
        $existing_marks = $marks_stmt->fetchAll();
    }

    // Delete a specific mark
    if (isset($_POST['delete_mark'])) {
        $mark_id = (int)$_POST['delete_mark'];
        $delete = $pdo->prepare("DELETE FROM marks WHERE id = ? AND student_id = ?");
        if ($delete->execute([$mark_id, $id])) {
            $message = "✅ Mark deleted successfully!";
            $marks_stmt->execute([$id]);
            $existing_marks = $marks_stmt->fetchAll();
        }
    }

    // Add new mark
    if (isset($_POST['add_mark'])) {
        $subject_id = $_POST['subject_id'];
        $marks_obtained = $_POST['marks_obtained'];
        if ($subject_id && is_numeric($marks_obtained) && $marks_obtained >= 0 && $marks_obtained <= 100) {
            // Check if mark already exists for this subject and student
            $check = $pdo->prepare("SELECT id FROM marks WHERE student_id = ? AND subject_id = ?");
            $check->execute([$id, $subject_id]);
            if ($check->rowCount() > 0) {
                $error = "⚠️ This student already has marks for this subject. You can edit it below.";
            } else {
                $insert = $pdo->prepare("INSERT INTO marks (student_id, subject_id, marks_obtained) VALUES (?, ?, ?)");
                if ($insert->execute([$id, $subject_id, $marks_obtained])) {
                    $message = "✅ New mark added successfully!";
                    $marks_stmt->execute([$id]);
                    $existing_marks = $marks_stmt->fetchAll();
                }
            }
        } else {
            $error = "Please select a subject and enter valid marks (0-100).";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student - RM Model School</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,600;14..32,700&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Inter', sans-serif; background: #f0f4f8; }
        .form-card { transition: all 0.3s ease; }
        .form-card:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .marks-table tr:hover { background-color: #f8fafc; }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="bg-[#1a3b5d] text-white shadow-lg sticky top-0 z-40">
        <div class="container mx-auto px-4 py-3 flex flex-wrap items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fas fa-school text-yellow-400 text-2xl"></i>
                <span class="text-xl font-bold">RM <span class="text-yellow-400">Model</span> <span class="hidden sm:inline text-sm font-normal">| Edit Student</span></span>
            </div>
            <div class="flex items-center gap-3">
                <a href="dashboard.php" class="text-white hover:text-yellow-400 transition text-sm flex items-center gap-1">
                    <i class="fas fa-arrow-left"></i> <span class="hidden xs:inline">Back to Dashboard</span>
                </a>
                <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-full text-xs font-semibold transition shadow flex items-center gap-1">
                    <i class="fas fa-sign-out-alt"></i> <span class="hidden xs:inline">Logout</span>
                </a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-6 max-w-4xl">

        <!-- Alerts -->
        <?php if ($message): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 flex items-start justify-between">
                <span><i class="fas fa-check-circle mr-2"></i> <?= htmlspecialchars($message) ?></span>
                <button type="button" class="text-green-700 hover:text-green-900" onclick="this.parentElement.remove()">&times;</button>
            </div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 flex items-start justify-between">
                <span><i class="fas fa-exclamation-circle mr-2"></i> <?= htmlspecialchars($error) ?></span>
                <button type="button" class="text-red-700 hover:text-red-900" onclick="this.parentElement.remove()">&times;</button>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Edit Student Info -->
            <div class="form-card bg-white p-6 rounded-2xl shadow-md">
                <h2 class="text-xl font-bold text-[#1a3b5d] mb-4 flex items-center gap-2">
                    <i class="fas fa-user-edit text-yellow-500"></i> Edit Student Info
                </h2>
                <form method="POST">
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                            <input type="text" name="name" value="<?= htmlspecialchars($student['name']) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a3b5d] focus:border-transparent" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Class *</label>
                            <input type="text" name="class" value="<?= htmlspecialchars($student['class']) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a3b5d] focus:border-transparent" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                            <input type="text" name="semester" value="<?= htmlspecialchars($student['semester']) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a3b5d] focus:border-transparent">
                        </div>
                        <button type="submit" name="update_student" class="w-full bg-[#1a3b5d] hover:bg-[#2a5f7a] text-white font-bold py-2.5 rounded-lg transition shadow flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i> Update Student
                        </button>
                    </div>
                </form>
            </div>

            <!-- Manage Marks -->
            <div class="form-card bg-white p-6 rounded-2xl shadow-md">
                <h2 class="text-xl font-bold text-[#1a3b5d] mb-4 flex items-center gap-2">
                    <i class="fas fa-pen-fancy text-yellow-500"></i> Manage Marks
                </h2>

                <!-- List existing marks -->
                <?php if (count($existing_marks) > 0): ?>
                    <form method="POST" class="mb-4">
                        <table class="w-full text-sm marks-table">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="px-3 py-2 text-left">Subject</th>
                                    <th class="px-3 py-2 text-left">Marks</th>
                                    <th class="px-3 py-2 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($existing_marks as $mark): ?>
                                    <tr class="border-b border-gray-100">
                                        <td class="px-3 py-2 font-medium"><?= htmlspecialchars($mark['subject_name']) ?></td>
                                        <td class="px-3 py-2">
                                            <input type="number" name="marks[<?= $mark['id'] ?>]" value="<?= $mark['marks_obtained'] ?>" min="0" max="100" class="w-20 px-2 py-1 border border-gray-300 rounded-md focus:ring-1 focus:ring-[#1a3b5d]">
                                        </td>
                                        <td class="px-3 py-2 text-center">
                                            <button type="submit" name="update_marks" class="text-blue-500 hover:text-blue-700 mr-2" title="Update this mark">
                                                <i class="fas fa-check-circle"></i>
                                            </button>
                                            <button type="submit" name="delete_mark" value="<?= $mark['id'] ?>" class="text-red-500 hover:text-red-700" title="Delete this mark" onclick="return confirm('Delete this mark?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <p class="text-xs text-gray-400 mt-2"><i class="fas fa-info-circle"></i> Change marks and click the <i class="fas fa-check-circle text-blue-500"></i> icon to update each row.</p>
                    </form>
                <?php else: ?>
                    <p class="text-gray-400 text-sm mb-4">No marks added for this student yet.</p>
                <?php endif; ?>

                <!-- Add new mark -->
                <hr class="my-4">
                <h4 class="font-semibold text-gray-700 mb-2">Add New Mark</h4>
                <form method="POST" class="flex flex-wrap items-end gap-3">
                    <div class="flex-1 min-w-[150px]">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Subject</label>
                        <select name="subject_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a3b5d]" required>
                            <option value="">Select</option>
                            <?php foreach ($subjects as $sub): ?>
                                <option value="<?= $sub['id'] ?>"><?= htmlspecialchars($sub['subject_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="flex-1 min-w-[100px]">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Marks</label>
                        <input type="number" name="marks_obtained" placeholder="0-100" min="0" max="100" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a3b5d]" required>
                    </div>
                    <button type="submit" name="add_mark" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-semibold transition flex items-center gap-1">
                        <i class="fas fa-plus-circle"></i> Add
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-[#0d1f30] text-gray-400 py-4 mt-8">
        <div class="container mx-auto px-4 text-center text-sm">
            &copy; <?= date('Y') ?> RM Model School — Edit Student
        </div>
    </footer>
</body>
</html>
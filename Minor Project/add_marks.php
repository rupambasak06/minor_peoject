<?php
// add_marks.php - Data Entry (Tailwind CSS)
require_once 'config.php';
if (!isset($_SESSION['logged_in'])) {
    header("Location: dashboard.php");
    exit;
}

$message = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_student'])) {
        $name = trim($_POST['name']);
        $class = trim($_POST['class']);
        $semester = trim($_POST['semester']);
        if (empty($name) || empty($class)) {
            $error = "Name and Class are required.";
        } else {
            try {
                $pdo->prepare("INSERT INTO students (name, class, semester) VALUES (?,?,?)")->execute([$name, $class, $semester]);
                $message = "✅ Student added successfully!";
            } catch (PDOException $e) {
                $error = "❌ Error: " . $e->getMessage();
            }
        }
    }
    if (isset($_POST['add_marks'])) {
        $student_id = $_POST['student_id'];
        $subject_id = $_POST['subject_id'];
        $marks = $_POST['marks_obtained'];
        if (empty($student_id) || empty($subject_id) || $marks === '') {
            $error = "All fields are required for marks.";
        } else {
            try {
                $pdo->prepare("INSERT INTO marks (student_id, subject_id, marks_obtained) VALUES (?,?,?)")->execute([$student_id, $subject_id, $marks]);
                $message = "✅ Marks added successfully!";
            } catch (PDOException $e) {
                $error = "❌ Error: " . $e->getMessage();
            }
        }
    }
}

// Fetch students and subjects for dropdowns
$students = $pdo->query("SELECT id, name FROM students ORDER BY name")->fetchAll();
$subjects = $pdo->query("SELECT id, subject_name FROM subjects ORDER BY subject_name")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Data - RM Model School</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,600;14..32,700&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; }
        .form-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .form-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
        }
        input:focus, select:focus {
            outline: none;
            ring: 2px solid #1a3b5d;
            border-color: transparent;
        }
        .alert-dismissible {
            padding-right: 3rem;
        }
        .alert-dismissible .close-btn {
            position: absolute;
            top: 0.75rem;
            right: 1rem;
            background: transparent;
            border: 0;
            font-size: 1.25rem;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <!-- ============================================================ -->
    <!-- TOP NAVBAR (consistent with dashboard) -->
    <!-- ============================================================ -->
    <nav class="bg-[#1a3b5d] text-white shadow-lg sticky top-0 z-40">
        <div class="container mx-auto px-4 py-3 flex flex-wrap items-center justify-between">
            <a href="dashboard.php" class="text-xl font-bold flex items-center gap-2">
                <i class="fas fa-school"></i> RM <span class="text-yellow-400">Model</span> <span class="text-sm font-normal hidden sm:inline">| Admin</span>
            </a>
            <div class="flex items-center gap-3">
                <a href="dashboard.php" class="text-sm hover:text-yellow-400 transition">
                    <i class="fas fa-chart-pie mr-1"></i> Dashboard
                </a>
                <a href="index.php" class="text-sm hover:text-yellow-400 transition">
                    <i class="fas fa-home mr-1"></i> Site
                </a>
                <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-1.5 rounded-full text-sm font-semibold transition shadow">
                    <i class="fas fa-sign-out-alt mr-1"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- ============================================================ -->
    <!-- MAIN CONTENT -->
    <!-- ============================================================ -->
    <div class="container mx-auto px-4 py-8 max-w-6xl">

        <!-- Page Header -->
        <div class="flex flex-wrap items-center justify-between mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-[#1a3b5d] flex items-center gap-2">
                <i class="fas fa-plus-circle text-yellow-500"></i> Add Data
            </h1>
            <a href="dashboard.php" class="text-[#1a3b5d] font-semibold hover:underline text-sm">
                <i class="fas fa-arrow-left mr-1"></i> Back to Dashboard
            </a>
        </div>

        <!-- Alerts (Success / Error) -->
        <?php if ($message): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 flex items-start justify-between alert-dismissible relative">
                <span><i class="fas fa-check-circle mr-2"></i> <?= htmlspecialchars($message) ?></span>
                <button type="button" class="close-btn text-green-700 hover:text-green-900" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 flex items-start justify-between alert-dismissible relative">
                <span><i class="fas fa-exclamation-circle mr-2"></i> <?= htmlspecialchars($error) ?></span>
                <button type="button" class="close-btn text-red-700 hover:text-red-900" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        <?php endif; ?>

        <!-- Two-column layout on desktop, stacked on mobile -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- ========== ADD STUDENT CARD ========== -->
            <div class="form-card bg-white p-6 md:p-8 rounded-2xl shadow-lg">
                <h2 class="text-xl font-bold text-[#1a3b5d] mb-4 flex items-center gap-2">
                    <i class="fas fa-user-plus text-yellow-500"></i> Add Student
                </h2>
                <form method="POST" class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Student Name *</label>
                        <input type="text" id="name" name="name" placeholder="Full name" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a3b5d] focus:border-transparent transition" required>
                    </div>
                    <div>
                        <label for="class" class="block text-sm font-medium text-gray-700 mb-1">Class *</label>
                        <input type="text" id="class" name="class" placeholder="e.g., 10, 12" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a3b5d] focus:border-transparent transition" required>
                    </div>
                    <div>
                        <label for="semester" class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                        <input type="text" id="semester" name="semester" placeholder="e.g., 1st, 2nd" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a3b5d] focus:border-transparent transition">
                    </div>
                    <button type="submit" name="add_student" class="w-full bg-[#1a3b5d] hover:bg-[#2a5f7a] text-white font-bold py-3 px-4 rounded-lg transition shadow-md flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i> Add Student
                    </button>
                </form>
            </div>

            <!-- ========== ADD MARKS CARD ========== -->
            <div class="form-card bg-white p-6 md:p-8 rounded-2xl shadow-lg">
                <h2 class="text-xl font-bold text-[#1a3b5d] mb-4 flex items-center gap-2">
                    <i class="fas fa-pen-fancy text-yellow-500"></i> Add Marks
                </h2>
                <form method="POST" class="space-y-4">
                    <div>
                        <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1">Select Student *</label>
                        <select id="student_id" name="student_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a3b5d] focus:border-transparent transition" required>
                            <option value="">— Choose a student —</option>
                            <?php foreach ($students as $s): ?>
                                <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (empty($students)): ?>
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-triangle"></i> No students found. Please add a student first.</p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label for="subject_id" class="block text-sm font-medium text-gray-700 mb-1">Select Subject *</label>
                        <select id="subject_id" name="subject_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a3b5d] focus:border-transparent transition" required>
                            <option value="">— Choose a subject —</option>
                            <?php foreach ($subjects as $sub): ?>
                                <option value="<?= $sub['id'] ?>"><?= htmlspecialchars($sub['subject_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (empty($subjects)): ?>
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-triangle"></i> No subjects found. Please add subjects to the database.</p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label for="marks_obtained" class="block text-sm font-medium text-gray-700 mb-1">Marks Obtained (out of 100) *</label>
                        <input type="number" id="marks_obtained" name="marks_obtained" placeholder="e.g., 85" min="0" max="100" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a3b5d] focus:border-transparent transition" required>
                    </div>
                    <button type="submit" name="add_marks" class="w-full bg-[#1a3b5d] hover:bg-[#2a5f7a] text-white font-bold py-3 px-4 rounded-lg transition shadow-md flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i> Submit Marks
                    </button>
                </form>
            </div>
        </div>

        <!-- Additional info / quick links -->
        <div class="mt-8 text-center text-sm text-gray-500">
            <p><i class="fas fa-info-circle mr-1"></i> After adding, you can view the updated statistics on the <a href="dashboard.php" class="text-[#1a3b5d] font-semibold hover:underline">Dashboard</a>.</p>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- FOOTER (optional, but matches other pages) -->
    <!-- ============================================================ -->
    <footer class="bg-[#0d1f30] text-gray-400 py-4 mt-8">
        <div class="container mx-auto px-4 text-center text-sm">
            &copy; 2026 RM Model School — Admin Panel
        </div>
    </footer>

</body>
</html>
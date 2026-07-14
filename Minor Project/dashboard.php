<?php
// dashboard.php - Admin Dashboard
require_once 'config.php';

// Login check
if (!isset($_SESSION['logged_in'])) {
    if (isset($_POST['login'])) {
        if ($_POST['username'] == ADMIN_USER && $_POST['password'] == ADMIN_PASS) {
            $_SESSION['logged_in'] = true;
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Invalid credentials!";
        }
    }
    // Show login form (mobile-friendly)
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
        <title>Admin Login - RM Model School</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
        <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,600;14..32,700&display=swap" rel="stylesheet" />
        <style>
            body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #1a3b5d 0%, #2a5f7a 100%); }
            .login-card { max-width: 420px; width: 100%; margin: 1rem; padding: 1.5rem; }
            @media (max-width: 480px) { .login-card { margin: 0.5rem; padding: 1rem; } }
        </style>
    </head>
    <body class="flex items-center justify-center min-h-screen p-2 md:p-4">
        <div class="bg-white/95 backdrop-blur-sm p-6 md:p-8 rounded-2xl shadow-2xl w-full max-w-md transform transition-all hover:scale-[1.02] login-card">
            <div class="text-center mb-6">
                <div class="bg-[#1a3b5d] w-14 h-14 md:w-16 md:h-16 rounded-full flex items-center justify-center mx-auto shadow-lg">
                    <i class="fas fa-lock text-white text-xl md:text-2xl"></i>
                </div>
                <h2 class="text-xl md:text-2xl font-bold text-[#1a3b5d] mt-3">Admin Access</h2>
                <p class="text-gray-500 text-xs md:text-sm">Please enter your credentials</p>
            </div>
            <?php if(isset($error)): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-2 md:p-3 rounded mb-3 text-xs md:text-sm flex items-center gap-2">
                    <i class="fas fa-exclamation-circle"></i> <?= $error ?>
                </div>
            <?php endif; ?>
            <form method="POST" class="space-y-3 md:space-y-4">
                <div>
                    <label for="username" class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Username</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i class="fas fa-user"></i></span>
                        <input type="text" id="username" name="username" placeholder="Enter username" class="w-full pl-10 pr-3 py-2 md:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a3b5d] focus:border-transparent text-sm md:text-base" required>
                    </div>
                </div>
                <div>
                    <label for="password" class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i class="fas fa-key"></i></span>
                        <input type="password" id="password" name="password" placeholder="Enter password" class="w-full pl-10 pr-3 py-2 md:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a3b5d] focus:border-transparent text-sm md:text-base" required>
                    </div>
                </div>
                <button type="submit" name="login" class="w-full bg-[#1a3b5d] hover:bg-[#2a5f7a] text-white font-bold py-2 md:py-3 rounded-lg transition shadow-md flex items-center justify-center gap-2 text-sm md:text-base">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
            </form>
        </div>
    </body>
    </html>
    <?php
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - RM Model School</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,600;14..32,700&display=swap" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background: #f0f4f8; }
        .stat-card { transition: all 0.3s ease; }
        .stat-card:hover { transform: translateY(-6px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04); }
        .chart-container { transition: transform 0.2s ease, box-shadow 0.2s ease; max-height: 350px; }
        .chart-container:hover { transform: translateY(-3px); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); }
        .table-hover tbody tr:hover { background-color: #f8fafc; }
        .student-list { max-height: 400px; overflow-y: auto; }
        .student-list::-webkit-scrollbar { width: 6px; }
        .student-list::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 8px; }
        .student-list::-webkit-scrollbar-thumb { background: #1a3b5d; border-radius: 8px; }
        canvas { max-height: 200px !important; }
        @media (max-width: 640px) {
            canvas { max-height: 150px !important; }
            .chart-container { max-height: 280px; }
        }
        /* Navbar toggle */
        .nav-menu { display: flex; align-items: center; gap: 1.5rem; }
        .nav-menu.active { display: flex; flex-direction: column; position: absolute; top: 100%; left: 0; right: 0; background: #1a3b5d; padding: 1rem 2rem; gap: 1rem; border-bottom: 2px solid rgba(255,255,255,0.1); }
        @media (max-width: 768px) { .nav-menu { display: none; } .nav-menu.active { display: flex; } }
        .menu-toggle { display: none; cursor: pointer; font-size: 1.5rem; }
        @media (max-width: 768px) { .menu-toggle { display: block; } }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="bg-[#1a3b5d] text-white shadow-lg sticky top-0 z-40 relative">
        <div class="container mx-auto px-4 py-3 flex flex-wrap items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fas fa-school text-yellow-400 text-2xl"></i>
                <span class="text-xl font-bold">RM <span class="text-yellow-400">Model</span> <span class="hidden sm:inline text-sm font-normal">| Admin</span></span>
            </div>
            <!-- Desktop nav -->
            <div class="nav-menu" id="navMenu">
                <a href="add_marks.php" class="bg-yellow-400 hover:bg-yellow-300 text-[#1a3b5d] px-3 sm:px-4 py-1.5 rounded-full text-xs sm:text-sm font-bold transition shadow flex items-center gap-1">
                    <i class="fas fa-plus-circle"></i> <span class="hidden xs:inline">Add Data</span>
                </a>
                <a href="index.php" class="hover:text-yellow-400 transition text-sm flex items-center gap-1">
                    <i class="fas fa-home"></i> <span class="hidden xs:inline">Site</span>
                </a>
                <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white px-3 sm:px-4 py-1.5 rounded-full text-xs sm:text-sm font-semibold transition shadow flex items-center gap-1">
                    <i class="fas fa-sign-out-alt"></i> <span class="hidden xs:inline">Logout</span>
                </a>
            </div>
            <!-- Mobile toggle -->
            <div class="menu-toggle" id="menuToggle">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <div class="container mx-auto px-4 py-6 md:py-8">

        <!-- Welcome Header -->
        <div class="flex flex-wrap items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-[#1a3b5d] flex items-center gap-2">
                    <i class="fas fa-chart-pie text-yellow-500"></i> Dashboard
                </h1>
                <p class="text-gray-500 text-sm mt-1">Real-time performance overview</p>
            </div>
            <div class="text-sm text-gray-400 bg-white px-4 py-2 rounded-full shadow-sm">
                <i class="fas fa-calendar-alt mr-1"></i> <?= date('d M, Y') ?>
            </div>
        </div>

        <!-- STATS CARDS -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4 mb-8" id="stats-container">
            <div class="stat-card bg-white p-4 md:p-5 rounded-xl shadow-md text-center border-l-4 border-[#1a3b5d]">
                <i class="fas fa-users text-2xl text-[#1a3b5d] mb-1"></i>
                <h3 id="s-students" class="text-2xl md:text-3xl font-bold text-[#1a3b5d]">0</h3>
                <p class="text-gray-500 text-xs font-semibold">Students</p>
            </div>
            <div class="stat-card bg-white p-4 md:p-5 rounded-xl shadow-md text-center border-l-4 border-[#4a8db7]">
                <i class="fas fa-book text-2xl text-[#4a8db7] mb-1"></i>
                <h3 id="s-subjects" class="text-2xl md:text-3xl font-bold text-[#4a8db7]">0</h3>
                <p class="text-gray-500 text-xs font-semibold">Subjects</p>
            </div>
            <div class="stat-card bg-white p-4 md:p-5 rounded-xl shadow-md text-center border-l-4 border-[#ffcc00]">
                <i class="fas fa-calculator text-2xl text-[#ffcc00] mb-1"></i>
                <h3 id="s-avg" class="text-2xl md:text-3xl font-bold text-[#e6b800]">0</h3>
                <p class="text-gray-500 text-xs font-semibold">Avg Marks</p>
            </div>
            <div class="stat-card bg-white p-4 md:p-5 rounded-xl shadow-md text-center border-l-4 border-green-500">
                <i class="fas fa-check-circle text-2xl text-green-500 mb-1"></i>
                <h3 id="s-pass" class="text-2xl md:text-3xl font-bold text-green-600">0</h3>
                <p class="text-gray-500 text-xs font-semibold">Pass</p>
            </div>
            <div class="stat-card bg-white p-4 md:p-5 rounded-xl shadow-md text-center border-l-4 border-red-500">
                <i class="fas fa-times-circle text-2xl text-red-500 mb-1"></i>
                <h3 id="s-fail" class="text-2xl md:text-3xl font-bold text-red-600">0</h3>
                <p class="text-gray-500 text-xs font-semibold">Fail</p>
            </div>
        </div>

        <!-- STUDENT LIST -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="px-4 py-3 border-b border-gray-100 flex flex-wrap items-center justify-between gap-2">
                <h3 class="text-lg font-bold text-gray-700 flex items-center gap-2">
                    <i class="fas fa-user-graduate text-[#1a3b5d]"></i> All Students & Marks
                </h3>
                <a href="add_marks.php" class="text-sm text-[#1a3b5d] font-semibold hover:underline">
                    <i class="fas fa-plus-circle mr-1"></i> Add New
                </a>
            </div>
            <div class="overflow-x-auto student-list">
                <table class="w-full text-sm table-hover">
                    <thead class="bg-[#1a3b5d] text-white sticky top-0">
                        <tr>
                            <th class="px-4 py-3 text-left">#</th>
                            <th class="px-4 py-3 text-left">Student Name</th>
                            <th class="px-4 py-3 text-left">Class</th>
                            <th class="px-4 py-3 text-left hidden sm:table-cell">Semester</th>
                            <th class="px-4 py-3 text-left">Subjects & Marks</th>
                            <th class="px-4 py-3 text-left">Total</th>
                            <th class="px-4 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $students = $pdo->query("
                            SELECT s.*, 
                                   GROUP_CONCAT(CONCAT(sub.subject_name, ': ', m.marks_obtained) SEPARATOR ' | ') as marks_detail,
                                   SUM(m.marks_obtained) as total_marks
                            FROM students s
                            LEFT JOIN marks m ON s.id = m.student_id
                            LEFT JOIN subjects sub ON m.subject_id = sub.id
                            GROUP BY s.id
                            ORDER BY s.id DESC
                        ");
                        $count = 1;
                        while($row = $students->fetch()) {
                            $marks_detail = $row['marks_detail'] ?: 'No marks added';
                            $total_marks = $row['total_marks'] ?: '—';
                            ?>
                            <tr class='border-b border-gray-100 hover:bg-gray-50 transition'>
                                <td class='px-4 py-3 text-gray-500'><?= $count ?></td>
                                <td class='px-4 py-3 font-medium text-gray-800'><?= htmlspecialchars($row['name']) ?></td>
                                <td class='px-4 py-3'><?= htmlspecialchars($row['class']) ?></td>
                                <td class='px-4 py-3 hidden sm:table-cell'><?= htmlspecialchars($row['semester']) ?></td>
                                <td class='px-4 py-3 text-xs max-w-xs'>
                                    <span class="text-gray-600"><?= htmlspecialchars($marks_detail) ?></span>
                                </td>
                                <td class='px-4 py-3 font-bold text-[#1a3b5d]'><?= $total_marks ?></td>
                                <td class='px-4 py-3'>
                                    <a href='edit_student.php?id=<?= $row['id'] ?>' class='text-blue-500 hover:text-blue-700 mr-2' title="Edit">
                                        <i class='fas fa-edit'></i>
                                    </a>
                                    <a href='delete_student.php?id=<?= $row['id'] ?>' class='text-red-500 hover:text-red-700' title="Delete" onclick="return confirm('Are you sure?')">
                                        <i class='fas fa-trash-alt'></i>
                                    </a>
                                </td>
                            </tr>
                            <?php
                            $count++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php if ($students->rowCount() == 0): ?>
                <div class="p-4 text-center text-gray-400 text-sm">
                    <i class="fas fa-inbox mr-2"></i> No students added yet. 
                    <a href="add_marks.php" class="text-[#1a3b5d] font-semibold hover:underline">Add your first student</a>.
                </div>
            <?php endif; ?>
        </div>

        <!-- CHARTS SECTION -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="chart-container bg-white p-4 md:p-6 rounded-xl shadow-md">
                <h3 class="text-base md:text-lg font-bold text-gray-700 mb-3 flex items-center gap-2">
                    <i class="fas fa-chart-bar text-[#1a3b5d]"></i> Subject-wise Average Marks
                </h3>
                <canvas id="subjectChart"></canvas>
                <div id="subjectChartFallback" class="text-center text-gray-400 text-sm mt-2 hidden">No subject data available</div>
            </div>
            <div class="chart-container bg-white p-4 md:p-6 rounded-xl shadow-md">
                <h3 class="text-base md:text-lg font-bold text-gray-700 mb-3 flex items-center gap-2">
                    <i class="fas fa-chart-pie text-[#1a3b5d]"></i> Pass / Fail Distribution
                </h3>
                <canvas id="pfChart"></canvas>
                <div id="pfChartFallback" class="text-center text-gray-400 text-sm mt-2 hidden">No marks data available</div>
            </div>
        </div>

    </div>

    <!-- FOOTER -->
    <footer class="bg-[#0d1f30] text-gray-400 py-4 mt-8">
        <div class="container mx-auto px-4 text-center text-sm">
            &copy; <?= date('Y') ?> RM Model School — Admin Dashboard <span class="hidden sm:inline">| BCA Minor Project</span>
        </div>
    </footer>

    <script>
        $(document).ready(function() {
            // Load Stats
            $.getJSON('get_data.php?action=stats', function(data) {
                if (data.error) {
                    console.error('Stats error:', data.error);
                    return;
                }
                $('#s-students').text(data.total_students || 0);
                $('#s-subjects').text(data.total_subjects || 0);
                $('#s-avg').text(data.avg_marks || 0);
                $('#s-pass').text(data.pass || 0);
                $('#s-fail').text(data.fail || 0);
            }).fail(function() {
                console.error('Failed to load stats');
            });

            // Subject Avg Chart
            $.getJSON('get_data.php?action=subject_avg', function(data) {
                if (data.error) {
                    console.error('Chart data error:', data.error);
                    $('#subjectChartFallback').removeClass('hidden').text('Error loading data');
                    return;
                }
                if (!data || data.length === 0) {
                    console.warn('No subject data available');
                    $('#subjectChartFallback').removeClass('hidden').text('No subject data available');
                    return;
                }
                
                const labels = data.map(item => item.subject_name);
                const values = data.map(item => parseFloat(item.avg_marks).toFixed(2));

                new Chart(document.getElementById('subjectChart'), {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Average Marks',
                            data: values,
                            backgroundColor: ['#1a3b5d', '#2a5f7a', '#4a8db7', '#ffcc00', '#e67e22'],
                            borderRadius: 6,
                            hoverBackgroundColor: ['#2a5f7a', '#3a6f8a', '#5a9dc7', '#f0b800', '#e67e22']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: true, max: 100, grid: { color: 'rgba(0,0,0,0.05)' } },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }).fail(function() {
                console.error('Failed to load subject data');
                $('#subjectChartFallback').removeClass('hidden').text('Error loading subject data');
            });

            // Pass/Fail Pie Chart
            $.getJSON('get_data.php?action=stats', function(data) {
                if (data.error) {
                    console.error('Pie chart data error:', data.error);
                    $('#pfChartFallback').removeClass('hidden').text('Error loading data');
                    return;
                }
                const pass = data.pass || 0;
                const fail = data.fail || 0;
                
                if (pass === 0 && fail === 0) {
                    $('#pfChartFallback').removeClass('hidden').text('No marks data available');
                    return;
                }

                new Chart(document.getElementById('pfChart'), {
                    type: 'pie',
                    data: {
                        labels: ['Pass', 'Fail'],
                        datasets: [{
                            data: [pass, fail],
                            backgroundColor: ['#28a745', '#dc3545'],
                            hoverOffset: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 12 } } }
                        }
                    }
                });
            }).fail(function() {
                console.error('Failed to load pass/fail data');
                $('#pfChartFallback').removeClass('hidden').text('Error loading pass/fail data');
            });
        });

        // Navbar toggle
        document.getElementById('menuToggle').addEventListener('click', function() {
            document.getElementById('navMenu').classList.toggle('active');
        });
    </script>
</body>
</html>
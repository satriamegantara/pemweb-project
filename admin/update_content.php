<?php
session_start();
include("../config/koneksi.php");

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../error.php");
    exit;
}

$admin_query = "SELECT * FROM login WHERE userId = '{$_SESSION['userId']}'";
$admin_result = mysqli_query($koneksi, $admin_query);
$admin_data = mysqli_fetch_assoc($admin_result);

// Initialize success and error messages from session if available
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : "";
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : "";

// Clear session messages after retrieving them
unset($_SESSION['success_message']);
unset($_SESSION['error_message']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'delete_planet' && isset($_POST['planet_id'])) {
        $planet_id = intval($_POST['planet_id']);

        // Hapus facts terlebih dahulu
        $delete_facts = "DELETE FROM planetarium_facts WHERE planet_id = $planet_id";
        mysqli_query($koneksi, $delete_facts);

        // Hapus planet
        $delete_planet = "DELETE FROM planetarium WHERE id = $planet_id";
        if (mysqli_query($koneksi, $delete_planet)) {
            $_SESSION['success_message'] = "Planetarium berhasil dihapus!";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $_SESSION['error_message'] = "Gagal menghapus planetarium!";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'delete_quiz' && isset($_POST['quiz_id'])) {
        $quiz_id = intval($_POST['quiz_id']);
        $delete_quiz = "DELETE FROM quiz_questions WHERE id = $quiz_id";

        if (mysqli_query($koneksi, $delete_quiz)) {
            $_SESSION['success_message'] = "Soal quiz berhasil dihapus!";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $_SESSION['error_message'] = "Gagal menghapus soal quiz!";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'toggle_planet' && isset($_POST['planet_id'])) {
        $planet_id = intval($_POST['planet_id']);

        // Get current status
        $check_query = "SELECT is_active FROM planetarium WHERE id = $planet_id";
        $check_result = mysqli_query($koneksi, $check_query);
        $planet = mysqli_fetch_assoc($check_result);

        $new_status = $planet['is_active'] == 1 ? 0 : 1;
        $update_query = "UPDATE planetarium SET is_active = $new_status WHERE id = $planet_id";

        if (mysqli_query($koneksi, $update_query)) {
            $status_text = $new_status == 1 ? "diaktifkan" : "dinonaktifkan";
            $_SESSION['success_message'] = "Planetarium berhasil $status_text!";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $_SESSION['error_message'] = "Gagal mengubah status planetarium!";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }
}

// Get all planetariums
$planets_query = "SELECT * FROM planetarium ORDER BY created_at DESC";
$planets_result = mysqli_query($koneksi, $planets_query);
$planets_data = [];
while ($planet = mysqli_fetch_assoc($planets_result)) {
    $planets_data[] = $planet;
}

// Get all quiz questions
$quiz_query = "SELECT * FROM quiz_questions ORDER BY created_at DESC";
$quiz_result = mysqli_query($koneksi, $quiz_query);
$quiz_data = [];
while ($quiz = mysqli_fetch_assoc($quiz_result)) {
    $quiz_data[] = $quiz;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/icons/thumbnail.png" type="image/png">
    <title>Update Content - Admin</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/admin-dashboard.css">
    <link rel="stylesheet" href="../assets/css/admin-content.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="update-content-page">
    <div class="bg"></div>
    <div class="admin-layout">
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3>admin dashboard</h3>
            </div>

            <ul class="sidebar-menu">
                <li><a href="dashboard.php"><i class="fas fa-home"></i> dashboard</a></li>
                <li><a href="edit_profile.php"><i class="fas fa-user-edit"></i> edit profile</a></li>
                <li><a href="add_content.php"><i class="fas fa-plus-circle"></i> add content</a></li>
                <li><a href="update_content.php" class="active"><i class="fas fa-edit"></i> update content</a></li>
                <li><a href="user_management.php"><i class="fas fa-users"></i> user management</a></li>
                <li><a href="review_report.php"><i class="fas fa-bullhorn"></i> announcement</a></li>
            </ul>

            <div class="sidebar-footer">
                <a href="../auth/logout.php" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> logout
                </a>
            </div>
        </div>

        <!-- MAIN CONTENT -->
        <div class="main-content">
            <!-- TOPBAR -->
            <div class="topbar">
                <div class="topbar-left">
                    <button class="menu-toggle" id="menuToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2 class="inner-shadow">update content</h2>
                </div>

                <div class="topbar-right">
                    <div class="admin-profile">
                        <i class="fas fa-user-circle"></i>
                        <span><?php echo htmlspecialchars($admin_data['username']); ?></span>
                    </div>
                    <a href="edit_profile.php" class="edit-profile-link">edit profile</a>
                </div>
            </div>

            <!-- CONTENT AREA -->
            <div class="content-area">
                <div class="content-container">
                    <?php if ($success_message): ?>
                        <div class="message-box success show">
                            <span><?php echo $success_message; ?></span>
                        </div>
                    <?php elseif ($error_message): ?>
                        <div class="message-box error show">
                            <span><?php echo $error_message; ?></span>
                        </div>
                    <?php endif; ?>

                    <div class="tabs">
                        <button class="tab-button active" onclick="switchTab('planets')">Planetarium</button>
                        <button class="tab-button" onclick="switchTab('quizzes')">Quiz</button>
                    </div>

                    <!-- PLANETS TAB -->
                    <div id="planets" class="tab-content active">
                        <?php if (count($planets_data) > 0): ?>
                            <div class="items-grid">
                                <?php foreach ($planets_data as $planet): ?>
                                    <div class="item-card">
                                        <div class="item-header">
                                            <div>
                                                <h3 class="item-title"><?php echo htmlspecialchars($planet['name']); ?></h3>
                                                <p class="item-type"><?php echo htmlspecialchars($planet['type']); ?></p>
                                            </div>
                                            <span
                                                class="item-status <?php echo $planet['is_active'] ? 'active' : 'inactive'; ?>">
                                                <?php echo $planet['is_active'] ? 'Aktif' : 'Nonaktif'; ?>
                                            </span>
                                        </div>

                                        <div class="item-info">
                                            <p><label>Diameter:</label> <?php echo htmlspecialchars($planet['diameter']); ?></p>
                                            <p><label>Massa:</label> <?php echo htmlspecialchars($planet['mass']); ?></p>
                                            <p><label>Suhu:</label> <?php echo htmlspecialchars($planet['temperature']); ?></p>
                                        </div>

                                        <div class="item-description">
                                            <?php echo htmlspecialchars(substr($planet['description'], 0, 150)); ?>...
                                        </div>

                                        <div class="item-actions">
                                            <form method="POST" style="flex: 1;">
                                                <input type="hidden" name="action" value="toggle_planet">
                                                <input type="hidden" name="planet_id" value="<?php echo $planet['id']; ?>">
                                                <button type="submit" class="btn-action btn-toggle">
                                                    <?php echo $planet['is_active'] ? '⊘ Nonaktifkan' : '✓ Aktifkan'; ?>
                                                </button>
                                            </form>
                                            <form method="POST" style="flex: 1;"
                                                onsubmit="return confirm('Yakin hapus planetarium ini?');">
                                                <input type="hidden" name="action" value="delete_planet">
                                                <input type="hidden" name="planet_id" value="<?php echo $planet['id']; ?>">
                                                <button type="submit" class="btn-action btn-delete">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="empty-state">
                                <i class="fas fa-planet"></i>
                                <h3>Belum ada planetarium</h3>
                                <p>Mulai dengan <a href="add_content.php" style="color: #d4af37;">menambah planetarium
                                        baru</a></p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- QUIZZES TAB -->
                    <div id="quizzes" class="tab-content">
                        <?php if (count($quiz_data) > 0): ?>
                            <div class="items-grid">
                                <?php foreach ($quiz_data as $quiz): ?>
                                    <div class="item-card">
                                        <div class="item-header">
                                            <div>
                                                <h3 class="item-title">Soal #<?php echo $quiz['id']; ?></h3>
                                            </div>
                                        </div>

                                        <div class="item-description">
                                            <?php echo htmlspecialchars($quiz['question']); ?>
                                        </div>

                                        <div class="quiz-options">
                                            <div class="quiz-option"><strong>A.</strong>
                                                <?php echo htmlspecialchars($quiz['option_a']); ?></div>
                                            <div class="quiz-option"><strong>B.</strong>
                                                <?php echo htmlspecialchars($quiz['option_b']); ?></div>
                                            <div class="quiz-option"><strong>C.</strong>
                                                <?php echo htmlspecialchars($quiz['option_c']); ?></div>
                                            <div class="quiz-option"><strong>D.</strong>
                                                <?php echo htmlspecialchars($quiz['option_d']); ?></div>
                                            <div
                                                style="margin-top: 10px; padding-top: 10px; border-top: 1px solid rgba(212, 175, 55, 0.2);">
                                                <span class="quiz-option correct">
                                                    Jawaban Benar: <strong><?php echo $quiz['correct_answer']; ?></strong>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="item-actions" style="margin-top: 15px;">
                                            <form method="POST" style="flex: 1;"
                                                onsubmit="return confirm('Yakin hapus soal ini?');">
                                                <input type="hidden" name="action" value="delete_quiz">
                                                <input type="hidden" name="quiz_id" value="<?php echo $quiz['id']; ?>">
                                                <button type="submit" class="btn-action btn-delete">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="empty-state">
                                <h3>Belum ada soal quiz</h3>
                                <p>Mulai dengan <a href="add_content.php" style="color: #d4af37;">menambah soal quiz
                                        baru</a></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/admin-dashboard.js"></script>
    <script>
        function switchTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });

            // Remove active class from all buttons
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active');
            });

            // Show selected tab
            document.getElementById(tabName).classList.add('active');

            // Add active class to clicked button
            event.target.closest('.tab-button').classList.add('active');
        }

        // Auto-hide message after 5 seconds
        document.addEventListener('DOMContentLoaded', function () {
            const messageBox = document.querySelector('.message-box.show');
            if (messageBox) {
                setTimeout(function () {
                    messageBox.classList.remove('show');
                }, 5000);
            }
        });
    </script>
</body>

</html>
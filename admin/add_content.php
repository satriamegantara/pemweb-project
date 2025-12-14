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

$success_message = "";
$error_message = "";
$action = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    if ($action === 'add_planetarium') {
        $name = mysqli_real_escape_string($koneksi, $_POST['planet_name']);
        $image = mysqli_real_escape_string($koneksi, $_POST['planet_image']);
        $type = mysqli_real_escape_string($koneksi, $_POST['planet_type']);
        $diameter = mysqli_real_escape_string($koneksi, $_POST['planet_diameter']);
        $mass = mysqli_real_escape_string($koneksi, $_POST['planet_mass']);
        $distance = mysqli_real_escape_string($koneksi, $_POST['planet_distance']);
        $temperature = mysqli_real_escape_string($koneksi, $_POST['planet_temperature']);
        $orbit_period = mysqli_real_escape_string($koneksi, $_POST['planet_orbit_period']);
        $moons = mysqli_real_escape_string($koneksi, $_POST['planet_moons']);
        $gravity = mysqli_real_escape_string($koneksi, $_POST['planet_gravity']);
        $day_length = mysqli_real_escape_string($koneksi, $_POST['planet_day_length']);
        $atmosphere = mysqli_real_escape_string($koneksi, $_POST['planet_atmosphere']);
        $composition = mysqli_real_escape_string($koneksi, $_POST['planet_composition']);
        $age = mysqli_real_escape_string($koneksi, $_POST['planet_age']);
        $description = mysqli_real_escape_string($koneksi, $_POST['planet_description']);
        $created_by = $_SESSION['userId'];

        if (!empty($name) && !empty($description)) {
            $insert_query = "INSERT INTO planetarium (name, image, type, diameter, mass, distance, temperature, orbit_period, moons, gravity, day_length, atmosphere, composition, age, description, created_by) 
                            VALUES ('$name', '$image', '$type', '$diameter', '$mass', '$distance', '$temperature', '$orbit_period', '$moons', '$gravity', '$day_length', '$atmosphere', '$composition', '$age', '$description', '$created_by')";

            if (mysqli_query($koneksi, $insert_query)) {
                $planet_id = mysqli_insert_id($koneksi);

                if (!empty($_POST['planet_facts']) && is_array($_POST['planet_facts'])) {
                    foreach ($_POST['planet_facts'] as $fact) {
                        if (!empty($fact)) {
                            $fact_escaped = mysqli_real_escape_string($koneksi, $fact);
                            $fact_query = "INSERT INTO planetarium_facts (planet_id, fact) VALUES ('$planet_id', '$fact_escaped')";
                            mysqli_query($koneksi, $fact_query);
                        }
                    }
                }

                $success_message = "✓ Planetarium '{$name}' berhasil ditambahkan!";
            } else {
                $error_message = "✗ Error: " . mysqli_error($koneksi);
            }
        } else {
            $error_message = "✗ Nama planetarium dan deskripsi harus diisi!";
        }
    } elseif ($action === 'add_quiz') {
        $question = mysqli_real_escape_string($koneksi, $_POST['quiz_question']);
        $option_a = mysqli_real_escape_string($koneksi, $_POST['quiz_option_a']);
        $option_b = mysqli_real_escape_string($koneksi, $_POST['quiz_option_b']);
        $option_c = mysqli_real_escape_string($koneksi, $_POST['quiz_option_c']);
        $option_d = mysqli_real_escape_string($koneksi, $_POST['quiz_option_d']);
        $correct_option = mysqli_real_escape_string($koneksi, $_POST['quiz_correct']);
        $created_by = $_SESSION['userId'];

        if (!empty($question) && !empty($option_a) && !empty($option_b) && !empty($option_c) && !empty($option_d)) {
            $insert_query = "INSERT INTO quiz_questions (question, option_a, option_b, option_c, option_d, correct_option, created_by) 
                            VALUES ('$question', '$option_a', '$option_b', '$option_c', '$option_d', '$correct_option', '$created_by')";

            if (mysqli_query($koneksi, $insert_query)) {
                $success_message = "✓ Soal quiz berhasil ditambahkan!";
            } else {
                $error_message = "✗ Error: " . mysqli_error($koneksi);
            }
        } else {
            $error_message = "✗ Semua field soal quiz harus diisi!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/icons/thumbnail.png" type="image/png">
    <title>Add Content - Admin</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/admin-dashboard.css">
    <link rel="stylesheet" href="../assets/css/admin-content.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="add-content-page">
    <div class="bg"></div>
    <div class="admin-layout">
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3>admin dashboard</h3>
            </div>

            <ul class="sidebar-menu">
                <li><a href="dashboard.php"><i class="fas fa-home"></i> dashboard</a></li>
                <li><a href="edit_profile.php"><i class="fas fa-user-edit"></i> edit profile</a></li>
                <li><a href="add_content.php" class="active"><i class="fas fa-plus-circle"></i> add content</a></li>
                <li><a href="update_content.php"><i class="fas fa-edit"></i> update content</a></li>
                <li><a href="verify_user.php"><i class="fas fa-check-circle"></i> verify user</a></li>
                <li><a href="review_report.php"><i class="fas fa-file-alt"></i> review report</a></li>
            </ul>

            <div class="sidebar-footer">
                <a href="../auth/logout.php" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> logout
                </a>
            </div>
        </div>

        <div class="main-content">
            <div class="topbar">
                <div class="topbar-left">
                    <button class="menu-toggle" id="menuToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2 class="inner-shadow">add content</h2>
                </div>

                <div class="topbar-right">
                    <div class="admin-profile">
                        <i class="fas fa-user-circle"></i>
                        <span><?php echo htmlspecialchars($admin_data['username']); ?></span>
                    </div>
                    <a href="edit_profile.php" class="edit-profile-link">edit profile</a>
                </div>
            </div>

            <div class="content-area">
                <div class="add-content-container">
                    <div class="content-form">
                        <div class="form-header inner-shadow">
                            <i class="fas fa-planet"></i>
                            <h3>Tambah Planetarium</h3>
                        </div>

                        <?php if ($action === 'add_planetarium' && $success_message): ?>
                            <div class="message-box success show">
                                <i class="fas fa-check-circle"></i>
                                <span><?php echo $success_message; ?></span>
                            </div>
                        <?php elseif ($action === 'add_planetarium' && $error_message): ?>
                            <div class="message-box error show">
                                <i class="fas fa-exclamation-circle"></i>
                                <span><?php echo $error_message; ?></span>
                            </div>
                        <?php endif; ?>

                        <form method="POST" id="planetariumForm">
                            <input type="hidden" name="action" value="add_planetarium">

                            <div class="form-group">
                                <label>Nama Planetarium *</label>
                                <input type="text" name="planet_name" placeholder="Contoh: Mars, Jupiter" required>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Nama File Gambar *</label>
                                    <input type="text" name="planet_image" placeholder="Contoh: mars.png" required>
                                </div>
                                <div class="form-group">
                                    <label>Tipe Planetarium *</label>
                                    <input type="text" name="planet_type" placeholder="Contoh: Terrestrial Planet"
                                        required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Diameter *</label>
                                    <input type="text" name="planet_diameter" placeholder="Contoh: 6,779 km" required>
                                </div>
                                <div class="form-group">
                                    <label>Massa *</label>
                                    <input type="text" name="planet_mass" placeholder="Contoh: 6.417 × 10²³ kg"
                                        required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Jarak dari Matahari</label>
                                    <input type="text" name="planet_distance" placeholder="Contoh: 227.9 million km">
                                </div>
                                <div class="form-group">
                                    <label>Suhu *</label>
                                    <input type="text" name="planet_temperature" placeholder="Contoh: -63°C" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Periode Orbit</label>
                                    <input type="text" name="planet_orbit_period" placeholder="Contoh: 687 Earth days">
                                </div>
                                <div class="form-group">
                                    <label>Bulan/Satelit</label>
                                    <input type="text" name="planet_moons" placeholder="Contoh: 2 (Phobos, Deimos)">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Gravitasi</label>
                                    <input type="text" name="planet_gravity" placeholder="Contoh: 3.71 m/s²">
                                </div>
                                <div class="form-group">
                                    <label>Durasi Hari</label>
                                    <input type="text" name="planet_day_length" placeholder="Contoh: 24.6 hours">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Atmosfer</label>
                                    <input type="text" name="planet_atmosphere" placeholder="Contoh: CO₂, N₂, Ar">
                                </div>
                                <div class="form-group">
                                    <label>Komposisi</label>
                                    <input type="text" name="planet_composition" placeholder="Contoh: Rock, metal">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Usia Planetarium</label>
                                <input type="text" name="planet_age" placeholder="Contoh: 4.6 billion years">
                            </div>

                            <div class="form-group">
                                <label>Deskripsi *</label>
                                <textarea name="planet_description"
                                    placeholder="Masukkan deskripsi lengkap planetarium..." required></textarea>
                            </div>

                            <div class="form-group">
                                <label>Fakta-Fakta Menarik</label>
                                <div class="facts-container" id="factsContainer">
                                    <div class="fact-input-group">
                                        <input type="text" name="planet_facts[]"
                                            placeholder="Masukkan fakta menarik...">
                                        <button type="button" class="btn-remove"
                                            onclick="removeFact(this)">Hapus</button>
                                    </div>
                                </div>
                                <button type="button" class="btn-add-fact" onclick="addFact()">+ Tambah Fakta</button>
                            </div>

                            <button type="submit" class="btn-submit">
                                <i class="fas fa-save"></i> Simpan Planetarium
                            </button>
                        </form>
                    </div>

                    <div class="content-form">
                        <div class="form-header inner-shadow">
                            <h3>Tambah Soal Quiz</h3>
                        </div>

                        <?php if ($action === 'add_quiz' && $success_message): ?>
                            <div class="message-box success show">
                                <i class="fas fa-check-circle"></i>
                                <span><?php echo $success_message; ?></span>
                            </div>
                        <?php elseif ($action === 'add_quiz' && $error_message): ?>
                            <div class="message-box error show">
                                <i class="fas fa-exclamation-circle"></i>
                                <span><?php echo $error_message; ?></span>
                            </div>
                        <?php endif; ?>

                        <form method="POST" id="quizForm">
                            <input type="hidden" name="action" value="add_quiz">

                            <div class="form-group">
                                <label>Soal Quiz *</label>
                                <textarea name="quiz_question" placeholder="Masukkan pertanyaan quiz..."
                                    required></textarea>
                            </div>

                            <div class="form-group">
                                <label>Opsi A *</label>
                                <input type="text" name="quiz_option_a" placeholder="Masukkan jawaban A..." required>
                            </div>

                            <div class="form-group">
                                <label>Opsi B *</label>
                                <input type="text" name="quiz_option_b" placeholder="Masukkan jawaban B..." required>
                            </div>

                            <div class="form-group">
                                <label>Opsi C *</label>
                                <input type="text" name="quiz_option_c" placeholder="Masukkan jawaban C..." required>
                            </div>

                            <div class="form-group">
                                <label>Opsi D *</label>
                                <input type="text" name="quiz_option_d" placeholder="Masukkan jawaban D..." required>
                            </div>

                            <div class="form-group">
                                <label>Jawaban Benar *</label>
                                <select name="quiz_correct" required>
                                    <option value="">-- Pilih jawaban benar --</option>
                                    <option value="A">Opsi A</option>
                                    <option value="B">Opsi B</option>
                                    <option value="C">Opsi C</option>
                                    <option value="D">Opsi D</option>
                                </select>
                            </div>

                            <button type="submit" class="btn-submit">
                                <i class="fas fa-save"></i> Simpan Soal Quiz
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/admin-dashboard.js"></script>
    <script>
        function addFact() {
            const container = document.getElementById('factsContainer');
            const div = document.createElement('div');
            div.className = 'fact-input-group';
            div.innerHTML = `
                <input type="text" name="planet_facts[]" placeholder="Masukkan fakta menarik...">
                <button type="button" class="btn-remove" onclick="removeFact(this)">Hapus</button>
            `;
            container.appendChild(div);
        }

        function removeFact(btn) {
            btn.parentElement.remove();
        }

        // Auto-hide success message after 5 seconds
        document.addEventListener('DOMContentLoaded', function () {
            const messageBox = document.querySelector('.message-box.success');
            if (messageBox) {
                setTimeout(function () {
                    messageBox.classList.remove('show');
                }, 5000);
            }
        });
    </script>
</body>

</html>
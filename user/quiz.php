<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SESSION['role'] !== 'user') {
    header("Location: ../error.php");
    exit;
}

include '../config/koneksi.php';

function fetchQuizQuestions(mysqli $koneksi): array
{
    $questions = [];

    $sql = "
        SELECT 
            id,
            question,
            option_a,
            option_b,
            option_c,
            option_d,
            correct_answer
        FROM quiz_questions
        ORDER BY RAND()
        LIMIT 10
    ";

    if ($result = $koneksi->query($sql)) {
        while ($row = $result->fetch_assoc()) {
            $options = [
                $row['option_a'],
                $row['option_b'],
                $row['option_c'],
                $row['option_d']
            ];

            // Map correct_answer (A-D) to index 0-3
            $correctIndex = ['A' => 0, 'B' => 1, 'C' => 2, 'D' => 3][$row['correct_answer']] ?? 0;

            $questions[] = [
                'id' => (int) $row['id'],
                'question' => $row['question'],
                'options' => $options,
                'correct' => $correctIndex
            ];
        }
        $result->free();
    }

    return $questions;
}

$quiz_questions = fetchQuizQuestions($koneksi);
$total_questions = count($quiz_questions);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/icons/thumbnail.png" type="image/png">
    <title>Quiz - Galaxy Explorer</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/quiz.css">
</head>

<body>
    <div class="container login-page">
        <div class="bg"></div>
    </div>

    <div class="content-quiz">
        <a href="dashboard.php" class="back-btn">
            <img src="../assets/icons/ui/back.png" class="icon" alt="Back">Back
        </a>

        <div class="quiz-container">
            <!-- Header -->
            <div class="quiz-header">
                <h1 class="page-title">Galaxy Quiz</h1>
                <p class="page-subtitle">Uji pengetahuanmu tentang Tata Surya</p>
            </div>

            <!-- Quiz Content -->
            <div class="quiz-content">
                <!-- Quiz Introduction -->
                <div id="quizIntro" class="quiz-intro">
                    <div class="intro-content">
                        <h2>Selamat datang di Galaxy Quiz!</h2>
                        <p>Jawab <?php echo $total_questions; ?> pertanyaan tentang planet dan Tata Surya</p>
                        <div class="quiz-stats">
                            <div class="stat">
                                <span class="stat-number"><?php echo $total_questions; ?></span>
                                <span class="stat-label">Pertanyaan</span>
                            </div>
                            <div class="stat">
                                <span class="stat-number">∞</span>
                                <span class="stat-label">Waktu Unlimited</span>
                            </div>
                        </div>
                        <?php if ($total_questions > 0): ?>
                            <button class="start-btn" onclick="startQuiz()">Mulai Quiz</button>
                        <?php else: ?>
                            <div class="empty-quiz">
                                <p>Belum ada soal quiz. Hubungi admin untuk menambahkan soal.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Quiz Questions -->
                <div id="quizQuestions" class="quiz-questions" style="display: none;">
                    <div class="progress-bar">
                        <div id="progressFill" class="progress-fill"></div>
                    </div>
                    <div class="question-counter">
                        <span id="currentQuestion">1</span> / <span
                            id="totalQuestions"><?php echo count($quiz_questions); ?></span>
                    </div>

                    <div id="questionsContainer"></div>

                    <div class="quiz-navigation">
                        <button class="nav-btn prev-btn" onclick="previousQuestion()" id="prevBtn" disabled>←
                            Sebelumnya</button>
                        <button class="nav-btn next-btn" onclick="nextQuestion()" id="nextBtn">Selanjutnya →</button>
                        <button class="nav-btn submit-btn" onclick="submitQuiz()" id="submitBtn"
                            style="display: none;">Selesai Quiz</button>
                    </div>
                </div>

                <!-- Quiz Results -->
                <div id="quizResults" class="quiz-results" style="display: none;">
                    <div class="results-content">
                        <h2>Hasil Quiz Kamu</h2>
                        <div class="score-circle">
                            <div class="score-number" id="scorePercentage">0%</div>
                            <div class="score-label">Skor Akhir</div>
                        </div>
                        <p class="score-message" id="scoreMessage"></p>
                        <div class="results-details" id="resultsDetails"></div>
                        <div class="results-actions">
                            <button class="action-btn retry-btn" onclick="location.reload()">Coba Lagi</button>
                            <button class="action-btn home-btn" onclick="window.location.href='dashboard.php'">Kembali
                                ke Dashboard</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const quizData = <?php echo json_encode($quiz_questions); ?>;
        let currentQuestion = 0;
        let answers = {};
        let quizStarted = false;

        const quizAvailable = Array.isArray(quizData) && quizData.length > 0;

        // Initialize answers object
        quizData.forEach(q => {
            answers[q.id] = null;
        });

        function startQuiz() {
            if (!quizAvailable) {
                alert('Belum ada soal quiz. Hubungi admin untuk menambahkan soal.');
                return;
            }
            quizStarted = true;
            document.getElementById('quizIntro').style.display = 'none';
            document.getElementById('quizQuestions').style.display = 'block';
            renderQuestion();
        }

        function renderQuestion() {
            const question = quizData[currentQuestion];
            let html = `
                <div class="question-card">
                    <h3 class="question-text">${question.question}</h3>
                    <div class="options-container">
            `;

            question.options.forEach((option, index) => {
                const isSelected = answers[question.id] === index;
                html += `
                    <label class="option ${isSelected ? 'selected' : ''}">
                        <input type="radio" name="option" value="${index}" 
                            ${isSelected ? 'checked' : ''} 
                            onchange="selectAnswer(${question.id}, ${index})">
                        <span class="option-text">${option}</span>
                        <span class="option-indicator"></span>
                    </label>
                `;
            });

            html += `</div></div>`;
            document.getElementById('questionsContainer').innerHTML = html;

            // Update progress
            updateProgress();
            updateNavigation();
        }

        function selectAnswer(questionId, optionIndex) {
            answers[questionId] = optionIndex;
        }

        function previousQuestion() {
            if (currentQuestion > 0) {
                currentQuestion--;
                renderQuestion();
            }
        }

        function nextQuestion() {
            if (currentQuestion < quizData.length - 1) {
                currentQuestion++;
                renderQuestion();
            }
        }

        function updateProgress() {
            const progress = ((currentQuestion + 1) / quizData.length) * 100;
            document.getElementById('progressFill').style.width = progress + '%';
            document.getElementById('currentQuestion').textContent = currentQuestion + 1;
        }

        function updateNavigation() {
            const isFirst = currentQuestion === 0;
            const isLast = currentQuestion === quizData.length - 1;

            document.getElementById('prevBtn').disabled = isFirst;
            document.getElementById('nextBtn').style.display = isLast ? 'none' : 'inline-block';
            document.getElementById('submitBtn').style.display = isLast ? 'inline-block' : 'none';
        }

        function submitQuiz() {
            // Calculate score
            let correctAnswers = 0;
            quizData.forEach(q => {
                if (answers[q.id] === q.correct) {
                    correctAnswers++;
                }
            });

            const percentage = Math.round((correctAnswers / quizData.length) * 100);

            // Show results
            showResults(correctAnswers, percentage);
        }

        function showResults(correctAnswers, percentage) {
            document.getElementById('quizQuestions').style.display = 'none';
            document.getElementById('quizResults').style.display = 'block';

            document.getElementById('scorePercentage').textContent = percentage + '%';

            let message = '';
            if (percentage === 100) {
                message = '🌟 Sempurna! Kamu adalah ahli astronomi sejati!';
            } else if (percentage >= 80) {
                message = '🎉 Luar biasa! Pengetahuanmu tentang Tata Surya sangat bagus!';
            } else if (percentage >= 60) {
                message = '👍 Bagus! Terus belajar tentang planet dan bintang.';
            } else if (percentage >= 40) {
                message = '📚 Lumayan! Ada banyak hal menarik untuk dipelajari tentang Tata Surya.';
            } else {
                message = '💪 Keep trying! Jelajahi planetarium untuk belajar lebih banyak.';
            }

            document.getElementById('scoreMessage').textContent = message;

            // Show details
            let detailsHtml = `
                <div class="result-stat">
                    <span class="result-label">Benar:</span>
                    <span class="result-value">${correctAnswers} dari ${quizData.length}</span>
                </div>
                <div class="result-answers">
                    <h3>Hasil Jawaban:</h3>
                    <div class="answers-list">
            `;

            quizData.forEach(q => {
                const isCorrect = answers[q.id] === q.correct;
                const selectedAnswer = answers[q.id] !== null ? q.options[answers[q.id]] : 'Tidak dijawab';
                const correctAnswer = q.options[q.correct];

                detailsHtml += `
                    <div class="answer-item ${isCorrect ? 'correct' : 'incorrect'}">
                        <div class="answer-icon">${isCorrect ? '✓' : '✗'}</div>
                        <div class="answer-content">
                            <p class="answer-question">${q.question}</p>
                            <p class="answer-your">Jawabanmu: ${selectedAnswer}</p>
                            ${!isCorrect ? `<p class="answer-correct">Jawaban benar: ${correctAnswer}</p>` : ''}
                        </div>
                    </div>
                `;
            });

            detailsHtml += `</div></div>`;
            document.getElementById('resultsDetails').innerHTML = detailsHtml;
        }

        // Set total questions on page load
        window.addEventListener('load', function () {
            document.getElementById('totalQuestions').textContent = quizData.length;
            if (!quizAvailable) {
                document.getElementById('quizQuestions').style.display = 'none';
                document.getElementById('quizResults').style.display = 'none';
            }
        });
    </script>
</body>

</html>
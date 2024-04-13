<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Retrieve correctAnswers and totalQuestions from the URL query parameters
$correctAnswers = isset($_GET['correctAnswers']) ? $_GET['correctAnswers'] : 0;
$totalQuestions = isset($_GET['totalQuestions']) ? $_GET['totalQuestions'] : 0;
$userName = isset($_GET['user_name']) ? $_GET['user_name'] : ''; // Get user name from query parameters

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Quiz Results</title>
    <!-- Add your CSS and other head elements here -->
</head>

<body>
    <header>
        <?php $this->load->view('Comman/header'); ?>
    </header>

    <div>CONGRATULATIONS <?php echo $user_name; ?></div>

    <div class="score">Score: <?= $correctAnswers ?>/<?= $totalQuestions ?></div>
    <!-- Rest of your score.php content -->
</body>

</html>

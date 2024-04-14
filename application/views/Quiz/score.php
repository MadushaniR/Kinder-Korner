<?php
defined('BASEPATH') or exit('No direct script access allowed');

$correctAnswers = isset($_GET['correctAnswers']) ? $_GET['correctAnswers'] : 0;
$totalQuestions = isset($_GET['totalQuestions']) ? $_GET['totalQuestions'] : 0;
$userName = isset($_GET['user_name']) ? $_GET['user_name'] : '';
$quizID = isset($_GET['quizID']) ? $_GET['quizID'] : '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Quiz Results</title>
    <style>
        body {
            background-image: url(<?php echo base_url('assets/images/bg.jpg'); ?>);
            background-size: cover;
            background-position: center top;
        }

        .score {
            font-size: 24px;
            margin-top: 20px;
        }

        .congrats-img {
            margin-bottom: 20px;
        }

        .results-container {
            width: 50%;
            margin-left: 35%;
            margin-right: 50%;
        }

        .score {
            font-size: 50px;
            font-weight: 800;
            text-align: center;
            margin-top: -3%;
            background-color: yellow;
            width: 58%;
        }

        .title-congrats {
            font-size: 50px;
            font-weight: 800;
            text-align: center;
            margin-left: -40%;
            margin-bottom: 10px;
        }

        #replay,
        #home {
            margin-top: 20px;
        }

        #replay img,
        #home img {
            width: 100px;
            height: 100px;
        }

        .btn-wrapper {
            display: flex;
            justify-content: space-between;
            margin-top: -200px;
            width: 75%;
            margin-left: auto;
            margin-right: auto;
            /* margin: 0 auto; */
            text-align: center;
        }
    </style>
</head>

<body>
    <header>
        <?php $this->load->view('Comman/header'); ?>
    </header>
    <div class="results-container">
        <div class="title-congrats">Congratulations <?php echo $user_name; ?>!</div>
        <div class="congrat-img">
            <img src="<?php echo base_url('assets/images/congrats.png'); ?>" alt="Congratulations" class="congrats-img">
        </div>
        <div class="score">Your Score: <?= $correctAnswers ?>/<?= $totalQuestions ?></div>
    </div>
    <div class="btn-wrapper">
        <!-- Replay button with image -->
        <div id="replay">
            <a href="<?php echo base_url(); ?>index.php/QuizDisplay/quizdisplay?quizID=<?= $quizID ?>">
                <img src="<?php echo base_url('assets/images/play_again.png'); ?>" alt="Replay">
            </a>
        </div>

        <!-- Home button with image -->
        <div id="home">
            <a href="<?php echo base_url(); ?>index.php/Auth/main">
                <img src="<?php echo base_url('assets/images/home.png'); ?>" alt="Home">
            </a>
        </div>
    </div>
</body>

</html>
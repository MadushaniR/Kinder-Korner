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
        .results-container{
            width: 50%;
          margin-left: 35%;
          margin-right: 50%;

        }
        .score{
            font-size: 50px;
font-weight: 800;
text-align: center;
/* margin-left: -40%; */
margin-top: -3%;
background-color: yellow;
width: 58%;

        }
        .congrats-img{

        }
        .title-congrats{
font-size: 50px;
font-weight: 800;
text-align: center;
margin-left: -40%;
margin-bottom: 10px;
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
    <div>
            <button class="kid-friendly-button" onclick="window.location.href='<?php echo base_url(); ?>index.php/Results/score?correctAnswers=<?= $correctAnswers ?>&totalQuestions=<?= $totalQuestions ?>'">Replay</button>
            <button class="kid-friendly-button" onclick="window.location.href='<?php echo base_url(); ?>index.php/Auth/main'">Home</button>
        </div>
</body>

</html>
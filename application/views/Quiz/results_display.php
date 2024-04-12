<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Quiz Results</title>
    <style>
        .optionButton {
            margin: 5px;
            padding: 10px;
            cursor: pointer;
        }

        .correct {
            background-color: #00e6ac;
            color: black;
        }

        .incorrect {
            background-color: #ff9999;
            color: black;
        }

        .checkmark,
        .cross {
            margin-left: 5px;
            font-weight: bold;
        }

        .checkmark {
            color: green;
        }

        .cross::before {
            content: '✗';
            color: red;
        }

        .correctAnswer {
            background-color: yellow;
            color: black;
        }

        .question-container {
            display: none;
        }

        .question-container.active {
            display: block;
        }

        .optionButton.selected {
            background-color: blue;
            color: white;
        }

        body {
            background-image: url(<?php echo base_url('assets/images/bg.jpg'); ?>);
            background-size: cover;
            background-position: center;
        }

        .top-bottons {
            display: grid;
            grid-template-columns: auto auto;
            grid-gap: 10px;
            margin-bottom: 20px;
            margin-top: 20px;
        }

        #prevButton,
        #nextButton {
            background-color: yellow;
            padding: 10px;
            border-radius: 5px;
            font-size: 20px;
            width: fit-content;
            cursor: pointer;
            margin-left: 25%;
        }

        #nextButton {
            background-color: yellow;
            margin-left: 55%;
            padding: 10px;
            border-radius: 5px;
            width: 20%;
            font-size: 20px;
        }

        #container {
            /* width: 50%;
            margin-top: 50px;
            margin-bottom: 50px;
            margin-left: auto;
            margin-right: auto;
            border: 2px solid black; */
            /* padding: 20px; */
        }

        .question-box {
            width: 100%;
            background-color: white;
            margin-top: 10px;
            margin-bottom: 10px;
            padding-top: 15px;
            padding-bottom: 10px;
            color: black;
            /* padding: 5px; */
            text-align: center;
            font-size: 30px;
            font-weight: bold;
        }

        .options-grid {
            width: 100%;
            /* margin-top: 10%; */
            /* margin-left: 50%;
            margin-right: auto; */
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-gap: 25px;
            align-items: center;
            justify-items: center;
        }


        .optionButton {
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 15px;
            font-size: 25px;
            border-radius: 50px;
            border-width: 3px;
        }

        .submit-btn {
            text-align: center;
            margin-top: 20px;
        }

        .submit-btn input[type="submit"] {
            background-color: red;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            font-size: 20px;
            cursor: pointer;
        }

        #topic-container {
            /* background-color: white; */
            width: 100%;
            text-align: center;
            font-size: 40px;
            font-weight: 800;
            color: red;
            /* padding: 10px; */
        }

        #question-text {
            background-color: white;
            text-align: center;
            font-size: 30px;
            color: black;
            font-weight: 600;
            padding: 10px;
            margin-bottom: 30px;

        }

        .score {
            width: 100%;
            background-color: #ecb3ff;
            color: black;
            text-align: center;
            font-size: 30px;
            font-weight: 600;
            padding: 10px;
        }

        #home {
            margin-top: 40px;
            margin-bottom: 20px;
            justify-content: center;
            align-items: center;
            margin-left: 48%;
            margin-right: auto;
        }

        .review-img {
            margin-top: 2%;
            margin-bottom: 2%;
        }
    </style>

    </style>
</head>

<header>
    <?php $this->load->view('Comman/header'); ?>
</header>

<body>
    <!-- <img src="<?php echo base_url('assets/images/review_quiz.png'); ?>" alt="review Image" class="review-img"> -->
    <div id="topic-container">
        <img src="<?php echo base_url('assets/images/review_quiz.png'); ?>" alt="review Image" class="review-img">
    </div>
    <div id="container">

        <?php
        $totalQuestions = count($questions);
        $correctAnswers = 0;

        foreach ($questions as $row) {
            $userAnswerText = '';
            $questionID = $row->questionID;

            if (isset($_POST['selectedOption'][$questionID])) {
                $userAnswerText = $_POST['selectedOption'][$questionID];
                $this->ResultsModel->updateUserAnswers($userID, $quizID, $questionID, $userAnswerText);
            }

            $isCorrect = ($userAnswerText == $row->correctAnswer);

            if ($isCorrect) {
                $correctAnswers++;
            }

        ?>
            <div>
                <div id="question-text"><?= $row->questionText ?></div>
                <div class="options-grid">
                    <?php foreach (['option1', 'option2', 'option3', 'option4'] as $option) { ?>
                        <button type="button" class="optionButton <?= ($userAnswerText == $row->$option) ? ($isCorrect ? 'correct' : 'incorrect') : '' ?> <?= (!$isCorrect && $row->correctAnswer == $row->$option) ? 'correctAnswer' : '' ?>">
                            <?= $row->$option ?>
                            <?php if ($isCorrect && $row->correctAnswer == $row->$option) { ?>
                                <span class="checkmark">&#10004;</span>
                            <?php } elseif (!$isCorrect && $userAnswerText == $row->$option) { ?>
                                <span class="cross"></span>
                            <?php } ?>
                        </button>
                    <?php } ?>
                </div>
                <!-- <p>Correct Answer: <span class="correct_answer"><?= $row->correctAnswer ?></span></p>
                <p>Your Answer: <?= $userAnswerText ?></p>
                <p><?= ($isCorrect ? 'Correct' : 'Incorrect') ?></p> -->
                <hr>
            </div>
        <?php } ?>

        <div class="score">Score: <?= $correctAnswers ?>/<?= $totalQuestions ?></div>
        <a href="<?php echo base_url(); ?>index.php/Auth/main">
            <div id="home">
                <img src="<?php echo base_url('assets/images/home.png'); ?>" alt="Home" width="100" height="100">
            </div>
        </a>

        <!-- <a href="<?php echo base_url(); ?>index.php/Auth/main"><button type="button">Go to Home Page</button></a> -->
    </div>
</body>

</html>
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

        .checkmark, .cross {
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
    </style>
</head>

<header>
    <?php $this->load->view('Comman/header'); ?>
</header>

<body>
    <div id="container">
        <h1>Quiz Results</h1>
        <h1>Welcome, <?= $user_name ?>!</h1>
        <h1>USER ID, <?= $userID ?>!</h1>
        <h2>Quiz Number: <?= $quizID ?></h2>

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
                <p><?= $questionID ?>. <?= $row->questionText ?></p>
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
                <p>Correct Answer: <span class="correct_answer"><?= $row->correctAnswer ?></span></p>
                <p>Your Answer: <?= $userAnswerText ?></p>
                <p><?= ($isCorrect ? 'Correct' : 'Incorrect') ?></p>
                <hr>
            </div>
        <?php } ?>

        <p>Result: <?= $correctAnswers ?>/<?= $totalQuestions ?></p>

        <a href="<?php echo base_url(); ?>index.php/Auth/main"><button type="button">Go to Home Page</button></a>
    </div>
</body>

</html>

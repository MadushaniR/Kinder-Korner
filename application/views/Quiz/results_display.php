<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Quiz Results</title>
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
            <p><?= $questionID ?>. <?= $row->questionText ?></p>
            <p>Correct Answer: <?= $row->correctAnswer ?></p>
            <p>Your Answer: <?= $userAnswerText ?></p>
            <p><?= ($isCorrect ? 'Correct' : 'Incorrect') ?></p>
            <hr>
        <?php } ?>

        <p>Result: <?= $correctAnswers ?>/<?= $totalQuestions ?></p>

        <a href="<?php echo base_url(); ?>index.php/Auth/main"><button type="button">Go to Home Page</button></a>
    </div>
</body>

</html>

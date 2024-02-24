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
        // Fetch user answers from the useranswer table
        $userAnswers = $this->quizmodel->getUserAnswers($userID, $quizID);

        foreach ($questions as $row) {
            $userAnswerText = '';
            // Find the corresponding user answer for the current question
            foreach ($userAnswers as $userAnswer) {
                if ($userAnswer->questionID == $row->questionID) {
                    $userAnswerText = $userAnswer->selectedOption;
                    break;
                }
            }
        ?>
            <p><?= $row->questionID ?>. <?= $row->questionText ?></p>
            <p>Correct Answer: <?= $row->correctAnswer ?></p>
            <p>Your Answer: <?= $userAnswerText ?></p>
            <hr>
        <?php } ?>
        <a href="<?php echo base_url(); ?>index.php/Auth/main"><button type="button">Go to Home Page</button></a>
    </div>
</body>

</html>

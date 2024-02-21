<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Play Quiz</title>
</head>
<header>
    <?php $this->load->view('Comman/header'); ?>
</header>

<body>

    <div id="container">
        <h1>Play Quiz!</h1>
        <h1>Welcome, <?= $user_name ?>!</h1>
        <h1>USER ID, <?= $userID ?>!</h1>
        <?php foreach ($questions as $row) { ?>
            <p><?= $row->questionID ?>. <?= $row->questionText ?></p>
            <p>Correct Answer: <?= $row->correctAnswer ?></p>
            <?php
            // Find the corresponding user answer for the question
            $userAnswer = array_filter($userAnswers, function ($ua) use ($row) {
                return $ua->questionID == $row->questionID;
            });

            if (!empty($userAnswer)) {
                $userAnswer = reset($userAnswer);
                echo "<p>User's Answer: $userAnswer->selectedOption</p>";
            }
            ?>
        <?php } ?>
        <br><br>
        <input type="submit" value="Submit">
        </form>
    </div>

</body>

</html>
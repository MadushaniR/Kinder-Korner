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
        <form method="post" action="<?php echo base_url(); ?>index.php/Questions/resultdisplay?quizID=<?= $quizID ?>">
            <p>Quiz Number: <?= $quizID ?></p>
            <?php foreach ($questions as $row) { ?>
                <p><?= $row->questionID ?>.<?= $row->questionText ?></p>
                <input type="radio" name="selectedOption<?= $row->questionID ?>" value="<?= $row->option1 ?>" required><?= $row->option1 ?><br>
                <input type="radio" name="selectedOption<?= $row->questionID ?>" value="<?= $row->option2 ?>"><?= $row->option2 ?><br>
                <input type="radio" name="selectedOption<?= $row->questionID ?>" value="<?= $row->option3 ?>"><?= $row->option3 ?><br>
                <input type="radio" name="selectedOption<?= $row->questionID ?>" value="<?= $row->option4 ?>"><?= $row->option4 ?><br>

                <!-- Add hidden fields to store questionID -->
                <input type="hidden" name="questionID<?= $row->questionID ?>" value="<?= $row->questionID ?>">
            <?php } ?>
            <br><br>
            <input type="submit" value="Submit">
             <!-- Add a button to go to the home page -->
             <a href="<?php echo base_url(); ?>index.php/Auth/main"><button type="button">Go to Home Page</button></a>
        </form>
    </div>
</body>

</html>
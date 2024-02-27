<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Play Quiz</title>
    <script>
        function selectOption(button) {
            const questionID = button.getAttribute('data-question');
            const selectedOption = button.getAttribute('data-value');

            // Set the selected option in the hidden input field
            const hiddenInput = document.getElementById('selectedOption' + questionID);
            if (hiddenInput) {
                hiddenInput.value = selectedOption;
            }
        }
    </script>
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
                <button type="button" class="optionButton" onclick="selectOption(this)" data-question="<?= $row->questionID ?>" data-value="<?= $row->option1 ?>"><?= $row->option1 ?></button>
                <button type="button" class="optionButton" onclick="selectOption(this)" data-question="<?= $row->questionID ?>" data-value="<?= $row->option2 ?>"><?= $row->option2 ?></button>
                <button type="button" class="optionButton" onclick="selectOption(this)" data-question="<?= $row->questionID ?>" data-value="<?= $row->option3 ?>"><?= $row->option3 ?></button>
                <button type="button" class="optionButton" onclick="selectOption(this)" data-question="<?= $row->questionID ?>" data-value="<?= $row->option4 ?>"><?= $row->option4 ?></button>

                <!-- Add hidden fields to store questionID and selectedOption -->
                <input type="hidden" name="questionID<?= $row->questionID ?>" value="<?= $row->questionID ?>">
                <input type="hidden" name="selectedOption<?= $row->questionID ?>" id="selectedOption<?= $row->questionID ?>">
            <?php } ?>
            <br><br>
            <input type="submit" value="Submit">
            <!-- Add a button to go to the home page -->
            <a href="<?php echo base_url(); ?>index.php/Auth/main"><button type="button">Go to Home Page</button></a>
        </form>
    </div>
</body>

</html>
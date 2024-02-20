<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Create New Quiz</title>
    <!-- Include Toastr.js -->
    <script src="path/to/toastr.min.js"></script>
    <link rel="stylesheet" href="path/to/toastr.min.css">
</head>

<body>
    <h1>Create New Quiz</h1>

    <?php echo form_open('questions/createquiz'); ?>
    
    <label for="question">Question:</label>
    <input type="text" name="question" required>

    <label for="choice1">Choice 1:</label>
    <input type="text" name="choice1" required>

    <label for="choice2">Choice 2:</label>
    <input type="text" name="choice2" required>

    <label for="choice3">Choice 3:</label>
    <input type="text" name="choice3" required>

    <label for="answer">Answer:</label>
    <input type="text" name="answer" required>

    <label for="quizNumber">Quiz Number:</label>
    <input type="text" name="quizNumber" required>

    <input type="submit" value="Create Quiz">

    <?php echo form_close(); ?>

    <script>
        // Display success or fail message using Toastr.js
        <?php
        if ($this->session->flashdata('success')) {
            echo "toastr.success('" . $this->session->flashdata('success') . "');";
        } elseif ($this->session->flashdata('error')) {
            echo "toastr.error('" . $this->session->flashdata('error') . "');";
        }
        ?>
    </script>
</body>

</html>
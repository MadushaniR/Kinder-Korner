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

    <label for="quizName">Quiz Name:</label>
    <input type="text" name="quizName" required>

    <label for="quizDescription">Quiz Description:</label>
    <textarea name="quizDescription" required></textarea>

    <div id="questions-container">
        <!-- This div provides space for a single set of question and answers -->
        <div class="question">
            <label for="question">Question:</label>
            <input type="text" name="question[]" required>

            <label for="choice1">Choice 1:</label>
            <input type="text" name="choice1[]" required>

            <label for="choice2">Choice 2:</label>
            <input type="text" name="choice2[]" required>

            <label for="choice3">Choice 3:</label>
            <input type="text" name="choice3[]" required>

            <label for="choice4">Choice 4:</label>
            <input type="text" name="choice4[]" required>

            <label for="answer">Correct Answer:</label>
            <input type="text" name="answer[]" required>
        </div>
    </div>

    <button type="button" onclick="addQuestion()">Add More</button>

    <input type="submit" value="Create Quiz">

    <?php echo form_close(); ?>

    <script>
        function addQuestion() {
            // Create a new div for a set of question and answers
            var newQuestionDiv = document.createElement('div');
            newQuestionDiv.className = 'question';

            // Define HTML structure for the set
            newQuestionDiv.innerHTML = `
                <label for="question">Question:</label>
                <input type="text" name="question[]" required>

                <label for="choice1">Choice 1:</label>
                <input type="text" name="choice1[]" required>

                <label for="choice2">Choice 2:</label>
                <input type="text" name="choice2[]" required>

                <label for="choice3">Choice 3:</label>
                <input type="text" name="choice3[]" required>

                <label for="choice4">Choice 4:</label>
                <input type="text" name="choice4[]" required>

                <label for="answer">Correct Answer:</label>
                <input type="text" name="answer[]" required>
            `;

            // Append the new set to the container
            document.getElementById('questions-container').appendChild(newQuestionDiv);
        }

        // Display success or fail message using Toastr.js
        <?php
        if ($this->session->flashdata('success')) {
            echo "toastr.success('" . $this->session->flashdata('success') . "');";
        } elseif ($this->session->flashdata('error')) {
            echo "toastr.error('" . $this->session->flashdata('error') . "');";
        }
        ?>
    </script>

    <h2>Quiz Details</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Username</th>
                <th>Quiz Name</th>
                <th>Quiz Description</th>
                <th>Question</th>
                <th>Choice 1</th>
                <th>Choice 2</th>
                <th>Choice 3</th>
                <th>Choice 4</th>
                <th>Correct Answer</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($quizzes as $quiz) : ?>
                <tr>
                    <td><?= $quiz->username ?></td>
                    <td><?= $quiz->quizName ?></td>
                    <td><?= $quiz->quizDescription ?></td>
                    <td><?= $quiz->questionText ?></td>
                    <td><?= $quiz->option1 ?></td>
                    <td><?= $quiz->option2 ?></td>
                    <td><?= $quiz->option3 ?></td>
                    <td><?= $quiz->option4 ?></td>
                    <td><?= $quiz->correctAnswer ?></td>

                    
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="<?php echo base_url(); ?>index.php/Auth/main"><button type="button">Go to Home Page</button></a>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Create New Quiz</title>
    <!-- Include Toastr.js -->
    <script src="path/to/toastr.min.js"></script>
    <link rel="stylesheet" href="path/to/toastr.min.css">
    <script src="path/to/toastr.min.js"></script>
    <link rel="stylesheet" href="path/to/toastr.min.css">

    <!-- Add jQuery for handling AJAX requests -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="<?php echo site_url(); ?>assets/all.css">
    <link rel="stylesheet" href="<?php echo site_url(); ?>assets/toast/toast.min.css">
    <script src="<?php echo site_url(); ?>assets/toast/jqm.js"></script>
    <script src="<?php echo site_url(); ?>assets/toast/toast.js"></script>
    <style>
        .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }
        body {
			background-image: url(<?php echo base_url('assets/images/bg.jpg'); ?>);
			background-size: cover;
			background-position: center top;

		}
    </style>
</head>

<body>
    <h1>Create New Quiz</h1>

    <?php echo form_open('QuizManage/createquiz'); ?>

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
        function editRow(questionID) {
            // Create a popup with close button and content "Hi"
            var popupDiv = document.createElement('div');
            popupDiv.className = 'popup';

            // Define HTML structure for the popup
            popupDiv.innerHTML = `
        <div id="editQuestionForm">
            <label for="editQuizName">Quiz Name:</label>
            <input type="text" name="editQuizName" id="editQuizName" required>

            <label for="editQuizDescription">Quiz Description:</label>
            <textarea name="editQuizDescription" id="editQuizDescription" required></textarea>

            <label for="editQuestion">Question:</label>
            <input type="text" name="editQuestion" id="editQuestion" required>

            <label for="editChoice1">Choice 1:</label>
            <input type="text" name="editChoice1" id="editChoice1" required>

            <label for="editChoice2">Choice 2:</label>
            <input type="text" name="editChoice2" id="editChoice2" required>

            <label for="editChoice3">Choice 3:</label>
            <input type="text" name="editChoice3" id="editChoice3" required>

            <label for="editChoice4">Choice 4:</label>
            <input type="text" name="editChoice4" id="editChoice4" required>

            <label for="editCorrectAnswer">Correct Answer:</label>
            <input type="text" name="editCorrectAnswer" id="editCorrectAnswer" required>

            <!-- Add a hidden input field to store the question ID in the form -->
            <input type="hidden" name="editQuestionID" id="editQuestionID" value="${questionID}">

            <button onclick="saveChanges()">Save Changes</button>
            <button onclick="closePopup()">Close</button>
        </div>
    `;

            // Append the popup to the body
            document.body.appendChild(popupDiv);

            // Fetch the data from the URL
            $.ajax({
                type: 'GET',
                url: 'http://localhost/Kinder-Korner/QuizDisplay/getQuestionDetails/' + questionID,
                dataType: 'json',
                success: function(data) {
                    // Populate the popup form with the retrieved values
                    $('#editQuizName').val(data.quizName);
                    $('#editQuizDescription').val(data.quizDescription);
                    $('#editQuestion').val(data.questionText);
                    $('#editChoice1').val(data.option1);
                    $('#editChoice2').val(data.option2);
                    $('#editChoice3').val(data.option3);
                    $('#editChoice4').val(data.option4);
                    $('#editCorrectAnswer').val(data.correctAnswer);
                },
                error: function() {
                    toastr.error('Error fetching question details.');
                }
            });
        }

        function closePopup() {
            // Remove the popup from the body
            var popup = document.querySelector('.popup');
            if (popup) {
                popup.parentNode.removeChild(popup);
            }
        }

        function deleteRow(questionID) {
            if (confirm("Are you sure you want to delete this question and its options?")) {
                // Make an AJAX request to delete the question and options from the database
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Reload the page or update the table
                        window.location.reload();
                    }
                };
                xhttp.open("GET", "<?= base_url('QuizManage/deleteQuestion/') ?>" + questionID, true);
                xhttp.send();
            }
        }

        function saveChanges() {
            // Retrieve edited values from the popup form
            var editedQuizName = $('#editQuizName').val();
            var editedQuizDescription = $('#editQuizDescription').val();
            var editedQuestion = $('#editQuestion').val();
            var editedChoice1 = $('#editChoice1').val();
            var editedChoice2 = $('#editChoice2').val();
            var editedChoice3 = $('#editChoice3').val();
            var editedChoice4 = $('#editChoice4').val();
            var editedCorrectAnswer = $('#editCorrectAnswer').val();
            var questionID = $('#editQuestionID').val();

            // Create an object with the edited data
            var editedData = {
                quizName: editedQuizName,
                quizDescription: editedQuizDescription,
                question: editedQuestion,
                choice1: editedChoice1,
                choice2: editedChoice2,
                choice3: editedChoice3,
                choice4: editedChoice4,
                correctAnswer: editedCorrectAnswer
            };

            // Make an AJAX request to update the data in the database
            $.ajax({
                type: 'POST', // Use POST method for updating data
                url: 'http://localhost/Kinder-Korner/QuizManage/updateQuestion/' + questionID,
                dataType: 'json',
                data: editedData,
                success: function(response) {
                    // Close the popup after successful update
                    closePopup();

                    // Display success message using Toastr.js
                    toastr.success('Question details updated successfully!');

                    // Optionally, you can update the table or reload the page
                    window.location.reload();
                },
                error: function() {
                    // Display an error message using Toastr.js
                    toastr.error('Error updating question details.');
                }
            });
        }

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
                <th>Action</th>
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
                    <td>
                        <button onclick="editRow(<?= $quiz->questionID ?>)">Edit</button>
                        <button onclick="deleteRow(<?= $quiz->questionID ?>)">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="<?php echo base_url(); ?>index.php/Auth/main"><button type="button">Go to Home Page</button></a>

</body>

</html>
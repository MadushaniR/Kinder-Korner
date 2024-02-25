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
    </style>
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
        function showAlert(message, type) {
            alert(type.toUpperCase() + ': ' + message);
        }

        // Display success or fail message using alert
        <?php
        if ($this->session->flashdata('success')) {
            echo "showAlert('" . $this->session->flashdata('success') . "', 'success');";
        } elseif ($this->session->flashdata('error')) {
            echo "showAlert('" . $this->session->flashdata('error') . "', 'error');";
        }
        ?>
    </script>

    <script>
        // function editRow(questionID) {

        //     // Create a popup with close button and content "Hi"
        //     var popupDiv = document.createElement('div');
        //     popupDiv.className = 'popup';

        //     // Define HTML structure for the popup
        //     popupDiv.innerHTML = `
        //     <div>
        //     <label for="quizName">Quiz Name:</label>
        //     <input type="text" name="quizName"  required>

        //     <label for="quizDescription">Quiz Description:</label>
        //     <textarea name="quizDescription" required></textarea>

        //     <label for="question">Question:</label>
        //     <input type="text" name="question" required>

        //     <label for="choice1">Choice 1:</label>
        //     <input type="text" name="choice1"  required>

        //     <label for="choice2">Choice 2:</label>
        //     <input type="text" name="choice2"  required>

        //     <label for="choice3">Choice 3:</label>
        //     <input type="text" name="choice3"  required>

        //     <label for="choice4">Choice 4:</label>
        //     <input type="text" name="choice4"  required>

        //     <label for="correctAnswer">Correct Answer:</label>
        //     <input type="text" name="correctAnswer"  required>
        //         <button onclick="closePopup()">Close</button>
        //     </div>
        // `;

        //     // Append the popup to the body
        //     document.body.appendChild(popupDiv);


        //     //alert('Hi! This is a popup message.');
        //     // Fetch the current values for the questionID and populate the popup form
        //     $.ajax({
        //         type: 'GET',
        //         url: '<?= base_url("questions/getQuestionDetails/") ?>' + questionID,
        //         dataType: 'json',
        //         success: function(data) {
        //             // Populate the popup form with the current values
        //             $('#editQuestionID').val(data.questionID);
        //             $('#editQuestionText').val(data.questionText);
        //             $('#editChoice1').val(data.option1);
        //             $('#editChoice2').val(data.option2);
        //             $('#editChoice3').val(data.option3);
        //             $('#editChoice4').val(data.option4);
        //             $('#editCorrectAnswer').val(data.correctAnswer);

        //             // Show the popup form
        //             $('#editQuestionModal').modal('show');
        //         },
        //         error: function() {
        //             toastr.error('Error fetching question details.');
        //         }
        //     });
        // }

        function editRow(questionID) {
    // Create a popup with close button and content "Hi"
    var popupDiv = document.createElement('div');
    popupDiv.className = 'popup';

    // Define HTML structure for the popup
    popupDiv.innerHTML = `
        <div>
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

            <button onclick="closePopup()">Close</button>
        </div>
    `;

    // Append the popup to the body
    document.body.appendChild(popupDiv);

    // Fetch the data from the URL
    $.ajax({
        type: 'GET',
        url: 'http://localhost/Kinder-Korner/questions/getQuestionDetails/' + questionID,
        dataType: 'json',
        success: function (data) {
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
        error: function () {
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
                xhttp.open("GET", "<?= base_url('questions/deleteQuestion/') ?>" + questionID, true);
                xhttp.send();
            }
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
    <script>
        function updateQuestion() {
            // Perform AJAX request to update the question in the database
            $.ajax({
                type: 'POST',
                url: '<?= base_url("questions/updateQuestion/") ?>',
                data: $('#editQuestionForm').serialize(),
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        // Close the modal after successful update
                        $('#editQuestionModal').modal('hide');
                        // Reload the page or update the table as needed
                        window.location.reload();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function() {
                    toastr.error('Error updating question.');
                }
            });
        }
    </script>
</body>

</html>
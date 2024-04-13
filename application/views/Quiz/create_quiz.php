<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Create New Quiz</title>
    <!-- Include SweetAlert library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 5%;
        }

        th,
        td {
            border: 10px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            cursor: pointer;
        }

        th:hover {
            background-color: #f2f2f2;
        }

        .manage-quiz th {
            border-width: 2px;
            background-color: #ffffe6;
        }

        .manage-quiz td {
            border-width: 2px;
        }

        .manage-quiz tr {
            border-width: 2px;
        }

        .add-container {
            width: 97%;
            margin-left: 1%;
            margin-right: auto;

        }

        .add-container label {
            font-size: 20px;
            font-weight: 600;

        }

        .add-container input {
            border: 2px solid lightblue;
            box-shadow: 0 0 5px lightblue;
            padding: 6px;
            margin-bottom: 10px;
        }

        .add-container textarea {
            border: 2px solid lightblue;
            box-shadow: 0 0 5px lightblue;
            padding: 6px;
            margin-bottom: 10px;
        }

        .add-container button {
            padding: 10px 20px;
            /* Add padding to the buttons */
            margin: 10px 0;
            /* Add margin to create space between buttons */
            background-color: #5DADE2;
            /* Set background color */
            color: white;
            /* Set text color */
            border: none;
            /* Remove border */
            border-radius: 5px;
            /* Add border radius */
            cursor: pointer;
            /* Add pointer cursor on hover */
        }

        .add-container button:hover {
            background-color: #7dbde8;
            /* Change background color on hover */
        }

        .add-container input[type="submit"] {
            padding: 10px 20px;
            /* Add padding to the submit button */
            margin: 10px 0;
            /* Add margin to create space */
            background-color: #ff4d88;
            /* Set background color */
            color: white;
            /* Set text color */
            border: none;
            /* Remove border */
            border-radius: 5px;
            /* Add border radius */
            cursor: pointer;
            /* Add pointer cursor on hover */
        }

        .add-container input[type="submit"]:hover {
            background-color: #ff80aa;
            /* Change background color on hover */
        }
    </style>
</head>

<body>
    <header>
        <?php $this->load->view('Comman/header'); ?>
    </header>
    <!-- <h1>Manage Quiz</h1> -->

    <?php echo form_open('QuizManage/createquiz'); ?>

    <div class=add-container>
        <label for="quizName">Quiz Name:</label>
        <input type="text" name="quizName" required style="width: 30%;">

        <label for="quizDescription">Quiz Description:</label>
        <input type="text" name="quizDescription" required style="width: 48%;">

        <div id="questions-container">
            <!-- This div provides space for a single set of question and answers -->
            <div class="question">
                <label for="question">Question:</label>
                <input type="text" name="question[]" required style="width: 90%;"><br>

                <label for="answer">Correct Answer:</label>
                <input type="text" name="answer[]" required style="width: 10%;">

                <label for="choice1">Choice 1:</label>
                <input type="text" name="choice1[]" required>

                <label for="choice2">Choice 2:</label>
                <input type="text" name="choice2[]" required>

                <label for="choice3">Choice 3:</label>
                <input type="text" name="choice3[]" required>

                <label for="choice4">Choice 4:</label>
                <input type="text" name="choice4[]" required>
                <hr>
            </div>
        </div>

        <button type="button" onclick="addQuestion()">+ Add More </button>

        <input type="submit" value="Create Quiz">
    </div>

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
                    // Display an error message using Swal
                    Swal.fire('Error', 'Error fetching question details.', 'error');
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
                        // Display success message using Swal
                        Swal.fire('Success', 'Question deleted successfully!', 'success');
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

                    // Display success message using Swal
                    Swal.fire('Success', 'Question details updated successfully!', 'success');

                    // Optionally, you can update the table or reload the page
                    window.location.reload();
                },
                error: function() {
                    // Display an error message using Swal
                    Swal.fire('Error', 'Error updating question details.', 'error');
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

        // Display success or fail message using Swal
        <?php
        if ($this->session->flashdata('success') && strpos($this->session->flashdata('success'), 'Quiz created') === false) {
            echo "Swal.fire('Success', '" . $this->session->flashdata('success') . "', 'success');";
        } elseif ($this->session->flashdata('error')) {
            echo "Swal.fire('Error', '" . $this->session->flashdata('error') . "', 'error');";
        }
        ?>
    </script>

    <h2>Quiz Details</h2>
    <table class="manage-quiz">
        <thead>
            <tr>
                <th onclick="sortTable(0)">Username</th>
                <th onclick="sortTable(1)">Quiz Name</th>
                <th onclick="sortTable(2)">Quiz Description</th>
                <th onclick="sortTable(3)">Question</th>
                <th onclick="sortTable(4)">Choice 1</th>
                <th onclick="sortTable(5)">Choice 2</th>
                <th onclick="sortTable(6)">Choice 3</th>
                <th onclick="sortTable(7)">Choice 4</th>
                <th onclick="sortTable(8)">Correct Answer</th>
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
                        <button onclick="editRow(<?= $quiz->questionID ?>)">
                            <img src="<?php echo base_url('assets/images/edit.png'); ?>" alt="Edit" style="width:35px; height:35px">
                        </button>
                        <button onclick="deleteRow(<?= $quiz->questionID ?>)">
                            <img src="<?php echo base_url('assets/images/delete.png'); ?>" alt="Delete" style="width:35px; height:35px">
                        </button>

                        <!-- <button onclick="editRow(<?= $quiz->questionID ?>)">Edit</button>
                        <button onclick="deleteRow(<?= $quiz->questionID ?>)">Delete</button> -->
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


    <!-- <a href="<?php echo base_url(); ?>index.php/Auth/main"><button type="button">Go to Home Page</button></a> -->

    <script>
        function sortTable(n) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.querySelector("table");
            switching = true;
            dir = "asc";
            while (switching) {
                switching = false;
                rows = table.rows;
                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("td")[n];
                    y = rows[i + 1].getElementsByTagName("td")[n];
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchcount++;
                } else {
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }

            // Remove all arrow symbols from table headers
            var headers = table.querySelectorAll("th");
            headers.forEach(header => {
                header.innerHTML = header.innerHTML.replace(/ ▲| ▼/g, '');
            });

            // Add arrow symbol to the sorted column header
            var arrow = dir === 'asc' ? ' ▲' : ' ▼';
            headers[n].innerHTML += arrow;
        }
    </script>
</body>

</html>
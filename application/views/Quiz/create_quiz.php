<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quiz Management</title>
    <link href="https://cdn.datatables.net/v/dt/dt-2.0.7/datatables.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Comic Sans MS', cursive, sans-serif;
            background-image: url(<?php echo base_url('assets/images/5555.png'); ?>);
            background-size: cover;
            background-position: center top;
            /* margin: 0;
            padding: 0;
            background-color: #f9f9f9; */
        }

        .container {
            /* margin: 20px; */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #add8e6;
            color: #333;
        }

        tr:hover {
            background-color: #e0ffff;
        }

        .action-buttons img {
            width: 35px;
            height: 35px;
            cursor: pointer;
        }

        .form-popup {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            border: 3px solid #f1f1f1;
            z-index: 9;
            padding: 20px;
            background-color: white;
            max-height: 90%;
            overflow-y: auto;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            width: 50%; 
        }

        .form-popup h2 {
            margin-top: 0;
            color: #6a5acd;
        }

        .form-popup label {
            font-size: 16px;
        }

        .form-popup input[type="text"],
        .form-popup input[type="email"] {
            width: calc(100% - 24px);
            padding: 12px;
            margin: 8px 0;
            border: 2px solid #87cefa;
            border-radius: 10px;
            background-color: #f0f8ff;
            font-size: 16px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .form-popup input[type="text"]:focus,
        .form-popup input[type="email"]:focus {
            border-color: #00bfff;
            box-shadow: 0 0 8px #00bfff;
            outline: none;
        }

        .form-popup button {
            background-color: #ff3399;
            color: white;
            padding: 12px 20px;
            border: none;
            cursor: pointer;
            border-radius: 10px;
            font-size: 16px;
            margin-top: 10px;
            opacity: 0.8;
        }

        .form-popup button[type="button"] {
            background-color: #00aaff;
            opacity: 0.8;
        }

        .form-popup button:hover {
            opacity: 0.9;
        }

        .form-popup button[type="button"]:hover {
            opacity: 0.9;
        }

        .question-group {
            border: 1px solid #87cefa;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 10px;
            background-color: #f0f8ff;
        }

        .create-btn {
            font-family: 'Comic Sans MS', cursive, sans-serif;
            background-color:#66ccff;
            /* border: none; */
            color: black;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            font-size: 20px;
            padding: 5px;
            margin-left: 76%;
            border-radius: 20px;
            width: 10%;
        }

        .create-btn:hover {
            background-color: #00aaff;
        }
        .add{
            background-color: #00aaff;
            color: #e0ffff;
        }
        .create{
            background-color: #ff4da6;
            color: #e0ffff;
        }
        .cancel{
            background-color: #00b3b3;
            color: #e0ffff;

        }
    </style>
   
</head>

<body>
    <header>
        <?php $this->load->view('Comman/header'); ?>
    </header>
    <div>
    <button onclick="openForm()" class="create-btn"> + New</button>
    </div>

    <div class="container">
     
        <table id="quizTable" class="display">
            <thead>
                <tr>
                    <th>Quiz Name</th>
                    <th>Quiz Description</th>
                    <th>Question Text</th>
                    <th>Correct Answer</th>
                    <th>Option 1</th>
                    <th>Option 2</th>
                    <th>Option 3</th>
                    <th>Option 4</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($quizData as $quiz) : ?>
                    <tr>
                        <td><?php echo $quiz['quizName']; ?></td>
                        <td><?php echo $quiz['quizDescription']; ?></td>
                        <td><?php echo $quiz['questionText']; ?></td>
                        <td><?php echo $quiz['correctAnswer']; ?></td>
                        <td><?php echo $quiz['option1']; ?></td>
                        <td><?php echo $quiz['option2']; ?></td>
                        <td><?php echo $quiz['option3']; ?></td>
                        <td><?php echo $quiz['option4']; ?></td>
                        <td>
                            <div class="action-buttons">
                                <img src="<?php echo base_url('assets/images/edit.png'); ?>" alt="Edit" onclick="editRow(<?php echo $quiz['questionID']; ?>)">
                                <img src="<?php echo base_url('assets/images/delete.png'); ?>" alt="Delete" onclick="deleteRow(<?php echo $quiz['questionID']; ?>)">
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="form-popup" id="createForm">
        <h2>Create New Quiz</h2>
        <form id="quizForm">
            <label for="quizName">Quiz Name:</label><br>
            <input type="text" id="quizName" name="quizName" required><br>
            <label for="quizDescription">Quiz Description:</label><br>
            <input type="text" id="quizDescription" name="quizDescription" required><br>

            <div id="questionsContainer">
                <div class="question-group">
                    <label for="questionText[]">Question:</label><br>
                    <input type="text" id="questionText" name="questionText[]" required><br>
                    <label for="correctAnswer[]">Correct Answer:</label><br>
                    <input type="text" id="correctAnswer" name="correctAnswer[]" required><br>
                    <label for="option1[]">Option 1:</label><br>
                    <input type="text" id="option1" name="option1[]" required><br>
                    <label for="option2[]">Option 2:</label><br>
                    <input type="text" id="option2" name="option2[]" required><br>
                    <label for="option3[]">Option 3:</label><br>
                    <input type="text" id="option3" name="option3[]" required><br>
                    <label for="option4[]">Option 4:</label><br>
                    <input type="text" id="option4" name="option4[]" required><br>
                </div>
            </div>

            <button type="button" class="add" onclick="addQuestion()">Add Another Question</button>
            <button type="submit" class="create">Create Quiz</button>
            <button type="button" onclick="closeForm()" class="cancel">Cancel</button>
        </form>
    </div>

    <div class="form-popup" id="editForm">
        <h2>Edit Quiz</h2>
        <form id="editQuizForm">
            <input type="hidden" id="editQuestionID" name="questionID">
            <label for="editQuizName">Quiz Name:</label><br>
            <input type="text" id="editQuizName" name="quizName" required><br>
            <label for="editQuizDescription">Quiz Description:</label><br>
            <input type="text" id="editQuizDescription" name="quizDescription" required><br>

            <label for="editQuestionText">Question:</label><br>
            <input type="text" id="editQuestionText" name="questionText[]" required><br>
            <label for="editCorrectAnswer">Correct Answer:</label><br>
            <input type="text" id="editCorrectAnswer" name="correctAnswer[]" required><br>
            <label for="editOption1">Option 1:</label><br>
            <input type="text" id="editOption1" name="option1[]" required><br>
            <label for="editOption2">Option 2:</label><br>
            <input type="text" id="editOption2" name="option2[]" required><br>
            <label for="editOption3">Option 3:</label><br>
            <input type="text" id="editOption3" name="option3[]" required><br>
            <label for="editOption4">Option 4:</label><br>
            <input type="text" id="editOption4" name="option4[]" required><br>

            <button type="submit">Save Changes</button>
            <button type="button" onclick="closeEditForm()">Cancel</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.0.7/datatables.min.js"></script>
    <script>
        function openForm() {
            document.getElementById("createForm").style.display = "block";
        }

        function closeForm() {
            document.getElementById("createForm").style.display = "none";
        }

        function closeEditForm() {
            document.getElementById("editForm").style.display = "none";
        }

        function addQuestion() {
            var questionHTML = `
                <div class="question-group">
                    <label for="questionText[]">Question:</label><br>
                    <input type="text" name="questionText[]" required><br>
                    <label for="correctAnswer[]">Correct Answer:</label><br>
                    <input type="text" name="correctAnswer[]" required><br>
                    <label for="option1[]">Option 1:</label><br>
                    <input type="text" name="option1[]" required><br>
                    <label for="option2[]">Option 2:</label><br>
                    <input type="text" name="option2[]" required><br>
                    <label for="option3[]">Option 3:</label><br>
                    <input type="text" name="option3[]" required><br>
                    <label for="option4[]">Option 4:</label><br>
                    <input type="text" name="option4[]" required><br>
                </div>
            `;
            $('#questionsContainer').append(questionHTML);
        }

        function editRow(questionID) {
            $.ajax({
                url: '<?php echo base_url('index.php/QuizManage/get_question_details'); ?>',
                method: 'POST',
                data: {
                    questionID: questionID
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        var questionDetails = response.data;
                        $('#editQuestionID').val(questionDetails.questionID);
                        $('#editQuizName').val(questionDetails.quizName);
                        $('#editQuizDescription').val(questionDetails.quizDescription);
                        $('#editQuestionText').val(questionDetails.questionText);
                        $('#editCorrectAnswer').val(questionDetails.correctAnswer);
                        $('#editOption1').val(questionDetails.option1);
                        $('#editOption2').val(questionDetails.option2);
                        $('#editOption3').val(questionDetails.option3);
                        $('#editOption4').val(questionDetails.option4);
                        $('#editForm').show();
                    } else {
                        alert('Failed to fetch question details.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        $('#editQuizForm').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '<?php echo base_url('index.php/QuizManage/update_question'); ?>',
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        alert('Question updated successfully');
                        location.reload();
                    } else {
                        alert('Failed to update question.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

        function deleteRow(questionID) {
            if (confirm("Are you sure you want to delete this question?")) {
                $.ajax({
                    url: '<?php echo base_url('index.php/QuizManage/delete_question'); ?>',
                    method: 'POST',
                    data: {
                        questionID: questionID
                    },
                    success: function(response) {
                        window.location.reload();
                        alert(response.message);
                        $('#quizTable').DataTable().ajax.reload();
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        }

        $(document).ready(function() {
            $.ajax({
                url: '<?php echo base_url('index.php/QuizManage/quiz_data'); ?>',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    var table = $('#quizTable').DataTable({
                        data: data,
                        columns: [{
                                data: 'quizName',
                                orderable: true
                            },
                            {
                                data: 'quizDescription',
                                orderable: true
                            },
                            {
                                data: 'questionText',
                                orderable: true
                            },
                            {
                                data: 'correctAnswer',
                                orderable: true
                            },
                            {
                                data: 'option1',
                                orderable: true
                            },
                            {
                                data: 'option2',
                                orderable: true
                            },
                            {
                                data: 'option3',
                                orderable: true
                            },
                            {
                                data: 'option4',
                                orderable: true
                            },
                            {
                                data: null,
                                render: function(data, type, row) {
                                    return '<div class="action-buttons">' +
                                        '<img src="<?php echo base_url('assets/images/edit.png'); ?>" alt="Edit" onclick="editRow(' + row.questionID + ')">' +
                                        '<img src="<?php echo base_url('assets/images/delete.png'); ?>" alt="Delete" onclick="deleteRow(' + row.questionID + ')">' +
                                        '</div>';
                                }
                            }
                        ]
                    });
                }
            });

            $('#quizForm').submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: '<?php echo base_url('index.php/QuizManage/create_quiz'); ?>',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        window.location.reload();
                        closeForm();
                        $('#quizTable').DataTable().ajax.reload();
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>

</html>

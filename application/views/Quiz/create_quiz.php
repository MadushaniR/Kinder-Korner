<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Quiz</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
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

        .wrapper {
            padding: 100px;
        }
        /* Add this CSS to make the labels larger and bold */
label {
    font-size: 20px;
    font-weight: bold;
}

        /* Add this CSS to make the table headers larger and bold */
#quizTable th {
    font-size: larger;
    font-weight: bold;
    background-color: #e6ffff;
}
/* Add this CSS to make the pagination text larger and bold */
#quizTable_info, #quizTable_previous, #quizTable_next {
    font-size: larger;
    font-weight: bold;
}

.question {
    margin-bottom: 20px;
}

.question label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    font-size: larger;
}

.question input[type="text"] {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: larger;
    margin-bottom: 10px;
}

.question input[type="text"]:focus {
    outline: none;
    border-color: dodgerblue;
    box-shadow: 0 0 5px dodgerblue;
}



    </style>
</head>

<body>
    <header>
        <?php $this->load->view('Comman/header'); ?>
    </header>
    <div class="wrapper">
        <h1>Manage Quiz</h1>
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
        <script>
            $(document).ready(function() {
                $('#quizTable').DataTable();
            });
        </script>
        <h2>Quiz Details</h2>
        <table id="quizTable" class="table table-bordered">
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
        <!-- <a href="<?php echo base_url(); ?>index.php/Auth/main"><button type="button">Go to Home Page</button></a> -->
    </div>
</body>

</html>
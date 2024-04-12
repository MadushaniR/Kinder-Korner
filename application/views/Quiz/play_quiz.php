<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Play Quiz</title>

    <style>
        .question-container {
            display: none;
        }

        .question-container.active {
            display: block;
        }

        .optionButton.selected {
            background-color: blue;
            color: white;
        }

        body {
            background-image: url(<?php echo base_url('assets/images/bg.jpg'); ?>);
            background-size: cover;
            background-position: center;
        }

        .top-bottons {
            display: grid;
            grid-template-columns: auto auto;
            grid-gap: 10px;
            margin-bottom: 20px;
            margin-top: 20px;
        }

        #prevButton,
        #nextButton {
            background-color: yellow;
            padding: 10px;
            border-radius: 5px;
            font-size: 20px;
            width: fit-content;
            cursor: pointer;
            margin-left: 25%;
        }

        #nextButton {
            background-color: yellow;
            margin-left: 55%;
            padding: 10px;
            border-radius: 5px;
            width: 20%;
            font-size: 20px;
        }

        */ #container {
            width: 50%;
            margin-top: 100px;
            margin-left: auto;
            margin-right: auto;
            border: 2px solid black;
            /* padding: 20px; */
        }

        .question-box {
            width: 100%;
            background-color: white;
            margin-top: 10px;
            margin-bottom: 10px;
            padding-top: 15px;
            padding-bottom: 10px;
            color: black;
            /* padding: 5px; */
            text-align: center;
            font-size: 30px;
            font-weight: bold;
        }

        .options-grid {
            width: 80%;
            margin-top: 10%;
            margin-left: auto;
            margin-right: auto;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-gap: 25px;
            align-items: center;
            justify-items: center;
        }

        .optionButton {
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 15px;
            font-size: 25px;
            border-radius: 50px;
            border-width: 3px;
        }

        .optionButton.option1 {
            background-color: #EEAAAB;
        }

        .optionButton.option2 {
            background-color: #86D1EE;
        }

        .optionButton.option3 {
            background-color: #B2D531;
        }

        .optionButton.option4 {
            background-color: #CA82E6;
        }

        .submit-btn {
            text-align: center;
            margin-top: 20px;
        }

        .submit-btn input[type="submit"] {
            background-color: red;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            font-size: 20px;
            cursor: pointer;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentPage = <?= $currentPage ?>; // Initialize currentPage with the value passed from the controller
            const totalQuestions = <?= count($questions) ?>; // Total number of questions

            function showQuestion(page) {
                const questions = document.querySelectorAll('.question-container');
                questions.forEach(function(question, index) {
                    question.style.display = index === page ? 'block' : 'none';
                });
            }


            function updateButtonsState() {
                // Enable or disable previous and next buttons based on the current page
                const prevButton = document.getElementById('prevButton');
                const nextButton = document.getElementById('nextButton');

                prevButton.disabled = currentPage === 0;
                nextButton.disabled = currentPage === totalQuestions - 1;
            }

            document.getElementById('nextButton').addEventListener('click', function() {
                if (currentPage < totalQuestions - 1) {
                    currentPage++;
                    showQuestion(currentPage);
                    updateButtonsState();
                }
            });

            document.getElementById('prevButton').addEventListener('click', function() {
                if (currentPage > 0) {
                    currentPage--;
                    showQuestion(currentPage);
                    updateButtonsState();
                }
            });

            showQuestion(currentPage);
            updateButtonsState();
        });

        function selectOption(button) {
            const questionID = button.getAttribute('data-question');
            const selectedOption = button.getAttribute('data-value');

            // Remove the "selected" class from all buttons in the same question
            const allButtons = document.querySelectorAll('.optionButton[data-question="' + questionID + '"]');
            allButtons.forEach(function(btn) {
                btn.classList.remove('selected');
            });

            // Add the "selected" class to the clicked button
            button.classList.add('selected');

            // Set the selected option in the hidden input field
            const hiddenInput = document.getElementById('selectedOption' + questionID);
            if (hiddenInput) {
                hiddenInput.value = selectedOption;
            }
        }
    </script>
</head>

<body>
    <header>
        <?php $this->load->view('Comman/header'); ?>
    </header>
    <div id="container">
        <form method="post" action="<?php echo base_url(); ?>index.php/Results/resultdisplay?quizID=<?= $quizID ?>">
            <div class=top-bottons>
                <button type="button" id="prevButton" <?= $currentPage === 0 ? 'disabled' : '' ?>>
                    << Previous </button>

                        <button type="button" id="nextButton" <?= $currentPage === count($questions) - 1 ? 'disabled' : '' ?>>Next >> </button>
            </div>
            <?php foreach ($questions as $row) { ?>
                <div class="question-container">
                    <div class="question-box">
                        <p><?= $row->questionText ?></p>
                    </div>
                    <div class="options-grid">
                        <!-- Option 1 -->
                        <button type="button" class="optionButton option1" onclick="selectOption(this)" data-question="<?= $row->questionID ?>" data-value="<?= $row->option1 ?>"><?= $row->option1 ?></button>
                        <!-- Option 2 -->
                        <button type="button" class="optionButton option2" onclick="selectOption(this)" data-question="<?= $row->questionID ?>" data-value="<?= $row->option2 ?>"><?= $row->option2 ?></button>
                        <!-- Option 3 -->
                        <button type="button" class="optionButton option3" onclick="selectOption(this)" data-question="<?= $row->questionID ?>" data-value="<?= $row->option3 ?>"><?= $row->option3 ?></button>
                        <!-- Option 4 -->
                        <button type="button" class="optionButton option4" onclick="selectOption(this)" data-question="<?= $row->questionID ?>" data-value="<?= $row->option4 ?>"><?= $row->option4 ?></button>
                    </div>

                    <!-- Updated: Use square brackets for array submission -->
                    <input type="hidden" name="questionID[]" value="<?= $row->questionID ?>">
                    <input type="hidden" name="selectedOption[<?= $row->questionID ?>]" id="selectedOption<?= $row->questionID ?>">
                </div>
            <?php } ?>
            <div class="submit-btn">
                <input type="submit" value="Submit">
            </div>
        </form>
    </div>
</body>

</html>
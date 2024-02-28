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

            function selectOption(button) {
                const questionID = button.getAttribute('data-question');
                const selectedOption = button.getAttribute('data-value');

                // Set the selected option in the hidden input field
                const hiddenInput = document.getElementById('selectedOption' + questionID);
                if (hiddenInput) {
                    hiddenInput.value = selectedOption;
                }
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

            // Set the selected option in the hidden input field
            const hiddenInput = document.getElementById('selectedOption' + questionID);
            if (hiddenInput) {
                hiddenInput.value = selectedOption;
            }
        }
    </script>

</head>

<body>
    <div id="container">
        <h1>Play Quiz!</h1>
        <h1>Welcome, <?= $user_name ?>!</h1>
        <h1>USER ID, <?= $userID ?>!</h1>
        <form method="post" action="<?php echo base_url(); ?>index.php/Questions/resultdisplay?quizID=<?= $quizID ?>">
            <p>Quiz Number: <?= $quizID ?></p>

            <?php foreach ($questions as $row) { ?>
                <div class="question-container">
                    <p><?= $row->questionID ?>.<?= $row->questionText ?></p>
                    <button type="button" class="optionButton" onclick="selectOption(this)" data-question="<?= $row->questionID ?>" data-value="<?= $row->option1 ?>"><?= $row->option1 ?></button>
                    <button type="button" class="optionButton" onclick="selectOption(this)" data-question="<?= $row->questionID ?>" data-value="<?= $row->option2 ?>"><?= $row->option2 ?></button>
                    <button type="button" class="optionButton" onclick="selectOption(this)" data-question="<?= $row->questionID ?>" data-value="<?= $row->option3 ?>"><?= $row->option3 ?></button>
                    <button type="button" class="optionButton" onclick="selectOption(this)" data-question="<?= $row->questionID ?>" data-value="<?= $row->option4 ?>"><?= $row->option4 ?></button>

                    <!-- Updated: Use square brackets for array submission -->
                    <input type="hidden" name="questionID[]" value="<?= $row->questionID ?>">
                    <input type="hidden" name="selectedOption[<?= $row->questionID ?>]" id="selectedOption<?= $row->questionID ?>">
                </div>
            <?php } ?>

            <br><br>
            <button type="button" id="prevButton" <?= $currentPage === 0 ? 'disabled' : '' ?>>Previous</button>
            <button type="button" id="nextButton" <?= $currentPage === count($questions) - 1 ? 'disabled' : '' ?>>Next</button>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>

</html>
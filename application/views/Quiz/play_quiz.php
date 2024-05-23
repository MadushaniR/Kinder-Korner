<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Play</title>
    <style>
        /* Kids-friendly CSS styles */
        body {
            background-image: url(<?php echo base_url('assets/images/bg.jpg'); ?>);
            background-size: cover;
            background-position: center bottom;
            margin: 0;
            font-family: 'Comic Sans MS', cursive, sans-serif;

        }

        /* h1 {
            color: #fff;
            font-size: 36px;
            margin-top: 0;
        } */

        #quiz-container {
            margin-top: 2%;
            /* border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); */
            /* padding: 3%;
            margin: 10% auto; */

        }

        .question {
            display: none;
        }

        .question.active {
            display: block;
        }

        .options {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-gap: 10px;
            margin-top: 11%;
            align-items: center;
            text-align: center;
            margin-left: 20%;
            margin-right: auto;
        }


        .option {
            background-color: #ffcc00;
            padding: 15px;
            font-size: 25px;
            border-radius: 50px;
            border-width: 3px;
            width: 50%;
            color: #333;
            cursor: pointer;
            font-size: 25px;
            margin-bottom: 3%;
            padding: 10px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        #btn1 {
            background-color: #EEAAAB;
        }

        #btn2 {
            background-color: #86D1EE;
        }

        #btn3 {
            background-color: #B2D531;
        }

        #btn4 {
            background-color: #CA82E6;
        }

        .option:hover {
            background-color: #ff9900;
        }

        .selected {
            background-color: #007bff;
            color: #fff;
        }

        /* #prev-question,
        #next-question,
        #submit-answers {
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            font-size: 18px;
            padding: 10px 20px;
            margin-right: 10px;
            transition: background-color 0.3s ease;
        } */

        #prev-question {
            font-family: 'Comic Sans MS', cursive, sans-serif;
            background-color: #ffff00;
            float: left;
            margin-left: 1%;
            margin-top: 1%;
            border: 2px solid #000;
            border-color: #000;
            border-width: 2px;
            border-radius: 10px;
            color: #000;
            cursor: pointer;
            font-size: 18px;
            padding: 10px 20px;
            margin-right: 10px;
            transition: background-color 0.3s ease;
            width: 10%;
        }

        #next-question {
            margin-right: 1%;
            margin-top: 1%;
            font-family: 'Comic Sans MS', cursive, sans-serif;
            background-color: #ffff00;
            float: right;
            border: 2px solid #000;
            border-color: #000;
            border-width: 2px;
            border-radius: 10px;
            color: #000;
            cursor: pointer;
            font-size: 18px;
            padding: 10px 20px;
            margin-right: 10px;
            transition: background-color 0.3s ease;
            width: 10%;
        }

        #submit-answers {
            display: block;
            margin-top: 20px;
            margin-left: auto;
            margin-right: auto;
            background-color: red;
            color: #fff;
            font-family: 'Comic Sans MS', cursive, sans-serif;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 18px;
        }


        #prev-question:hover,
        #next-question:hover {
            background-color: #e6e600;
        }

        #submit-answers:hover {
            background-color: #ff4d4d;
        }


        .submit-btn {
            text-align: center;
            margin-top: 20px;
            margin-left: auto;
            margin-right: auto;
            background-color: red;
            color: #000;
        }

        .qText {
            background-color: #fff;
            color: #000;
            font-weight: bolder;
            text-align: center;
            margin-top: 5%;
            margin-bottom: 10%;
            padding-top: 3%;
            padding-bottom: 3%;
        }
    </style>
</head>

<body>
    <header>
        <?php $this->load->view('Comman/header'); ?>
    </header>
    <!-- <h1>Quiz Play</h1> -->
    <div id="quiz-container">
        <?php if (!empty($quizData)) : ?>
            <button id="prev-question">
                << Previous</button>
                    <button id="next-question">Next >></button>
                    <?php foreach ($quizData as $index => $question) : ?>
                        <div class="question <?php echo $index === 0 ? 'active' : ''; ?>" data-question-id="<?php echo $question->questionID; ?>">
                            <h2 class="qText"><?php echo $question->questionText; ?></h2>
                            <div class="options">
                                <button class="option" id="btn1" data-option="<?php echo $question->option1; ?>"><?php echo $question->option1; ?></button>
                                <button class="option" id="btn2" data-option="<?php echo $question->option2; ?>"><?php echo $question->option2; ?></button>
                                <button class="option" id="btn3" data-option="<?php echo $question->option3; ?>"><?php echo $question->option3; ?></button>
                                <button class="option" id="btn4" data-option="<?php echo $question->option4; ?>"><?php echo $question->option4; ?></button>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <button id="submit-answers">Submit Answers</button>
                <?php else : ?>
                    <p>No questions available for this quiz.</p>
                <?php endif; ?>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            var currentIndex = 0;
            var questions = $('.question');
            var selectedAnswers = [];
            // Fetch quiz ID from URL parameter
            const urlParams = new URLSearchParams(window.location.search);
            const quizID = urlParams.get('quizID');

            // Function to show or hide previous and next buttons based on the current question index
            function toggleButtons() {
                $('#prev-question').toggle(currentIndex > 0);
                $('#next-question').toggle(currentIndex < questions.length - 1);
                $('#submit-answers').toggle(currentIndex === questions.length - 1);
            }

            // Initialize button states
            toggleButtons();

            // Handle option click
            $('.option').on('click', function() {
                var selectedOption = $(this).data('option');
                var questionID = $(this).closest('.question').data('question-id');
                selectedAnswers[currentIndex] = {
                    questionID: questionID,
                    answer: selectedOption
                };
                $('.option').removeClass('selected'); 
                $(this).addClass('selected');
            });

            // Handle previous button click
            $('#prev-question').on('click', function() {
                if (currentIndex > 0) {
                    currentIndex--;
                    showQuestion(currentIndex);
                    toggleButtons();
                    // Highlight previously selected option
                    var prevSelectedOption = selectedAnswers[currentIndex] ? selectedAnswers[currentIndex].answer : null;
                    if (prevSelectedOption) {
                        $('.option').removeClass('selected');
                        $('.option[data-option="' + prevSelectedOption + '"]').addClass('selected');
                    }
                }
            });

            // Handle next button click
            $('#next-question').on('click', function() {
                if (currentIndex < questions.length - 1) {
                    currentIndex++;
                    showQuestion(currentIndex);
                    toggleButtons();
                    // Highlight previously selected option
                    var prevSelectedOption = selectedAnswers[currentIndex] ? selectedAnswers[currentIndex].answer : null;
                    if (prevSelectedOption) {
                        $('.option').removeClass('selected');
                        $('.option[data-option="' + prevSelectedOption + '"]').addClass('selected');
                    }
                }
            });

            // Handle submit button click
            $('#submit-answers').on('click', function() {
                // Redirect to result page with selected answers and quiz ID
                var selectedAnswersString = JSON.stringify(selectedAnswers);
                window.location.href = '<?php echo base_url("index.php/Results/resultdisplay"); ?>?quizID=' + quizID + '&selectedAnswers=' + encodeURIComponent(selectedAnswersString);
            });

            // Function to show current question and hide others
            function showQuestion(index) {
                questions.removeClass('active');
                questions.eq(index).addClass('active');
            }
        });
    </script>

</body>

</html>
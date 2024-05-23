<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results</title>
    <style>
        body {
            background-image: url(<?php echo base_url('assets/images/bg.jpg'); ?>);
            background-size: cover;
            background-position: center;
        }

        .correct-answer {
            background-color: #ff0080;
            color: white;
        }

        .user-answer.correct-answer {
            background-color: #00cc00;
            color: white;
        }

        .user-answer.wrong-answer {
            background-color: #ff4d4d;
            color: white;
        }

        /* Updated CSS */
        .options {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin: 2%;
        }


        .option-button {
            width: 200px;
            padding: 10px;
            margin-bottom: 10px;
            font-size: 25px;
            border-radius: 50px;
            border-width: 3px;
        }




        /* .option-button {
            display: inline-block;
            padding: 10px;
            margin: 5px;
            border: none;
            cursor: pointer;
            position: relative;
        } */
        .question {
            margin-bottom: 20px;
        }

        .score {
            margin-top: 20px;
            font-weight: bold;
        }

        #topic-container {
            width: 100%;
            text-align: center;
            font-size: 40px;
            font-weight: 800;
            color: red;
            margin-top: 3%;
            margin-bottom: 3%;
        }

        #question-text {
            background-color: white;
            text-align: center;
            font-size: 30px;
            color: black;
            font-weight: 600;
            padding: 10px;
            margin-bottom: 30px;

        }

        #next {
            background-color: #ffd700;
            color: #000;
            border: none;
            padding: 15px 40px;
            font-size: 20px;
            font-weight: bold;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: block;
            margin: 20px auto;
        }


        #next:hover {
            background-color: #ffec80;
        }

        .score {
            width: 100%;
            background-color: #ecb3ff;
            color: black;
            text-align: center;
            font-size: 30px;
            font-weight: 600;
            padding: 10px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://underscorejs.org/underscore-min.js"></script>
    <script src="https://backbonejs.org/backbone-min.js"></script>
</head>

<body>
    <header>
        <?php $this->load->view('Comman/header'); ?>
    </header>
    <div id="topic-container">
        <img src="<?php echo base_url('assets/images/review_quiz.png'); ?>" alt="review Image" class="review-img">
    </div>
    <?php
    $totalQuestions = count($quizData);
    $correctAnswers = 0;
    $selectedAnswersMap = [];

    if (!is_array($selectedAnswers)) {
        $selectedAnswersData = json_decode($selectedAnswers, true);
        foreach ($selectedAnswersData as $selectedAnswer) {
            $selectedAnswersMap[$selectedAnswer['questionID']] = $selectedAnswer['answer'];
        }
    } else {
        foreach ($selectedAnswers as $selectedAnswer) {
            $selectedAnswersMap[$selectedAnswer['questionID']] = $selectedAnswer['answer'];
        }
    }
    ?>
    <?php foreach ($quizData as $question) : ?>
        <div class="question">
            <h2 id="question-text"><?php echo $question->questionText; ?></h2>
            <div class="options">
                <?php
                $options = [$question->option1, $question->option2, $question->option3, $question->option4];
                $userAnswer = isset($selectedAnswersMap[$question->questionID]) ? $selectedAnswersMap[$question->questionID] : null;
                $correctAnswer = $question->correctAnswer;
                foreach ($options as $option) {
                    $buttonClass = 'option-button';
                    $isCorrectAnswer = ($option == $correctAnswer);
                    $isUserAnswer = ($userAnswer == $option);

                    if ($isCorrectAnswer) {
                        if ($isUserAnswer) {
                            $buttonClass .= ' user-answer correct-answer'; // Correct user's answer
                            $correctAnswers++;
                            echo '<button class="' . $buttonClass . '">' . $option . ' ✓</button>'; // Correct answer with checkmark
                        } else {
                            $buttonClass .= ' correct-answer'; // Correct answer
                            echo '<button class="' . $buttonClass . '">' . $option . '</button>';
                        }
                    } elseif ($isUserAnswer) {
                        $buttonClass .= ' user-answer wrong-answer'; // Wrong user's answer
                        echo '<button class="' . $buttonClass . '">' . $option . ' x</button>'; // Wrong answer with 'x' mark
                    } else {
                        echo '<button class="' . $buttonClass . '">' . $option . '</button>';
                    }
                }
                ?>
            </div>
            <div class="answer-info">
                <!-- <p>User Selected Answer: <?php echo $userAnswer; ?></p>
                <p>Correct Answer: <?php echo $correctAnswer; ?></p> -->
            </div>
        </div>
    <?php endforeach; ?>
    <div class="score">
        Score: <?php echo $correctAnswers; ?> / <?php echo $totalQuestions; ?>
    </div>

    <button id="next">Next >></button>

    <script>
        $(document).ready(function() {
            // Define the quizID variable and set its value from PHP
            var quizID = <?php echo json_encode($quizID); ?>;

            // Attach click event handler to the Next button
            $('#next').click(function() {
                var score = <?php echo $correctAnswers; ?>;
                var totalQuestions = <?php echo $totalQuestions; ?>;

                // Perform AJAX request to update score
                $.ajax({
                    url: '<?php echo site_url('Results/score') ?>',
                    method: 'GET',
                    data: {
                        score: score,
                        totalQuestions: totalQuestions,
                        quizID: quizID // Include quizID in the data
                    },
                    success: function(response) {
                        // Redirect to the score page with updated parameters
                        window.location.href = '<?php echo site_url('Results/score') ?>?score=' + score + '&totalQuestions=' + totalQuestions + '&quizID=' + quizID;
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error: ' + textStatus + ' - ' + errorThrown);
                    }
                });
            });
        });
    </script>

</body>

</html>
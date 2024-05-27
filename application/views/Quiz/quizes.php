<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Details</title>
    <style>
        body {
            background-image: url(<?php echo base_url('assets/images/bg.jpg'); ?>);
            background-size: cover;
            background-position: center top;
            margin: 0;
            font-family: 'Comic Sans MS', cursive, sans-serif;
        }

        .play_quizes_img {
            margin-left: 35%;
            margin-right: auto;
            margin-top: 50px;
            margin-bottom: 5px;
            z-index: 1;
        }

        .quiz-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .quiz-card {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            background-color: #e6ffff;
            position: relative;
            width: 300px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .quiz-card:hover {
            transform: translateY(-5px);
        }

        .quiz-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            position: relative;
        }

        .quiz-name {
            font-family: 'Comic Sans MS', cursive, sans-serif;
            font-size: 34px;
            font-weight: bold;
            color: white;
            position: absolute;
            top: 30%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            width: 90%;
            text-shadow: -2px -2px 0 black, 2px -2px 0 black, -2px 2px 0 black, 2px 2px 0 black;
            letter-spacing: 2px;
        }



        .quiz-description {
            color: #666;
            margin-bottom: 10px;
            text-align: center;
            font-size: 18px;
        }

        .start-quiz-btn {
            display: block;
            text-align: center;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            text-decoration: none;
            transition: background-color 0.3s;
            margin-top: auto;
            font-size: 18px;
        }

        .start-quiz-btn:hover {
            background-color:#0000ff;
            color: #e6ffff;
        }

        .search-container {
            margin-top: 20px;
            text-align: center;
        }

        .search-input {
            width: 300px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 20px;
            font-size: 18px;
            box-shadow: 0px 0px 6px 2px #ccffff;
            text-align: center;
            margin-top: 3%;
            margin-bottom: 3%;
        }

        .feedback {
            text-align: center;
            margin-top: 10px;
        }

        .feedback img {
            width: 50px;
            height: 50px;
            cursor: pointer;
            margin: 0 10px;
        }

        .total-feedback {
            text-align: center;
            font-size: 20px;
            color: #555;
            margin-top: 5px;
            padding-bottom: 10px;
        }

        .overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
            width: 100%;
        }
    </style>
</head>

<body>
    <header>
        <?php $this->load->view('Comman/header'); ?>
    </header>
    <img src="<?php echo base_url('assets/images/play_quizzes.png'); ?>" alt="play quizzes image" class="play_quizes_img">
    <div class="search-container">
        <input type="text" id="quiz-search" class="search-input" placeholder="Search quizzes by name..." onkeyup="searchQuizzes()">
    </div>
    <div class="quiz-container" id="quiz-container">
        <?php
        $imagePaths = [
            'assets/images/hand-drawn-back-school-background_23-2149458512.jpg',
            'assets/images/q12.jpg',
            'assets/images/cute-kids-school-objects-tag_110279-169.jpg',
            'assets/images/q13.avif',
            'assets/images/q4.avif',
            'assets/images/80175e8f1b3f1afff108bd5c0081db96.jpg',
            'assets/images/back-to-school-vector-banner-design-with-colorfull_951778-44453-7.jpg',
            'assets/images/school-supply-stationary-background-free-vector.png',
            'assets/images/q9.avif',
        ];
        $imageIndex = 0; // Initialize image index counter

        foreach ($quizDetails as $quiz) :
            $currentImagePath = $imagePaths[$imageIndex % count($imagePaths)];
        ?>
            <div class="quiz-card" id="quiz-<?php echo $quiz->quizID; ?>">
                <img src="<?php echo base_url($currentImagePath); ?>" alt="Quiz Image">
                <div class="quiz-name"><?php echo $quiz->quizName; ?></div>
                <p class="quiz-description"><?php echo $quiz->quizDescription; ?></p>
                <div class="feedback">
                    <img src="<?php echo base_url('assets/images/like.png'); ?>" alt="Like" onclick="sendFeedback(<?php echo $userID; ?>, <?php echo $quiz->quizID; ?>, 'like')">
                    <img src="<?php echo base_url('assets/images/dislike.png'); ?>" alt="Dislike" onclick="sendFeedback(<?php echo $userID; ?>, <?php echo $quiz->quizID; ?>, 'dislike')">
                </div>
                <div class="total-feedback">
                    Likes: <span class="like-count" style="color: #4CAF50; font-weight: bold;"><?php echo $quiz->totalLikes; ?></span>,
                    Dislikes: <span class="dislike-count" style="color: #F44336;"><?php echo $quiz->totalDislikes; ?></span>
                </div>
                <a href="<?php echo base_url('index.php/QuizDisplay/quizplay?quizID=' . $quiz->quizID); ?>" class="start-quiz-btn">Start Quiz</a>
            </div>
        <?php
            $imageIndex++; // Increment image index
        endforeach;
        ?>
    </div>

    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- like and dislike for quizes function -->
    <script>
        function sendFeedback(userID, quizID, action) {
            $.ajax({
                url: '<?php echo base_url('index.php/UserFeedback/updateFeedback'); ?>',
                type: 'POST',
                data: {
                    userID: userID,
                    quizID: quizID,
                    action: action
                },
                success: function(response) {
                    if (response.success) {
                        console.log('Feedback sent successfully');
                        // Update like and dislike counts on the UI for the specific quiz
                        $('#quiz-' + quizID + ' .like-count').text(response.totalLikes);
                        $('#quiz-' + quizID + ' .dislike-count').text(response.totalDislikes);
                    } else {
                        console.error('Error updating feedback:', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error sending feedback:', error);
                }
            });
        }

        // search function 
        function searchQuizzes() {
            var input, filter, quizzes, quizName, i;
            input = document.getElementById("quiz-search");
            filter = input.value.toUpperCase();
            quizzes = document.getElementsByClassName("quiz-card");
            for (i = 0; i < quizzes.length; i++) {
                quizName = quizzes[i].getElementsByClassName("quiz-name")[0];
                if (quizName) {
                    if (quizName.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        quizzes[i].style.display = "";
                    } else {
                        quizzes[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</body>

</html>
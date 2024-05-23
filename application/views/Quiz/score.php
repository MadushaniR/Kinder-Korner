<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Score</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.1/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>
    <style>
        body {
            background-image: url(<?php echo base_url('assets/images/bg.jpg'); ?>);
            background-size: cover;
            background-position: center top;
        }

        .score {
            font-size: 24px;
            margin-top: 20px;
        }

        .congrats-img {
            margin-bottom: 20px;
        }

        .results-container {
            width: 50%;
            margin-left: 35%;
            margin-right: 50%;
        }

        .score {
            font-size: 40px;
            font-weight: 800;
            text-align: center;
            margin-top: -3%;
            background-color: yellow;
            width: 58%;
        }

        .title-congrats {
            font-size: 50px;
            font-weight: 800;
            text-align: center;
            margin-left: -40%;
            margin-bottom: 10px;
        }

        #replay,
        #home {
            margin-top: 20px;
        }

        #replay img,
        #home img {
            width: 100px;
            height: 100px;
        }

        .btn-wrapper {
            display: flex;
            justify-content: space-between;
            margin-top: -200px;
            width: 75%;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }

        .star {
            font-size: 60px;
            font-weight: 800;
            text-align: center;
            margin-top: -3%;
            background-color: yellow;
            width: 58%;
            color: red;
        }
    </style>
</head>

<body>
    <header>
        <?php $this->load->view('Comman/header'); ?>
    </header>
    <div class="results-container">
        <div class="title-congrats" id="congrats">Congratulations <?php echo $this->session->userdata('user_name'); ?>!</div>
        <div class="congrat-img">
            <img src="<?php echo base_url('assets/images/congrats.png'); ?>" alt="Congratulations" class="congrats-img">
        </div>
        <div class="score" id="score">Your Score: <?php echo $score; ?> / <?php echo $totalQuestions; ?></div>
        <div class="star" id="star">Total Stars: <?php echo $totalStars; ?></div>
    </div>
    <div class="btn-wrapper">
        <div id="replay">
            <a href="<?php echo base_url(); ?>index.php/QuizDisplay/quizplay?quizID=<?= $quizID ?>">
                <img src="<?php echo base_url('assets/images/play_again.png'); ?>" alt="Replay">
            </a>
        </div>
        <div id="home">
            <a href="<?php echo base_url(); ?>index.php/QuizDisplay/quizes">
                <img src="<?php echo base_url('assets/images/home.png'); ?>" alt="Home">
            </a>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var ScoreView = Backbone.View.extend({
                el: '.results-container',
                initialize: function() {
                    this.render();
                },
                render: function() {
                    this.$el.find('#congrats').text("Congratulations <?php echo $this->session->userdata('user_name'); ?>!");
                    this.$el.find('#score').text("Your Score: <?php echo $score; ?> / <?php echo $totalQuestions; ?>");
                    this.$el.find('#star').text("Total Stars: <?php echo $totalStars; ?>");
                    return this;
                }
            });

            var scoreView = new ScoreView();
        });
    </script>
</body>

</html>
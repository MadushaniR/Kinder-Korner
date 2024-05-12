<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="This is a login page template based on Bootstrap 5">
    <title>Kinder Koner</title>
    <link rel="stylesheet" href="<?php echo site_url(); ?>assets/all.css">
    <link rel="stylesheet" href="<?php echo site_url(); ?>assets/toast/toast.min.css">
    <script src="<?php echo site_url(); ?>assets/toast/jqm.js"></script>
    <script src="<?php echo site_url(); ?>assets/toast/toast.js"></script>
    <style>
        body {
            background-image: url(<?php echo base_url('assets/images/bg.jpg'); ?>);
            background-size: cover;
            background-position: center;
        }

        .play_quizes_img {
            margin-left: 35%;
            margin-right: auto;
            top: 50px;
            z-index: 1;
        }

        #quizSearch {
            box-shadow: 0px 0px 6px 2px #ccffff;
        }

        .card-body {
            background-color: #e6ffff;
        }

        .card-title {
            text-align: center;
            font-size: 40px;
            margin-top: -120px; 
			margin-bottom: 20px;
        }

        .start-quiz-btn {
            text-align: center;
            /* margin-top: -10px;  */
        }

        .total-feedback {
            text-align: center;
        }

        .play-quiz {
            text-align: center;
        }

        .feedback {
            text-align: center;
        }
		.search-box {
        margin: 0 auto; 
        text-align: center; 
    }

    .search-box input[type="text"] {
        border-radius: 20px; 
        padding: 8px 12px; 
        font-size: 16px; 
        border: 3px solid pink; 
		width: 60%;
		text-align: center;
		margin-left: auto;
		margin-right: auto;
		margin-top: 3%;
		margin-bottom: 3%;
    }
    </style>
</head>

<body>
    <header>
        <?php $this->load->view('Comman/header'); ?>
    </header>
    <img src="<?php echo base_url('assets/images/play_quizzes.png'); ?>" alt="play quizes image" class="play_quizes_img">
    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-sm-center h-100">
                <div class="search-box">
                    <input type="text" id="quizSearch" class="form-control" placeholder="Search quiz names">
                </div>

                <?php
                // Define image paths
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
                $this->db->select('quizID,quizName,totalLikes,totalDislikes');
                $this->db->distinct();
                $query = $this->db->get('quizdetails');
                $quizDetails = $query->result_array();

                $imageIndex = 0; // Initialize image index counter

                foreach ($quizDetails as $quiz) {
                    // Get the current image path
                    $currentImagePath = $imagePaths[$imageIndex % count($imagePaths)]; ?>

                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-4">
                        <div class="card" style="position: relative;">
                            <img src="<?php echo base_url($currentImagePath); ?>" class="card-img-top" alt="Quiz Image" style="width: 100%; height: 200px; object-fit: cover;">
                            <div class="overlay" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; color: white;">
                                <h2 class="card-title" style="color: white; text-shadow: -2px -2px 0 black, 2px -2px 0 black, -2px 2px 0 black, 2px 2px 0 black; letter-spacing: 1px; font-family: 'Comic Sans MS', cursive;"><?php echo $quiz['quizName']; ?></h2>
                                <form method="" action="<?php echo base_url(); ?>index.php/QuizDisplay/quizdisplay" class="start-quiz-btn"> 
                                    <input type="hidden" name="quizID" value="<?php echo $quiz['quizID']; ?>">
                                    <input type="submit" class="btn btn-primary" value="Start Quiz">
                                </form>
                            </div>
                            <div class="mt-2 feedback-container" style="background-color: #fff; padding: 20px; border-radius: 5px;">
                                <div class="feedback" style="text-align: center; padding-top: 10px;">
                                    <img src="<?php echo base_url('assets/images/like.png'); ?>" alt="Like" onclick="updateCount(<?php echo $quiz['quizID']; ?>, 'like')" class="feedback-btn" style="width: 50px; height: 50px; cursor: pointer; margin-right: 10px;">
                                    <img src="<?php echo base_url('assets/images/dislike.png'); ?>" alt="Dislike" onclick="updateCount(<?php echo $quiz['quizID']; ?>, 'dislike')" class="feedback-btn" style="width: 50px; height: 50px; cursor: pointer;">
                                </div>
                                <div class="total-feedback" style="text-align: center; font-size: 18px; color: #555; margin-top: 5px; padding-bottom: 10px;">
                                    <div id="totalCount_<?php echo $quiz['quizID']; ?>">Total Likes: <span style="color: #4CAF50; font-weight: bold;"><?php echo $quiz['totalLikes']; ?></span>, Total Dislikes: <span style="color: #F44336;"><?php echo $quiz['totalDislikes']; ?></span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php
                    $imageIndex++; // Increment image index
                }
                ?>
            </div>
        </div>
    </section>

    <script>
    // Function to filter quiz cards based on search input
    document.getElementById('quizSearch').addEventListener('input', function() {
        // Convert search input value to lowercase for case-insensitive comparison
        var searchValue = this.value.toLowerCase();
        // Select all quiz cards
        var quizCards = document.querySelectorAll('.card');

        // Iterate through each quiz card
        quizCards.forEach(function(card) {
            // Get the text content of the card title and convert to lowercase
            var cardTitle = card.querySelector('.card-title').innerText.toLowerCase();
            // Check if the card title contains the search value
            if (cardTitle.includes(searchValue)) {
                // Display the card if it matches the search value
                card.style.display = 'block';
            } else {
                // Hide the card if it does not match the search value
                card.style.display = 'none';
            }
        });
    });

    // Function to update like/dislike count for a quiz
    function updateCount(quizID, type) {
        // Fetch the user ID from PHP (assuming it's already defined in the page)
        var userID = <?php echo $userID; ?>; 
        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();
        // Construct the URL for the AJAX request
        var url = '<?php echo base_url("index.php/UserFeedback/updateFeedback"); ?>/' + userID + '/' + quizID + '/' + type;
        // Open a POST request to the specified URL
        xhr.open('POST', url, true);
        // Set the request header
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        // Send the request
        xhr.send();
        // Reload the page after updating the feedback
        window.location.reload();
    }
</script>

</body>
</html>

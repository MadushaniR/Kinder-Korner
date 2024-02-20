<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Play Quiz</title>
</head>
<header>
    <?php $this->load->view('Comman/header'); ?>
</header>

<body>

    <div id="container">
        <h1>Welcome, <?= $user_name ?>!</h1>
        <h1>Play the Quiz!</h1>

        <?php $score = 0; ?>

        <?php $array1 = array(); ?>
        <?php $array2 = array(); ?>
        <?php $array3 = array(); ?>
        <?php $array4 = array(); ?>
        <?php $array5 = array(); ?>
        <?php $array6 = array(); ?>
        <?php $array7 = array(); ?>
        <?php $array8 = array(); ?>

        <?php foreach ($checks as $checkans) { ?>
            <?php array_push($array1, $checkans); ?>
        <?php } ?>

        <?php foreach ($results as $res) { ?>
            <?php
            array_push($array2, $res->answer);
            array_push($array3, $res->quizID);
            array_push($array4, $res->question);
            array_push($array5, $res->choice1);
            array_push($array6, $res->choice2);
            array_push($array7, $res->choice3);
            array_push($array8, $res->answer);
            ?>
        <?php } ?>

        <form method="post" action="<?php echo base_url(); ?>index.php/Questions/quizdisplay?quizNumber=<?= $quizNumber ?>">
            <?php for ($x = 0; $x < count($results); $x++) { ?>
                <p><?= $array3[$x] ?>.<?= $array4[$x] ?></p>

                <?php
                $userAnswer = isset($_POST['quizid' . $array3[$x]]) ? $_POST['quizid' . $array3[$x]] : '';
                ?>

                <?php if ($array2[$x] != $userAnswer) { ?>
                    <p><span style="background-color: #FF9C9E"><?= $userAnswer ?></span></p>
                    <p><span style="background-color: #ADFFB4"><?= $array2[$x] ?></span></p>
                <?php } else { ?>
                    <p><span style="background-color: #ADFFB4"><?= $userAnswer ?></span></p>
                    <?php $score = $score + 1; ?>
                <?php } ?>

                <!-- Add a hidden input field to capture the user's answer -->
                <input type="hidden" name="quizid<?= $array3[$x] ?>" value="<?= $userAnswer ?>">
            <?php } ?>

            <br><br>
            <h2>Your Score: </h2>
            <h1><?= $score ?>/<?= count($results) ?></h1>
            <input type="submit" value="Play Again">
        </form>
    </div>

</body>

</html>
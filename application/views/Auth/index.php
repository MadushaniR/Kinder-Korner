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
</head>

<body>
    <header>
        <?php $this->load->view('Comman/header'); ?>
    </header>
    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-sm-center h-100">
			<form method="get" action="<?php echo base_url(); ?>index.php/QuizManage/createquiz">
							<input type="submit" value="Create New Quiz">
						</form>
                <div class="col-12 mb-3">
                    <!-- Add search bar input field -->
                    <input type="text" id="quizSearch" class="form-control" placeholder="Search quiz names">
                </div>
                <?php
                $this->db->select('quizID,quizName');
                $this->db->distinct();
                $query = $this->db->get('quizdetails');
                $uniquequizIDs = $query->result_array();

                foreach ($uniquequizIDs as $quizID) {
                    echo '<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">';
                    echo '<div class="card">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $quizID['quizName'] . '</h5>';
                    echo '<form method="" action="' . base_url() . 'index.php/QuizDisplay/quizdisplay">';
                    echo '<input type="hidden" name="quizID" value="' . $quizID['quizID'] . '">';
                    echo '<input type="submit" class="btn btn-primary" value="Start Quiz">';
                    echo '</form>';
                    echo '<div class="mt-2">';
                    echo '<button class="btn btn-success" onclick="updateCount(' . $quizID['quizID'] . ', \'like\')">Like</button>';
                    echo '<button class="btn btn-danger" onclick="updateCount(' . $quizID['quizID'] . ', \'dislike\')">Dislike</button>';
                    echo '<span id="quizCount_' . $quizID['quizID'] . '">Likes: 0, Dislikes: 0</span>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('quizSearch').addEventListener('input', function () {
            var searchValue = this.value.toLowerCase();
            var quizCards = document.querySelectorAll('.card');

            quizCards.forEach(function (card) {
                var cardTitle = card.querySelector('.card-title').innerText.toLowerCase();
                if (cardTitle.includes(searchValue)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        function updateCount(quizID, type) {
            var countSpan = document.getElementById('quizCount_' + quizID);
            var likes = parseInt(countSpan.innerText.split(',')[0].split(':')[1].trim());
            var dislikes = parseInt(countSpan.innerText.split(',')[1].split(':')[1].trim());

            if (type === 'like') {
                likes++;
            } else if (type === 'dislike') {
                dislikes++;
            }

            countSpan.innerText = 'Likes: ' + likes + ', Dislikes: ' + dislikes;
        }
    </script>

    <!-- Your existing toastr script -->
    <script type="text/javascript">
        <?php if ($this->session->flashdata('suc')) { ?>
            toastr.success("<?php echo $this->session->flashdata('suc'); ?>");
        <?php } else if ($this->session->flashdata('wrong')) {  ?>
            toastr.error("<?php echo $this->session->flashdata('wrong'); ?>");
        <?php } else if ($this->session->flashdata('warning')) {  ?>
            toastr.warning("<?php echo $this->session->flashdata('warning'); ?>");
        <?php } else if ($this->session->flashdata('info')) {  ?>
            toastr.info("<?php echo $this->session->flashdata('info'); ?>");
        <?php } ?>
        <?php
        $this->session->unset_userdata('suc'); ?>
        <?php
        $this->session->unset_userdata('wrong'); ?>
    </script>
</body>

</html>

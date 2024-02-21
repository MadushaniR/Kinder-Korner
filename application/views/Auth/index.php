<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="author" content="Muhamad Nauval Azhar">
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
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<div class="text-center my-5"></div>
					<div id="main-container">
						<h1>Welcome to Quiz!</h1>
						<form method="get" action="<?php echo base_url(); ?>index.php/Questions/createquiz">
        					<input type="submit" value="Create New Quiz">
   						 </form>
						<h1>Welcome,
							<?= $user_name ?>
							!</h1>
							<h1>user id,
							<?= $userID ?>
							!</h1>
						<?php
						$this->db->select('quizNumber');
						$this->db->distinct();
						$query = $this->db->get('quizdetails');
						$uniqueQuizNumbers = $query->result_array();
						foreach ($uniqueQuizNumbers as $quizNumber) {
							echo '<form method="" action="' . base_url() . 'index.php/Questions/quizdisplay">';
							echo '<input type="hidden" name="quizNumber" value="' . $quizNumber['quizNumber'] . '">';
							echo '<input type="submit" value="Start Quiz ' . $quizNumber['quizNumber'] . '">';
							echo '</form>';
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</section>

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
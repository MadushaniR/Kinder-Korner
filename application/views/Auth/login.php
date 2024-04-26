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
			background-position: center top;

		}
		.card {
			margin-top: 50%;
			margin-bottom: auto;
			max-width: 400px;
			width: 100%;
			/* border: 2px dashed black;  */
    		box-sizing: border-box;
		}

		.login-img {
            position: absolute;
			top: 50px; 
            left: 50%;
            transform: translateX(-50%);
            z-index: 1; 
        }
		.card label,
        .card h1 {
            color: black !important;
			font-weight: bold;
			font-size: larger;
        }

		.card input[type="email"] {
			box-shadow: 0px 0px 6px 2px #ffe6e6; 
        }

        .card input[type="password"] {
            box-shadow: 0px 0px 6px 2px #ccffff; 
        }

		.card .btn-login {
            background-color: #EEAAAB; 
            color: black; 
            border: 2px solid black; 
            border-radius: 30px; 
			width: 50%;
			font-weight: bolder;
			font-size: larger;
			margin: auto; 
			margin-top: 20px;
        }

        .card .btn-login:hover {
            background-color: #D89DA5; 
        }

		.card-footer {
    background-color: #bfecf2;
}

	</style>
</head>

<body>
<img src="<?php echo base_url('assets/images/login.png'); ?>" alt="Login Image" class="login-img">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<div class="card shadow-lg">
						<div class="card-body p-5">
							<!-- <h1 class="fs-4 card-title fw-bold mb-4">Login</h1> -->
							<?php echo form_open('Auth/login_form'); ?>
							<div class="mb-3">
                            <label class="mb-2 text-muted" for="email">E-Mail</label>
                            <input id="email" type="email" class="form-control" name="email" value="" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label class="mb-2 text-muted" for="password">Password</label>
                            <input id="password" type="password" class="form-control" name="password" required>
                        </div>

							<div class="d-flex align-items-center">
								<!-- <button type="submit" class="btn btn-primary ms-auto">
									Login
								</button> -->
								<button type="submit" class="btn btn-login ms-auto">Login</button>
							</div>
							<?php echo form_close(); ?>
						</div>
						<div class="card-footer py-3 border-0">
							<div class="text-center">
								Don't have an account? <a href="Auth/register" class="text-dark">Create One</a>
							</div>
						</div>
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
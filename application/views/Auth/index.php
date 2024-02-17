<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Muhamad Nauval Azhar">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="description" content="This is a login page template based on Bootstrap 5">
	<title>Bootstrap 5 Login Page</title>
    <link rel="stylesheet" href="<?php echo site_url();?>assets/all.css">
    <link rel="stylesheet" href="<?php echo site_url();?>assets/toast/toast.min.css">
    <script src="<?php echo site_url();?>assets/toast/jqm.js"></script>
    <script src="<?php echo site_url();?>assets/toast/toast.js"></script>
    
 </head>

<body>
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<div class="text-center my-5">
						<img src="<?php echo site_url();?>assets/logo.jpg" alt="logo" width="100">
					</div>
				
                    

                    <div class="card text-white bg-primary">
                      <img class="card-img-top" src="holder.js/100px180/" alt="">
                      <div class="card-body">
                        <h4 class="card-title">Welcome </h4>
                        <p class="card-text">Users</p>
                      </div>
                    </div>


					<div class="text-center mt-5 text-muted">
						Copyright &copy; 2017-2021 &mdash; Your Company 
					</div>
				</div>
			</div>
		</div>
	</section>

    <script type="text/javascript">


<?php if($this->session->flashdata('suc')){ ?>
    toastr.success("<?php echo $this->session->flashdata('suc'); ?>");
<?php }else if($this->session->flashdata('worng')){  ?>
    toastr.error("<?php echo $this->session->flashdata('worng'); ?>");
<?php }else if($this->session->flashdata('warning')){  ?>
    toastr.warning("<?php echo $this->session->flashdata('warning'); ?>");
<?php }else if($this->session->flashdata('info')){  ?>
    toastr.info("<?php echo $this->session->flashdata('info'); ?>");
<?php } ?>
<?php
	$this->session->unset_userdata ( 'suc' ); ?>
	
	<?php
    $this->session->unset_userdata ( 'worng' ); ?>

</script>
</body>
</html>
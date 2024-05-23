<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kinder Koner</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo site_url(); ?>assets/all.css">
  <link rel="stylesheet" href="<?php echo site_url(); ?>assets/toast/toast.min.css">
  <script src="<?php echo site_url(); ?>assets/toast/jqm.js"></script>
  <script src="<?php echo site_url(); ?>assets/toast/toast.js"></script>

  <style>
    header {
      background-color: #AAE6EE;
      height: 100px;
      width: 100%;
      top: 0;
      margin-bottom: 10px;
    }

    .container {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .site-name {
      margin-top: 1%;
      font-weight: bold;
      color: red;
    }

    .user-info {
      display: flex;
      align-items: center;
    }

    .user-info p {
      color: red;
    }

    .welcome-message {
      margin-right: 10px;
    }

    nav {
      display: flex;
      margin-left: 20px;
    }

    nav a {
      text-decoration: none;
      color: black;
      margin-right: 20px;
      font-weight: bold;
      font-size: 20px;
    }

    nav a:hover {
      color: #007bff;
    }
  </style>
</head>

<body>
  <header>
    <div class="container">
      <div class="site-name">
        <h1>Kinder Koner</h1>
      </div>
      <nav>
        <a href="<?php echo base_url('index.php/QuizDisplay/quizes'); ?>">&nbsp;Home</a> |
        <a href="<?php echo base_url('index.php/QuizDisplay/quizes'); ?>">&nbsp;Quiz</a> |
        <a href="<?php echo base_url('index.php/QuizManage/quize_manage'); ?>">&nbsp;Manage</a>
      </nav>
      <div class="user-info">
        <?php if ($this->session->userdata('userID') && $this->session->userdata('user_name')) { ?>
          <p class="welcome-message"><?php echo $this->session->userdata('user_name'); ?></p>
          <a href="<?php echo base_url('index.php/Auth/login'); ?>" class="btn btn-danger">Logout</a>
        <?php } else { ?>
          <a href="<?php echo base_url('index.php/Auth/login'); ?>" class="btn btn-primary">Login</a>
        <?php } ?>
      </div>
    </div>
  </header>
</body>

</html>
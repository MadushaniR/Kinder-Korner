<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Your Name">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kinder Koner</title>
    <link rel="stylesheet" href="<?php echo site_url(); ?>assets/all.css">
    <link rel="stylesheet" href="<?php echo site_url(); ?>assets/toast/toast.min.css">
    <script src="<?php echo site_url(); ?>assets/toast/jqm.js"></script>
    <script src="<?php echo site_url(); ?>assets/toast/toast.js"></script>

    <style>
        header {
            background-color: #f8f9fa;
        }

        .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .site-name {
            margin: 0;
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .welcome-message {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <header>
        <div class="container">
            <div class="site-name">
                <h1>Kinder Koner</h1>
            </div>
            <div class="user-info">
                <?php if ($this->session->userdata('userID') && $this->session->userdata('user_name')) { ?>
                    <p class="welcome-message">Welcome, <?php echo $this->session->userdata('user_name'); ?></p>
                    <a href="<?php echo site_url('Auth/logout'); ?>" class="btn btn-danger">Logout</a>
                <?php } else { ?>
                    <a href="<?php echo site_url('Auth/'); ?>" class="btn btn-primary">Login</a>
                <?php } ?>
            </div>
        </div>
    </header>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Landing Page</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        body {
            background-image: url(<?php echo base_url('assets/images/rt.jpg'); ?>);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .content-container {
            text-align: center;
        }

        .content-container>div {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .content-container>button {
            background-color: #1A99A8;
            border: none;
            color: #fff;
            font-weight: 600;
            padding: 20px 50px;
            border-radius: 40px;
            font-size: 36px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .content-container>button:hover {
            background-color: #00bfff;
        }

        .landing-title h1 {
            font-weight: 600;
            color: black;
            font-size: larger;
            text-align: center;
            font-size: 50px;
            margin-bottom: 20px;
            width: 90%;
            margin-top: -1%;
            margin-bottom: 10%;
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

        .nav {
            width: 100%;
            background-color: #AAE6EE;
            height: 100px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 999;
            font-weight: bold;
            color: red;
        }

        .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .site-name {
            color: red;
            font-size: 40px;
            margin-top: 1%;
        }

        .login-button {
            background-color: #1A99A8;
            border: none;
            color: #fff;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 40px;
            font-size: 18px;
            margin-top: 2%;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-button:hover {
            background-color: #00bfff;
        }
    </style>
</head>

<body>
    <header>
        <div class="nav">
            <div class="container">
                <div class="site-name">Kinder Koner</div>
                <button class="login-button" onclick="location.href='<?php echo base_url('Auth/login'); ?>'">Login</button>
            </div>
        </div>
    </header>
    <div class="content-container">
        <div class="landing-title">
            <h1>Inspire a Lifetime of Learning and Discovery!</h1>
        </div>
        <button onclick="location.href='<?php echo base_url('Auth/login'); ?>'">Get Started</button>

    </div>
</body>
</html>

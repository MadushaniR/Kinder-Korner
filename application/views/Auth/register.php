<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="This is a register">
    <title>Kinder Koner</title>
    <style>
        body {
            background-image: url(<?php echo base_url('assets/images/bg.jpg'); ?>);
            background-size: cover;
            background-position: center top;
            margin: 0;
            font-family: 'Comic Sans MS', cursive, sans-serif;
        }

        .register-container {
            display: flex;
            justify-content: center;
            align-items: center;
            /* min-height: 100vh; */
        }

        .register-img {
            margin-top: 5%;
            margin-bottom: 2%;
        }

        .register-form {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        .register-form h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            color: black !important;
            font-weight: bold;
            font-size: larger;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: 95%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-shadow: 0px 0px 6px 2px #ffe6e6;
        }

        .form-group button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #EEAAAB;
            color: #333;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-group button:hover {
            background-color: #D89DA5;
        }

        .text-center {
            text-align: center;
            margin-top: 20px;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <img src="<?php echo base_url('assets/images/register.png'); ?>" alt="Register Image" class="register-img">
    </div>
    <div class="register-container">
        <div class="register-form">
            <div class="form-group">
                <label for="username">Username</label>
                <input id="username" name="username" type="text" required autofocus>
            </div>
            <div class="form-group">
                <label for="email">E-Mail</label>
                <input id="email" name="email" type="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" required>
            </div>
            <div class="form-group">
                <label for="con_password">Confirm Password</label>
                <input id="con_password" name="con_password" type="password" required>
            </div>
            <div class="form-group">
                <button id="registerBtn">Register</button>
            </div>
            <div class="text-center">
                Have an account? <a href="<?php echo base_url('index.php/Auth/login'); ?>" class="text-dark">Login</a>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo site_url(); ?>assets/toast/jqm.js"></script>
    <script src="<?php echo site_url(); ?>assets/toast/toast.js"></script>


    <script>
        $(document).ready(function() {
            $('#registerBtn').click(function(event) {
                event.preventDefault();
                // Perform AJAX registration request
                $.ajax({
                    url: "<?php echo base_url() ?>index.php/Auth/register_user",
                    type: "POST",
                    data: {
                        username: $('#username').val(),
                        email: $('#email').val(),
                        password: $('#password').val(),
                        con_password: $('#con_password').val()
                    },
                    success: function(response) {
                        // Redirect to the login page
                        window.location.href = "<?php echo base_url('index.php/Auth/login'); ?>";
                        // Display success message to the user
                        $.toast({
                            heading: 'Success',
                            text: response.message,
                            icon: 'success',
                            position: 'top-right',
                            stack: false
                        });

                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        $.toast({
                            heading: 'Error',
                            text: xhr.responseJSON.message,
                            icon: 'error',
                            position: 'top-right',
                            stack: false
                        });
                    }
                });

            });
        });
    </script>
</body>

</html>
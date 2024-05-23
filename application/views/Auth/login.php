<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="This is a login page">
    <title>Kinder Koner</title>
    <style>
        body {
            background-image: url(<?php echo base_url('assets/images/bg.jpg'); ?>);
            background-size: cover;
            background-position: center top;
            margin: 0;
            font-family: 'Comic Sans MS', cursive, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
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

        .card input[type="email"],
        .card input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-shadow: 0px 0px 6px 2px #ffe6e6;
            margin-bottom: 10px;
            margin-top: 5px;
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
            margin-top: 20px;
            margin-bottom: 10px;
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
    <div class="card">
        <img src="<?php echo base_url('assets/images/login.png'); ?>" alt="Login Image" class="login-img">
        <form id="loginForm">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit" id="loginBtn">Login</button>
            </div>
        </form>
        <div class="text-center">
            Don't have an account? <a href="<?php echo base_url('index.php/Auth/register'); ?>" class="text-dark">Create One</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#loginBtn').click(function(event) {
                event.preventDefault();
                $.ajax({
                    url: "<?php echo base_url() ?>index.php/Auth/login_user",
                    type: "POST",
                    data: {
                        email: $('#email').val(),
                        password: $('#password').val()
                    },
                    success: function(response) {
                        alert('Login successful');
                        window.location.href = "<?php echo base_url('index.php/QuizDisplay/quizes'); ?>";
                    },
                    error: function(xhr, status, error) {
                        alert('Login failed');
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>

</html>
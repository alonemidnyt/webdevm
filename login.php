<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./styles/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="wrapper">
        <div class="container main">
            <div class="row">
                <div class="col-md-6 side-image">

                    <!-------------      image     ------------->

                    <img src="assets/car-icon.png" alt="">
                    <div class="text">
                        <p>Welcome!</i></p>
                    </div>

                </div>
                <div class="col-md-6 right">

                    <div class="input-box">
                        <form action="./scripts/login_submit.php" method="POST">

                            <header>Login account</header>
                            <!-- Email Input -->
                            <div class="input-field">
                                <input type="text" class="input" id="email" name="email" required="" autocomplete="off">
                                <label for="email">Username</label>
                            </div>
                            <!-- Password Input -->
                            <div class="input-field">
                                <input type="password" class="input" id="password" name="password" required="">
                                <label for="password">Password</label>
                            </div>
                            <div class="input-field">

                                <button type="submit" name="submit" class="submit">Login</button>
                            </div>
                            <div class="signin">
                                <span>Don't have an account? <a href="register.php">Register in here</a></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
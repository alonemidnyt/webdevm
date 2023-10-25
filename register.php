<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="./styles/register.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="wrapper">
        <div class="container main">
            <div class="row">
                <div class="col-md-6 side-image">

                    <!-------------      image     ------------->

                    <img src="assets/car-icon.png" alt="">

                </div>
                <div class="col-md-6 right">

                    <div class="input-box">

                        <header>Register account</header>
                        <form method="POST" action="./scripts/register_submit.php">
                            <!-- Email Input  -->
                            <div class="input-field">
                                <input type="text" class="input" id="email" name="email" autocomplete="off" required>
                                <label for="email">Username</label>
                            </div>
                            <!-- Password Input -->
                            <div class="input-field">
                                <input type="password" class="input" id="password" name="password" required>
                                <label for="password">Password</label>
                            </div>

                            <!----------------------Button----------------------->
                            <div class="input-field">
                                <button type="submit" name="submit" class="submit">Register</button>
                            </div>
                            <div class="signin">
                                <span>Already have an account? <a href="login.php">Log in here</a></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>


</html>
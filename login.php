<?php
    include 'includes/loginFunctions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes Login</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Marck+Script&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style/loginRegisterStyle.css">
</head>
<body>
    <?php
        if(isset($_SESSION['logged'])){
            header('Location: notes.php');
        }
    ?>
    <main class="main">
        <div class="container">
            <a href="index.php"><img src="images/note.png" class="login__image"></a>
            <h1 class="title">Login</h1>
            <form action="" method="POST">
                <div class="form__group">
                    <input type="text" name="username" class="form__input" value="demo" placeholder="Username">
                </div>
                <div class="form__group">
                    <input type="password" name="password" class="form__input" value="demo" placeholder="Password">
                </div>
                <input type="submit" name="submit" class="form__submit" value="Login">
            </form>
            <a href="register.php" class="no__account">Register here</a>
            <?php
            if(isset($_POST['submit'])){
                loginUser();
            }
            ?>
        </div>
    </main>
</body>
</html>
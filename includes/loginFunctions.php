<?php include 'db.php' ?>
<?php
function loginUser()
{
    global $conn;
        $username = $_POST['username'];
        $password = $_POST['password'];
        $username = mysqli_real_escape_string($conn, $username);
        $password = mysqli_real_escape_string($conn, $password);
        $query = "SELECT * FROM users WHERE user_username = '$username'";
        $findUser = mysqli_query($conn, $query);
        $user = mysqli_fetch_assoc($findUser);
        if(mysqli_num_rows($findUser) < 1) {
            die("<p class='login__error'>ERROR: Username not found!</p>");
        }
        $hashedPassword = $user['user_password'];
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_firstname'] = $user['user_firstname'];
            $_SESSION['user_username'] = $user['user_username'];
            $_SESSION['user_role'] = $user['user_role'];
            $_SESSION['user_email'] = $user['user_email'];
            $_SESSION['logged'] = true;
            header('Location: notes.php');
        } else {
            echo "<p class='login__error'>ERROR: Password incorrect!</p>";
        }
}
?>
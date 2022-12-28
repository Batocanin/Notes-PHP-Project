<?php include 'db.php' ?>
<?php
function registerUser(){
    global $conn;
    $email = $_POST['email'];
    $email = mysqli_real_escape_string($conn, $email);
    $firstName = $_POST['firstName'];
    $firstName = mysqli_real_escape_string($conn, $firstName);
    $username = $_POST['username'];
    $username = mysqli_real_escape_string($conn, $username);
    $password = $_POST['password'];
    $password = mysqli_real_escape_string($conn, $password);
    $password = password_hash($password, PASSWORD_BCRYPT);
    if(empty($email) && empty($firstName) && empty($username) && empty($password)){
        die("<p class='login__error'>ERROR: All inputs are important!</p>");
    }
    $query = "SELECT * FROM users WHERE user_email = '$email'";
    $checkEmail = mysqli_query($conn, $query);
    if(mysqli_num_rows($checkEmail) > 0) {
        die("<p class='login__error'>ERROR: Email exist, try another!</p>");
    }
    $query = "SELECT * FROM users WHERE user_username = '$username'";
    $checkUsername = mysqli_query($conn, $query);
    if(mysqli_num_rows($checkUsername) > 0) {
        die("<p class='login__error'>ERROR: Username exist, try another!</p>");
    }
    $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
    $user_ip = $_SERVER['REMOTE_ADDR'];
    $query = "SELECT * FROM users WHERE user_ip = '$user_ip'";
    $checkExistIP = mysqli_query($conn, $query);
    if(mysqli_num_rows($checkExistIP) > 0){
        die("<p class='login__error'>ERROR: You can only have one account, because this site is for PORTFOLIO!</p>");
    }
    $query = "INSERT INTO users(user_firstname, user_email, user_username, user_password, user_role, user_ip) VALUES('$firstName', '$email', '$username', '$password', 'user', '$user_ip')";
    $insertUser = mysqli_query($conn, $query);
    header('Location: login.php');
}
?>
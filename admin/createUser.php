<?php
include 'header.php';

$fields = '';
if(isset($_POST['submit'])){
    try{
        $user_id = $_SESSION['user_id'];
        $user_username = $_POST['username'];
        $user_password = $_POST['password'];
        $user_firstname = $_POST['firstName'];
        $user_email = $_POST['email'];
        $user_role = $_POST['role'];
        if(!empty($user_username) && !empty($user_firstname) && !empty($user_password) && !empty($user_email) && !empty($user_role)){
            $query = "SELECT * FROM users WHERE user_email = '$user_email'";
            $checkEmail = mysqli_query($conn, $query);
            if(mysqli_num_rows($checkEmail) > 0) {
                throw new Exception('User email exist!');
            }
            $query = "SELECT * FROM users WHERE user_username = '$user_username'";
            $checkUsername = mysqli_query($conn, $query);
            if (mysqli_num_rows($checkUsername) > 0) {
                throw new Exception('Username exist!');
            }
            $user_username = mysqli_real_escape_string($conn, $user_username);
            $user_password = mysqli_real_escape_string($conn, $user_password);
            $user_password = password_hash($user_password, PASSWORD_BCRYPT);
            $user_firstname = mysqli_real_escape_string($conn, $user_firstname);
            $user_email = mysqli_real_escape_string($conn, $user_email);
            $user_role = mysqli_real_escape_string($conn, $user_role);
            $query = "INSERT INTO users(user_username, user_password, user_firstname, user_email, user_role) VALUES('$user_username', '$user_password', '$user_firstname', '$user_email', '$user_role')";
            $insertUser = mysqli_query($conn, $query);
        } else {
            throw new Exception('All fields are important');
        }
    }catch(exception $e) {
        $error = $e->getMessage();
    }
}
?>
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Create User</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="firstName" class="form-label">Username</label>
                                        <input
                                            class="form-control"
                                            type="text"
                                            id="username"
                                            name="username"
                                            value=""
                                            autofocus
                                        />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="password" class="form-label">Password</label>
                                        <input class="form-control" type="password" name="password" id="password" value="" />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="firstName" class="form-label">First Name</label>
                                        <input class="form-control" type="text" name="firstName" id="firstName" value="" />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="email" class="form-label">E-mail</label>
                                        <input
                                            class="form-control"
                                            type="text"
                                            id="email"
                                            name="email"
                                            value=""
                                            placeholder="john.doe@example.com"
                                        />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <select class="form-control" name="role">
                                            <option value="admin">Admin</option>
                                            <option value="user">User</option>
                                        </select>
                                    </div>
                                </div>
                                <?php
                                if(!empty($error)){
                                    ?>
                                    <p class="text-danger font-weight-bold"><?php echo $error ?></p>
                                    <?php
                                }
                                ?>
                                <div class="mt-2">
                                    <button type="submit" name="submit" class="btn btn-primary me-2">Create User</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
include 'footer.php';
?>
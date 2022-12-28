<?php
function editUser(){
    if($_SESSION['user_role'] == 'admin') {
        global $conn;
        $user_id = $_GET['id'];
        $query = "SELECT * FROM users WHERE user_id = $user_id";
        $userQuery = mysqli_query($conn, $query);
        $user = mysqli_fetch_assoc($userQuery);

        if (isset($_POST['submit'])) {
            try {
                $user_username = $_POST['username'];
                $user_username = mysqli_real_escape_string($conn, $user_username);
                if ($user['user_username'] !== $user_username) {
                    $query = "SELECT * FROM users WHERE user_username = '$user_username'";
                    $checkUsername = mysqli_query($conn, $query);
                    if (mysqli_num_rows($checkUsername) > 0) {
                        throw new Exception('Username exist!');
                    }
                }
                $user_password = $_POST['password'];
                if (empty($user_password)) {
                    $user_password = $user['user_password'];
                } else {
                    $user_password = mysqli_real_escape_string($conn, $user_password);
                    $user_password = password_hash($user_password, PASSWORD_BCRYPT);
                }
                $user_firstname = $_POST['firstName'];
                $user_firstname = mysqli_real_escape_string($conn, $user_firstname);
                $user_email = $_POST['email'];
                $user_email = mysqli_real_escape_string($conn, $user_email);
                if ($user['user_email'] !== $user_email) {
                    $query = "SELECT * FROM users WHERE user_email = '$user_email'";
                    $checkEmail = mysqli_query($conn, $query);
                    if (mysqli_num_rows($checkEmail) > 0) {
                        throw new Exception('User email exist!');
                    }
                }
                $user_role = $_POST['role'];
                $user_role = mysqli_real_escape_string($conn, $user_role);
                $query = "UPDATE users SET user_username = '$user_username', user_password = '$user_password', user_firstname = '$user_firstname', user_email = '$user_email', user_role = '$user_role' WHERE user_id = $user_id";
                $updateUser = mysqli_query($conn, $query);
                header("refresh:2;url=users.php");
                throw new Exception('User settings changed!');
            } catch (exception $e) {
                $error = $e->getMessage();
            }
        }
    }
    ?>

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> Edit User</h4>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <form id="formAccountSettings" method="POST">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="firstName" class="form-label">Username</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        id="username"
                                        name="username"
                                        value="<?php echo $user['user_username'] ?>"
                                    />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="password" class="form-label">Password</label>
                                    <input class="form-control" type="password" name="password" id="password" value="" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="firstName" class="form-label">First Name</label>
                                    <input class="form-control" type="text" name="firstName" id="firstName" value="<?php echo $user['user_firstname'] ?>" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        id="email"
                                        name="email"
                                        value="<?php echo $user['user_email'] ?>"
                                        placeholder="john.doe@example.com"
                                    />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="role" class="form-label">Role</label>
                                    <select name="role" class="form-control">
                                        <option value="admin">Admin</option>
                                        <option value="user">User</option>
                                    </select>
                                </div>
                            </div>
                            <?php
                            if(!empty($error)){
                                ?>
                                <p class="text-primary font-weight-bold"><?php echo $error ?></p>
                                <?php
                            }
                            ?>
                            <div class="mt-2">
                                <button type="submit" name="submit" class="btn btn-primary me-2">Save changes</button>
                                <a href="users.php" class="btn btn-primary me-2">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}
$edit = '';
?>

<?php
function deleteUser(){
    if($_SESSION['user_role'] == 'admin'){
        global $conn;
        $user_id = $_GET['id'];
        $query = "DELETE FROM notes WHERE user_id = $user_id";
        $deleteNotesFromUser = mysqli_query($conn, $query);
        $query = "DELETE FROM users WHERE user_id = $user_id";
        $deleteUser = mysqli_query($conn, $query);
        header('Location: users.php');
    }
}

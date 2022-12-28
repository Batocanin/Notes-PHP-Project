<?php
include 'header.php';

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE user_id = $user_id";
$userQuery = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($userQuery);

if(isset($_POST['submit'])){
    try{
        $user_id = $_SESSION['user_id'];
        $user_username = $_POST['username'];
        $user_password = $_POST['password'];
        $user_firstname = $_POST['firstName'];
        $user_email = $_POST['email'];
        if(!empty($user_username) && !empty($user_email) && !empty($user_firstname)){
            if($user_email !== $_SESSION['user_email']){
                $query = "SELECT * FROM users WHERE user_email = '$user_email'";
                $checkEmail = mysqli_query($conn, $query);
                if(mysqli_num_rows($checkEmail) > 0) {
                    throw new Exception('User email exist!');
                }
            }
            if($user_username !== $_SESSION['user_username']) {
                $query = "SELECT * FROM users WHERE user_username = '$user_username'";
                $checkUsername = mysqli_query($conn, $query);
                if (mysqli_num_rows($checkUsername) > 0) {
                    throw new Exception('Username exist!');
                }
            }
            if(empty($user_password)){
                $query = "SELECT * FROM users WHERE user_id = $user_id";
                $userQuery = mysqli_query($conn,$query);
                $user = mysqli_fetch_assoc($userQuery);
                $user_password = $user['user_password'];
            } else {
                $user_password = mysqli_real_escape_string($conn, $user_password);
                $user_password = password_hash($user_password, PASSWORD_BCRYPT);
            }
            $user_username = mysqli_real_escape_string($conn, $user_username);
            $user_firstname = mysqli_real_escape_string($conn, $user_firstname);
            $user_email = mysqli_real_escape_string($conn, $user_email);
            $query = "UPDATE users SET user_username = '$user_username', user_password = '$user_password', user_firstname = '$user_firstname', user_email = '$user_email' WHERE user_id = $user_id";
            $updateUser = mysqli_query($conn, $query);
            $_SESSION['user_username'] = $user_username;
            $_SESSION['user_email'] = $user_email;
            $_SESSION['user_firstname'] = $user_firstname;
            header( "refresh:2;url=profile.php" );
            throw new Exception('Profile settings changed!');
        } else {
            throw new Exception('All fields are important');
        }
    }catch(exception $e) {
        $error = $e->getMessage();
    }
}
?>
          <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Account</h4>
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
                              type="email"
                              id="email"
                              name="email"
                              value="<?php echo $user['user_email'] ?>"
                              placeholder=""
                            />
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
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
<?php
include 'footer.php';
?>
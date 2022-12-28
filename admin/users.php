<?php
include 'header.php';
include 'includes/userFunctions.php';
?>

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">

            <?php
            if(isset($_GET['edit'])){
                    editUser();
            } else if(isset($_GET['delete'])) {
                    deleteUser();
            } else {
            ?>
            <!-- Basic Bootstrap Table -->
            <div class="card">
                <h5 class="card-header">Users</h5>
                <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>E-Mail</th>
                        <th>FirstName</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                <tbody class="table-border-bottom-0">
                <?php
                $query = "SELECT * FROM users";
                $userQuery = mysqli_query($conn, $query);
                while($user = mysqli_fetch_assoc($userQuery)){
                    ?>
                    <tr>
                    <td><?php echo $user['user_id'] ?></td>
                    <td><i class="fab fa-angular fa-lg text-danger"></i> <strong><?php echo $user['user_username'] ?></strong></td>
                    <td><?php echo $user['user_email'] ?></td>
                    <td><?php echo $user['user_firstname'] ?></td>
                    <td><?php echo $user['user_role'] ?></td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="users.php?edit&id=<?php echo $user['user_id'] ?>"><i class="bx bx-edit-alt me-1"></i>Edit</a>
                                <a class="dropdown-item" onclick="javascript: return confirm('Are you sure you want to delete user <?php echo $user['user_username'] ?>');" href="users.php?delete&id=<?php echo $user['user_id'] ?>"><i class="bx bx-trash me-1"></i>Delete</a>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php
                }
            }
                ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
<?php
include 'footer.php';
?>
<?php
include 'header.php';

if(isset($_GET['delete'])){
    if($_SESSION['user_role'] == 'admin') {
        $note_id = $_GET['id'];
        $query = "DELETE FROM notes WHERE note_id = $note_id";
        $deleteNote = mysqli_query($conn, $query);
    }
}
?>
          <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="card">
                <h5 class="card-header">Notes</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Note ID</th>
                        <th>Title</th>
                        <th>User</th>
                        <th>Important</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    <?php
                        $query = "SELECT * FROM notes";
                        $notesQuery = mysqli_query($conn, $query);
                        while($note = mysqli_fetch_assoc($notesQuery)){
                            ?>
                            <tr>
                                <td><?php echo $note['note_id'] ?></td>
                                <td><i class="fab fa-angular fa-lg text-danger"></i> <strong><?php echo $note['note_title'] ?></strong></td>
                                <td><?php
                                    $user_id = $note['user_id'];
                                    $query = "SELECT * FROM users WHERE user_id = $user_id";
                                    $userQuery = mysqli_query($conn, $query);
                                    $user = mysqli_fetch_assoc($userQuery);
                                    echo $user['user_username'];
                                    ?></td>
                                <td><?php echo $note['note_important'] ?></td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" onclick="javascript: return confirm('Are you sure you want to delete note from user <?php echo $user['user_username'] ?>');" href="notesList.php?delete&id=<?php echo $note['note_id'] ?>"><i class="bx bx-trash me-1"></i>Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php
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
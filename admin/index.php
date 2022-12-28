<?php
include 'header.php';
?>

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row">
                <div class="col-lg-4 col-md-4 order-1">
                  <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <span class="fw-semibold d-block mb-1">Notes</span>
                          <h3 class="card-title mb-2">
                              <?php
                              $query = "SELECT * FROM notes";
                              $notesQuery = mysqli_query($conn, $query);
                              $numNotes = mysqli_num_rows($notesQuery);
                              echo $numNotes;
                              ?></h3>
                        </div>
                      </div>
                    </div>
                  <div class="col-lg-6 col-md-12 col-6 mb-4">
                      <div class="card">
                          <div class="card-body">
                              <span class="fw-semibold d-block mb-1">Users</span>
                              <h3 class="card-title mb-2">
                                  <?php
                                  $query = "SELECT * FROM users";
                                  $usersQuery = mysqli_query($conn, $query);
                                  $numUsers = mysqli_num_rows($usersQuery);
                                  echo $numUsers;
                                  ?></h3>
                          </div>
                      </div>
                  </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

<?php
include 'footer.php';
?>

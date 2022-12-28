<?php

// Logout function
if(isset($_POST['logout'])){
    unset($_SESSION['user_id']);
    unset($_SESSION['user_firstName']);
    unset($_SESSION['user_role']);
    unset($_SESSION['logged']);
    header('Location: login.php');
}


/////////////////// NOTE FUNCTIONS /////////////////////////
// Side Load Notes
function sideLoad(){
    global $conn;
    $user_id = $_SESSION['user_id'];
    $user_id = mysqli_real_escape_string($conn, $user_id);
    $query = "SELECT * FROM notes WHERE user_id = $user_id";
    $showNotesQuery = mysqli_query($conn, $query);
    if(mysqli_num_rows($showNotesQuery) < 1){
        ?>
        <p class="no__result">No Results Found!</p>
        <?php
    } else {
    $query = "SELECT * FROM notes WHERE user_id = $user_id AND note_important = 1 ORDER BY note_id DESC";
    $showNotesQuery = mysqli_query($conn, $query);
    while($note = mysqli_fetch_assoc($showNotesQuery)){
        ?>
        <a href="notes.php?id=<?php echo $note['note_id'] ?>" class="note__link">
            <div class="note important">
                <h3 class="note-title">
                    <?php
                    if(empty($note['note_title'])) {
                        echo 'Title not entered';
                    }
                    else if(strlen($note['note_title']) >= 27){
                        echo substr($note['note_title'], 0, 27). '...';
                    } else {
                        echo $note['note_title'];
                    }
                    ?>
                </h3>
                <p class="note-time"><?php echo $note['note_date'] ?></p>
                <p class="note-firstLine">
                    <?php
                    if(empty($note['note_content'])){
                        echo 'Content not entered';
                    } else if(strlen($note['note_content']) >= 36){
                        echo substr($note['note_content'], 0, 36). '...';
                    } else {
                        echo $note['note_content'];
                    }?>
                </p>
            </div>
        </a>
    <?php
    }
    $query = "SELECT * FROM notes WHERE user_id = $user_id AND note_important = 0 ORDER BY note_id ASC";
    $showNotesQueryImportantZero = mysqli_query($conn, $query);
    while($note = mysqli_fetch_assoc($showNotesQueryImportantZero)){
        ?>
        <a href="notes.php?id=<?php echo $note['note_id'] ?>" class="note__link">
            <div class="note">
                <h3 class="note-title">
                    <?php
                    if(empty($note['note_title'])){
                      echo 'Title not entered';
                    } else if(strlen($note['note_title']) >= 27){
                        echo substr($note['note_title'], 0, 27). '...';
                    } else {
                        echo $note['note_title'];
                    }
                    ?>
                </h3>
                <p class="note-time"><?php echo $note['note_date'] ?></p>
                <p class="note-firstLine">
                    <?php
                    if(empty($note['note_content'])){
                        echo 'Content not entered';
                    } else if(strlen($note['note_content']) >= 36){
                        echo substr($note['note_content'], 0, 36). '...';
                    } else {
                        echo $note['note_content'];
                    }?>
                </p>
            </div>
        </a>
        <?php
        }
    }
}

// Add New Note
function addNewNote(){
    global $conn;
    $user_id = $_SESSION['user_id'];
    $user_id = mysqli_real_escape_string($conn, $user_id);
    $title = $_POST['note__title-input'];
    $title = mysqli_real_escape_string($conn, $title);
    if(isset($_POST['important'])){
        $important = 1;
    } else {
        $important = 0;
    }
    $content = $_POST['content'];
    $content = mysqli_real_escape_string($conn, $content);
    $currentTime = date('d/m/20y H:i');
    $currentTime = mysqli_real_escape_string($conn, $currentTime);
    $query = "INSERT INTO notes (user_id, note_title, note_important, note_content, note_date) VALUES($user_id, '$title', $important, '$content', '$currentTime')";
    $insertNewNote = mysqli_query($conn, $query);
    $lastIDNotes = mysqli_insert_id($conn);
    header("Location: notes.php?id=$lastIDNotes");
}

// Show Note in Main Section
function showNote(){
    global $conn;
    $note_id = $_GET['id'];
    $note_id = mysqli_real_escape_string($conn, $note_id);
    $query = "SELECT * FROM notes WHERE note_id = $note_id";
    $selectNote = mysqli_query($conn, $query);
    $note = mysqli_fetch_assoc($selectNote);
    if($_SESSION['user_id'] === $note['user_id']){
        ?>
        <div class="content__header">
            <h1 class="content__title">
                <?php
                if(empty($note['note_title'])){
                    echo 'Title not found';
                } else {
                    echo $note['note_title'];
                }
                ?>
            </h1>
            <div class="content__header--buttons">
                <a href="?delete&id=<?php echo $note['note_id'] ?>" class="btn button__delete">Delete</a>
                <a href="?edit&id=<?php echo $note['note_id'] ?>" class="btn button__edit">Edit</a>
            </div>
        </div>
        <div class="note__content">
            <?php
            if(empty($note['note_content'])){
                ?>
                <p class="content">Content not found</p>
                <?php
            } else {
                ?>
                <p class="content"><?php echo $note['note_content'] ?></p>
                <?php
            }
            ?>
        </div>
        <?php
    } else {
        header('Location: notes.php');
    }
}

// Delete Note
if(isset($_GET['delete'])){
        $note_id = $_GET['id'];
        $note_id = mysqli_real_escape_string($conn, $note_id);
        $user_id = $_SESSION['user_id'];
        $query = "SELECT * FROM notes WHERE note_id = $note_id";
        $getNote = mysqli_query($conn, $query);
        $note = mysqli_fetch_assoc($getNote);
        if($note['user_id'] == $user_id){
            $query = "DELETE FROM notes WHERE note_id = $note_id";
            $deleteNote = mysqli_query($conn, $query);
            header('Location: notes.php');
        } else {
            header('Location: notes.php');
        }
}

// Edit Note
function editNote(){
    global $conn;
    $note_id = $_GET['id'];
    $note_id = mysqli_real_escape_string($conn, $note_id);
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM notes WHERE note_id = $note_id";
    $queryNote = mysqli_query($conn, $query);
    $note = mysqli_fetch_assoc($queryNote);
        if($note['user_id'] == $user_id){
            ?>
            <form action="" method="POST" class="note__edit">
                <header class="note__edit--header">
                    <input placeholder="Title.." name="note__title-input" type="text" class="note__title-input" value="<?php echo $note['note_title'] ?>">
                </header>
                <textarea class="textarea__content" name="content" rows="18" cols="100%" placeholder="Content text..."><?php echo $note['note_content'] ?></textarea>
                <div class="radio__btn">
                    <div class="important__btn">
                        <?php
                        if($note['note_important'] == 1){
                            ?>
                            <input type="checkbox" name="important" class="note__important--button" checked>
                            <?php
                        } else {
                            ?>
                            <input type="checkbox" name="important" class="note__important--button">
                            <?php
                        }
                        ?>
                        <span class="important__text">Important</span>
                    </div>
                    <input type="submit" name="editNote" value="Apply" class="btn edit__btn">
                </div>
            </form>
            <?php
        } else {
            header('Location: notes.php');
        }
}
if(isset($_POST['editNote'])){
    $note_id = $_GET['id'];
    $note_id = mysqli_real_escape_string($conn, $note_id);
    $title = $_POST['note__title-input'];
    $title = mysqli_real_escape_string($conn, $title);
    if(isset($_POST['important'])){
        $important = 1;
    } else {
        $important = 0;
    }
    $content = $_POST['content'];
    $content = mysqli_real_escape_string($conn, $content);
    $currentTime = date('d/m/20y H:i');
    $currentTime = mysqli_real_escape_string($conn, $currentTime);
    $query = "UPDATE notes SET note_title='$title', note_important='$important', note_content = '$content', note_date = 'Last time edited: $currentTime' WHERE note_id = $note_id";
    $editNote = mysqli_query($conn, $query);
    header("Location: notes.php?id=$note_id");
}

// Search Note
function searchNote(){
    global $conn;
    $searchResult = $_POST['search'];
    $searchResult = mysqli_real_escape_string($conn, $searchResult);
    $query = "SELECT * FROM notes WHERE (note_content LIKE '%$searchResult%')";
    $allNotes = mysqli_query($conn, $query);
    if(mysqli_num_rows($allNotes) < 1){
        ?>
        <p class="no__result">No Results Found!</p>
        <?php
    } else {
        $user_id = $_SESSION['user_id'];
        while($note = mysqli_fetch_assoc($allNotes)){
            $note_id = $note['note_id'];
            $query = "SELECT * FROM notes WHERE note_id = $note_id";
            $queryNote = mysqli_query($conn, $query);
            $note = mysqli_fetch_assoc($queryNote);
            if($note['user_id'] == $user_id){
                if($note['note_important'] == 1){
                    ?>
                    <a href="notes.php?id=<?php echo $note['note_id'] ?>" class="note__link">
                        <div class="note important">
                            <h3 class="note-title">
                                <?php
                                if(strlen($note['note_title']) >= 28){
                                    echo substr($note['note_title'], 0, 28). '...';
                                } else {
                                    echo $note['note_title'];
                                }
                                ?>
                            </h3>
                            <p class="note-time"><?php echo $note['note_date'] ?></p>
                            <p class="note-firstLine">
                                <?php
                                if(strlen($note['note_content']) >= 38){
                                    echo substr($note['note_content'], 0, 38). '...';
                                } else {
                                    echo $note['note_content'];
                                }?>
                            </p>
                        </div>
                    </a>
                    <?php
                }
                if($note['note_important'] == 0){
                    ?>
                    <a href="notes.php?id=<?php echo $note['note_id'] ?>" class="note__link">
                        <div class="note">
                            <h3 class="note-title">
                                <?php
                                if(strlen($note['note_title']) >= 28){
                                    echo substr($note['note_title'], 0, 28). '...';
                                } else {
                                    echo $note['note_title'];
                                }
                                ?>
                            </h3>
                            <p class="note-time"><?php echo $note['note_date'] ?></p>
                            <p class="note-firstLine">
                                <?php
                                if(strlen($note['note_content']) >= 38){
                                    echo substr($note['note_content'], 0, 38). '...';
                                } else {
                                    echo $note['note_content'];
                                }?>
                            </p>
                        </div>
                    </a>
                    <?php
                }
            }
        }
    }
}

/////////////////// NOTE FUNCTIONS /////////////////////////

// Check if Note exist (URL CHECK)
if(isset($_GET['id'])){
    $note_id = $_GET['id'];
    $note_id = mysqli_real_escape_string($conn, $note_id);
    $query = "SELECT * FROM notes WHERE note_id = $note_id";
    $checkID = mysqli_query($conn, $query);
    if(mysqli_num_rows($checkID) < 0){
        header('Location: index.php');
    }
}
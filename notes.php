<?php
include 'includes/db.php';
include 'includes/noteFunctions.php';
ob_start();
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Notes</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Marck+Script&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="style/style.css">
    </head>
    <body>
<?php
if(!$_SESSION['logged']){
    header('Location: login.php');
}
?>

<main class="main">
    <div class="container">
        <div class="section__note">
            <div class="note__section-header">
                <div class="note__logo">
                    <img src="images/note.png" class="note__header--logo">
                </div>
                <div class="header__hi">
                    <h1 class="note__name">Hello, <?php echo $_SESSION['user_firstname'] ?>!</h1>
                    <img src="images/smileface.gif" class="hi__smile">
                </div>
                <div class="note__header--buttons">
                    <button class="btn add__note">Add New Note</button>
                    <form action="" method="POST">
                        <input type="submit" name="logout" class="btn main__logout" value="Logout">
                    </form>
                    <?php
                    if(isset($_SESSION['user_role'])){
                        if($_SESSION['user_role'] == 'admin'){
                            ?>
                            <a href="admin/index.php" class="btn">Admin Panel</a>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="note__content">
                <div class="note__section--side">
                    <div class="side__search">
                        <form action="" method="POST">
                            <input name="search" class="side__search--input" placeholder="Search by content...">
                        </form>
                        <?php
                        if(isset($_POST['search'])){
                            ?>
                            <div class="showAllNotes">
                                <?php
                                if(isset($_GET['id'])){
                                    ?>
                                    <a href="notes.php?id=<?php echo $_GET['id'] ?>" class="showAll__notes">Show All Notes</a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="notes.php" class="showAll__notes">Show All Notes</a>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="note__section--list">
                        <?php
                        if(isset($_POST['search'])){
                            searchNote();
                        } else {
                            sideLoad();
                        }
                        ?>
                    </div>
                </div>
                <div class="main__content">
                    <?php
                    if(isset($_POST['addNewNote'])){
                        addNewNote();
                    }
                    if(isset($_GET['edit'])){
                        editNote();
                    } else if(isset($_GET['id'])){
                        showNote();
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="js/script.js"></script>
    </body>
</html>

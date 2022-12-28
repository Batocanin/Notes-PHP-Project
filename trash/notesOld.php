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

    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
    if(!$_SESSION['logged']){
        header('Location: login.php');
    }
?>
    <main class="main">
        <div class="container">
            <header class="main__header">
                <h3 class="firstName">Zdravo, <?php echo $_SESSION['user_firstName'] ?>!</h3>
                <form action="" method="POST">
                <input type="submit" name="logout" class="main__logout" value="Logout">
                </form>
            </header>
            <div class="flex">
                <div class="side">
                    <div class="side__header">
                        <h1 class="side__title">Notes</h1>
                        <button class="add__note">Add New Note</button>
                    </div>
                    <div class="search">
                        <form action="" method="POST">
                            <input name="search" class="side__search" placeholder="Search by content...">
                        </form>
                    </div>
                    <?php
                    if(isset($_POST['search'])){
                        ?>
                            <a class="show_all--notes" href="../notes.php">Show All Notes</a>
                        <?php
                        searchNote();
                    } else {
                        sideLoad();
                    }
                    ?>
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
        <footer>
            <h1>Footer</h1>
        </footer>
    </main>

    <script src="../js/script.js"></script>
</body>
</html>
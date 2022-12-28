<?php
    function addNewNote(){
        if(isset($_POST['submit'])){
            echo 'TEST';
            ?>
            <header>
            <input placeholder="Title..." name="note__title-input" type="text" class="note__title-input">
            <div class="radio__btn">
                <input type="checkbox" name="important" class="note__important-button">
                <span class="important__text">Important</span>
            </div>
        </header>
        <textarea class="textarea" id="w3review" name="w3review" rows="20" cols="60" placeholder="Text...">At w3schools.com you will learn how to make a website. They offer free tutorials in all web development technologies.</textarea>
        <?php
            header('Location: notes.php');
        }
    }
?>
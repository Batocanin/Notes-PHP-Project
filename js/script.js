'use strict';
const mainContent = document.querySelector('.main__content');
const btnAddNote = document.querySelector('.add__note');
btnAddNote.addEventListener('click', function(){
    mainContent.innerHTML = '';
    if(!mainContent.contains(document.querySelector('header'))){
        mainContent.insertAdjacentHTML("afterbegin", `        
            <form action="" method="POST" class="note__edit">
                <header class="note__edit--header">
                    <input placeholder="Title.." name="note__title-input" type="text" class="note__title-input">
                </header>
                <textarea class="textarea__content" name="content" rows="18" cols="100%" placeholder="Content text..."></textarea>
                <div class="radio__btn">
                    <div class="important__btn">
                            <input type="checkbox" name="important" class="note__important--button">
                            <span class="important__text">Important</span>
                    </div>
                    <input type="submit" name="addNewNote" value="Add" class="btn edit__btn">
                </div>
            </form>            
`   )
    }
})
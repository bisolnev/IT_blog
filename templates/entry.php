<?php require('header.php') ?>

<style type="text/css" >
    .comments {
        font-size: 0.9em;
        margin-bottom: 20px; 
        <!-- background: #F8F8F8  ; -->
    }
    .comment-header{
        font-size: 1em;
        padding-bottom:10px;
    }
    .comment-content{
        padding-left:10px;
        margin-bottom: 10px;
    }
    .date, .author {  
        margin-right: 10px;
    }
    .content{
        padding-top: 5px;
        padding-left: 15px;
    }
    h2{
        margin-bottom: 10px;
    }
</style>

<h2> <?=$ENTRY['header']?> </h2>
     <p class="well"><?=$ENTRY['content']?></p>
     <div class="comments" >
        <span class="date">[<?=$ENTRY['date']?>]</span>
        <span class="author"><i
                 class="icon-user"></i><?=$ENTRY['author']?></span>
     </div>
     
 <h2> Коментари</h2>   
 
<?php foreach ($comments as $row): ?>
    <hr>
     <div class="comments">
        <div class="comment-header">
           <span class="date">[<?=$row['date']?>]</span>
           <span class="author"><i class="icon-user"></i><?=$row['author']?></span>
           <?php if (IS_ADMIN): ?>
         <a href="?act=delete-comment&entry_id=<?=$ENTRY['id']?>&id=<?=$row['id']?>"><i
                 class="icon-trash"></i>delete comment</a>
         <?php endif ?>
        </div>
     <p class="comment-content"><?=$row['content']?></p>
     </div>
<?php endforeach ?>
     <hr>
<h2> Добави нов коментар</h2>

<form action="?act=do-new-comment" method="POST" class="well" id="useform">
    <input type="hidden" name="entry_id" value="<?=$id?>">
    <label>Автор(име)</label>
    <input name="author" type="text">
    <label>Съдържание</label>
    <textarea  cols="40" rows="5" name="content" form="useform"></textarea>
    <div style="padding-top: 10px;">
        <button style="submit" class="btn">
        Изпрати
        </button>
    </div>
</form>
 
<?php require('footer.php') ?>
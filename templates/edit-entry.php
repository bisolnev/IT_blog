<?php require('header.php') ?>

<h1>Edit entry</h1>

<form action="?act=applay-edit-entry" method="POST" class="well" id="useform">
    <input type="hidden" name="id" value="<?=$id?>" />
    <label>Author</label>
    <input name="author" type="text" value="<?=$row['author']?>" />
    <label>Header</label>
    <input name="header" type="text" value="<?=$row['header']?>" />
    <label>Content</label>
    <textarea  cols="40" rows="5" name="content" form="useform"><?=$row['content']?></textarea>
    <div style="padding-top: 10px;">
        <button style="submit" class="btn">
        Post
        </button>
    </div>
</form>

<?php require('footer.php') ?>
<?php require('header.php') ?>


<style type="text/css" >
    .comments{
        font-size: 0.8em;
        margin-bottom: 20px;        
    }
    .date, .author {  
        margin-right: 10px;
    }
    .content{
        padding-top: 5px;
        padding-left: 15px;
    }
    .entry{
        padding-left:20px;
    }
    h3{
        margin-bottom: 10px;
    }
</style>
<h1>Статии в блога</h1>
<?php foreach ($records as $row): ?>
    
     <div class="well">
     <h3> 
         <a href="?act=view-entry&id=<?=$row['id']?>"> <?=$row['header']?>  </a>
         <?php if (IS_ADMIN): ?>
         <a href="?act=edit-entry&id=<?=$row['id']?>"><i class="icon-edit"></i>промени</a>
         <a href="?act=delete-entry&id=<?=$row['id']?>"><i class="icon-trash"></i>изтрий</a>
         <?php endif ?>
     </h3>
     <p><?=$row['content']?></p>
       <span class="date">[<?=$row['date']?>]</span>
        <span class="author"><i class="icon-user"></i><?=$row['author']?></span>
     <div class="comments">
         <a href="?act=view-entry&id=<?=$row['id']?>"><?=$row['comments']?> коментари</a></div>
     </div>
<?php endforeach ?>

<div class="pages">
<strong>Страници:</strong>
<?php for($i=1; $i<=$pages; $i++):  ?>
     <?php  if ($i==$page): ?>
            <b><?=$i?></b>
     <?php else: ?>
            <a href="?page<?=$i?>"></a>
     <?php endif ?>
<?php endfor ?>
</div>     
    
<?php if (IS_ADMIN): ?>
<h2> Добави нова статия</h2>

<form action="?act=do-new-entry" method="POST" class="well" id="useform">
    <label>Автор</label>
    <input name="author" type="text">
    <label>Заглавие</label>
    <input name="header" type="text">
    <label>Съдържание</label>
    <textarea  class="input-xxlarge"  name="content" form="useform"></textarea>
    <div style="padding-top: 10px;">
        <button style="submit" class="btn">
        Post
        </button>
    </div>
</form>

        
<?php endif ?>
<?php require('footer.php') ?>
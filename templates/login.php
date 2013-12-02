<?php require('header.php') ?>

<form action="?act=do-login" method="POST" class="well">
    <label>Потребител</label>
    <input name="login" type="text">
    <label>Парола</label>
    <input name="password" type="password">
    <div style="padding-top: 10px;">
        <button style="submit" class="btn">
        Влез
        </button>
    </div>
</form>
     
<?php require('footer.php') ?>
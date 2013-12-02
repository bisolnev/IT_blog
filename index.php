<?php
session_start();
header('Content-type: text/html; charset=UTF-8');
$mysqli = new mysqli('localhost' ,'root','123','blog') or die ('Cannot connect to datebase!');
//$mysqli -> select_db(blog) or die ('Cannot select datebase!');
$mysqli->set_charset('UTF-8');
mb_internal_encoding('UTF-8');
$act = isset($_GET['act']) ? $_GET['act']:'list';
$formatstr = 'Y-m-d H:i:s';

define ('IS_ADMIN', isset($_SESSION['IS_ADMIN']));


switch ($act){
    case 'list':
        $page = isset($_GET['page']) ?  max(1,intval($_GET['page'])) : 1;
        $limit = 10;
        $offset = ($page -1)* $limit;
        $records = array();
        $pages_result = $mysqli->query("SELECT COUNT(*)
            AS cnt FROM entry")->fetch_assoc();
        $pages=$pages_result['cnt'];
        $sel=$mysqli ->query("SELECT entry.*, COUNT(comment.id) AS comments 
            FROM entry
            LEFT JOIN comment ON entry.id = comment.entry_id
            GROUP BY entry.id
            ORDER BY date DESC
            LIMIT $offset, $limit");  
        while ($row = $sel->fetch_assoc()){
            
            $row['date']=date($formatstr,$row['date']);
            if (mb_strlen($row['content'])>60){
                $row['content']=mb_substr(strip_tags($row['content']),0,57).'...';
            }
            $row['content']=  nl2br($row['content']);
            $row['header']=htmlspecialchars($row['header']);
            $records[]=$row;
        }
        require('templates/list.php');
        break;
    case 'view-entry':
        if (!isset($_GET['id'])) die ("Missing ID");
        $id=intval($_GET['id']);
        
        $ENTRY = $mysqli->query("SELECT * FROM entry WHERE id = $id")->fetch_assoc();
        if (!$ENTRY) die ("No such entry");
        
        $ENTRY['date']=date($formatstr,$ENTRY['date']);
        $ENTRY['content']=  nl2br($ENTRY['content']);
        $ENTRY['header']=htmlspecialchars($ENTRY['header']);
        
        $comments = array();
        $sel = $mysqli->query("SELECT * FROM comment WHERE entry_id = $id ORDER BY date");
        
        while ($row = $sel->fetch_assoc()){
            
            $row['date']=date($formatstr,$row['date']);
            $row['content']=  nl2br(htmlspecialchars($row['content']));
            //$row['header']=htmlspecialchars($row['header']);
            $row['author']=htmlspecialchars($row['author']);
            $comments[]=$row;
        }
        
        require('templates/entry.php');
        break;
    case 'do-new-entry':
        if (!IS_ADMIN) die ('You must be admin to add entry');
        $sel = $mysqli->prepare("INSERT INTO 
            entry(author, date,header,content)
            VALUES (?,?,?,?)");
        $time=  time();
        $sel->bind_param('siss',
                $_POST['author'],
                $time, $_POST['header'],
                $_POST['content']);
        if ($sel->execute()){
            header('Location: .');
        }else{
            die ('Cannot insert entry!');
        }
        break;
        case 'delete-entry':
        if (!IS_ADMIN) die ('You must be admin to delite entry');
        $id=intval($_GET['id']);
        $mysqli->query("DELETE FROM entry where id=$id") or die('Cannot Delete entry');
        $mysqli->query("DELETE FROM comment where entry_id=$id")or die('Cannot Delete comment');
        header('Location: .');
        break;
        case 'delete-comment':
        if (!IS_ADMIN) die ('You must be admin to delite comment');
        $id=intval($_GET['id']);
        $mysqli->query("DELETE FROM comment where id=$id") or die('Cannot delete comment');
        header('Location: ?act=view-entry&id='. intval($_GET['entry_id']));
        break;
        case 'edit-entry':
        if (!IS_ADMIN) die ('You must be admin to edit entry');
        $id=intval($_GET['id']);
        $row=$mysqli->query("SELECT * FROM entry WHERE id=$id")->fetch_assoc();
        require('templates/edit-entry.php');
        break;
        case 'applay-edit-entry':
        if (!IS_ADMIN) die ('You must be admin to edit entry');
        $sel = $mysqli->prepare("UPDATE
            entry SET author=? ,header= ?,content= ? WHERE id=
            ?");
        $id=intval($_POST['id']);
        $sel->bind_param('sssi',
                $_POST['author'],
                $_POST['header'],
                $_POST['content'],
                $id);
        if ($sel->execute()){
            header('Location: .');
        }else{
            die ('Cannot edit entry!');
        }
        break;
        case 'do-new-comment':
        $sel = $mysqli->prepare("INSERT INTO 
            comment(entry_id, author, date,content)
            VALUES (?,?,?,?)");
        $time=  time();
        $sel->bind_param('isis',
                $_POST['entry_id'],
                $_POST['author'],
                $time,
                $_POST['content']);
        if ($sel->execute()){
            header('Location: ?act=view-entry&id='. intval($_POST['entry_id']));
        }else{
            die ('Cannot insert entry!');
        }
        break;
    case 'login':
        require('templates/login.php');
        break;
    case 'logout':
        unset($_SESSION['IS_ADMIN']);
        header('Location: .');
        break;
    case 'do-login':
        if ($_POST['login']=='login' && $_POST['password']=='123'){
            $_SESSION['IS_ADMIN']=true;
            header('Location: .');
        }else{
            header('Location: ?act=login');
        }
        break;
    default: 
           die ('No such act!');
        
}


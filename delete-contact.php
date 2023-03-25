<?php
require_once('./includes/functions.inc.php');


if(!isset($_GET['id'])) {
    dd( "Id not set");
}else{
    $id=$_GET['id'];
    $query=prepare_delete_query("contacts","id =$id");
    db_query($query);
    // echo "Deleted id:- $id";
    header('Location: index.php?op=delete&status=success');
   
}
?>

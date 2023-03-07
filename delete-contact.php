<?php
require_once('./includes/functions.inc.php');

$result=false;
if(!isset($_GET['id'])) {
    dd( "Id not set");
}else{
    $id=$_GET['id'];
    $query=prepare_delete_query("contacts","id =$id");
    db_query($query);
    $result=true;
    // echo "Deleted id:- $id";
   
}

if($result) {
     header('Location: index.php?op=delete&status=success');
} else { 
    header('Location: index.php?op=delete&status=error');
}


?>

<?php
function db_connect(){
    static $connection;
    if(!isset($connection)){
        $config=parse_ini_file("./config.ini");
        $connection=mysqli_connect($config['host'],$config['username'],$config['password'],$config['database'],$config['port']);
    }

    if(!$connection){
        dd(mysqli_connect_error());
    }

    return $connection;
}

function db_query($query){
    $connection=db_connect();
    $result=mysqli_query($connection,$query);
    return $result;
}

function db_select($select_query){
    $result=db_query($select_query);
    if(!$result){
        return false;
    }
    $rows=array();
    while($row=mysqli_fetch_assoc($result)){
        $rows[]=$row;  //in php [] khudhi new index banata hai and data dalta hai
    }

    return $rows;
}

function db_error(){
    $connection=db_connect();
    return mysqli_error($connection);
}
function dd($mixed_data){
    die(var_dump($mixed_data));
}


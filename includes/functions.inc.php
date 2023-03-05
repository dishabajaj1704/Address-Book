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
    $rows=array();  //declared row as array
    while($row=mysqli_fetch_assoc($result)){
        $rows[]=$row;  //in php [] khudhi new index banata hai and data dalta hai
        // print_r($rows);
    }

    return $rows;
}

function get_last_insert_id(){
    $connection=db_connect();
    return mysqli_insert_id($connection);
}

//Prevents mysql injection
function sanitize($value){
    $connection=db_connect();
    return trim(mysqli_real_escape_string($connection,$value));
}


function old($collection,$key,$defaultValue=""){
    //Form mein koi value wrong hai toh right value bhi nikal jarahe the to prevent that..
    return trim(isset($collection[$key])?$collection[$key]:$defaultValue);
}


function getOldValue($data, $key, $defaultValue = "") {
    if(isset($data[$key])) {
        return $data[$key];
    }

    return $defaultValue;
}

function prepare_insert_query($table_name,$data){
    // '' commas for insert query for string ,phone no,address etc
    $values=array_values($data);
    for($i=0;$i<count($values);$i++){
        $values[$i]="'".$values[$i]."'";
    }
    //implode is used for converting array to string
    $columns=implode(", ",array_keys($data));
    $values=implode(", ",$values);
    $query="INSERT INTO $table_name($columns) VALUES($values)";
    return $query;
}
// function prepare_update_query($table_name,$data,$where){
//     $values=array_values($data);
//     $keys=array_keys($data);
//     for($i=0;$i<count($keys);$i++){
//         $keys[$i]=$keys[$i]."='".$values[$i]."'";
//     }
    
//     $params=implode(", ",$keys);
//      $query = "UPDATE $table_name SET $params where $where";

//      return $query;
// }


function prepare_update_query($table_name,$data,$where){
    //UPDATE table_name SET col1=value1,col2=value2
    $params="";
    foreach($data as $key=>$value){
        $params.="$key = '$value', ";
    }
     $params=rtrim($params,", ");
     $query = "UPDATE $table_name SET $params WHERE $where";

     return $query;
}

function get_image_name($image_name,$id){
    // If name contains only extension
    return strpos($image_name,'.')?$image_name:"$id.$image_name";
}

function db_error(){
    $connection=db_connect();
    return mysqli_error($connection);
}
function dd($mixed_data){
    die(var_dump($mixed_data));
}


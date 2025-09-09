<?php

$host="localhost";
$user="root";
$pass="";
$db="pap";
$conn=new mysqli($host,$user,$pass,$db);
if($conn->connect_error){
    die("Falha ao conectar á base de dados!".$conn->connect_error);
}
?>
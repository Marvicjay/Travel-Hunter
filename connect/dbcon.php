<?php
try{
    $pdoConnect = new PDO("mysql:host=localhost;dbname=dbportal","root","12345");
    $pdoConnect-> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} 
catch(PDOException $e){
    echo $e-> getMessage();
}
?>
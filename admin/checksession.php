<?php 
session_start(); 
 
if ($_SESSION ['username'] == "")//masuk secara haram
    echo"<script>window.location.href='login.php';</script>";

?>
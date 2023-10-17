<?php session_start(); /* Starts the session */

if(!isset($_SESSION['UserData']['Username'])){
        header("location:login.php");
        exit;
}
?>

<?php
include 'functions.php'; // untuk memanggil fungsi pada file ./function.php
// Your PHP code here.

// Home Page template below.
?>

<?=template_header('Dashboard - Vito Karyadi')?>

<div class="content">
	<h2>Task Manager</h2>
	<p>Welcome Vito Karyadi to your Task Manager</p><br>
	<p>App Version: <b>v1.2.1</b></p>
	<p>+ Fix Bug Auth</p>
</div>

<?=template_footer()?>
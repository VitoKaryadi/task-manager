<?php session_start(); /* Starts the session */

if(!isset($_SESSION['UserData']['Username'])){
        header("location:login.php");
        exit;
}
?>

<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $info = isset($_POST['info']) ? $_POST['info'] : '';
    $deadline = isset($_POST['deadline']) ? $_POST['deadline'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    $owner = isset($_POST['owner']) ? $_POST['owner'] : '';

    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO worklist VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$id, $name, $info, $deadline, $status, $owner]);
    // Output message
    $msg = 'Created Successfully!';
}
?>


<?=template_header('Create New Task - Vito Karyadi')?>

<div class="content update">
	<h2>Create New Task</h2>
    <form action="create.php" method="post">
        <label for="id">ID</label>
        <input type="text" name="id" value="auto" id="id">
        <label for="name">Task Name</label>
        <input type="text" name="name" id="name">
        <label for="info">Information</label>
        <input type="text" name="info" id="info">
        <label for="deadline">Deadline</label>
        <input type="text" name="deadline" id="deadline">
        <label for="status">Status</label>
        <input type="text" name="status" value="0" id="status">
        <label for="owner">Created by</label>
        <input type="text" name="owner" id="owner">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?> 
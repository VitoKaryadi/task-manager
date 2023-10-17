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
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $info = isset($_POST['info']) ? $_POST['info'] : '';
        $deadline = isset($_POST['deadline']) ? $_POST['deadline'] : '';
        $status = isset($_POST['status']) ? $_POST['status'] : '';
        $owner = isset($_POST['owner']) ? $_POST['owner'] : '';
        
        // Update the record
        $stmt = $pdo->prepare('UPDATE worklist SET id = ?, name = ?, info = ?, deadline = ?, status = ?, owner = ? WHERE id = ?');
        $stmt->execute([$id, $name, $info, $deadline, $status, $owner, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM worklist WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Task doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>



<?=template_header('Update Task - Vito Karyadi')?>

<div class="content update">
	<h2>Update Task #<?=$contact['id']?></h2>
    <form action="update.php?id=<?=$contact['id']?>" method="post">
        <label for="id">ID</label>
        <input type="text" name="id" value="<?=$contact['id']?>" id="id">
        <label for="name">Name</label>
        <input type="text" name="name" value="<?=$contact['name']?>" id="name">
        <label for="info">Information</label>
        <input type="text" name="info" value="<?=$contact['info']?>" id="info">
        <label for="deadline">Deadline</label>
        <input type="text" name="deadline" value="<?=$contact['deadline']?>" id="deadline">
        <label for="status">Status<br>0 = taken | 1 = Progress | 2 = Finish</label>
        <input type="text" name="status" value="<?=$contact['status']?>" id="status">
        <label for="owner">Created by</label>
        <input type="text" name="owner" value="<?=$contact['owner']?>" id="owner">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $phone_number = isset($_POST['phone_number']) ? $_POST['phone_number'] : '';
       
        
        $stmt = $pdo->prepare('UPDATE students SET id = ?, username = ?, password = ?, email = ?, phone_number = ?, WHERE id = ?');
        $stmt->execute([$id, $username, $password, $email, $phone_number,  $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    
    $stmt = $pdo->prepare('SELECT * FROM students WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $students = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$students) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Read')?>

<div class="content update">
	<h2>Update Contact #<?=$students['id']?></h2>
    <form action="update.php?id=<?=$students['id']?>" method="post">
        <label for="id">ID</label>
        <input type="text" name="id" placeholder="1" value="<?=$students['id']?>" id="id">
        <label for="name">username</label>
        
        <input type="text" name="username" placeholder="" value="<?=$students['username']?>" id="username">
        <label for="email">password</label>
        <input type="text" name="password" placeholder="password" value="<?=$students['password']?>" id="password">
        <label for="phone">email</label>
        <input type="email" name="email" placeholder="email" value="<?=$students['email']?>" id="email">
        <label for="title">phone number</label>
        <input type="text" name="phone_number" placeholder="phone_number" value="<?=$students['phone_number']?>" id="phone_number">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>

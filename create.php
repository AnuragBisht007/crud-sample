<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

if (!empty($_POST)) {
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone_number = isset($_POST['phone_number']) ? $_POST['phone_number']:'';
 
    
    $stmt = $pdo->prepare('INSERT INTO students VALUES (?, ?, ?, ?, ? )');
    $stmt->execute([$id, $username, $password, $email, $phone_number ]);
    
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Create Students</h2>
    <form action="create.php" method="post">
        <label for="id">ID</label>
        <input type="text" name="id" placeholder="id" value="auto" id="id">

        <label for="name">username</label>
        <input type="text" name="username" placeholder="username" id="username">

        <label for="password">password</label>
        <input type="password" name="password" placeholder="enter password" id="password">

        <label for="phone">email</label>
        <input type="email" name="email" placeholder="email" id="email">

        <label for="title">phone number</label>
        <input type="text" name="phone_number" placeholder="number" id="phone_number">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
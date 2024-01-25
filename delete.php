<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

if (isset($_GET['id'])) {
    
    $stmt = $pdo->prepare('SELECT * FROM students WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $students = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$students) {
        exit('Contact doesn\'t exist with that ID!');
    }
    
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            
            $stmt = $pdo->prepare('DELETE FROM students WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'You have deleted the student info!';
        } else {
            
            header('Location: read.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Delete')?>

<div class="content student">
	<h2>Delete student #<?=$students['id']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete student #<?=$students['id']?>?</p>
    <div class="yesno">
       <button class="btn btn-danger"> <a href="delete.php?id=<?=$students['id']?>&confirm=yes">Yes</a></button>
       <button class="btn btn-danger"> <a href="delete.php?id=<?=$students['id']?>&confirm=no">No</a></button>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>
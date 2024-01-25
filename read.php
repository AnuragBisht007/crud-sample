<?php
include 'functions.php';

$pdo = pdo_connect_mysql();

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

$records_per_page = 10;


$stmt = $pdo->prepare('SELECT * FROM students ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();

$student = $stmt->fetchAll(PDO::FETCH_ASSOC);


$num_students = $pdo->query('SELECT COUNT(*) FROM students')->fetchColumn();
?>

<?=template_header('Read')?>

<div class="content read">
	<h2>Read students</h2>
	<a href="create.php" class="create-contact">Create student</a>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Name</td>
                <td>password</td>
                <td>email</td>
                <td>phone_number</td>
                
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($student as $students):  ?>
                
            <tr>
                <td><?=$students['id']?></td>
                <td><?=$students['username']?></td>
                <td><?=$students['password']?></td>
                <td><?=$students['email']?></td>
                <td><?=$students['phone_number']?></td>
                
                <td class="actions">
                    <a href="update.php?id=<?=$students['id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?id=<?=$students['id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_students): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>
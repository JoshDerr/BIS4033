<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;
// Prepare the SQL statement and get records from our fev1s table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM fev1s AS F, visits AS V WHERE F.visit_id = V.visit_id ORDER BY F.fev1_id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$fev1s = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of fev1s, this is so we can determine whether there should be a next and previous button
$num_fev1s = $pdo->query('SELECT COUNT(*) FROM fev1s')->fetchColumn();
?>
<?=template_header('Read')?>

<div class="content read">
	<h2>Read FEV1s</h2>
	<a href="fev1s_create.php" class="create-contact">Create FEV1s</a>
	<table>
        <thead>
            <tr>
                <td>FEV1 ID</td>
                <td>Value</td>
                <td>Visit ID</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($fev1s as $fev1): ?>
            <tr>
                <td><?=$fev1['fev1_id']?></td>
                <td><?=$fev1['fev1_value']?></td>
                <td><?=$fev1['visit_id']?></td>
                <td class="actions">
                    <a href="fev1s_update.php?fev1_id=<?=$fev1['fev1_id']?>&visit_id=<?=$fev1['visit_id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="fev1s_delete.php?fev1_id=<?=$fev1['fev1_id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="fev1s_read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_fev1s): ?>
		<a href="fev1s_read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
    <a class="back" href="..\landingPage.php">Back</a>
</div>

<?=template_footer()?>
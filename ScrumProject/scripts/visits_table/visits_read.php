<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;
// Prepare the SQL statement and get records from our visits table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM visits AS V, doctors AS D, patients AS Pa, prescriptions AS Pr WHERE V.doctor_id = D.doctor_id AND V.patient_id = Pa.patient_id AND V.prescription_id = Pr.prescription_id ORDER BY V.visit_id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$visits = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of visits, this is so we can determine whether there should be a next and previous button
$num_visits = $pdo->query('SELECT COUNT(*) FROM visits')->fetchColumn();
?>
<?=template_header('Read')?>

<div class="content read">
	<h2>Read Visits</h2>
	<a href="visits_create.php" class="create-contact">Create Visits</a>
	<table>
        <thead>
            <tr>
                <td>Visit ID</td>
                <td>Date of Visit</td>
                <td>Doctor ID</td>
                <td>Doctor Name</td>
                <td>Patient ID</td>
                <td>Patient Name</td>
                <td>Prescription ID</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($visits as $visit): ?>
            <tr>
                <td><?=$visit['visit_id']?></td>
                <td><?=$visit['date_of_visit']?></td>
                <td><?=$visit['doctor_id']?></td>
                <td><?=$visit['doctor_first_name'].' '.$visit['doctor_last_name']?></td>
                <td><?=$visit['patient_id']?></td>
                <td><?=$visit['patient_first_name'].' '.$visit['patient_last_name']?></td>
                <td><?=$visit['prescription_id']?></td>
                <td class="actions">
                    <a href="visits_update.php?visit_id=<?=$visit['visit_id']?>&doctor_id=<?=$visit['doctor_id']?>&patient_id=<?=$visit['patient_id']?>&prescription_id=<?=$visit['prescription_id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="visits_delete.php?visit_id=<?=$visit['visit_id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="visits_read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_visits): ?>
		<a href="visits_read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
    <a class="back" href="..\landingPage.php">Back</a>
</div>

<?=template_footer()?>
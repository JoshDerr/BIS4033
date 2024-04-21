<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the fev1 id exists, for example //update.php?id=1 will get the fev1 with the id //of 1
if (isset($_GET['fev1_id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, //but instead we update a record and not //insert
        $fev1_id = isset($_POST['fev1_id']) ? $_POST['fev1_id'] : NULL;
        $fev1_value = isset($_POST['fev1_value']) ? $_POST['fev1_value'] : '';
        $visit_id = isset($_POST['visit_id']) ? $_POST['visit_id'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE fev1s SET fev1_id = ?, fev1_value = ?, visit_id = ? WHERE fev1_id = ?');
        $stmt->execute([$fev1_id, $fev1_value, $visit_id, $_GET['fev1_id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the fev1 from the fev1s table
    $stmt = $pdo->prepare('SELECT * FROM fev1s WHERE fev1_id = ?');
    $stmt->execute([$_GET['fev1_id']]);
    $fev1 = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$fev1) {
        exit('FEV1 doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Read')?>

<div class="content update">
	<h2>Update FEV1 #<?=$fev1['fev1_id']?></h2>
    <form action="fev1s_update.php?fev1_id=<?=$fev1['fev1_id']?>&visit_id=<?=$fev1['visit_id']?>" method="post">
        <label for="fev1_id">FEV1 ID</label>
            <input type="text" name="fev1_id" placeholder="Ex. 1" value="<?=$fev1['fev1_id']?>" id="fev1_id" required readonly>
        <label for="fev1_value">Value</label>
            <input type="number" name="fev1_value" value="<?=$fev1['fev1_value']?>" placeholder="Ex. 90" id="fev1_vlaue" step = "1" required>

        <?php
        $stmt = $pdo->query("SELECT V.visit_id, V.date_of_visit, D.doctor_first_name, D.doctor_last_name, Pa.patient_first_name, Pa.patient_last_name FROM visits AS V, doctors AS D, patients AS Pa WHERE V.doctor_id = D.doctor_id AND V.patient_id = Pa.patient_id ORDER BY visit_id");
        $visits = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <label for="visit_id">Visit ID / Doctor ID / Patient ID / Date of Visit</label>
            <select name="visit_id" id="visit_id" required>
                <option value="<?=$fev1['visit_id']?>" hidden selected><?=$fev1['visit_id']?></option>
                <option value="" disabled>Please select an option</option>
                <?php foreach($visits as $visit) : ?>
                    <option value="<?php echo $visit['visit_id']; ?>"><?php echo $visit['visit_id'] . ' - ' . $visit['doctor_first_name'] . ' ' . $visit['doctor_last_name'] . ' - ' . $visit['patient_first_name'] . ' ' . $visit['patient_last_name'] . ' - ' . $visit['date_of_visit']; ?></option>
                <?php endforeach; ?>
            </select>
        
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>

<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check if FEV1 id exists 
if (!empty($_GET)) {
    //similar to create.php file// updating instead, no insert
    $fev1_id = isset($_POST['fev1_id']) ? $_POST['prescription_id'] : NULL;
    $fev1_value = isset($_POST['fev1_value']) ? $_POST['fev1_value'] : '';
    $visit_id = isset($_POST['visit_id']) ? $_POST['visit_id'] : '';
    //update the record
    $stmt = $pdo->prepare('UPDATE fev1s SET fev1_id = ?, fev1_value = ?, visit_id = ? WHERE fev1_id = ?');
    $stmt->execute([$fev1_id, $fev1_value, $visit_id, $_GET['fev1_id']]);
    //Output message
    $msg = 'fev1 value(s) updated successfully';
};
?>
<?=template_header('Update Values')?>

<div class="content update">
	<h2>Update values for FEV-1 id#<?=$fev1s['fev1_id']?></h2>
    <form action="fev1s_update.php?prescription_id=<?=$fev1s['fev1_id']?>&fev1_id=<?=$fev1s['fev1_id']?>" method="post">
        <label for="fev1_id">FEV-1 ID</label>
            <input type="text" name="fev1_id" placeholder="Ex. 26" value="<?=$fev1s['fev1_id']?>" id="fev1_id" required readonly>
        <label for="fev1_value">FEV-1 VALUE</label>
            <input type="number" name="fev1_value" placeholder="Ex. 90" value="<?=$fev1s['fev1_value']?>" id="fev1_vlaue" step = "1" required>
 
        <?php
        //$stmt = $pdo->query("SELECT F.fev1_id, F.fev1_value, V.visit_id FROM fev1s AS F, visits AS v, patients AS Pa WHERE V.doctor_id = D.doctor_id AND V.patient_id = Pa.patient_id ORDER BY visit_id");
        $fev1s = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        
        <label for="visit_id">Visit ID / Doctor ID / Patient ID / Date of Visit</label>
            <select name="visit_id" id="visit_id" required>
                <option value="<?=$visits['visit_id']?>" disabled selected>Please select an option</option>
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

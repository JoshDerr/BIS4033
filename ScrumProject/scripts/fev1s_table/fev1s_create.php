<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, //we must check if the POST variables exist if not we //can default them to blank
    $fev1_id = isset($_POST['fev1_id']) && !empty($_POST['fev1_id']) && $_POST['fev1_id'] != 'auto' ? $_POST['fev1_id'] : NULL;
    /*Check if POST variable //"fev1_id" exists, if not default //the value to blank, basically the same for //all variables*/
    $fev1_value = isset($_POST['fev1_value']) ? $_POST['fev1_value'] : '';
    $visit_id = isset($_POST['visit_id']) ? $_POST['visit_id'] : '';
    // Insert new record into the fev1s table
    $stmt = $pdo->prepare('INSERT INTO fev1s VALUES (?, ?, ?)');
    $stmt->execute([$fev1_id, $visit_id, $fev1_value]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Create FEV1</h2>
    <form action="fev1s_create.php" method="post">
        <label for="fev1_id">FEV1 ID</label>
            <input type="text" name="fev1_id" placeholder="Ex. 26" value="auto" id="fev1_id" required readonly>
        <label for="fev1_value">Value</label>
            <input type="number" name="fev1_value" placeholder="Ex. 90" id="fev1_vlaue" step = "1" required>
 
        <?php
        $stmt = $pdo->query("SELECT V.visit_id, V.date_of_visit, D.doctor_first_name, D.doctor_last_name, Pa.patient_first_name, Pa.patient_last_name FROM visits AS V, doctors AS D, patients AS Pa WHERE V.doctor_id = D.doctor_id AND V.patient_id = Pa.patient_id ORDER BY visit_id");
        $visits = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        
        <label for="visit_id">Visit ID / Doctor ID / Patient ID / Date of Visit</label>
            <select name="visit_id" id="visit_id" required>
                <option value="" disabled selected>Please select an option</option>
                <?php foreach($visits as $visit) : ?>
                    <option value="<?php echo $visit['visit_id']; ?>"><?php echo $visit['visit_id'] . ' - ' . $visit['doctor_first_name'] . ' ' . $visit['doctor_last_name'] . ' - ' . $visit['patient_first_name'] . ' ' . $visit['patient_last_name'] . ' - ' . $visit['date_of_visit']; ?></option>
                <?php endforeach; ?>
            </select>

        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
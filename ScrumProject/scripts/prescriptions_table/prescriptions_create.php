<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, //we must check if the POST variables exist if not we //can default them to blank
    $prescription_id = isset($_POST['prescription_id']) && !empty($_POST['prescription_id']) && $_POST['prescription_id'] != 'auto' ? $_POST['prescription_id'] : NULL;
    /*Check if POST variable //"prescription_id" exists, if not default //the value to blank, basically the same for //all variables*/
    $medication_id = isset($_POST['medication_id']) ? $_POST['medication_id'] : '';
    $visit_id = isset($_POST['visit_id']) ? $_POST['visit_id'] : '';
    $prescription_lot_num = isset($_POST['prescription_lot_num']) ? $_POST['prescription_lot_num'] : '';
    $prescription_expiration_date = isset($_POST['prescription_expiration_date']) ? $_POST['prescription_expiration_date'] : '';
    // Insert new record into the prescriptions table
    $stmt = $pdo->prepare('INSERT INTO prescriptions VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$prescription_id, $medication_id, $visit_id, $prescription_lot_num, $prescription_expiration_date]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Create Prescription</h2>
    <form action="prescriptions_create.php" method="post">
        <label for="prescription_id">Prescription ID</label>
            <input type="text" name="prescription_id" placeholder="Ex. 26" value="auto" id="prescription_id" required readonly>
        <label for="prescription_lot_num">Lot Number</label>
            <input type="text" name="prescription_lot_num" placeholder="Ex. AD4ZBT1" id="prescription_lot_num" required>
        <label for="prescription_expiration_date">Expiration Date</label>
            <input type="date" name="prescription_expiration_date" id="prescription_expiration_date" required>
        
        <?php
        $stmt = $pdo->query("SELECT medication_id, medication_name, medication_dosage FROM medications ORDER BY medication_id");
        $medications = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        
        <label for="medication_id">Medication ID / Name / Dosage</label>
            <select name="medication_id" id="medication_id" required>
                <option value="" disabled selected>Please select an option</option>
                <?php foreach($medications as $medication) : ?>
                    <option value="<?php echo $medication['medication_id']; ?>"><?php echo $medication['medication_id'] . ' - ' . $medication['medication_name'] . ' - ' . $medication['medication_dosage']; ?></option>
                <?php endforeach; ?>
            </select>
 
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
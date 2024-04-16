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
    $patient_id = isset($_POST['patient_id']) ? $_POST['patient_id'] : '';
    //$patient_first_name = isset($_POST['patient_first_name']) ? $_POST['patient_first_name'] : '';
    //$patient_last_name = isset($_POST['patient_last_name']) ? $_POST['patient_last_name'] : '';
    $prescription_lot_num = isset($_POST['prescription_lot_num']) ? $_POST['prescription_lot_num'] : '';
    $prescription_expiration_date = isset($_POST['prescription_expiration_date']) ? $_POST['prescription_expiration_date'] : '';
    // Insert new record into the prescriptions table
    $stmt = $pdo->prepare('INSERT INTO prescriptions VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$prescription_id, $medication_id, $patient_id, $prescription_lot_num, $prescription_expiration_date]);
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
        $stmt = $pdo->query("SELECT medication_id, medication_name FROM medications ORDER BY medication_id");
        $medications = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        
        <label for="medication_id">Medication ID / Name</label>
            <select name="medication_id" id="medication_id" required>
                <option value="" disabled selected>Please select an option</option>
                <?php foreach($medications as $medication) : ?>
                    <option value="<?php echo $medication['medication_id']; ?>"><?php echo $medication['medication_id'] . ' - ' . $medication['medication_name']; ?></option>
                <?php endforeach; ?>
            </select>
 
        <?php
        $stmt = $pdo->query("SELECT patient_id, patient_first_name, patient_last_name FROM patients ORDER BY patient_id");
        $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <label for="patient_id">Patient ID / Name</label>
            <select name="patient_id" id="patient_id" required>
                <option value="" disabled selected>Please select an option</option>
                <?php foreach($patients as $patient) : ?>
                    <option value="<?php echo $patient['patient_id']; ?>"><?php echo $patient['patient_id'] . ' - ' . $patient['patient_first_name'] . ' ' . $patient['patient_last_name']  ; ?></option>
                <?php endforeach; ?>
            </select>

        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
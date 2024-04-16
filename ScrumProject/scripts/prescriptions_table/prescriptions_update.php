<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Set timezone to America/Chicago
date_default_timezone_set('America/Chicago');
// Check if the presctiption id exists, for example //update.php?id=1 will get the prescription with the id //of 1
if (isset($_GET['prescription_id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, //but instead we update a record and not //insert
        $prescription_id = isset($_POST['prescription_id']) ? $_POST['prescription_id'] : NULL;
        $medication_id = isset($_POST['medication_id']) ? $_POST['medication_id'] : '';
        $patient_id = isset($_POST['patient_id']) ? $_POST['patient_id'] : '';
        $prescription_lot_num = isset($_POST['prescription_lot_num']) ? $_POST['prescription_lot_num'] : '';
        $prescription_exp_date = isset($_POST['prescription_exp_date']) ? $_POST['prescription_exp_date'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE prescriptions SET prescription_id = ?, patient_id = ?, prescription_lot_num = ?, prescription_exp_date = ? WHERE prescription_id = ?');
        $stmt->execute([$prescription_id, $medication_id, $patient_id, $prescription_lot_num, $prescription_exp_date, $_GET['prescription_id']]);
        $msg = 'Prescription Updated Successfully!';
    }
    // Get the prescription from the prescriptions table
    $stmt = $pdo->prepare('SELECT * FROM prescriptions WHERE prescription_id = ?');
    $stmt->execute([$_GET['prescription_id']]);
    $prescription = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$prescription) {
        exit('Prescription doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Read')?>

<div class="content update">
	<h2>Update Prescription</h2>
    <form action="prescriptions_update.php?prescription_id=<?=$prescription['prescription_id']?>" method="post">
        <label for="prescription_id">Prescription ID</label>
            <input type="text" name="prescription_id" placeholder="Ex. 26" value="<?$prescription['prescription_id']?>" id="prescription_id" readonly required>
        <label for="prescription_lot_num">Lot Number</label>
            <input type="text" name="prescription_lot_num" placeholder="Ex. AD4ZBT1" value="<?$prescription['prescription_lot_mun']?> id="prescription_lot_num" required>
        <label for="prescription_expiration_date">Expiration Date</label>
            <input type="date" name="prescription_expiration_date" value="<?$prescription['prescription_exp_date']?> id="prescription_exp_date" required>
        
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
            <select name="patient_id" id="patient_id" value="<?$prescription['patient_id']?> required>
                <option value="" disabled selected>Please select an option</option>
                <?php foreach($patients as $patient) : ?>
                    <option value="<?php echo $patient['patient_id']; ?>"><?php echo $patient['patient_id'] . ' - ' . $patient['patient_first_name'] . ' ' . $patient['patient_last_name']  ; ?></option>
                <?php endforeach; ?>
            </select>

        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
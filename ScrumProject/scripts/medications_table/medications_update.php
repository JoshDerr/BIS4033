<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Set timezone to America/Chicago
date_default_timezone_set('America/Chicago');
// Check if the medication id exists, for example //update.php?id=1 will get the medication with the id //of 1
if (isset($_GET['medication_id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, //but instead we update a record and not //insert
        $medication_id = isset($_POST['medication_id']) ? $_POST['medication_id'] : NULL;
        $medication_name = isset($_POST['medication_name']) ? $_POST['medication_name'] : '';
        $medication_enzyme_status = isset($_POST['medication_enzyme_status']) ? $_POST['medication_enzyme_status'] : '';
        $medication_enzyme_type = isset($_POST['medication_enzyme_type']) ? $_POST['medication_enzyme_type'] : '';
        $medication_dosage = isset($_POST['medication_dosage']) ? $_POST['medication_dosage'] : '';
        $medication_quantity = isset($_POST['medication_quantity']) ? $_POST['medication_quantity'] : '';
        $medication_frequency = isset($_POST['medication_frequency']) ? $_POST['medication_frequency'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE medications SET medication_id = ?, medication_name = ?, medication_enzyme_status = ?, medication_enzyme_type = ?, medication_dosage = ?, medication_quantity = ?, medication_frequency = ? WHERE medication_id = ?');
        $stmt->execute([$medication_id, $medication_name, $medication_enzyme_status, $medication_enzyme_type, $medication_dosage, $medication_quantity, $medication_frequency, $_GET['medication_id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the medication from the medications table
    $stmt = $pdo->prepare('SELECT * FROM medications WHERE medication_id = ?');
    $stmt->execute([$_GET['medication_id']]);
    $medication = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$medication) {
        exit('Medication doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Read')?>

<div class="content update">
	<h2>Update Medication #<?=$medication['medication_id']?></h2>
    <form action="medications_update.php?medication_id=<?=$medication['medication_id']?>" method="post">
        <label for="medication_id">Medication ID</label>
            <input type="text" name="medication_id" placeholder="Ex. 1" value="<?=$medication['medication_id']?>" id="medication_id" readonly required>
        <label for="medication_name">Name</label>
            <input type="text" name="medication_name" placeholder="Ex. Bactrim" value="<?=$medication['medication_name']?>" id="medication_name" pattern = "[A-Za-z\-\s]{2,}" required>
        <label for="medication_enzyme_status">Enzyme Status</label>
            <select name = "medication_enzyme_status" value="<?=$medication['medication_enzyme_status']?>" id = "medication_enzyme_status" required>
                <option value='<?php echo $medication['medication_enzyme_status']?>' hidden selected><?php echo $medication['medication_enzyme_status']?></option>
                <option value="" disabled>Please select an option</option>
                <option value = "Yes">Yes</option>
                <option value = "No">No</option>
            </select>
        <label for="medication_enzyme_type">Enzyme Type</label>
            <input type="text" name="medication_enzyme_type" placeholder="Ex. Oxidoreductases" value="<?=$medication['medication_enzyme_type']?>" id="medication_enzyme_type" pattern = "[A-Za-z\-\s]{2,}">
        <label for="medication_dosage">Dosage</label>
            <input type="text" name="medication_dosage" placeholder="Ex. 50mg" value="<?=$medication['medication_dosage']?>" id="medication_dosage" required>
        <label for="medication_quantity">Quantity</label>
            <input type="number" name="medication_quantity" value="<?=$medication['medication_quantity']?>" id="medication_quantity" min="1" pattern=" 0+\.[0-9]*[1-9][0-9]*$" required>
        <label for="medication_frequency">Frequency</label>
            <select name = "medication_frequency" value="<?=$medication['medication_frequency']?>" id = "medication_frequency" required>
                <option value='<?php echo $medication['medication_frequency']?>' hidden selected><?php echo $medication['medication_frequency']?></option>
                <option value="" disabled>Please select an option</option>
                <option value = "QD">QD (Once Daily)</option>
                <option value = "BID">BID (Twice Daily)</option>
                <option value = "TID">TID (Three Times Daily)</option>
                <option value = "QHS">QHS (Once Every Night)</option>
                <option value = "N/A">N/A</option>
            </select>
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>

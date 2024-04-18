<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the prescription id exists, for example //update.php?id=1 will get the prescription with the id //of 1
if (isset($_GET['prescription_id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, //but instead we update a record and not //insert
        $prescription_id = isset($_POST['prescription_id']) ? $_POST['prescription_id'] : NULL;
        $medication_id = isset($_POST['medication_id']) ? $_POST['medication_id'] : '';
        $prescription_lot_num = isset($_POST['prescription_lot_num']) ? $_POST['prescription_lot_num'] : '';
        $prescription_expiration_date = isset($_POST['prescription_expiration_date']) ? $_POST['prescription_expiration_date'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE prescriptions SET prescription_id = ?, medication_id = ?, prescription_lot_num = ?, prescription_expiration_date = ? WHERE prescription_id = ?');
        $stmt->execute([$prescription_id, $medication_id, $prescription_lot_num, $prescription_expiration_date, $_GET['prescription_id']]);
        $msg = 'Updated Successfully!';
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
	<h2>Update Prescription #<?=$prescription['prescription_id']?></h2>
    <form action="prescriptions_update.php?prescription_id=<?=$prescription['prescription_id']?>&medication_id=<?=$prescription['medication_id']?>" method="post">
        <label for="prescription_id">Prescription ID</label>
            <input type="text" name="prescription_id" placeholder="Ex. 1" value="<?=$prescription['prescription_id']?>" id="prescription_id" required readonly>
        <label for="prescription_lot_num">Lot Number</label>
            <input type="text" name="prescription_lot_num" placeholder="Ex. AD4ZBT1" value="<?=$prescription['prescription_lot_num']?>" id="prescription_lot_num" required>
        <label for="prescription_expiration_date">Expiration Date</label>
            <input type="date" name="prescription_expiration_date" value="<?=$prescription['prescription_expiration_date']?>" id="prescription_expiration_date" required>
       
        <?php
        $stmt = $pdo->query("SELECT medication_id, medication_name FROM medications");
        $medications = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <label for="medication_id">Medication ID / Name</label>
            <select name="medication_id" id="medication_id" required>
                <option value="<?=$prescription['medication_id']?>" hidden selected><?=$prescription['medication_id']?></option>
                <option value="" disabled>Please select an option</option>
                <?php foreach($medications as $medication) : ?>
                    <option value="<?php echo $medication['medication_id']; ?>"><?php echo $medication['medication_id'] . ' - ' . $medication['medication_name']; ?></option>
                <?php endforeach; ?>
            </select>
        
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>

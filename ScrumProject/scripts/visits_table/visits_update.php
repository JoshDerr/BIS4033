<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
//check if the visitID exists
if (isset($_GET['visit_id'])) {
    if (!empty($_POST)) {
    // This part is similar to the create.php, //but instead we update a record and not //insert
    $visit_id = isset($_POST['visit_id']) ? $_POST['visit_id'] : NULL;
    $doctor_id = isset($_POST['doctor_id']) ? $_POST['doctor_id'] : '';
    $prescription_id = isset($_POST['prescription_id']) ? $_POST['prescription_id'] : '';
    $date_of_visit = isset($_POST['date_of_visit']) ? $_POST['date_of_visit'] : '';
    // update the record
    $stmt = $pdo->prepare('UPDATE visits SET visit_id = ?, doctor_id = ?, presription_id = ?, date_of_visit = ? WHERE visit_id = ?');
    $stmt->execute([$visit_id, $doctor_id, $prescription_id, $date_of_visit, $_GET['visit_id']]);
    $msg = 'Visit Updated Successfully'
}

    // Get the visit from the visits table
    $stmt = $pdo->prepare('SELECT * FROM visits WHERE visit_id = ?');
    $stmt->execute([$_GET['visit_id']]);
    $prescription = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$prescription) {
        exit('Visit doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Read')?>

<div class = "content update">
    <h2>Update Visit for Visit ID #<?=$visit['visit_id']?></h2>
    <form action="visits_update.php?visit_id=<?=$visit['visit_id']?>&doctor_id=<?=$visit['doctor_id']?>" method="post">
    <label for="visit_id">Visit ID</label>
            <input type="text" name="visit_id" placeholder="Ex. 1" value="<?=$visit['visit_id']?>" id="visit_id" required readonly>
            <label for="doctor_id">Doctor ID / Name</label>
            <select name="doctor_id" id="doctor_id" required>
                <option value="" disabled selected>Please select an option</option>
                <?php foreach($doctors as $doctor) : ?>
                    <option value="<?php echo $doctor['doctor_id']; ?>"><?php echo $doctor['doctor_id'] . ' - ' . $doctor['doctor_first_name'] . ' ' . $doctor['doctor_last_name']; ?></option>
                <?php endforeach; ?>
            </select>

            <?php
            $stmt = $pdo->query("SELECT doctor_id, doctor_name FROM doctors ORDER BY doctor_id");
            $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <label for="doctor_id">Doctor ID / Name</label>
            <select name="doctor_id" id="doctor_id" required>
                <option value="<?=$visit['doctor_id']?>" hidden selected><?=$visit['doctor_id']?></option>
                <option value="" disabled>Please select an option</option>
                <?php foreach($visits as $visit) : ?>
                    <option value="<?php echo $visit['doctor_id']; ?>"><?php echo $visit['doctor_id'] . ' - ' . $visit['doctor_name']; ?></option>
                <?php endforeach; ?>
            </select>

            <?php
            $stmt = $pdo->query("SELECT patient_id, patient_first_name, patient_last_name FROM patients ORDER BY patient_id");
            $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <label for="patient_id">Patient ID / Name</label>
            <select name="patient_id" id="patient_id" required>
                <option value="<?=$visit['patient_id']?>" hidden selected><?=$visit['patient_id']?></option>
                <option value="" disabled>Please select an option</option>
                <?php foreach($visits as $visit) : ?>
                    <option value="<?php echo $visit['patient_id']; ?>"><?php echo $visit['patient_id'] . ' - ' . $visit['patient_first_name'] . '' . ['patient_last_name']; ?></option>
                <?php endforeach; ?>
            </select>



            <input type="submit" value="Update this Visit">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>


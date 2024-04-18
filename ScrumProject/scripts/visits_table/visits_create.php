<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, //we must check if the POST variables exist if not we //can default them to blank
    $visit_id = isset($_POST['visit_id']) && !empty($_POST['visit_id']) && $_POST['visit_id'] != 'auto' ? $_POST['visit_id'] : NULL;
    /*Check if POST variable //"visit_id" exists, if not default //the value to blank, basically the same for //all variables*/
    $doctor_id = isset($_POST['doctor_id']) ? $_POST['doctor_id'] : '';
    $patient_id = isset($_POST['patient_id']) ? $_POST['patient_id'] : '';
    $date_of_visit = isset($_POST['date_of_visit']) ? $_POST['date_of_visit'] : '';
    // Insert new record into the visits table
    $stmt = $pdo->prepare('INSERT INTO visits VALUES (?, ?, ?, ?)');
    $stmt->execute([$visit_id, $doctor_id, $patient_id, $date_of_visit]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Create Visit</h2>
    <form action="visits_create.php" method="post">
        <label for="visit_id">Visit ID</label>
            <input type="text" name="visit_id" placeholder="Ex. 26" value="auto" id="visit_id" required readonly>
        <label for="date_of_visit">Date of Visit</label>
            <input type="date" name="date_of_visit" id="date_of_visit" required>
        
        <?php
        $stmt = $pdo->query("SELECT doctor_id, doctor_first_name, doctor_last_name FROM doctors ORDER BY doctor_id");
        $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        
        <label for="doctor_id">Doctor ID / Name</label>
            <select name="doctor_id" id="doctor_id" required>
                <option value="" disabled selected>Please select an option</option>
                <?php foreach($doctors as $doctor) : ?>
                    <option value="<?php echo $doctor['doctor_id']; ?>"><?php echo $doctor['doctor_id'] . ' - ' . $doctor['doctor_first_name'] . ' ' . $doctor['doctor_last_name']; ?></option>
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
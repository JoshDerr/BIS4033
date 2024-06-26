<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Set timezone to America/Chicago
date_default_timezone_set('America/Chicago');
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, //we must check if the POST variables exist if not we //can default them to blank
    $patient_id = isset($_POST['patient_id']) && !empty($_POST['patient_id']) && $_POST['patient_id'] != 'auto' ? $_POST['patient_id'] : NULL;
    // Check if POST variable "name" exists, if not default //the value to blank, basically the same for all //variables
    $patient_first_name = isset($_POST['patient_first_name']) ? $_POST['patient_first_name'] : '';
    $patient_last_name = isset($_POST['patient_last_name']) ? $_POST['patient_last_name'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $birthdate = isset($_POST['birthdate']) ? $_POST['birthdate'] : '';
    $genetics = isset($_POST['genetics']) ? $_POST['genetics'] : '';
    $diabetes = isset($_POST['diabetes']) ? $_POST['diabetes'] : '';
    $other_conditions = isset($_POST['other_conditions']) ? $_POST['other_conditions'] : '';

    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO patients VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$patient_id, $patient_first_name, $patient_last_name, $gender, $birthdate, $genetics, $diabetes, $other_conditions]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
    <h2>Create Patient</h2>
    <form action="patients_create.php" method="post">
        <label for="patient_id">Patient ID</label>
            <input type="text" name="patient_id" placeholder="Ex. 26" value="auto" id="patient_id" readonly required>
        <label for="patient_first_name">First Name</label>
            <input type="text" name="patient_first_name" placeholder="Ex. John" id="patient_first_name" pattern = "[A-Za-z']{2,}" required>
        <label for="patient_last_name">Last Name</label>
            <input type="text" name="patient_last_name" placeholder="Ex. Doe" id="patient_last_name" pattern = "[A-Za-z'\-\s]{2,}" required>
        <label for="gender">Gender</label>
            <select name = "gender" id = "gender" required>
                <option value="" disabled selected>Please select an option</option>
                <option value = "Male">Male</option>
                <option value = "Female">Female</option>
                <option value = "Other">Other</option>
            </select>
        <label for="birthdate">Birthdate</label>
            <input type="date" name="birthdate" id="birthdate" max="<?= date('Y-m-d'); ?>" required>
        <label for="genetics">Genetics</label>
            <input type="text" name="genetics" placeholder="Ex. Green Eyes" id="genetics">
        <label for="diabetes">Diabetes</label>
            <select name = "diabetes" id = "diabetes" required>
                <option value="" disabled selected>Please select an option</option>
                <option value = "Yes">Yes</option>
                <option value = "No">No</option>
            </select>
        <label for="other_conditions">Other Conditions</label>
            <input type="text" name="other_conditions" placeholder="Ex. High Blood Pressure" id="other_conditions">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
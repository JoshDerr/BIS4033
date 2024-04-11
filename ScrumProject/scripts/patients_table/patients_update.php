<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the patient id exists, for example //update.php?id=1 will get the contact with the id //of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, //but instead we update a record and not //insert
        $id = isset($_POST['patient_id']) ? $_POST['patient_id'] : NULL;
        $patient_first_name = isset($_POST['patient_first_name']) ? $_POST['patient_first_name'] : '';
        $patient_last_name = isset($_POST['patient_last_name']) ? $_POST['patient_last_name'] : '';
        $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
        $birthdate = isset($_POST['birthdate']) ? $_POST['birthdate'] : '';
        $genetics = isset($_POST['genetics']) ? $_POST['genetics'] : '';
        $diabetes = isset($_POST['diabetes']) ? $_POST['diabetes'] : '';
        $other_conditions = isset($_POST['other_conditions']) ? $_POST['other_conditions'] : '';
        // Update the patient record
        $stmt = $pdo->prepare('UPDATE contacts SET id = ?, name = ?, email = ?, phone = ?, title = ?, created = ? WHERE id = ?');
        $stmt->execute([$id, $patient_first_name, $patient_last_name, $gender, $birthdate, $genetics, $diabetes, $other_conditions $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the patient from the patients table
    $stmt = $pdo->prepare('SELECT * FROM patients WHERE id = ?');
    $stmt->execute([$_GET['patient_id']]);
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$patient) {
        exit('Patient doesn\'t exist with that ID!');
    }
} else {
    exit('No Patient ID specified!');
}
?>
<?=template_header('Read')?>

<div class="content update">
    <h2>Update Patient</h2>
    <form action="patients_update.php" method="post">
        <label for="patient_id">Patient ID</label>
            <input type="text" name="patient_id" placeholder="26" value="auto" id="patient_id" required>
        <label for="patient_first_name">First Name</label>
            <input type="text" name="patient_first_name" placeholder="John" id="patient_first_name" pattern = "[A-Za-z]{2,}" required>
        <label for="patient_last_name">Last Name</label>
            <input type="text" name="patient_last_name" placeholder="Doe" id="patient_last_name" pattern = "[A-Za-z]{2,}" required>
        <label for="gender">Gender</label>
            <select name = "gender" id = "gender" required>
                <option value="" disabled selected>Please select an option</option>
                <option value = "Male">Male</option>
                <option value = "Female">Female</option>
                <option value = "Other">Other</option>
            </select>
            <!-- <input type="text" name="gender" placeholder="Male, Female, or Other" id="gender" pattern="^(?:Male|Female|Other)$" required> -->
        <label for="birthdate">Birthdate</label>
            <input type="date" name="birthdate" id="birthdate" max="2024-04-23" required>
        <label for="genetics">Genetics</label>
            <input type="text" name="genetics" placeholder="Enter genetic information here" id="genetics" required>
        <label for="diabetes">Diabetes</label>
            <select name = "diabetes" id = "diabetes" required>
                <option value="" disabled selected>Please select an option</option>
                <option value = "Yes">Yes</option>
                <option value = "No">No</option>
            </select>
            <!-- <input type="text" name="diabetes" placeholder="Yes or No" id="diabetes" pattern="^(?:Yes|No|yes|no)$" required> -->
        <label for="other_conditions">Other Conditions</label>
            <input type="text" name="other_conditions" placeholder="List other conditions here" id="other_conditions" required>
        <input type="submit" value="Update Patient Information">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>

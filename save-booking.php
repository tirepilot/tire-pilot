<?php
// save-booking.php
// Step 1: start session for admin later (optional)
session_start();

// Step 2: capture POST data
$name = $_POST['Name'] ?? '';
$phone = $_POST['Phone'] ?? '';
$location = $_POST['Location'] ?? '';
$vehicle = $_POST['Vehicle'] ?? '';
$service = $_POST['Service'] ?? '';
$date = date("Y-m-d H:i:s");

// Step 3: handle uploaded file if exists
$uploadFile = '';
if(isset($_FILES['Photo']) && $_FILES['Photo']['error'] == 0){
    $uploadDir = 'uploads/';
    if(!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
    $uploadFile = $uploadDir . basename($_FILES['Photo']['name']);
    move_uploaded_file($_FILES['Photo']['tmp_name'], $uploadFile);
}

// Step 4: save data to CSV
$file = 'submissions.csv';
$row = [$date, $name, $phone, $location, $vehicle, $service, $uploadFile];
$fp = fopen($file, 'a');
fputcsv($fp, $row);
fclose($fp);

// Step 5: do NOT stop form submit, just return OK
http_response_code(200);
echo "Logged successfully";
?>
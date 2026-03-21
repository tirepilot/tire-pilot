<?php
session_start();

// Hardcoded admin credentials (change these to secure ones)
$admin_user = "admin";
$admin_pass = "TirePilot@123";

// LOGIN CHECK
if(isset($_POST['username']) && isset($_POST['password'])){
    if($_POST['username'] === $admin_user && $_POST['password'] === $admin_pass){
        $_SESSION['admin_logged_in'] = true;
    } else {
        die("Invalid login. <a href='admin-login.html'>Try again</a>");
    }
}

// LOGOUT OPTION
if(isset($_GET['logout'])){
    session_destroy();
    header("Location: admin-login.html");
    exit;
}

// PROTECT PAGE
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: admin-login.html");
    exit;
}

// Load submissions from CSV
$file = 'submissions.csv';
$submissions = [];

if(file_exists($file)){
    $f = fopen($file,'r');
    $headers = fgetcsv($f);
    while($row = fgetcsv($f)){
        $submissions[] = array_combine($headers, $row);
    }
    fclose($f);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Panel | TirePilot</title>
<style>
body{font-family:Arial, sans-serif;background:#0b0b0b;color:white;padding:20px;}
table{width:100%;border-collapse:collapse;}
th,td{border:1px solid #d4af37;padding:8px;text-align:left;}
th{background:#d4af37;color:black;}
a.logout{color:#d4af37;float:right;}
</style>
</head>
<body>
<h1>Admin Panel</h1>
<a href="?logout=1" class="logout">Logout</a>

<?php if(count($submissions) > 0): ?>
<table>
<tr>
<?php foreach($headers as $header): ?>
<th><?php echo htmlspecialchars($header); ?></th>
<?php endforeach; ?>
</tr>
<?php foreach($submissions as $sub): ?>
<tr>
<?php foreach($sub as $value): ?>
<td><?php echo htmlspecialchars($value); ?></td>
<?php endforeach; ?>
</tr>
<?php endforeach; ?>
</table>
<?php else: ?>
<p>No submissions yet.</p>
<?php endif; ?>
</body>
</html>
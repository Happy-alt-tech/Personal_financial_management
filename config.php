<?php
$host = "localhost";  // XAMPP માટે localhost જ રાખો
$user = "root";       // ડિફોલ્ટ યુઝરનેમ `root` છે
$pass = "";           // XAMPP માં ડિફોલ્ટ પાસવર્ડ ખાલી હોય છે
$dbname = "pfm"; // તમારું ડેટાબેઝ નામ અહીં લખો

$conn = mysqli_connect($host, $user, $pass, $dbname);

// ચેક કરો કે કનેક્શન સફળ થયું કે નહીં
if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>

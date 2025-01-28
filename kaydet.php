<?php
// Veritabanı bağlantı bilgileri
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

// mysqli sınıfının yüklü olduğundan emin olun
if (!class_exists('mysqli')) {
    die("mysqli sınıfı bulunamadı. Lütfen PHP'nin mysqli uzantısının yüklü olduğundan emin olun.");
}

// Veritabanına bağlan
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

?>
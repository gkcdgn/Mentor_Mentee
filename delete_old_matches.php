<?php
require 'C:\xampp\htdocs\son\proje\kaydet.php';

// 15 günden daha eski ve hem mentee hem de mentor tarafından onaylanmış kayıtları sil
$sql = "DELETE FROM matches WHERE mentee_onay = 1 AND mentor_onay = 1 AND DATEDIFF(NOW(), created_at) > 15";
$conn->query($sql);

// Bağlantıyı kapat
$conn->close();
?>
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'C:\xampp\htdocs\son\proje\kaydet.php';   


if (isset($_GET['mentor_id'])) {
    $mentor_id = $_GET['mentor_id']; // Tırnakları temizle  
    echo "Received mentor_id: '$mentor_id'<br>"; // Gelen değeri göster  
    $mentor_id = intval($mentor_id); // Tamsayıya çevir  
} else {
    die("Mentor ID belirtilmedi.");
}

echo '<pre>';
var_dump($_GET); // Düzgün bir çıktı için var_dump kullanın  
echo '</pre>';// Mentee bilgilerini al
// Mentor bilgilerini al
$mentor_query = "SELECT Name, Surname FROM mentor WHERE ID = ?";
$stmt = $conn->prepare($mentor_query);
$stmt->bind_param("i", $mentor_id); // $mentor_id değişkenini kullanıyoruz
$stmt->execute();
$mentor_result = $stmt->get_result();

// Mentor bulunamazsa hata mesajı göster
if ($mentor_result->num_rows === 0) {
    die("Mentor bulunamadı.");
}

// Mentor bilgilerini getir
$mentor = $mentor_result->fetch_assoc();

// Mentor ad ve soyadını yazdırma  
echo "Mentor Adı: " . htmlspecialchars($mentor['Name']) . "<br>";
echo "Mentor Soyadı: " . htmlspecialchars($mentor['Surname']) . "<br>";

$stmt->close();



// Mentor'un eşleşen mentee'lerini getir
$sql = "SELECT mentee.* FROM matches 
        JOIN mentee ON matches.mentee_id = mentee.ID 
        WHERE matches.mentor_id = ? 
        ORDER BY matches.score DESC 
        LIMIT 5";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $mentor_id);
$stmt->execute();
$result = $stmt->get_result();
$mentees = $result->fetch_all(MYSQLI_ASSOC);

if ($result->num_rows === 0) { // Burada $mentors_result yerine $result kullanılmalı
    die("Bu mentor için eşleşen mentee bulunamadı.");
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mentee Seçimi</title>
  <style>
 body {  
            font-family: Arial, sans-serif;  
            margin: 20px;  
            background-color: #e6cccc; /* Arka plan rengi */  
        }  
        h1 {  
            text-align: center; /* Başlığı ortala */  
            color: #333; /* Başlık rengi */  
        }  
        form {  
            background-color: #fff; /* Form arka planı */  
            padding: 20px;  
            border-radius: 10px; /* Köşe yuvarlama */  
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Gölge efekti */  
            max-width: 75%;
      
           
    
        }  
        .mentee {  
            display: flex;  
            justify-content: space-between;  
            align-items: center;  
            background-color: #d8d0d0;  
            padding: 10px;  
            margin-bottom: 10px;  
            border-radius: 5px;  
        }  
        .mentee .details {  
            flex-grow: 1;  
            color: #333; /* Metin rengi */  
        }  
        .mentee input[type="checkbox"] {  
            margin-left: 10px;  
            transform: scale(1.2); /* Kutucuğu büyütme */  
        }  
        button {  
            display: block; /* Butonu tam genişlikte yap */  
            width: 100%;   
            background-color: #09076f;  
            color: white;  
            padding: 12px;  
            border: none;  
            cursor: pointer;  
            border-radius: 5px;  
            margin-top: 15px; /* Üstteki alandan boşluk bırak */  
            font-size: 16px; /* Yazı boyutu */  
        }  
        button:hover {  
            background-color: #5585c7; /* Hover durumu için farklı yeşil */  
        }  
</style>
</head>

<body>
  <h2>Sizinle Eşleşen Mentee Seçimi Yapınız</h2>
  <form action="confirm_matches.php" method="post">
      <input type="hidden" name="mentor_id" value="<?php echo $mentor_id; ?>">
      <?php foreach ($mentees as $mentee): ?>
      <div class="mentee">  
        <div class="details">  
            Mentee: <?php echo $mentee['First_Name'] . " " . $mentee['Last_Name']; ?><br>  
            Telefon: <?php echo $mentee['Phone']; ?><br>  
            E-posta: <?php echo $mentee['Email']; ?><br>  
        </div>  
        <input type="checkbox" name="mentee_ids[]" value="<?php echo $mentee['ID']; ?>">   
    </div>  
      <?php endforeach; ?>
      <button type="submit">Onayla</button>
  </form>
</body>

</html>
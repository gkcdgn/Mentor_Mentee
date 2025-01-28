<?php
session_start();
require 'C:/xampp/htdocs/son/proje/kaydet.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Hata mesajı değişkenleri
$mentor_nameErr = $mentor_surnameErr = $mentor_emailErr = $mentor_phoneErr = $mentor_departmentErr = $mentor_sectorErr = $mentor_experienceErr = $mentor_interestsErr = $kvkk_checkErr = "";

// Form alanı değişkenleri
$mentor_name = $mentor_surname = $mentor_email = $mentor_phone = $mentor_department = $mentor_sector = $mentor_experience = $mentor_interests = "";
$form_success = null;

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ad doğrulama
    if (empty($_POST["mentor_name"])) {
        $mentor_nameErr = "Ad gerekli.";
    } else {
        $mentor_name = test_input($_POST["mentor_name"]);
    }

    // Soyad doğrulama
    if (empty($_POST["mentor_surname"])) {
        $mentor_surnameErr = "Soyad gerekli.";
    } else {
        $mentor_surname = test_input($_POST["mentor_surname"]);
    }

    // Email doğrulama
    if (empty($_POST["mentor_email"])) {  
        $mentor_emailErr = "Email gerekli.";  
    } else {  
        $mentor_email = test_input($_POST["mentor_email"]);  
        if (!filter_var($mentor_email, FILTER_VALIDATE_EMAIL)) {  
            $mentor_emailErr = "Geçerli bir email adresi girin.";  
        } else {  
            // E-posta mevcut mu kontrolü  
            $email_check_sql = "SELECT * FROM mentor WHERE Email = ?";  
            $email_stmt = $conn->prepare($email_check_sql);  
            $email_stmt->bind_param("s", $mentor_email);  
            $email_stmt->execute();  
            $email_stmt->store_result();  

            if ($email_stmt->num_rows > 0) {  
                $mentor_emailErr = "Bu e-posta adresi zaten kayıtlı.";  
            }  

            $email_stmt->close();  
        }  
    }  

    // Telefon numarasını kontrol et
if (empty($_POST["mentor_phone"])) {
    $mentor_phoneErr = "Telefon gerekli.";
} else {
    $mentor_phone = test_input($_POST["mentor_phone"]);

    // Telefon numarasının veritabanında olup olmadığını kontrol et
    $sql_check_phone = "SELECT COUNT(*) AS total FROM mentor WHERE Phone = ?";
    $stmt = $conn->prepare($sql_check_phone);
    $stmt->bind_param("s", $mentor_phone);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($total);
    $stmt->fetch();

    // Eğer telefon numarası zaten varsa hata mesajı göster
    if ($total > 0) {
        $mentor_phoneErr = "Bu telefon numarası zaten kullanılıyor!";
    }
}

    // Bölüm doğrulama
    if (empty($_POST["mentor_department"])) {
        $mentor_departmentErr = "Bölüm gerekli.";
    } else {
        $mentor_department = test_input($_POST["mentor_department"]);
    }

    // Sektör doğrulama
    if (empty($_POST["mentor_sector"])) {
        $mentor_sectorErr = "Sektör gerekli.";
    } else {
        $mentor_sector = test_input($_POST["mentor_sector"]);
    }

    // Deneyim yılı doğrulama
    if (empty($_POST["mentor_experience"])) {
        $mentor_experienceErr = "Deneyim yılı gerekli!";
    } elseif (!is_numeric($_POST["mentor_experience"]) || $_POST["mentor_experience"] < 0) {
        $mentor_experienceErr = "Geçerli bir deneyim yılı giriniz.";
    } else {
        $mentor_experience = test_input($_POST["mentor_experience"]);
        $mentor_experience = (int)$_POST["mentor_experience"];
    }

    // İlgi alanları doğrulama
    if (empty($_POST["mentor_interests"])) {
        $mentor_interestsErr = "İlgi alanları gerekli.";
    } else {
        $mentor_interests = test_input($_POST["mentor_interests"]);
    }
    
   /* if (isset($_POST["kvkk_check"]) && $_POST["kvkk_check"] === "on") {
        // KVKK onayı verildi
    $kvkk_checkErr = "";
    } else {
        $kvkk_checkErr = "KVKK onayı gerekli!";
    }*/
    if (empty($_POST["kvkk_check"])) {
        $kvkk_checkErr = "KVKK onayı gerekli!";
    }

    if (empty($mentor_nameErr) && empty($mentor_surnameErr) && empty($mentor_emailErr) && empty($mentor_phoneErr) && empty($mentor_departmentErr) && empty($mentor_sectorErr) && empty($mentor_experienceErr) && empty($mentor_interestsErr) && empty($kvkk_checkErr)) {
        // Veritabanı bağlantısı ve veri ekleme işlemi
        $sql = "INSERT INTO mentor (Name, Surname, Email, Phone, Department, Sector, Experience_Years, Interests)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
        // Prepared statement oluştur
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            // Statement hazırlama başarısız oldu
            echo "Prepared statement oluşturulurken hata oluştu: " . $conn->error;
            $form_success = false;
        } else {
            $stmt->bind_param("ssssssis", $mentor_name, $mentor_surname, $mentor_email, $mentor_phone, $mentor_department, $mentor_sector, $mentor_experience, $mentor_interests);
    
            // Sorguyu çalıştır
            if ($stmt->execute()) {
                $form_success = true;
    
                // Mentee-Mentor eşleştirme fonksiyonunu çağır
                $callResult = $conn->query("CALL match_mentees_with_mentors()");
                if ($callResult) {
                    // Eşleşmeler başarılı, işlemleri gerçekleştir
                    require 'C:/xampp/htdocs/son/proje/notify_users.php';
                } else {
                    // Prosedür çağrısı başarısız
                    $form_success = false;
                    echo "Mentee-Mentor eşleştirme işlemi sırasında hata oluştu: " . $conn->error;
                }
            } else {
                // Veri ekleme sırasında hata oluştu
                $form_success = false;
                echo "Veri eklenirken hata oluştu: " . $stmt->error;
            }
    
            // Prepared statement'ı kapat
            $stmt->close();
        }
    } else {
        $form_success = false; // Eğer hatalar varsa form_success'ı false olarak ayarla
        echo "Formda hata var, lütfen tüm alanları doğru doldurduğunuzdan emin olun.";
    }
    
    // Bağlantıyı kapat
    $conn->close();

    // Hata mesajlarını ve form başarı durumunu session'a kaydet
    $_SESSION['mentor_nameErr'] = $mentor_nameErr;
    $_SESSION['mentor_surnameErr'] = $mentor_surnameErr;
    $_SESSION['mentor_emailErr'] = $mentor_emailErr;
    $_SESSION['mentor_phoneErr'] = $mentor_phoneErr;
    $_SESSION['mentor_departmentErr'] = $mentor_departmentErr;
    $_SESSION['mentor_sectorErr'] = $mentor_sectorErr;
    $_SESSION['mentor_experienceErr'] = $mentor_experienceErr;
    $_SESSION['mentor_interestsErr'] = $mentor_interestsErr;
    $_SESSION['kvkk_checkErr'] = $kvkk_checkErr;
    $_SESSION['form_success'] = $form_success;

  

    // Geri yönlendirme
    header("Location: mentor.php");
    exit();

    // Bağlantıyı kapat
    $conn->close();
}

?>
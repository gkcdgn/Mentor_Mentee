<?php
session_start();
require 'C:/xampp/htdocs/son/proje/kaydet.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Hata mesajı değişkenleri
$first_nameErr = $last_nameErr = $emailErr = $phoneErr = $departmentErr = $entry_yearErr = $sectorErr = $experience_yearErr = $desired_departmentErr = $desired_sectorErr = $desired_experienceErr = $mentor_interestErr = "";

// Form alanı değişkenleri

$first_name = $last_name = $email = $phone = $department = $entry_year = $sector = $experience_year = $desired_department = $desired_sector = $desired_experience = $mentor_interest = "";

$form_success = null;

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // First Name validation
    if (empty($_POST["first_name"])) {
        $first_nameErr = "Adınız gerekli!";
    } else {
        $first_name = test_input($_POST["first_name"]);
    }

    // Last Name validation
    if (empty($_POST["last_name"])) {
        $last_nameErr = "Soyadınız gerekli!";
    } else {
        $last_name = test_input($_POST["last_name"]);
    }

    // Email validation
    // Email validation
    if (empty($_POST["email"])) {
        $emailErr = "Email alanı zorunludur.";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Geçersiz email formatı.";
    } else {
        $email = test_input($_POST["email"]);

        // Email adresinin veritabanında zaten var olup olmadığını kontrol et
        $sql_check_email = "SELECT COUNT(*) AS total FROM mentee WHERE Email = ?";
        $stmt = $conn->prepare($sql_check_email);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($total);
        $stmt->fetch();

        if ($total > 0) {
            $emailErr = "Bu email adresi zaten kullanılıyor!";
        }
    }
   /* // Phone validation
    if (empty($_POST["phone"])) {
        $phoneErr = "Telefon numarası gerekli!";
    } else {
        $phone = test_input($_POST["phone"]);
    }*/
    
    // Telefon numarasını kontrol et
if (empty($_POST["phone"])) {
    $phoneErr = "Telefon numarası gerekli!";
} else {
    $phone = test_input($_POST["phone"]);

    // Telefon numarasının veritabanında olup olmadığını kontrol et
    $sql_check_phone = "SELECT COUNT(*) AS total FROM mentee WHERE Phone = ?";
    $stmt = $conn->prepare($sql_check_phone);
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($total);
    $stmt->fetch();

    // Eğer telefon numarası zaten varsa hata mesajı göster
    if ($total > 0) {
        $phoneErr = "Bu telefon numarası zaten kullanılıyor!";
    }
}

    // Department validation
    if (empty($_POST["department"])) {
        $departmentErr = "Bölüm gerekli!";
    } else {
        $department = test_input($_POST["department"]);
    }

    // Entry Year validation
    if (empty($_POST["entry_year"])) {
        $entry_yearErr = "Bölüme giriş yılı zorunludur.";
    } elseif (!is_numeric($_POST["entry_year"]) || $_POST["entry_year"] < 1900 || $_POST["entry_year"] > 2100) {
        $entry_yearErr = "Geçerli bir giriş yılı giriniz.";
    } else {
        $entry_year = test_input($_POST["entry_year"]);
        $entry_year = (int)$_POST["entry_year"];
    }

    // Sector validation
    if (empty($_POST["sector"])) {
        $sectorErr = "Sektör gerekli!";
    } else {
        $sector = test_input($_POST["sector"]);
    }

    // Experience Year validation
    if (empty($_POST["experience_year"])) {
        $experience_yearErr = "Deneyim yılı alanı zorunludur.";
    } elseif (!is_numeric($_POST["experience_year"]) || $_POST["experience_year"] < 0) {
        $experience_yearErr = "Geçerli bir deneyim yılı giriniz.";
    } else {
        $experience_year = test_input($_POST["experience_year"]);
        $experience_year = (int)$_POST["experience_year"];
    }

    // Desired Department validation
    if (empty($_POST["desired_department"])) {
        $desired_departmentErr = "Hayal edilen mentorun bölümü alanı zorunludur.";
    } else {
        $desired_department = test_input($_POST["desired_department"]);
    }

    // Desired Sector validation
    if (empty($_POST["desired_sector"])) {
        $desired_sectorErr = "Hayal edilen mentorun sektörü alanı zorunludur.";
    } else {
        $desired_sector = test_input($_POST["desired_sector"]);
    }

    // Desired Experience validation
    if (empty($_POST["desired_experience"])) {
        $desired_experienceErr = "Hayal edilen mentorun deneyim yılı alanı zorunludur.";
    } elseif (!is_numeric($_POST["desired_experience"]) || $_POST["desired_experience"] < 0) {
        $desired_experienceErr = "Geçerli bir deneyim yılı giriniz.";
    } else {
        $desired_experience = test_input($_POST["desired_experience"]);
        $desired_experience = (int)$_POST["desired_experience"];
    }

    // Mentor Interest validation
    if (empty($_POST["mentor_interest"])) {
        $mentor_interestErr = "Mentorun ilgi alanları gerekli!";
    } else {
        $mentor_interest = test_input($_POST["mentor_interest"]);
    }

    // If there are no error messages, set form_success to true
    if (empty($first_nameErr) && empty($last_nameErr) && empty($emailErr) && empty($phoneErr) && empty($departmentErr) && empty($entry_yearErr) && empty($sectorErr) && empty($experience_yearErr) && empty($desired_departmentErr) && empty($desired_sectorErr) && empty($desired_experienceErr) && empty($mentor_interestErr)) {
        // Veritabanı bağlantısı ve veri ekleme işlemi
        $sql = "INSERT INTO mentee (First_Name, Last_Name, Email, Phone, Department, Entry_Year, Sector, Experience_Years, Desired_Department_mtr, Desired_Sector_mtr, Desired_Experience_mtr, Mentor_Interest_mtr) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssisisis", $first_name, $last_name, $email, $phone, $department, $entry_year, $sector, $experience_year, $desired_department, $desired_sector, $desired_experience, $mentor_interest);

        if ($stmt->execute()) {
            $form_success = true;

            // Mentee-Mentor eşleştirme fonksiyonunu çağır
            $conn->query("CALL match_mentees_with_mentors()");

            // Eşleşmeleri işlemek ve e-posta göndermek için yönlendirme
            require 'C:/xampp/htdocs/son/proje/notify_users.php';
            notifyAllUsers($conn);
        } else {
            $form_success = false;
        }
    } else {
        $form_success = false; // Eğer hatalar varsa form_success'ı false olarak ayarla
    }

    // Hata mesajlarını ve form başarı durumunu session'a kaydet
    $_SESSION['first_nameErr'] = $first_nameErr;
    $_SESSION['last_nameErr'] = $last_nameErr;
    $_SESSION['emailErr'] = $emailErr;
    $_SESSION['phoneErr'] = $phoneErr;
    $_SESSION['departmentErr'] = $departmentErr;
    $_SESSION['entry_yearErr'] = $entry_yearErr;
    $_SESSION['sectorErr'] = $sectorErr;
    $_SESSION['experience_yearErr'] = $experience_yearErr;
    $_SESSION['desired_departmentErr'] = $desired_departmentErr;
    $_SESSION['desired_sectorErr'] = $desired_sectorErr;
    $_SESSION['desired_experienceErr'] = $desired_experienceErr;
    $_SESSION['mentor_interestErr'] = $mentor_interestErr;
    $_SESSION['form_success'] = $form_success;

    // Bağlantıyı kapat
    $conn->close();

    // Geri yönlendirme
    header("Location: mentee.php");
    exit();
}
?>

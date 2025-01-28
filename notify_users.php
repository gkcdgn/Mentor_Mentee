<?php
require 'C:/xampp/htdocs/son/proje/kaydet.php';
require 'C:/xampp/htdocs/son/proje/vendor/autoload.php';

use Twilio\Rest\Client;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

// .env dosyasını yükle
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

if (file_exists(__DIR__ . '/.env')) {  
    echo ".env dosyası mevcut.\n";  
} else {  
    echo ".env dosyası bulunamadı.\n";  
}  

// Hassas bilgileri çevre değişkenlerinden yükle
$sid =  ?? null;  
$token =  ?? null;  
$email_user = ?? null;  
$email_pass = ?? null;

// Değerlerin doğru yüklendiğini kontrol et
if (!$sid || !$token) {
    die("Twilio kimlik bilgileri eksik.");
}

if (!$email_user || !$email_pass) {
    die("Email kimlik bilgileri eksik.");
}

// Twilio API kullanarak WhatsApp mesajı gönderir
function sendWhatsAppMessage($phone, $message) {  
    global $sid, $token;  
    $twilio = new Client($sid, $token);  
    
    if (!preg_match('/^\+\d{1,15}$/', $phone)) {  
        error_log("Geçersiz telefon numarası formatı: $phone");  
        return false;  
    }  

    try {  
        $twilio->messages->create(  
            "whatsapp:$phone",  
            [  
                "from" => "whatsapp:+14155238886",  
                "body" => $message  
            ]  
        );  
        return true;  
    } catch (Exception $e) {  
        error_log("WhatsApp mesajı gönderilemedi: " . $e->getMessage());  
        return false;  
    }  
}

// PHPMailer kullanarak e-posta gönderir
function sendEmail($email, $subject, $message) {
    global $email_user, $email_pass;
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = ; 
        $mail->Password =;
        $mail->SMTPSecure = ;
        $mail->Port = 587;

        $mail->setFrom(, 'Your Name');
        $mail->addReplyTo($email_user, 'Your Name');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = '<h1>Merhaba!</h1><p>Bu bir test e-postasıdır.</p>';
        $mail->Body = $message;

        $mail->send();
        return true;

    } catch (Exception $e) {
        error_log($e->getMessage());
        return false;
    }
}

// Tüm mentee'leri bilgilendirme fonksiyonu
function notifyAllMentees($conn) {
    $result = $conn->query("SELECT ID, Email, Phone FROM mentee");
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $menteeId = $row['ID'];
            $message = "Sizinle eşleşen mentorlarınızı görmek ve seçim yapmak için lütfen ";
            $message .= '<a href="http://localhost/son/proje/mentor_selection.php?mentee_id=' . $menteeId . '">buraya tıklayın</a>';
            echo $message;
            
            // Veriyi ekrana yazdırıyoruz
            /*echo "Mentee ID: " . $menteeId . "<br>";
            echo "Email: " . $row['Email'] . "<br>";
            echo "Phone: " . $row['Phone'] . "<br>";
            echo "Mesaj: " . $message . "<br><br>";*/
            
            if (!empty($row['Phone'])) {
                sendWhatsAppMessage($row['Phone'], strip_tags($message));
            } else {
                sendEmail($row['Email'], "Mentor Seçimi", $message);
            }
        }
    } else {
        echo "Veri bulunamadı.";
    }
  
}


// Tüm mentorları bilgilendirme fonksiyonu
function notifyAllMentors($conn) {
    if ($result = $conn->query("SELECT ID, Email, Phone FROM mentor")) {
        while ($row = $result->fetch_assoc()) {
            $mentorId = $row['ID'];
            $htmlMessage = "Sizinle eşleşen mentee'leri görmek ve seçim yapmak için lütfen ";
            $htmlMessage .= '<a href="http://localhost/son/proje/mentee_selection.php?mentor_id=' . $mentorId . '">buraya tıklayın</a>.';
            echo $htmlMessage;
            
            $plainMessage = "Sizinle eşleşen mentee'leri görmek ve seçim yapmak için lütfen şu bağlantıya gidin: ";
            $plainMessage .= "http://localhost/son/proje/mentee_selection.php?mentor_id=" . $mentorId;
            echo $plainMessage;

            if (!empty($row['Phone'])) {
                if (!sendWhatsAppMessage($row['Phone'], $plainMessage)) {
                    error_log("WhatsApp mesajı gönderilemedi: " . $row['Phone']);
                }
            } else {
                if (!sendEmail($row['Email'], "Mentor Eşleşme Sonuçları", $htmlMessage, "Content-Type: text/html; charset=UTF-8")) {
                    error_log("E-posta gönderilemedi: " . $row['Email']);
                }
            }
        }
    } else {
        // Sorgu hatası
        die("Sorgu başarısız: " . $conn->error);
    }
}


// Tüm mentee ve mentorları bilgilendirme fonksiyonu
// Tüm mentee ve mentorları bilgilendirme fonksiyonu
function notifyAllUsers($conn) {
    notifyAllMentees($conn);
    notifyAllMentors($conn);
}

// Veritabanı bağlantısının açık olup olmadığını kontrol et
if ($conn && $conn->ping()) {
    notifyAllUsers($conn);
} else {
    die("Veritabanı bağlantısı kapalı.");
}




$conn->close();
?>

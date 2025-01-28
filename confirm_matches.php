<?php
require 'C:\xampp\htdocs\son\proje\kaydet.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mentee onayı
    if (isset($_POST['mentee_id']) && isset($_POST['mentor_ids']) && is_array($_POST['mentor_ids'])) {
        $mentee_id = $_POST['mentee_id'];
        $selected_mentor_ids = $_POST['mentor_ids'];

        // mentee_selected_mentors tablosuna ekleme veya güncelleme
        $sql = "INSERT INTO mentee_selected_mentors (mentee_id, mentor_id_1, mentor_id_2, mentor_id_3, mentor_id_4, mentor_id_5) 
                VALUES (?, ?, ?, ?, ?, ?) 
                ON DUPLICATE KEY UPDATE 
                mentor_id_1 = VALUES(mentor_id_1),
                mentor_id_2 = VALUES(mentor_id_2),
                mentor_id_3 = VALUES(mentor_id_3),
                mentor_id_4 = VALUES(mentor_id_4),
                mentor_id_5 = VALUES(mentor_id_5)";

        // Mentor ID'lerini sırasıyla yerleştirin, eğer daha az mentor seçildiyse kalanlarını NULL yapın
        $mentor_id_1 = isset($selected_mentor_ids[0]) ? $selected_mentor_ids[0] : NULL;
        $mentor_id_2 = isset($selected_mentor_ids[1]) ? $selected_mentor_ids[1] : NULL;
        $mentor_id_3 = isset($selected_mentor_ids[2]) ? $selected_mentor_ids[2] : NULL;
        $mentor_id_4 = isset($selected_mentor_ids[3]) ? $selected_mentor_ids[3] : NULL;
        $mentor_id_5 = isset($selected_mentor_ids[4]) ? $selected_mentor_ids[4] : NULL;

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiiiiiiiiiii",
                 $mentor_id,       // İlk ?
                 $mentee_id_1,     // İkinci ?
                 $mentee_id_2,     // Üçüncü ?
                 $mentee_id_3,     // Dördüncü ?
                 $mentee_id_4,     // Beşinci ?
                 $mentee_id_5,     // Altıncı ?
                 $mentee_id_1,     // Yedinci ?
                 $mentee_id_2,     // Sekizinci ?
                 $mentee_id_3,     // Dokuzuncu ?
                 $mentee_id_4,     // Onuncu ?
                 $mentee_id_5      // Onbirinci ?
                 );
                 $stmt->execute();

        foreach ($selected_mentor_ids as $mentor_id) {
            // matches tablosunda mentee'nin onay durumunu güncelleme
            $sql = "UPDATE matches SET mentee_onay = 1 WHERE mentee_id = ? AND mentor_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $mentee_id, $mentor_id);
            $stmt->execute();
        }
    }
    // Mentor onayı
    elseif (isset($_POST['mentor_id']) && isset($_POST['mentee_ids']) && is_array($_POST['mentee_ids'])) {
        $mentor_id = $_POST['mentor_id'];
        $selected_mentee_ids = $_POST['mentee_ids'];

        foreach ($selected_mentee_ids as $mentee_id) {
            // matches tablosunda mentor'un onay durumunu güncelleme
            $sql = "UPDATE matches SET mentor_onay = 1 WHERE mentee_id = ? AND mentor_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $mentee_id, $mentor_id);
            $stmt->execute();

            // mentor_approved_mentees tablosuna ekleme veya güncelleme
            $sql = "INSERT INTO mentor_approved_mentees (mentor_id, mentee_id_1, mentee_id_2, mentee_id_3, mentee_id_4, mentee_id_5) 
            VALUES (?, ?, ?, ?, ?, ?) 
            ON DUPLICATE KEY UPDATE 
            mentee_id_1 = IF(mentee_id_1 IS NULL, ?, mentee_id_1),
            mentee_id_2 = IF(mentee_id_2 IS NULL, ?, mentee_id_2),
            mentee_id_3 = IF(mentee_id_3 IS NULL, ?, mentee_id_3),
            mentee_id_4 = IF(mentee_id_4 IS NULL, ?, mentee_id_4),
            mentee_id_5 = IF(mentee_id_5 IS NULL, ?, mentee_id_5);";

            // Mentee ID'lerini sırasıyla yerleştirin, daha az ID varsa NULL yapın
            $mentee_id_1 = isset($selected_mentee_ids[0]) ? $selected_mentee_ids[0] : NULL;
            $mentee_id_2 = isset($selected_mentee_ids[1]) ? $selected_mentee_ids[1] : NULL;
            $mentee_id_3 = isset($selected_mentee_ids[2]) ? $selected_mentee_ids[2] : NULL;
            $mentee_id_4 = isset($selected_mentee_ids[3]) ? $selected_mentee_ids[3] : NULL;
            $mentee_id_5 = isset($selected_mentee_ids[4]) ? $selected_mentee_ids[4] : NULL;

            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                "iiiiiiiiiii",
                  $mentor_id,
                  $mentee_id_1,
                  $mentee_id_2,
                  $mentee_id_3,
                  $mentee_id_4,
                  $mentee_id_5,
                  $mentee_id_1,
                  $mentee_id_2,
                  $mentee_id_3,
                  $mentee_id_4,
                  $mentee_id_5
               
            );
            $stmt->execute();
        }
    }
}

// Bağlantıyı kapatmadan önce bağlantının açık olup olmadığını kontrol edin
if (isset($conn) && $conn->ping()) {
    $conn->close();
}

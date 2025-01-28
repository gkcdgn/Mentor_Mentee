<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'C:\xampp\htdocs\son\proje\kaydet.php';

if (isset($_GET['mentee_id']) ) {
    $mentee_id = $_GET['mentee_id'];
    $mentee_id = intval($mentee_id); // mentee_id'yi tam sayı olarak al
    echo "Mentee ID: " . htmlspecialchars($mentee_id) . "<br>";
} else {
    die("Mentee ID belirtilmedi veya geçersiz.");
}


echo '<pre>';
var_dump($_GET); // Düzgün bir çıktı için var_dump kullanın  
echo '</pre>';



// Mentee bilgilerini al
$mentee_query = "SELECT First_Name, Last_Name FROM mentee WHERE ID = ?";
$stmt = $conn->prepare($mentee_query);
$stmt->bind_param("i", $mentee_id);
$stmt->execute();
$mentee_result = $stmt->get_result();

if ($mentee_result->num_rows === 0) {
    die("Mentee bulunamadı.");
}

$mentee = $mentee_result->fetch_assoc();
// Mentee ad ve soyadını yazdırma  
echo "Mentee Adı: " . htmlspecialchars($mentee['First_Name']) . "<br>";
echo "Mentee Soyadı: " . htmlspecialchars($mentee['Last_Name']) . "<br>";

$stmt->close();



// Bu mentee için eşleşen mentorları al
$mentors_query = "SELECT mentor.ID, mentor.Name, mentor.Surname FROM matches
                  JOIN mentor ON matches.mentor_id = mentor.ID
                  WHERE matches.mentee_id = ?
                  ORDER BY matches.score DESC
                  LIMIT 10";
$stmt = $conn->prepare($mentors_query);
$stmt->bind_param("i", $mentee_id);
$stmt->execute();
$mentors_result = $stmt->get_result();


if ($mentors_result->num_rows === 0) {
    die("Bu mentee için eşleşen mentor bulunamadı.");
}
$conn->close();

// HTML çıktısı
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Mentee Mentor Seçimi</title>
    <style>
        body {
            background-color:rgb(238, 233, 188);
            font-family: Arial, sans-serif;
        }

        .container {
            background-color:rgb(231, 200, 200);
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h3 {
            color: #333;
            font-size: 24px;
            margin-bottom: 25px;
        }

        .form-check-label {
            font-size: 18px;
            color: #555;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            font-size: 16px;
            padding: 10px 20px;
            border-radius: 5px;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color:rgb(90, 135, 182);
        }

        .form-check-input {
            height: 20px;
            width: 20px;
            margin-right: 30px;
        }

        .form-check {
            
            margin-bottom: 15px;
        }

        .container .form-check {
            background-color:rgb(232, 235, 211);
            border-radius: 8px;
            padding: 10px;
        }
    </style>
   
</head>

<body>
    <div class="container mt-5">
        <h3 font-family: Arial, sans-serif; font-size: 20px; color: #000; >Merhaba mentee <?php echo htmlspecialchars(ucwords($mentee['First_Name']) . ' ' . ucwords($mentee['Last_Name'])); ?> sizinle eşlen mentorleri seçiniz</h3>
        <form action="confirm_matches.php" method="post">
            <input type="hidden" name="mentee_id" value="<?php echo htmlspecialchars($mentee_id); ?>">

            <?php while ($mentor = $mentors_result->fetch_assoc()): ?>
                <div class="form-check d-flex justify-content-between  align-items-center ">
                    <label class="form-check-label">
                        Mentor :<?php echo htmlspecialchars(ucwords($mentor['Name']) . ' ' . ucwords($mentor['Surname'])); ?>
                    </label>
                    <input class="form-check-input" type="checkbox" name="mentor_ids[]" value="<?php echo htmlspecialchars($mentor['ID']); ?>">
                </div>
            <?php endwhile; ?>

            <button type="submit" class="btn btn-primary mt-3">Onayla</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    const maxSelection = 5;

    // Her checkbox'a event listener ekle
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedCount = document.querySelectorAll('input[type="checkbox"]:checked').length;

            if (checkedCount > maxSelection) {
                this.checked = false; // Seçimi kaldır
                alert('En fazla 5 mentor seçebilirsiniz.');
            }
        });
    });

    // Form gönderiminde en az bir seçim kontrolü
    document.querySelector('form').addEventListener('submit', function(e) {
        const checkedCount = document.querySelectorAll('input[type="checkbox"]:checked').length;
        if (checkedCount === 0) {
            e.preventDefault(); // Form gönderimini durdur
            alert('En az bir mentor seçmelisiniz.');
        }
    });
});
    </script>

</body>

</html>

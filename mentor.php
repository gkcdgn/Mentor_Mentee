<?php
session_start();
require 'C:/xampp/htdocs/son/proje/kaydet.php';

// Hata mesajı değişkenleri
$mentor_nameErr = $mentor_surnameErr = $mentor_emailErr = $mentor_phoneErr = $mentor_departmentErr = $mentor_sectorErr = $mentor_experienceErr = $mentor_interestsErr = $kvkk_checkErr = "";

// Form alanı değişkenleri
$mentor_name = $mentor_surname = $mentor_email = $mentor_phone = $mentor_department = $mentor_sector = $mentor_experience = $mentor_interests = "";

$form_success = null;

error_reporting(E_ALL);
ini_set('display_errors', 1);

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Mentor form</title>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #5b5e60;">
        <a class="navbar-brand" href="#">
            <img src="resim1.png" width="30" height="30">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="Anasayfa.php">Anasayfa</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="mentor.php">Mentor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="mentee.php">Mentee</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container my-4">
        <form class="needs-validation" action="/son/proje/mentorFromD.php" method="POST" novalidate>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="mentor_name">Adınız:</label>
                    <input type="text" class="form-control" id="mentor_name" name="mentor_name" value="<?php echo isset($_SESSION['mentor_name']) ? htmlspecialchars($_SESSION['mentor_name']) : ''; ?>" required>
                    <span class="text-danger"><?php echo isset($_SESSION['mentor_nameErr']) ? $_SESSION['mentor_nameErr'] : ''; ?></span>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="mentor_surname">Soyadınız:</label>
                    <input type="text" class="form-control" id="mentor_surname" name="mentor_surname" value="<?php echo isset($_SESSION['mentor_surname']) ? htmlspecialchars($_SESSION['mentor_surname']) : ''; ?>" required>
                    <span class="text-danger"><?php echo isset($_SESSION['mentor_surnameErr']) ? $_SESSION['mentor_surnameErr'] : ''; ?></span>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="mentor_email">Email:</label>
                    <input type="email" class="form-control" id="mentor_email" name="mentor_email" value="<?php echo isset($_SESSION['mentor_email']) ? htmlspecialchars($_SESSION['mentor_email']) : ''; ?>">
                    <span class="text-danger"><?php echo isset($_SESSION['mentor_emailErr']) ? $_SESSION['mentor_emailErr'] : ''; ?></span>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="mentor_phone">Whatsapp Telefon:</label>
                    <input type="tel" class="form-control" id="mentor_phone" name="mentor_phone" value="<?php echo isset($_SESSION['mentor_phone']) ? htmlspecialchars($_SESSION['mentor_phone']) : ''; ?>" required>
                    <span class="text-danger"><?php echo isset($_SESSION['mentor_phoneErr']) ? $_SESSION['mentor_phoneErr'] : ''; ?></span>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="mentor_department">Bölüm:</label>
                    <input type="text" class="form-control" id="mentor_department" name="mentor_department" value="<?php echo isset($_SESSION['mentor_department']) ? htmlspecialchars($_SESSION['mentor_department']) : ''; ?>" required>
                    <span class="text-danger"><?php echo isset($_SESSION['mentor_departmentErr']) ? $_SESSION['mentor_departmentErr'] : ''; ?></span>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="mentor_sector">Sektör:</label>
                    <input type="text" class="form-control" id="mentor_sector" name="mentor_sector" value="<?php echo isset($_SESSION['mentor_sector']) ? htmlspecialchars($_SESSION['mentor_sector']) : ''; ?>" required>
                    <span class="text-danger"><?php echo isset($_SESSION['mentor_sectorErr']) ? $_SESSION['mentor_sectorErr'] : ''; ?></span>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="mentor_experience">Deneyim(yıl):</label>
                    <input type="number" class="form-control" id="mentor_experience" name="mentor_experience" value="<?php echo isset($_SESSION['mentor_experience']) ? htmlspecialchars($_SESSION['mentor_experience']) : ''; ?>" required>
                    <span class="text-danger"><?php echo isset($_SESSION['mentor_experienceErr']) ? $_SESSION['mentor_experienceErr'] : ''; ?></span>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label for="mentor_interests">İlgi Alanları:</label>
                    <textarea class="form-control" id="mentor_interests" name="mentor_interests" rows="3"><?php echo isset($_SESSION['mentor_interests']) ? htmlspecialchars($_SESSION['mentor_interests']) : ''; ?></textarea>
                    <span class="text-danger"><?php echo isset($_SESSION['mentor_interestsErr']) ? $_SESSION['mentor_interestsErr'] : ''; ?></span>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <input class="form-check-input" type="checkbox" value="1" id="kvkk_check" name="kvkk_check" required>
                    <label class="form-check-label" for="kvkk_check">
                        KVKK kapsamında sadece ilgili kişilerle paylaşılmasına izin veriyorum
                    </label>
                    <span class="text-danger"><?php echo isset($_SESSION['kvkk_checkErr']) ? $_SESSION['kvkk_checkErr'] : ''; ?></span>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <button class="btn btn-primary btn-lg active mr-4" type="submit" aria-pressed="true">Gönder</button>
                    <button class="btn btn-secondary btn-lg active" type="reset" aria-pressed="true">Temizle</button>
                </div>
            </div>
            <?php if (isset($_SESSION['form_success']) && $_SESSION['form_success']): ?>
                <div class="alert alert-success mt-3">
                    Form başarıyla gönderildi!
                </div>
            <?php elseif (isset($_SESSION['form_success']) && !$_SESSION['form_success']): ?>
                <div class="alert alert-danger mt-3">
                    Form gönderilirken bir hata oluştu.
                </div>
            <?php endif; ?>
        </form>
        <footer class="text-center">
        <div class="container">
            <p>Tasarım ve geliştirme: Gökçe Çiçek Doğan</p>
            <p>&copy; 2024 MyCompany. Tüm hakları saklıdır.</p>
            <p>Bu web sitesinde sağlanan tüm içerik yalnızca bilgilendirme amaçlıdır ve aksi belirtilmedikçe MyCompany ile herhangi bir kişi veya kuruluş arasında yasal bir sözleşme teşkil etmez.</p>
        </div>
    </footer>
</div>


    <!-- Bootstrap JS ve bağlı kütüphaneler -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<?php
// Session verilerini temizle
session_unset();
?>
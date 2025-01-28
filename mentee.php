<?php
session_start();
require 'C:/xampp/htdocs/son/proje/kaydet.php';

// Hata mesajı değişkenleri
$first_nameErr = $last_nameErr = $emailErr = $phoneErr = $departmentErr = $entry_yearErr = $sectorErr = $experience_yearErr = $desired_departmentErr = $desired_sectorErr = $desired_experienceErr = $mentor_interestErr = "";

// Form alanı değişkenleri
$first_name = $last_name = $email = $phone = $department = $entry_year = $sector = $experience_year = $desired_department = $desired_sector = $desired_experience = $mentor_interest = "";
$form_success = null;

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Mentee Form</title>
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
                <a class="nav-link" href="Anasayfa.php">AnaSayfa</a>
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
    <form class="needs-validation" novalidate action="menteeFromD.php" method="post">
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label for="first_name">Adınız:</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?>" required>
                <span class="text-danger"><?php echo isset($_SESSION['first_nameErr']) ? $_SESSION['first_nameErr'] : ''; ?></span>
            </div>
            <div class="col-md-6 mb-3">
                <label for="last_name">Soyadınız:</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : ''; ?>" required>
                <span class="text-danger"><?php echo isset($_SESSION['last_nameErr']) ? $_SESSION['last_nameErr'] : ''; ?></span>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                <span class="text-danger"><?php echo isset($_SESSION['emailErr']) ? $_SESSION['emailErr'] : ''; ?></span>
            </div>
            <div class="col-md-6 mb-3">
                <label for="phone">Whatsapp Telefon:</label>
                <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>" required>
                <span class="text-danger"><?php echo isset($_SESSION['phoneErr']) ? $_SESSION['phoneErr'] : ''; ?></span>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-3 mb-3">
                <label for="department">Bölüm:</label>
                <input type="text" class="form-control" id="department" name="department" value="<?php echo isset($_POST['department']) ? htmlspecialchars($_POST['department']) : ''; ?>" required>
                <span class="text-danger"><?php echo isset($_SESSION['departmentErr']) ? $_SESSION['departmentErr'] : ''; ?></span>
            </div>
            <div class="col-md-3 mb-3">
                <label for="entry_year">Bölüme Giriş Yılı:</label>
                <input type="number" class="form-control" id="entry_year" min="1900" max="2100" name="entry_year" value="<?php echo isset($_POST['entry_year']) ? htmlspecialchars($_POST['entry_year']) : ''; ?>" placeholder="YYYY" required>
                <span class="text-danger"><?php echo isset($_SESSION['entry_yearErr']) ? $_SESSION['entry_yearErr'] : ''; ?></span>
            </div>
            <div class="col-md-3 mb-3">
                <label for="sector">Sektör:</label>
                <input type="text" class="form-control" id="sector" name="sector" value="<?php echo isset($_POST['sector']) ? htmlspecialchars($_POST['sector']) : ''; ?>" required>
                <span class="text-danger"><?php echo isset($_SESSION['sectorErr']) ? $_SESSION['sectorErr'] : ''; ?></span>
            </div>
            <div class="col-md-3 mb-3">
                <label for="experience_year">Deneyim (Yıl):</label>
                <input type="number" class="form-control" id="experience_year" name="experience_year" value="<?php echo isset($_POST['experience_year']) ? htmlspecialchars($_POST['experience_year']) : ''; ?>" required>
                <span class="text-danger"><?php echo isset($_SESSION['experience_yearErr']) ? $_SESSION['experience_yearErr'] : ''; ?></span>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-12 mb-3">
                <h6 class="text-left my-3">Hayalinizdeki mentor hakkındaki alanları doldurunuz</h6>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label for="desired_department">Bölüm:</label>
                <input type="text" class="form-control" id="desired_department" name="desired_department" value="<?php echo isset($_POST['desired_department']) ? htmlspecialchars($_POST['desired_department']) : ''; ?>" required>
                <span class="text-danger"><?php echo isset($_SESSION['desired_departmentErr']) ? $_SESSION['desired_departmentErr'] : ''; ?></span>
            </div>
            <div class="col-md-4 mb-3">
                <label for="desired_sector">Sektör:</label>
                <input type="text" class="form-control" id="desired_sector" name="desired_sector" value="<?php echo isset($_POST['desired_sector']) ? htmlspecialchars($_POST['desired_sector']) : ''; ?>" required>
                <span class="text-danger"><?php echo isset($_SESSION['desired_sectorErr']) ? $_SESSION['desired_sectorErr'] : ''; ?></span>
            </div>
            <div class="col-md-4 mb-3">
                <label for="desired_experience">Deneyim (Yıl):</label>
                <input type="number" class="form-control" id="desired_experience" name="desired_experience" value="<?php echo isset($_POST['desired_experience']) ? htmlspecialchars($_POST['desired_experience']) : ''; ?>" required>
                <span class="text-danger"><?php echo isset($_SESSION['desired_experienceErr']) ? $_SESSION['desired_experienceErr'] : ''; ?></span>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-12 mb-3">
                <label for="mentor_interest">Mentorun ilgi alanı:</label>
                <textarea class="form-control" id="mentor_interest" name="mentor_interest" rows="3"><?php echo isset($_POST['mentor_interest']) ? htmlspecialchars($_POST['mentor_interest']) : ''; ?></textarea>
                <span class="text-danger"><?php echo isset($_SESSION['mentor_interestErr']) ? $_SESSION['mentor_interestErr'] : ''; ?></span>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-12 mb-3">
                <button type="submit" class="btn btn-primary btn-lg active mr-4">Gönder</button>
                <button type="reset" class="btn btn-secondary btn-lg active">Temizle</button>
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
    <footer class="text-center my-4">
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
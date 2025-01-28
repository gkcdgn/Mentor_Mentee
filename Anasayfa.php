<?php
require 'C:\xampp\htdocs\son\proje\kaydet.php';

$sql_mentor = "SELECT COUNT(*) AS total_mentors FROM mentor";  // mentors tablosu
$result_mentor = $conn->query($sql_mentor);
$row_mentor = $result_mentor->fetch_assoc();
$total_mentors = $row_mentor['total_mentors'];

// Mentee sayısını al
$sql_mentee = "SELECT COUNT(*) AS total_mentees FROM mentee";  // mentees tablosu
$result_mentee = $conn->query($sql_mentee);
$row_mentee = $result_mentee->fetch_assoc();
$total_mentees = $row_mentee['total_mentees'];

$sql_success_rate = "SELECT COUNT(*) AS total_matches, SUM(mentor_onay = 1 AND mentee_onay = 1) AS successful_matches FROM matches";
$result_success_rate = $conn->query($sql_success_rate);
$row_success_rate = $result_success_rate->fetch_assoc();

$total_matches = $row_success_rate['total_matches'];
$successful_matches = $row_success_rate['successful_matches'];

if ($total_matches > 0) {
    $success_rate = round(($successful_matches / $total_matches) * 100);
} else {
    $success_rate = 0;
}

/*$conn->close();*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Page</title>
    <link rel="stylesheet" href="stil.css">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #5b5e60;">
        <a class="navbar-brand" href="#">
            <img src="resim1.png" width="25" height="25" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="C:\xampp\htdocs\son\proje\Anasayfa.php">Anasayfa <span class="sr-only">(şu anki sayfa)</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Formlar
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="mentor.php">Mentor Formu</a>
                        <a class="dropdown-item" href="mentee.php">Mentee Formu</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    
  


    <div class="container mt-5">
      <h1 class="text-center">Hoşgeldiniz!</h1>
      <p class="text-center">Mentor ve mentee programımız hakkında daha fazla bilgi almak için aşağıdaki bölümlere göz atabilirsiniz.</p>
  
      <ul class="nav nav-tabs mt-4" id="myTab" role="tablist">
          <li class="nav-item">
              <a class="nav-link" id="mentor-tab" data-toggle="tab" href="#mentor" role="tab" aria-controls="mentor" aria-selected="true">Mentor</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" id="mentee-tab" data-toggle="tab" href="#mentee" role="tab" aria-controls="mentee" aria-selected="false">Mentee</a>
          </li>
      </ul>
      <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show" id="mentor" role="tabpanel" aria-labelledby="mentor-tab">
              <div class="p-4 bg-light">
                <p>Mentor, belirli bir alanda deneyim ve bilgi sahibi olan, bu birikimini daha az deneyimli kişilere (mentee'lere) aktaran bir rehberdir. Mentorlar, genç profesyonellere ya da öğrencilere kariyer, kişisel gelişim ve hedef belirleme konularında yol gösterirler.</p><br>

                <h6>Bir Mentorun Faydaları Neler Olabilir?</h6>
                <ul>
                    <li><strong>Deneyim Paylaşımı:</strong> Mentorlar, geçmiş deneyimlerini paylaşarak mentee'lerin karşılaşabileceği zorluklara hazırlıklı olmalarına yardımcı olabilir.</li>
                    <li><strong>Kariyer Rehberliği:</strong> Mentorlar, mentee'lerin kariyer hedeflerine ulaşmalarına yönelik stratejiler geliştirmelerinde destek olur.</li>
                    <li><strong>Bağlantı Kurma:</strong> Mentorlar, mentee'lerine profesyonel ağlarındaki önemli kişilerle tanışma fırsatı sunabilir.</li>
                    <li><strong>Kişisel Gelişim:</strong> Mentorlar, mentee'lerin kişisel becerilerini ve öz güvenlerini artırmaları için rehberlik eder.</li>
                </ul>
                
                <h6>Mentor Formu Doldururken Nelere Dikkat Etmesi Gerekir?</h6>
                <ul>
                    <li><strong>Doğru ve Eksiksiz Bilgi:</strong> Formda istenen tüm bilgilerin doğru ve eksiksiz şekilde doldurulması önemlidir. Yanlış bilgi, mentor ve mentee eşleşmesinde sorunlara yol açabilir.</li>
                    <li><strong>Deneyim ve Uzmanlık Alanı:</strong> Mentorluk yapılacak alanda sahip olunan deneyim ve uzmanlık net bir şekilde belirtilmelidir.</li>
                    <li><strong>Hedef ve Beklentiler:</strong> Mentorluk sürecinden beklentiler ve hedefler açık bir şekilde ifade edilmelidir. Bu, hem mentor hem de mentee için sürecin daha verimli geçmesini sağlar.</li>
                    <li><strong>İletişim Bilgileri:</strong> İletişim bilgileri güncel olmalı ve tercih edilen iletişim yöntemleri belirtilmelidir.</li>
                </ul>
                <div class="alert alert-info mt-4">
                  <strong>Uyarı:</strong> Lütfen mentor eşlemesi için ilgili alanları doldurup, KVKK kapsamında onay veriniz. Bilgileriniz genel liste olarak değil, sadece ilgili kişiyle bireysel bazda paylaşılmaktadır.
               </div>
                
              </div>
          </div>
          <div class="tab-pane fade" id="mentee" role="tabpanel" aria-labelledby="mentee-tab">
              <div class="p-4 bg-light">
                <p>Mentee, belirli bir alanda daha az deneyimli olan ve bu alanda rehberlik almak isteyen kişidir. Mentorlar tarafından yönlendirilir ve gelişim süreçlerinde desteklenirler.</p>

                <h6>Bir Mentee'nin Faydaları Neler Olabilir?</h6>
                <ul>
                    <li><strong>Rehberlik:</strong> Mentee'ler, mentorlarının rehberliği sayesinde kendi kariyer hedeflerine daha kolay ulaşabilirler.</li>
                    <li><strong>Deneyim Kazanımı:</strong> Mentee'ler, mentorlarından aldıkları bilgiler ve öneriler sayesinde daha hızlı ve etkili bir şekilde deneyim kazanabilirler.</li>
                    <li><strong>Ağ Kurma:</strong> Mentee'ler, mentorlarının profesyonel çevresinden faydalanarak kendi ağlarını genişletebilirler.</li>
                    <li><strong>Kişisel Gelişim:</strong> Mentee'ler, mentorları sayesinde kişisel becerilerini geliştirir ve öz güvenlerini artırabilirler.</li>
                </ul>
                <h6>Mentee'ler için Tavsiyeler</h6>
                <ul>
                    <li><strong>Hazırlıklı Olun:</strong> Mentorluk görüşmelerine hazırlıklı gidin. Hedeflerinizi ve sorularınızı belirleyin.</li>
                    <li><strong>Aktif Dinleyici Olun:</strong> Mentorunuzun tavsiyelerini dikkatlice dinleyin ve anlamaya çalışın. Aktif dinleme, öğrenme sürecinizi hızlandırır.</li>
                    <li><strong>Geri Bildirim Alın:</strong> Mentorunuzdan düzenli olarak geri bildirim isteyin. Bu, gelişiminizi daha iyi takip etmenizi sağlar.</li>
                    <li><strong>Hedeflerinizi Belirleyin:</strong> Mentorluk sürecinin başında kısa ve uzun vadeli hedeflerinizi belirleyin. Bu hedefler doğrultusunda mentorunuzla birlikte bir plan yapabilirsiniz.</li>
                    <li><strong>İletişimde Kalın:</strong> Mentorunuzla düzenli iletişimde kalın. Bu, mentor-mentee ilişkisinin güçlü ve verimli olmasını sağlar.</li>
                </ul>
                
                
                <h6>Mentee Formu Doldururken Nelere Dikkat Etmesi Gerekir?</h6>
                <ul>
                    <li><strong>Açık ve Net Bilgiler:</strong> Formu doldururken kendinizle ilgili bilgileri açık ve net bir şekilde belirtmelisiniz.</li>
                    <li><strong>Hedeflerinizi Belirtin:</strong> Mentorluk sürecinden beklentilerinizi ve hedeflerinizi formda açıkça ifade edin.</li>
                    <li><strong>İlgilendiğiniz Alanlar:</strong> Mentorluk almak istediğiniz alanları ve bu alanlardaki ilginizi formda belirtin.</li>
                    <li><strong>İletişim Bilgileri:</strong> Güncel iletişim bilgilerinizi doğru bir şekilde girin, böylece mentorunuzla kolayca iletişim kurabilirsiniz.</li>
                </ul>
                <div class="alert alert-info mt-4">
                   <strong>Uyarı:</strong> Lütfen mentor eşlemesi için ilgili alanları doldurup, KVKK kapsamında onay veriniz. Bilgileriniz genel liste olarak değil, sadece ilgili kişiyle bireysel bazda paylaşılmaktadır.
                </div>
                
              </div>
          </div>
      </div>
      <div class="container mt-5">
        <div class="row text-center">
            <div class="col-md-4">
                <div class="stat-box p-3 bg-light">
                    <h3><?php echo $total_mentors; ?></h3>
                    <p>Mentor</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-box p-3 bg-light">
                    <h3><?php echo $total_mentees; ?></h3>
                    <p>Mentee</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-box p-3 bg-light">
                    <h3><?php echo $success_rate; ?>%</h3>
                    <p>Başarılı Eşleşme Oranı</p>
                </div>
            </div>
        </div>
    </div>
    <footer class="text-center my-3">
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

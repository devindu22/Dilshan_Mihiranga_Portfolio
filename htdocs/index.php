<?php
include 'db_connect.php';

// Daten abrufen
$profile = $pdo->query("SELECT * FROM profile LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$contact = $pdo->query("SELECT * FROM contact LIMIT 1")->fetch(PDO::FETCH_ASSOC);

// PDF Logik
if (isset($_GET['download']) && $_GET['download'] == 'cv') {
    $file = 'uploads/cv_dilshan.pdf';
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="Lebenslauf_Dilshan_Mihiranga.pdf"');
        readfile($file);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($profile['full_name']); ?> | Portfolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body data-bs-theme="light">

    <nav class="navbar navbar-expand-lg sticky-top navbar-glass shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="bi bi-gear-fill text-primary me-2"></i>Engineering Portfolio
            </a>
            <button class="theme-toggle-btn" id="themeToggle">
                <i class="bi bi-moon-stars" id="themeIcon"></i>
            </button>
        </div>
    </nav>

    <header class="hero-header text-center shadow-lg position-relative overflow-hidden">
        <div class="container position-relative z-3">
            <div class="mb-4" data-aos="zoom-in">
                <img src="profile.jpg" alt="Dilshan Mihiranga" class="profile-img rounded-circle shadow-lg">
            </div>
            <h1 class="display-4 fw-bold mb-2 header-title" data-aos="fade-up">
                <?php echo htmlspecialchars($profile['full_name']); ?>
            </h1>
            <p class="lead fs-4 fw-light mb-4 header-subtitle" data-aos="fade-up" data-aos-delay="200">
                Experte für <span class="text-primary fw-bold">Verfahrenstechnik</span>
            </p>
            
            <div data-aos="fade-up" data-aos-delay="400">
                 <a href="?download=cv" class="creative-download-btn">
                    <span class="btn-text">Lebenslauf PDF</span>
                    <span class="btn-icon"><i class="bi bi-cloud-arrow-down-fill"></i></span>
                 </a>
            </div>
        </div>
        <div class="tech-bg-pattern"></div>
    </header>

    <div class="container my-5">
        <div class="row g-4">
            <div class="col-lg-4">
                <section class="card mb-4 shadow-sm border-0" data-aos="fade-right">
                    <div class="card-body">
                        <h3 class="h5 border-bottom pb-2 mb-3 text-primary"><i class="bi bi-person-badge me-2"></i>Profil</h3>
                        <p class="text-secondary small"><?php echo nl2br(htmlspecialchars($profile['profile_text'])); ?></p>
                    </div>
                </section>

                <section class="card mb-4 shadow-sm border-0" data-aos="fade-right" data-aos-delay="100">
                    <div class="card-body">
                        <h3 class="h5 border-bottom pb-2 mb-3 text-primary"><i class="bi bi-telephone me-2"></i>Kontakt</h3>
                        <div class="d-flex flex-column gap-2 small text-secondary">
                            <span><i class="bi bi-phone me-2"></i><?php echo htmlspecialchars($contact['phone']); ?></span>
                            <span><i class="bi bi-envelope me-2"></i><?php echo htmlspecialchars($contact['email']); ?></span>
                            <span><i class="bi bi-geo-alt me-2"></i><?php echo htmlspecialchars($contact['address']); ?></span>
                        </div>
                    </div>
                </section>

                <section class="card mb-4 shadow-sm border-0" data-aos="fade-right" data-aos-delay="200">
                    <div class="card-body">
                        <h3 class="h5 border-bottom pb-2 mb-3 text-primary"><i class="bi bi-cpu me-2"></i>Software & Tools</h3>
                        <?php
                        $skills = $pdo->query("SELECT * FROM computer_skills")->fetchAll();
                        foreach ($skills as $s) {
                            // Filter: Nur anzeigen, wenn es keine Sprache ist
                            $name = strtolower($s['skill_name']);
                            if (strpos($name, 'deutsch') !== false || strpos($name, 'english') !== false || strpos($name, 'singhalesisch') !== false) {
                                continue;
                            }
                            $val = (trim($s['level']) == 'erweitert') ? 95 : 75;
                            echo "<div class='mb-3 small'>";
                            echo "<div class='d-flex justify-content-between mb-1'><span>".htmlspecialchars($s['skill_name'])."</span><span class='text-muted'>".htmlspecialchars($s['level'])."</span></div>";
                            echo "<div class='progress' style='height: 8px;'><div class='progress-bar bg-primary' style='width: $val%'></div></div>";
                            echo "</div>";
                        }
                        ?>
                    </div>
                </section>

                <section class="card mb-4 shadow-sm border-0" data-aos="fade-right" data-aos-delay="300">
                    <div class="card-body">
                        <h3 class="h5 border-bottom pb-2 mb-3 text-info"><i class="bi bi-translate me-2"></i>Sprachkenntnisse</h3>
                        <?php
                        $langs = $pdo->query("SELECT * FROM languages")->fetchAll();
                        foreach ($langs as $l) {
                            echo "<div class='d-flex justify-content-between mb-2 small'>";
                            echo "<span class='fw-bold'>".htmlspecialchars($l['lang_name'])."</span>";
                            echo "<span class='badge bg-info-subtle text-info-emphasis'>".htmlspecialchars($l['level'])."</span>";
                            echo "</div>";
                        }
                        ?>
                    </div>
                </section>
            </div>

            <div class="col-lg-8">
                <section class="mb-5" data-aos="fade-up">
                    <h2 class="fw-bold mb-4 ps-3 border-start border-4 border-primary">BERUFSERFAHRUNG</h2>
                    <?php
                    $exps = $pdo->query("SELECT * FROM experience ORDER BY id ASC")->fetchAll();
                    foreach ($exps as $e) {
                        echo "<div class='card mb-4 border-0 shadow-sm card-hover'>";
                        echo "<div class='card-body p-4'>";
                        echo "<div class='d-flex justify-content-between align-items-start mb-2'>";
                        echo "<div><h4 class='h5 fw-bold mb-0'>".htmlspecialchars($e['position'])."</h4>";
                        echo "<span class='text-primary fw-semibold small'>".htmlspecialchars($e['company'])."</span></div>";
                        echo "<span class='badge bg-light text-dark border'>".htmlspecialchars($e['start_date'])." - ".htmlspecialchars($e['end_date'])."</span>";
                        echo "</div>";
                        echo "<p class='small text-secondary mb-0'>".nl2br(htmlspecialchars($e['description']))."</p>";
                        echo "</div></div>";
                    }
                    ?>
                </section>

                <section class="mb-5" data-aos="fade-up" data-aos-delay="200">
                    <h2 class="fw-bold mb-4 ps-3 border-start border-4 border-info">AUSBILDUNG</h2>
                    <?php
                    $edus = $pdo->query("SELECT * FROM education ORDER BY end_year DESC")->fetchAll();
                    foreach ($edus as $edu) {
                        echo "<div class='card mb-3 border-0 shadow-sm'>";
                        echo "<div class='card-body p-4'>";
                        echo "<h4 class='h6 fw-bold mb-1 text-uppercase'>".htmlspecialchars($edu['degree'])."</h4>";
                        echo "<p class='mb-2 small'><strong>".htmlspecialchars($edu['institution'])."</strong> | ".htmlspecialchars($edu['start_year'])." - ".htmlspecialchars($edu['end_year'])."</p>";
                        if($edu['specialization']) echo "<div class='alert alert-info py-1 px-2 small mb-2' style='display:inline-block;'>Schwerpunkt: ".htmlspecialchars($edu['specialization'])."</div>";
                        echo "<p class='small text-muted mb-0'>".nl2br(htmlspecialchars($edu['projects']))."</p>";
                        echo "</div></div>";
                    }
                    ?>
                </section>
            </div>
        </div>
    </div>

    <footer class="py-4 text-center border-top">
        <p class="small mb-0 opacity-75">&copy; <?php echo date('Y'); ?> | Dilshan Mihiranga - Engineering Portfolio</p>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true });
        const themeToggle = document.getElementById('themeToggle');
        themeToggle.addEventListener('click', () => {
            const current = document.body.getAttribute('data-bs-theme');
            const target = current === 'dark' ? 'light' : 'dark';
            document.body.setAttribute('data-bs-theme', target);
            document.getElementById('themeIcon').className = target === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-stars';
        });
    </script>
</body>
</html>
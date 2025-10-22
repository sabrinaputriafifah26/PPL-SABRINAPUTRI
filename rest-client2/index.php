<?php
// Load config
include("config/config.php");

// API Key NewsAPI
$api_key = "733f4eee66a541eaa9d589546ce30ba9";

// URL utama (berita teknologi dunia)
$url = "https://newsapi.org/v2/top-headlines?category=technology&language=en&apiKey=" . $api_key;

// URL alternatif (jika kategori teknologi gagal)
$alternative_urls = [
    "https://newsapi.org/v2/top-headlines?country=us&apiKey=" . $api_key,
    "https://newsapi.org/v2/top-headlines?country=id&apiKey=" . $api_key,
    "https://newsapi.org/v2/top-headlines?language=en&apiKey=" . $api_key,
];

// Ambil data awal
$data = http_request_get($url);
$hasil = json_decode($data, true);

// Cek hasil
$error_message = "";
if (!$data) {
    $error_message = "Gagal mengambil data dari API.";
} elseif (!$hasil || !isset($hasil['articles']) || empty($hasil['articles'])) {
    $success = false;
    foreach ($alternative_urls as $alt_url) {
        $data = http_request_get($alt_url);
        $hasil = json_decode($data, true);
        if ($hasil && isset($hasil['articles']) && !empty($hasil['articles'])) {
            $success = true;
            break;
        }
    }

    if (!$success) {
        // Data sample jika API gagal
        $hasil = [
            'status' => 'ok',
            'totalResults' => 3,
            'articles' => [
                [
                    'title' => 'Quantum Computing Revolutionizes AI',
                    'description' => 'Quantum computing opens a new frontier in artificial intelligence processing.',
                    'url' => '#',
                    'urlToImage' => 'https://via.placeholder.com/400x200/0dcaf0/ffffff?text=Quantum+AI',
                    'author' => 'TechNova Team',
                    'publishedAt' => date('c')
                ],
                [
                    'title' => 'Electric Cars Take Over Global Market',
                    'description' => 'Electric vehicles are now outselling gasoline cars in major countries.',
                    'url' => '#',
                    'urlToImage' => 'https://via.placeholder.com/400x200/198754/ffffff?text=EV+Market',
                    'author' => 'Green Future Daily',
                    'publishedAt' => date('c')
                ],
                [
                    'title' => 'Cybersecurity Trends 2025',
                    'description' => 'AI-driven defense systems redefine global cybersecurity standards.',
                    'url' => '#',
                    'urlToImage' => 'https://via.placeholder.com/400x200/6f42c1/ffffff?text=Cyber+Security',
                    'author' => 'SecureNet Journal',
                    'publishedAt' => date('c')
                ],
            ]
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TechNova News — Global Tech Updates</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background-color: #0e0e10;
            color: #e9ecef;
            font-family: 'Segoe UI', Roboto, sans-serif;
            padding-top: 80px;
        }

        .navbar {
            background: linear-gradient(90deg, #0dcaf0, #6610f2);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
        }

        .card {
            background-color: #1a1a1d;
            border: 1px solid #2c2f33;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 20px rgba(13, 202, 240, 0.15);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            color: #dee2e6;
        }

        .btn-primary {
            background: linear-gradient(90deg, #0dcaf0, #6610f2);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #6610f2, #0dcaf0);
        }

        .footer {
            background-color: #111;
            color: #aaa;
            text-align: center;
            padding: 30px 0;
            margin-top: 40px;
            border-top: 1px solid #222;
        }

        .section-title {
            font-weight: 700;
            color: #0dcaf0;
            text-align: center;
            margin-bottom: 30px;
        }

        .card-footer {
            font-size: 0.9rem;
            color: #6c757d;
            background-color: #18181b;
            border-top: 1px solid #2c2f33;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-microchip"></i> TechNova News
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="container">
        <?php if ($error_message): ?>
            <div class="alert alert-danger mt-4 text-center">
                <h4><i class="fas fa-exclamation-circle"></i> Error!</h4>
                <p><?php echo $error_message; ?></p>
            </div>
        <?php else: ?>
            <h2 class="section-title mt-4"><i class="fas fa-globe"></i> Global Technology Highlights</h2>
            <div class="row">
                <?php foreach ($hasil['articles'] as $row): ?>
                    <?php if (!empty($row['title']) && !empty($row['url'])): ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100">
                                <img src="<?php echo !empty($row['urlToImage']) ? htmlspecialchars($row['urlToImage']) : 'https://via.placeholder.com/400x200/0dcaf0/ffffff?text=No+Image'; ?>"
                                     class="card-img-top" alt="News Image"
                                     onerror="this.src='https://via.placeholder.com/400x200/0dcaf0/ffffff?text=No+Image'">
                                <div class="card-body d-flex flex-column">
                                    <small class="text-muted mb-2">
                                        <i class="fas fa-user"></i> 
                                        <?php echo htmlspecialchars($row['author'] ?? 'Unknown'); ?>
                                    </small>
                                    <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                                    <p class="card-text flex-grow-1">
                                        <?php echo htmlspecialchars(substr($row['description'] ?? '', 0, 100)) . '...'; ?>
                                    </p>
                                    <a href="<?php echo htmlspecialchars($row['url']); ?>" target="_blank"
                                       class="btn btn-primary btn-sm mt-auto">
                                       Read More <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                                <div class="card-footer text-muted">
                                    <?php echo date('d M Y, H:i', strtotime($row['publishedAt'] ?? 'now')); ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="footer">
        <p>&copy; <?php echo date('Y'); ?> TechNova News — Powered by NewsAPI.org</p>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
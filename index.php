<?php include 'config/database.php'; session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teras Coklat - Loyalty Program</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<!-- Navbar Premium -->
<nav class="navbar navbar-premium">
    <div class="container">
        <span class="navbar-brand mb-0 h1">
            <i class="fas fa-chocolate-bar brand-icon"></i>
            Teras Coklat <span style="color: var(--gold);">★</span> Loyalty
        </span>
        <div class="text-white small">
            <i class="fas fa-gem"></i> Premium Member
        </div>
    </div>
</nav>

<div class="container py-4">
    <div class="row g-4">
        <!-- QR Code Section -->
        <div class="col-lg-4">
            <div class="card-premium">
                <div class="card-header-premium">
                    <i class="fas fa-qrcode" style="font-size: 2rem; color: var(--gold);"></i>
                    <h6 class="mt-2">SCAN UNTUK POIN</h6>
                    <p>Setiap scan = +10 Poin</p>
                </div>
                <div class="card-body text-center p-4">
                    <div class="qr-wrapper float-animation">
                        <div id="qrcode" class="d-flex justify-content-center"></div>
                    </div>
                    <div class="mt-3">
                        <span class="qr-timer-badge">
                            <i class="fas fa-sync-alt"></i> Update tiap 60 detik
                        </span>
                    </div>
                    <p class="small text-muted mt-3 mb-0">
                        <i class="fas fa-info-circle"></i> Tunjukkan QR ke customer untuk scan
                    </p>
                </div>
            </div>
            
            <!-- Stats Card - RAPI 3 KOLOM SEJAJAR -->
            <div class="card-premium mt-4">
                <div class="card-body p-3">
                    <?php 
                    $total_members = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM pelanggan"));
                    $total_poin_all = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_poin) as total FROM pelanggan"));
                    ?>
                    <div class="row g-2 text-center">
                        <div class="col-4">
                            <div class="hero-stats p-2">
                                <p class="stat-number mb-0 fs-3 fw-bold"><?= $total_members['total'] ?></p>
                                <p class="stat-label mb-0 small"><i class="fas fa-users"></i> Total Member</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="hero-stats p-2">
                                <p class="stat-number mb-0 fs-3 fw-bold"><?= $total_poin_all['total'] ?? 0 ?></p>
                                <p class="stat-label mb-0 small"><i class="fas fa-star"></i> Total Poin</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="hero-stats p-2">
                                <p class="stat-number mb-0 fs-3 fw-bold"><?= $total_members['total'] ?></p>
                                <p class="stat-label mb-0 small"><i class="fas fa-user-plus"></i> Terdaftar</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Link Cepat - DIBUAT JADI BUTTON YANG RAPI -->
            <div class="card-premium mt-4">
                <div class="card-header-premium py-2">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-link"></i> Link Cepat</h6>
                </div>
                <div class="card-body p-3">
                    <div class="d-grid gap-2">
                        <a href="register.php" class="btn-gold" style="text-decoration: none; display: block; text-align: center; padding: 10px; border-radius: 12px;">
                            <i class="fas fa-user-plus"></i> Daftar Member Baru
                        </a>
                        <a href="checkin.php" class="btn-outline-coklat" style="text-decoration: none; display: block; text-align: center; padding: 10px; border-radius: 12px;">
                            <i class="fas fa-qrcode"></i> Halaman Klaim Poin
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Leaderboard Section -->
        <div class="col-lg-8">
            <div class="card-premium">
                <div class="card-header-premium d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-trophy" style="color: var(--gold);"></i>
                        <h5 class="d-inline-block ms-2 mb-0">Leaderboard Member</h5>
                    </div>
                    <span class="badge bg-light text-dark">
                        <i class="fas fa-fire"></i> Top Performers
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-premium mb-0">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-user"></i> Nama Member</th>
                                    <th class="text-center"><i class="fas fa-coins"></i> Poin</th>
                                    <th class="text-center"><i class="fas fa-cog"></i> Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $q = mysqli_query($conn, "SELECT * FROM pelanggan ORDER BY total_poin DESC");
                                $rank = 1;
                                if(mysqli_num_rows($q) > 0):
                                while($r = mysqli_fetch_assoc($q)): 
                                ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <?php if($rank == 1): ?>
                                                    <i class="fas fa-crown" style="color: var(--gold); font-size: 1.5rem;"></i>
                                                <?php elseif($rank == 2): ?>
                                                    <i class="fas fa-medal" style="color: #c0c0c0; font-size: 1.3rem;"></i>
                                                <?php elseif($rank == 3): ?>
                                                    <i class="fas fa-medal" style="color: #cd7f32; font-size: 1.3rem;"></i>
                                                <?php else: ?>
                                                    <span class="text-muted" style="width: 28px; display: inline-block;">#<?= $rank ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div>
                                                <strong><?= htmlspecialchars($r['nama']) ?></strong><br>
                                                <small class="text-muted"><i class="fab fa-whatsapp"></i> <?= htmlspecialchars($r['whatsapp']) ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-poin">
                                            <i class="fas fa-star"></i> <?= $r['total_poin'] ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button onclick="konfirmasiRedeem('<?= htmlspecialchars($r['nama']) ?>', <?= $r['total_poin'] ?>, <?= $r['id'] ?>)" 
                                                class="btn-redeem me-1">
                                            <i class="fas fa-gift"></i> Redeem
                                        </button>
                                        <button onclick="konfirmasiReset(<?= $r['id'] ?>)" 
                                                class="btn-reset">
                                            <i class="fas fa-undo-alt"></i> Reset
                                        </button>
                                    </td>
                                </tr>
                                <?php 
                                $rank++; 
                                endwhile;
                                else:
                                ?>
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted">
                                        <i class="fas fa-users fa-2x mb-2 d-block"></i>
                                        Belum ada member<br>
                                        <small>Silakan daftarkan member baru melalui menu "Daftar Member Baru"</small>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Info Panel -->
            <div class="card-premium mt-4">
                <div class="card-body p-3">
                    <div class="row text-center">
                        <div class="col-4">
                            <i class="fas fa-coffee" style="font-size: 1.5rem; color: var(--coklat);"></i>
                            <p class="small mt-1 mb-0">10 Poin = 1x Beli</p>
                        </div>
                        <div class="col-4">
                            <i class="fas fa-ticket-alt" style="font-size: 1.5rem; color: var(--gold);"></i>
                            <p class="small mt-1 mb-0">50 Poin = Free 1 Cup</p>
                        </div>
                        <div class="col-4">
                            <i class="fas fa-chart-line" style="font-size: 1.5rem; color: var(--coklat-muda);"></i>
                            <p class="small mt-1 mb-0">Top Member = Extra Gift</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let qrInterval;
    
    function updateQR() {
        fetch('includes/proses.php?aksi=generate_qr')
        .then(res => res.text())
        .then(token => {
            document.getElementById("qrcode").innerHTML = "";
            new QRCode(document.getElementById("qrcode"), {
                text: window.location.origin + "/es_coklat/checkin.php?token=" + token,
                width: 200,
                height: 200
            });
        })
        .catch(err => console.log('QR Update Error:', err));
    }
    
    updateQR();
    qrInterval = setInterval(updateQR, 60000);
</script>

<script src="assets/js/script.js"></script>
</body>
</html>
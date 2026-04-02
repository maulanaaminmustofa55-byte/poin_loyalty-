<?php include 'config/database.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klaim Poin - Teras Coklat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="d-flex align-items-center" style="min-height: 100vh; background: linear-gradient(135deg, #fef8ed 0%, #f5e6d3 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="checkin-card">
                    <div class="checkin-header">
                        <div class="chocolate-icon">
                            🍫🥤
                        </div>
                        <h4 class="fw-bold mb-0">KLAIM POIN</h4>
                        <p class="mb-0 mt-1 small">Scan & Dapatkan Poin Loyalty</p>
                    </div>
                    <div class="p-4">
                        <?php 
                        $status = $_GET['status'] ?? '';
                        $token = $_GET['token'] ?? '';
                        
                        if($status == 'ok'): ?>
                            <div class="alert alert-premium alert-success-premium mb-4">
                                <i class="fas fa-check-circle me-2"></i>
                                <strong>✓ Berhasil!</strong> +10 Poin telah ditambahkan ke akun Anda!
                            </div>
                        <?php endif; ?>
                        
                        <?php if($status == 'expired'): ?>
                            <div class="alert alert-premium alert-danger-premium mb-4">
                                <i class="fas fa-clock me-2"></i>
                                <strong>⚠ QR Expired!</strong> Silakan scan QR terbaru yang ditunjukkan kasir.
                            </div>
                        <?php endif; ?>
                        
                        <?php if($status == 'fail'): ?>
                            <div class="alert alert-premium alert-warning-premium mb-4">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>⚠ Nomor Tidak Terdaftar!</strong> 
                                <a href="register.php?token=<?= $token ?>" class="alert-link">Daftar dulu di sini</a> jadi member.
                            </div>
                        <?php endif; ?>
                        
                        <form action="includes/proses.php" method="POST">
                            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                            <div class="mb-4">
                                <label class="input-label">
                                    <i class="fas fa-mobile-alt me-2"></i> Nomor WhatsApp Kamu
                                </label>
                                <input type="number" 
                                       name="whatsapp" 
                                       class="form-control input-premium text-center" 
                                       required 
                                       placeholder="contoh: 81234567890"
                                       style="font-size: 1.1rem;">
                                <small class="text-muted d-block mt-2">
                                    <i class="fas fa-info-circle me-1"></i> Pastikan nomor sudah terdaftar
                                </small>
                            </div>
                            <button type="submit" name="self_checkin" class="btn-coklat w-100 py-3">
                                <i class="fas fa-gem me-2"></i> DAPATKAN POIN <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </form>
                        
                        <hr class="my-4">
                        
                        <div class="text-center">
                            <p class="small text-muted mb-2">
                                Belum punya akun? 
                                <a href="register.php?token=<?= $token ?>" class="text-decoration-none fw-bold" style="color: var(--gold);">
                                    <i class="fas fa-user-plus"></i> Daftar Member Baru
                                </a>
                            </p>
                            <div class="d-flex justify-content-center gap-3 mt-3">
                                <span class="badge bg-light text-dark p-2">
                                    <i class="fas fa-coffee"></i> 1x Beli = 10 Poin
                                </span>
                                <span class="badge bg-light text-dark p-2">
                                    <i class="fas fa-ticket-alt"></i> 50 Poin = Free 1 Cup
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
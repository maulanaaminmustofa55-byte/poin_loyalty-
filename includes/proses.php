<?php
include '../config/database.php';
session_start();

// Buat Token QR baru setiap kali dipanggil (Hanya Admin yang bisa trigger)
if (isset($_GET['aksi']) && $_GET['aksi'] == 'generate_qr') {
    $_SESSION['qr_token'] = bin2hex(random_bytes(16));
    $_SESSION['qr_time'] = time();
    echo $_SESSION['qr_token'];
    exit();
}

// REGISTRASI MEMBER BARU
if (isset($_POST['register_member'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $wa = mysqli_real_escape_string($conn, $_POST['whatsapp']);
    $token_input = $_POST['token'] ?? '';
    
    // Cek apakah nomor sudah terdaftar
    $cek = mysqli_query($conn, "SELECT id FROM pelanggan WHERE whatsapp = '$wa'");
    if (mysqli_num_rows($cek) > 0) {
        // Sudah terdaftar, redirect dengan pesan
        header("Location: ../register.php?status=exists&token=" . $token_input);
        exit();
    }
    
    // Insert member baru (poin awal 0)
    $query = "INSERT INTO pelanggan (nama, whatsapp, total_poin) VALUES ('$nama', '$wa', 0)";
    if (mysqli_query($conn, $query)) {
        header("Location: ../register.php?status=success&token=" . $token_input);
    } else {
        header("Location: ../register.php?status=error");
    }
    exit();
}

// PROSES SELF CHECK-IN PEMBELI (sudah terdaftar)
if (isset($_POST['self_checkin'])) {
    $wa = mysqli_real_escape_string($conn, $_POST['whatsapp']);
    $token_input = $_POST['token'];

    // Cek apakah token sama dengan yang ada di server dan belum expired (120 detik)
    if (isset($_SESSION['qr_token']) && $token_input === $_SESSION['qr_token'] && (time() - $_SESSION['qr_time']) < 120) {
        $cek = mysqli_query($conn, "SELECT id, nama FROM pelanggan WHERE whatsapp = '$wa'");
        if (mysqli_num_rows($cek) > 0) {
            // Update poin +10
            mysqli_query($conn, "UPDATE pelanggan SET total_poin = total_poin + 10 WHERE whatsapp = '$wa'");
            header("Location: ../checkin.php?status=ok&token=" . $token_input);
        } else {
            // Nomor tidak terdaftar, arahkan ke register
            header("Location: ../checkin.php?status=fail&token=" . $token_input);
        }
    } else {
        // Jika token salah atau sudah kadaluarsa
        header("Location: ../checkin.php?status=expired&token=" . $token_input);
    }
    exit();
}

// FITUR ADMIN LAINNYA (TUKAR, RESET)
if (isset($_GET['aksi'])) {
    $id = $_GET['id'];
    if ($_GET['aksi'] == 'tukar_poin') {
        // Cek dulu poin cukup ga
        $cek_poin = mysqli_fetch_assoc(mysqli_query($conn, "SELECT total_poin FROM pelanggan WHERE id = $id"));
        if ($cek_poin['total_poin'] >= 50) {
            mysqli_query($conn, "UPDATE pelanggan SET total_poin = total_poin - 50 WHERE id = $id");
        }
    }
    if ($_GET['aksi'] == 'reset_poin') {
        mysqli_query($conn, "UPDATE pelanggan SET total_poin = 0 WHERE id = $id");
    }
    header("Location: ../index.php");
    exit();
}
?>
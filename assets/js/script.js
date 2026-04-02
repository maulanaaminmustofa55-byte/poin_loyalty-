// Konfirmasi Redeem dengan animasi toast effect
function konfirmasiRedeem(nama, totalPoin, id) {
    if (totalPoin < 50) {
        // Custom alert yang lebih menarik
        showNotification('warning', `Poin ${nama} belum cukup! Minimal 50 poin untuk redeem.`);
        return;
    }
    
    if (confirm(`🍫 Yakin mau tukar 50 poin milik ${nama}?\n\n✅ Bonus: 1 Cup Es Coklat GRATIS!\n💰 Sisa poin: ${totalPoin - 50}`)) {
        window.location.href = "includes/proses.php?aksi=tukar_poin&id=" + id;
    }
}

// Konfirmasi Reset Poin
function konfirmasiReset(id) {
    if (confirm("⚠️ PERINGATAN!\n\nSemua poin akan direset menjadi 0!\n\nApakah Anda yakin ingin melanjutkan?")) {
        window.location.href = "includes/proses.php?aksi=reset_poin&id=" + id;
    }
}

// Function untuk menampilkan notifikasi (optional)
function showNotification(type, message) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'warning' ? 'warning' : 'info'}`;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        animation: slideIn 0.3s ease;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    `;
    notification.innerHTML = `
        <i class="fas ${type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle'} me-2"></i>
        ${message}
    `;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
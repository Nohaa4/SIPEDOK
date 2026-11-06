
<?php
$pesanSukses = session()->getFlashdata('success');
$pesanError = session()->getFlashdata('error');
?>

<?php if ($pesanSukses || $pesanError): ?>
<div id="sipNotification"
     class="sip-notification <?= $pesanError ? 'notification-error' : 'notification-success' ?>">

    <div class="notification-icon">
        <i class="bi <?= $pesanError ? 'bi-exclamation-circle-fill' : 'bi-check-circle-fill' ?>"></i>
    </div>

    <div class="notification-content">
        <strong><?= $pesanError ? 'Terjadi Kesalahan' : 'Berhasil!' ?></strong>
        <p><?= esc($pesanSukses ?: $pesanError) ?></p>
    </div>

    <button type="button" onclick="closeSipNotification()">
        <i class="bi bi-x-lg"></i>
    </button>
</div>
<?php endif; ?>

<style>
.sip-notification {
    position: fixed;
    top: 22px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 99999;
    width: min(420px, calc(100% - 30px));
    display: flex;
    align-items: center;
    gap: 13px;
    padding: 16px 18px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(0,0,0,.13);
    border-left: 4px solid #21965c;
    animation: sipToastIn .35s ease;
}

.notification-error {
    border-left-color: #dc5353;
}

.notification-icon {
    font-size: 25px;
    color: #21965c;
}

.notification-error .notification-icon {
    color: #dc5353;
}

.notification-content {
    flex: 1;
}

.notification-content strong {
    display: block;
    color: #263445;
    font-size: 14px;
}

.notification-content p {
    margin: 3px 0 0;
    color: #687586;
    font-size: 13px;
}

.sip-notification button {
    border: 0;
    background: transparent;
    color: #87909c;
    cursor: pointer;
}

@keyframes sipToastIn {
    from { opacity: 0; transform: translate(-50%, -20px); }
    to { opacity: 1; transform: translate(-50%, 0); }
}
</style>

<script>
function closeSipNotification() {
    const notification = document.getElementById('sipNotification');
    if (notification) notification.remove();
}

document.addEventListener('DOMContentLoaded', function () {
    const notification = document.getElementById('sipNotification');

    if (notification) {
        setTimeout(function () {
            notification.style.opacity = '0';
            notification.style.transition = 'opacity .3s ease';

            setTimeout(function () {
                notification.remove();
            }, 300);
        }, 4000);
    }
});
</script>

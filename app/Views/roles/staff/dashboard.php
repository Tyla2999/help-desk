<main class="dashboard-page">
    <div class="dashboard-header">
        <h1>แดชบอร์ดพนักงาน</h1>
        <p>ยินดีต้อนรับ <?= e((string) ($currentUser['full_name'] ?? '')) ?></p>
    </div>

    <div class="dashboard-actions">
        <a class="btn-hero-secondary dark" href="<?= e(url('/')) ?>">ไปหน้าเว็บหลัก</a>
        <form method="post" action="<?= e(url('logout')) ?>" class="inline-form">
            <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
            <button type="submit" class="btn-report">ออกจากระบบ</button>
        </form>
    </div>

    <section class="card">
        <div class="card-header">สิทธิ์ของพนักงาน</div>
        <div class="card-body">
            <p>คุณสามารถเข้าสู่ระบบและส่งคำขอแจ้งซ่อมผ่านหน้าเว็บหลักได้</p>
        </div>
    </section>
</main>

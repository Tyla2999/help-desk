<main class="dashboard-page">
    <div class="dashboard-header">
        <h1>แดชบอร์ดหัวหน้างาน</h1>
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
        <div class="card-header">สิทธิ์ของหัวหน้างาน</div>
        <div class="card-body">
            <p>คุณสามารถเข้าสู่ระบบและใช้งานฟอร์มแจ้งซ่อมได้ตามสิทธิ์ที่ระบบกำหนด</p>
        </div>
    </section>
</main>

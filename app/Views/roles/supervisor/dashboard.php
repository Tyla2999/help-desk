<main class="dashboard-shell">
    <aside class="dashboard-sidebar">
        <div class="sidebar-brand">SUPERVISOR</div>
        <nav class="sidebar-menu">
            <a href="<?= e(url('supervisor/dashboard')) ?>" class="active">แดชบอร์ดหัวหน้างาน</a>
            <a href="<?= e(url('/')) ?>">หน้าเว็บหลัก</a>
        </nav>
        <form method="post" action="<?= e(url('logout')) ?>" class="sidebar-logout">
            <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
            <button type="submit" class="btn-report">ออกจากระบบ</button>
        </form>
    </aside>

    <section class="dashboard-content">
        <div class="dashboard-header">
            <div class="sub">SUPERVISOR DASHBOARD</div>
            <h1>แดชบอร์ดหัวหน้างาน</h1>
            <p>ยินดีต้อนรับ <?= e((string) ($currentUser['full_name'] ?? '')) ?></p>
        </div>

        <section class="card">
            <div class="card-header">สิทธิ์ของหัวหน้างาน</div>
            <div class="card-body">
                <p>คุณสามารถเข้าสู่ระบบและใช้งานฟอร์มแจ้งซ่อมได้ตามสิทธิ์ที่ระบบกำหนด</p>
            </div>
        </section>
    </section>
</main>

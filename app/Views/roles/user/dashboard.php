<main class="dashboard-shell">
    <aside class="dashboard-sidebar">
        <div class="sidebar-brand">USER</div>
        <nav class="sidebar-menu">
            <a href="<?= e(url('user/dashboard')) ?>" class="active">แดชบอร์ดพนักงาน</a>
            <a href="<?= e(url('/')) ?>">หน้าเว็บหลัก</a>
        </nav>
        <form method="post" action="<?= e(url('logout')) ?>" class="sidebar-logout">
            <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
            <button type="submit" class="btn-report">ออกจากระบบ</button>
        </form>
    </aside>

    <section class="dashboard-content">
        <div class="dashboard-header">
            <div class="sub">USER DASHBOARD</div>
            <h1>แดชบอร์ดพนักงาน</h1>
            <p>ยินดีต้อนรับ <?= e((string) ($currentUser['full_name'] ?? '')) ?></p>
        </div>

        <section class="card">
            <div class="card-header">สิทธิ์ของพนักงาน</div>
            <div class="card-body">
                <p>คุณสามารถเข้าสู่ระบบและส่งคำขอแจ้งซ่อมผ่านหน้าเว็บหลักได้</p>
            </div>
        </section>
    </section>
</main>

<main class="auth-page">
    <div class="auth-card">
        <h1>เข้าสู่ระบบ</h1>
        <p>เข้าสู่ระบบเพื่อใช้งาน Help Desk ตามบทบาทของคุณ</p>

        <?php if (!empty($success)): ?>
            <div class="alert"><?= e((string) $success) ?></div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="alert alert-error"><?= e((string) $error) ?></div>
        <?php endif; ?>

        <form method="post" action="<?= e(url('login')) ?>" class="report-form">
            <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
            <div class="form-row">
                <label>อีเมล</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-row">
                <label>รหัสผ่าน</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn-submit">เข้าสู่ระบบ</button>
        </form>

        <div class="auth-links">
            <a href="<?= e(url('register')) ?>">ยังไม่มีบัญชี? สมัครสมาชิก</a>
            <a href="<?= e(url('/')) ?>">กลับหน้าแรก</a>
        </div>
    </div>
</main>

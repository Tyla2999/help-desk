<main class="auth-page">
    <div class="auth-card">
        <h1>สมัครสมาชิก</h1>
        <p>บัญชีใหม่จะอยู่ในสถานะรออนุมัติจากแอดมินก่อนเข้าใช้งาน</p>

        <?php if (!empty($success)): ?>
            <div class="alert"><?= e((string) $success) ?></div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="alert alert-error"><?= e((string) $error) ?></div>
        <?php endif; ?>

        <form method="post" action="<?= e(url('register')) ?>" class="report-form">
            <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
            <div class="form-row">
                <label>ชื่อ-นามสกุล</label>
                <input type="text" name="full_name" required>
            </div>
            <div class="form-row">
                <label>อีเมล</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-row">
                <label>รหัสผ่าน (อย่างน้อย 8 ตัวอักษร)</label>
                <input type="password" name="password" minlength="8" required>
            </div>
            <div class="form-row">
                <label>บทบาท</label>
                <select name="role" required>
                    <option value="staff" selected>พนักงาน</option>
                    <option value="supervisor">หัวหน้างาน</option>
                </select>
            </div>
            <button type="submit" class="btn-submit">สมัครสมาชิก</button>
        </form>

        <div class="auth-links">
            <a href="<?= e(url('login')) ?>">มีบัญชีแล้ว? เข้าสู่ระบบ</a>
            <a href="<?= e(url('/')) ?>">กลับหน้าแรก</a>
        </div>
    </div>
</main>

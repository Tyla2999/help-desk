<main class="dashboard-page">
    <div class="dashboard-header">
        <h1>แดชบอร์ดแอดมิน</h1>
        <p>ยินดีต้อนรับ <?= e((string) ($currentUser['full_name'] ?? '')) ?></p>
    </div>

    <div class="dashboard-actions">
        <a class="btn-hero-secondary dark" href="<?= e(url('admin/content')) ?>">จัดการเนื้อหาเว็บไซต์</a>
        <a class="btn-hero-secondary dark" href="<?= e(url('/')) ?>">ไปหน้าเว็บหลัก</a>
        <form method="post" action="<?= e(url('logout')) ?>" class="inline-form">
            <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
            <button type="submit" class="btn-report">ออกจากระบบ</button>
        </form>
    </div>

    <?php if (!empty($success)): ?>
        <div class="alert"><?= e((string) $success) ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="alert alert-error"><?= e((string) $error) ?></div>
    <?php endif; ?>

    <section class="card">
        <div class="card-header">ผู้ใช้รออนุมัติ</div>
        <div class="card-body">
            <?php if (empty($pendingUsers)): ?>
                <p>ไม่มีผู้ใช้ที่รออนุมัติ</p>
            <?php else: ?>
                <div class="table-wrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ชื่อ</th>
                                <th>อีเมล</th>
                                <th>บทบาท</th>
                                <th>สมัครเมื่อ</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pendingUsers as $user): ?>
                                <tr>
                                    <td><?= e((string) ($user['full_name'] ?? '-')) ?></td>
                                    <td><?= e((string) ($user['email'] ?? '-')) ?></td>
                                    <td><?= e((string) ($user['role'] ?? '-')) ?></td>
                                    <td><?= e((string) ($user['created_at'] ?? '-')) ?></td>
                                    <td class="table-actions">
                                        <form method="post" action="<?= e(url('admin/users/approve')) ?>" class="inline-form">
                                            <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
                                            <input type="hidden" name="user_id" value="<?= e((string) ($user['id'] ?? 0)) ?>">
                                            <button type="submit" class="btn-submit small">อนุมัติ</button>
                                        </form>
                                        <form method="post" action="<?= e(url('admin/users/reject')) ?>" class="inline-form">
                                            <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
                                            <input type="hidden" name="user_id" value="<?= e((string) ($user['id'] ?? 0)) ?>">
                                            <button type="submit" class="btn-cancel small">ปฏิเสธ</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

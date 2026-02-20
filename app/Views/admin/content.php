<main class="dashboard-page">
    <div class="dashboard-header">
        <h1>จัดการเนื้อหาเว็บไซต์</h1>
        <p>แอดมินสามารถปรับข้อความและจัดการประกาศได้จากหน้านี้</p>
    </div>

    <div class="dashboard-actions">
        <a class="btn-hero-secondary dark" href="<?= e(url('admin/users')) ?>">กลับไปอนุมัติผู้ใช้</a>
        <a class="btn-hero-secondary dark" href="<?= e(url('/')) ?>">ไปหน้าเว็บหลัก</a>
    </div>

    <?php if (!empty($success)): ?>
        <div class="alert"><?= e((string) $success) ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="alert alert-error"><?= e((string) $error) ?></div>
    <?php endif; ?>

    <section class="card">
        <div class="card-header">ข้อมูลหน้าเว็บ</div>
        <div class="card-body">
            <form method="post" action="<?= e(url('admin/content/update')) ?>" class="report-form">
                <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
                <div class="form-row">
                    <label>หัวข้อ Hero</label>
                    <input type="text" name="hero_title" value="<?= e((string) ($values['hero_title'] ?? '')) ?>">
                </div>
                <div class="form-row">
                    <label>ข้อความรอง Hero</label>
                    <textarea name="hero_subtitle"><?= e((string) ($values['hero_subtitle'] ?? '')) ?></textarea>
                </div>
                <div class="form-row">
                    <label>เบอร์ติดต่อ</label>
                    <input type="text" name="contact_phone" value="<?= e((string) ($values['contact_phone'] ?? '')) ?>">
                </div>
                <div class="form-row">
                    <label>อีเมลติดต่อ</label>
                    <input type="email" name="contact_email" value="<?= e((string) ($values['contact_email'] ?? '')) ?>">
                </div>
                <button type="submit" class="btn-submit">บันทึกเนื้อหา</button>
            </form>
        </div>
    </section>

    <section class="card spaced-top">
        <div class="card-header">ลบประกาศ</div>
        <div class="card-body">
            <?php if (empty($announcements)): ?>
                <p>ยังไม่มีประกาศในระบบ</p>
            <?php else: ?>
                <div class="table-wrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>หัวข้อ</th>
                                <th>วันที่</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($announcements as $announcement): ?>
                                <tr>
                                    <td><?= e((string) ($announcement['title'] ?? '-')) ?></td>
                                    <td><?= e((string) ($announcement['created_at'] ?? '-')) ?></td>
                                    <td>
                                        <form method="post" action="<?= e(url('admin/announcements/delete')) ?>" class="inline-form">
                                            <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
                                            <input type="hidden" name="announcement_id" value="<?= e((string) ($announcement['id'] ?? 0)) ?>">
                                            <button type="submit" class="btn-cancel small">ลบ</button>
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

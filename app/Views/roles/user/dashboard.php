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

        <?php if (!empty($success)): ?>
            <div class="alert"><?= e((string) $success) ?></div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="alert alert-error"><?= e((string) $error) ?></div>
        <?php endif; ?>

        <section class="dashboard-grid two">
            <article class="card card-soft">
                <div class="card-header">ส่งไอเดียพัฒนาองค์กร</div>
                <div class="card-body">
                    <form method="post" action="<?= e(url('user/ideas')) ?>" class="report-form">
                        <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
                        <div class="form-row">
                            <label>หัวข้อไอเดีย</label>
                            <input type="text" name="title" maxlength="120" placeholder="เช่น ระบบแจ้งเตือนสถานะงานผ่านอีเมล" required>
                        </div>
                        <div class="form-row">
                            <label>รายละเอียด</label>
                            <textarea name="description" maxlength="500" placeholder="อธิบายแนวคิดแบบสั้น กระชับ และชัดเจน" required></textarea>
                        </div>
                        <button type="submit" class="btn-submit">ส่งไอเดีย</button>
                    </form>
                </div>
            </article>

            <article class="card card-soft">
                <div class="card-header">ไอเดียที่ทีมกำลังโหวต</div>
                <div class="card-body">
                    <div class="idea-list">
                        <?php if (empty($ideas)): ?>
                            <p>ยังไม่มีไอเดียในระบบ ลองเป็นคนแรกที่เริ่มแชร์ไอเดีย</p>
                        <?php else: ?>
                            <?php foreach ($ideas as $idea): ?>
                                <div class="idea-item">
                                    <div class="idea-item-head">
                                        <h4><?= e((string) ($idea['title'] ?? '-')) ?></h4>
                                        <span class="idea-vote">👍 <?= e((string) ($idea['vote_count'] ?? '0')) ?></span>
                                    </div>
                                    <p><?= e((string) ($idea['description'] ?? '-')) ?></p>
                                    <div class="idea-meta">
                                        <span>โดย <?= e((string) ($idea['full_name'] ?? '-')) ?></span>
                                        <form method="post" action="<?= e(url('user/ideas/vote')) ?>" class="inline-form">
                                            <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
                                            <input type="hidden" name="idea_id" value="<?= e((string) ($idea['id'] ?? 0)) ?>">
                                            <button type="submit" class="btn-vote">โหวตไอเดียนี้</button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </article>
        </section>
    </section>
</main>

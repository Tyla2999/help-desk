<?php
/** @var array<int, array<string, mixed>> $announcements */
/** @var array<int, array<string, mixed>> $tickets */
?>

<section class="hero">
    <div class="hero-content">
        <p class="hero-label">SERVICE DESK</p>
        <h2>ศูนย์แจ้งซ่อมและประกาศงานไอที</h2>
        <p>จัดการคำขอซ่อม แจ้งข่าวสารสำคัญ และติดตามงานล่าสุดได้จากหน้าเดียวในรูปแบบมาตรฐานองค์กร</p>
    </div>
    <img src="<?= e(asset_url('assets/images/banner-it.svg')) ?>" alt="IT Support Banner" class="hero-image">
</section>

<?php if (!empty($success)): ?>
    <div class="alert"><?= e($success) ?></div>
<?php endif; ?>

<section class="panel-grid single-column">
    <article class="panel">
        <div class="panel-head">
            <h3>ประกาศล่าสุด</h3>
            <p>ข่าวสารและการแจ้งเตือนจากทีมไอที</p>
        </div>
        <?php if (empty($announcements)): ?>
            <p class="muted">ยังไม่มีประกาศ</p>
        <?php else: ?>
            <div class="list">
                <?php foreach ($announcements as $announcement): ?>
                    <article class="list-item">
                        <div class="item-head">
                            <h4><?= e($announcement['title'] ?? '-') ?></h4>
                            <small><?= e($announcement['created_at'] ?? '-') ?></small>
                        </div>
                        <p class="item-body"><?= nl2br(e($announcement['detail'] ?? '-')) ?></p>
                        <?php if (!empty($announcement['image_url'])): ?>
                            <img src="<?= e($announcement['image_url']) ?>" alt="announcement image" class="thumb">
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </article>
</section>

<section class="panel-grid">
    <article class="panel">
        <div class="panel-head">
            <h3>รายการแจ้งซ่อมล่าสุด</h3>
            <p>คำขอซ่อมที่ถูกส่งเข้าระบบล่าสุด</p>
        </div>
        <?php if (empty($tickets)): ?>
            <p class="muted">ยังไม่มีงานแจ้งซ่อม</p>
        <?php else: ?>
            <div class="list">
                <?php foreach ($tickets as $ticket): ?>
                    <article class="list-item">
                        <div class="item-head">
                            <h4><?= e($ticket['problem'] ?? '-') ?></h4>
                            <small><?= e($ticket['created_at'] ?? '-') ?></small>
                        </div>
                        <p class="item-body">ผู้แจ้ง: <?= e($ticket['name'] ?? '-') ?> • แผนก: <?= e($ticket['department'] ?? '-') ?></p>
                        <div class="meta-row">
                            <span class="meta-pill">ความเร่งด่วน: <?= e($ticket['priority'] ?? '-') ?></span>
                            <span class="meta-pill">สถานะ: <?= e($ticket['status'] ?? '-') ?></span>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </article>

    <article class="panel action-panel">
        <div class="panel-head">
            <h3>แจ้งงานซ่อม</h3>
            <p>กรอกแบบฟอร์มเมื่อต้องการส่งคำขอซ่อมเท่านั้น</p>
        </div>

        <details class="request-box">
            <summary class="request-trigger">+ แจ้งงานซ่อม</summary>
            <form method="post" action="<?= e(url('tickets')) ?>" class="stack request-form">
                <label>ชื่อผู้แจ้ง</label>
                <input type="text" name="name" placeholder="ชื่อ-สกุล" required>

                <label>แผนก</label>
                <input type="text" name="department" placeholder="เช่น บัญชี / ฝ่ายขาย">

                <label>รายละเอียดปัญหา</label>
                <textarea name="problem" rows="4" placeholder="อธิบายปัญหาที่พบ" required></textarea>

                <label>ความเร่งด่วน</label>
                <select name="priority">
                    <option value="ต่ำ">ต่ำ</option>
                    <option value="ปกติ" selected>ปกติ</option>
                    <option value="สูง">สูง</option>
                    <option value="เร่งด่วน">เร่งด่วน</option>
                </select>

                <button type="submit">ส่งแจ้งซ่อม</button>
            </form>
        </details>
    </article>
</section>

<section class="panel-grid single-column">
    <article class="panel">
        <div class="panel-head">
            <h3>เพิ่มประกาศ</h3>
            <p>สำหรับผู้ดูแลระบบ: บันทึกประกาศเพื่อสื่อสารกับผู้ใช้งานภายใน</p>
        </div>
        <form method="post" action="<?= e(url('announcements')) ?>" class="stack">
            <label>หัวข้อประกาศ</label>
            <input type="text" name="title" placeholder="เช่น แจ้งปิดปรับปรุงระบบ" required>

            <label>รายละเอียด</label>
            <textarea name="detail" rows="4" placeholder="รายละเอียดประกาศ" required></textarea>

            <label>ลิงก์รูปภาพ (ถ้ามี)</label>
            <input type="url" name="image_url" placeholder="https://example.com/image.jpg">

            <button type="submit">บันทึกประกาศ</button>
        </form>
    </article>
</section>

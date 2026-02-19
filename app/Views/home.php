<?php
/** @var array<int, array<string, mixed>> $announcements */
/** @var array<int, array<string, mixed>> $tickets */
?>

<section class="banner">
    <div>
        <h2>ศูนย์รับแจ้งปัญหาไอที</h2>
        <p>แจ้งซ่อมได้รวดเร็ว ติดตามงานง่าย และประกาศสำคัญเห็นชัดในหน้าเดียว</p>
    </div>
    <img src="<?= e(url('assets/images/banner-it.svg')) ?>" alt="IT Support Banner">
</section>

<?php if (!empty($success)): ?>
    <div class="alert"><?= e($success) ?></div>
<?php endif; ?>

<section class="grid two-columns">
    <article class="card">
        <h3>เพิ่มประกาศ</h3>
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

    <article class="card">
        <h3>แจ้งซ่อมไอที</h3>
        <form method="post" action="<?= e(url('tickets')) ?>" class="stack">
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
    </article>
</section>

<section class="grid two-columns">
    <article class="card">
        <h3>รายการประกาศล่าสุด</h3>
        <?php if (empty($announcements)): ?>
            <p class="muted">ยังไม่มีประกาศ</p>
        <?php else: ?>
            <div class="list">
                <?php foreach ($announcements as $announcement): ?>
                    <div class="list-item">
                        <h4><?= e($announcement['title'] ?? '-') ?></h4>
                        <p><?= nl2br(e($announcement['detail'] ?? '-')) ?></p>
                        <?php if (!empty($announcement['image_url'])): ?>
                            <img src="<?= e($announcement['image_url']) ?>" alt="announcement image" class="thumb">
                        <?php endif; ?>
                        <small><?= e($announcement['created_at'] ?? '-') ?></small>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </article>

    <article class="card">
        <h3>งานแจ้งซ่อมล่าสุด</h3>
        <?php if (empty($tickets)): ?>
            <p class="muted">ยังไม่มีงานแจ้งซ่อม</p>
        <?php else: ?>
            <div class="list">
                <?php foreach ($tickets as $ticket): ?>
                    <div class="list-item">
                        <h4><?= e($ticket['problem'] ?? '-') ?></h4>
                        <p>ผู้แจ้ง: <?= e($ticket['name'] ?? '-') ?> | แผนก: <?= e($ticket['department'] ?? '-') ?></p>
                        <p>ความเร่งด่วน: <strong><?= e($ticket['priority'] ?? '-') ?></strong> | สถานะ: <?= e($ticket['status'] ?? '-') ?></p>
                        <small><?= e($ticket['created_at'] ?? '-') ?></small>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </article>
</section>

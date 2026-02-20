<?php
/** @var array<int, array<string, mixed>> $announcements */
/** @var array<int, array<string, mixed>> $tickets */
/** @var array<string, string> $siteContents */
/** @var array<string, mixed>|null $currentUser */

$featuredAnnouncement = $announcements[0] ?? null;
$recentAnnouncements = array_slice($announcements, 1, 5);
$recentTickets = array_slice($tickets, 0, 5);
$urgentCount = count(array_filter($tickets, static fn(array $ticket): bool => in_array((string) ($ticket['priority'] ?? ''), ['สูง', 'เร่งด่วน'], true)));
$openCount = count(array_filter($tickets, static fn(array $ticket): bool => (string) ($ticket['status'] ?? '') !== 'ปิดงาน'));

$tickerParts = [];
foreach (array_slice($announcements, 0, 5) as $announcement) {
    $title = trim((string) ($announcement['title'] ?? ''));
    $detail = trim((string) ($announcement['detail'] ?? ''));
    if ($title === '' && $detail === '') {
        continue;
    }
    $tickerParts[] = trim($title . ' ' . $detail);
}

$tickerText = empty($tickerParts)
    ? 'ยินดีต้อนรับสู่ศูนย์บริการฝ่ายเทคโนโลยีสารสนเทศ • สามารถติดตามข่าวสารและแจ้งซ่อมผ่านระบบออนไลน์ได้ทันที'
    : implode(' | ', $tickerParts);

$heroTitle = trim((string) ($siteContents['hero_title'] ?? '')) ?: 'บริการไอทีครบวงจร เพื่อการทำงานที่มีประสิทธิภาพ';
$heroSubtitle = trim((string) ($siteContents['hero_subtitle'] ?? '')) ?: 'ศูนย์กลางข้อมูลข่าวสาร บริการ และการสนับสนุนด้านเทคโนโลยีสารสนเทศ สำหรับบุคลากรทุกท่าน';
$contactPhone = trim((string) ($siteContents['contact_phone'] ?? '')) ?: '0-2xxx-xxxx ต่อ 1234';
$contactEmail = trim((string) ($siteContents['contact_email'] ?? '')) ?: 'it@company.com';

$isLoggedIn = $currentUser !== null;
$isAdmin = $isLoggedIn && ((string) ($currentUser['role'] ?? '') === 'admin');
?>

<div class="topbar">
    <div class="container">
        <div class="topbar-left">
            <span>โทร: <?= e($contactPhone) ?></span>
        </div>
        <div>
            <a href="#announcements">ข่าวสาร</a>
            <a href="#service-status">สถานะระบบ</a>
            <a href="#contact-it">ติดต่อเรา</a>
        </div>
    </div>
</div>

<header>
    <div class="container">
        <div class="logo-area">
            <div class="logo-icon">IT</div>
            <div class="logo-text">
                <h1>ฝ่ายเทคโนโลยีสารสนเทศ</h1>
                <p>Information Technology Division</p>
            </div>
        </div>
        <nav>
            <a href="#announcements" class="active">หน้าแรก</a>
            <a href="#announcements">ข่าวสาร</a>
            <a href="#service-status">บริการ</a>
            <a href="#contact-it">ติดต่อ</a>
            <?php if ($isLoggedIn): ?>
                <a href="<?= e(url('dashboard')) ?>">แดชบอร์ด</a>
                <button type="button" class="btn-report" data-open-report>แจ้งซ่อม</button>
                <form method="post" action="<?= e(url('logout')) ?>" class="inline-form">
                    <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
                    <button type="submit" class="btn-report secondary">ออกจากระบบ</button>
                </form>
            <?php else: ?>
                <a href="<?= e(url('login')) ?>">เข้าสู่ระบบ</a>
                <a href="<?= e(url('register')) ?>">สมัครสมาชิก</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<div class="ticker-wrap">
    <div class="container ticker-inner">
        <div class="ticker-label">ประกาศ</div>
        <div class="ticker-scroll">
            <div class="ticker-text"><?= e($tickerText) ?></div>
        </div>
    </div>
</div>

<section class="hero">
    <div class="container">
        <div class="hero-text">
            <h2><?= e($heroTitle) ?></h2>
            <p><?= e($heroSubtitle) ?></p>
        </div>
        <div class="hero-actions">
            <?php if ($isLoggedIn): ?>
                <button type="button" class="btn-hero-primary" data-open-report>แจ้งซ่อมออนไลน์</button>
            <?php else: ?>
                <a href="<?= e(url('login')) ?>" class="btn-hero-primary">เข้าสู่ระบบเพื่อแจ้งซ่อม</a>
            <?php endif; ?>
            <a href="#service-status" class="btn-hero-secondary">ตรวจสอบสถานะ</a>
        </div>
    </div>
</section>

<section class="quick-access">
    <div class="container">
        <a href="#announcements" class="quick-item">
            <div class="qi-icon">N</div>
            <div>
                <div class="qi-label">ข่าวสารไอที</div>
                <div class="qi-sub">ประกาศล่าสุด</div>
            </div>
        </a>
        <a href="#service-status" class="quick-item">
            <div class="qi-icon">S</div>
            <div>
                <div class="qi-label">สถานะบริการ</div>
                <div class="qi-sub">ตรวจสอบระบบ</div>
            </div>
        </a>
        <a href="#contact-it" class="quick-item">
            <div class="qi-icon">C</div>
            <div>
                <div class="qi-label">ติดต่อฝ่าย IT</div>
                <div class="qi-sub">ช่องทางติดต่อ</div>
            </div>
        </a>
        <button type="button" class="quick-item quick-action" data-open-report>
            <div class="qi-icon">R</div>
            <div>
                <div class="qi-label">แจ้งซ่อมอุปกรณ์</div>
                <div class="qi-sub">ส่งคำขอออนไลน์</div>
            </div>
        </button>
    </div>
</section>

<?php if (!empty($success)): ?>
    <div class="alert"><?= e($success) ?></div>
<?php endif; ?>
<?php if (!empty($error)): ?>
    <div class="alert alert-error"><?= e($error) ?></div>
<?php endif; ?>

<main class="main-section">
    <div class="container">
        <section class="stats-row">
            <article class="stat-card">
                <div class="stat-icon">A</div>
                <div class="stat-info">
                    <div class="num"><?= e((string) count($announcements)) ?></div>
                    <div class="label">ประกาศทั้งหมด</div>
                </div>
            </article>
            <article class="stat-card">
                <div class="stat-icon">T</div>
                <div class="stat-info">
                    <div class="num"><?= e((string) count($tickets)) ?></div>
                    <div class="label">คำขอแจ้งซ่อมทั้งหมด</div>
                </div>
            </article>
            <article class="stat-card">
                <div class="stat-icon">U</div>
                <div class="stat-info">
                    <div class="num"><?= e((string) $urgentCount) ?></div>
                    <div class="label">คำขอเร่งด่วน</div>
                </div>
            </article>
            <article class="stat-card">
                <div class="stat-icon">O</div>
                <div class="stat-info">
                    <div class="num"><?= e((string) $openCount) ?></div>
                    <div class="label">งานที่ยังเปิดอยู่</div>
                </div>
            </article>
        </section>

        <section class="grid-2col" id="announcements">
            <div>
                <div class="section-header">
                    <h3 class="section-title">ข่าวสารและประกาศ</h3>
                </div>

                <?php if ($featuredAnnouncement !== null): ?>
                    <article class="news-featured">
                        <div class="news-featured-img">
                            <div class="nfi-badge">ข่าวเด่น</div>
                        </div>
                        <div class="news-featured-body">
                            <h3><?= e((string) ($featuredAnnouncement['title'] ?? '-')) ?></h3>
                            <p><?= nl2br(e((string) ($featuredAnnouncement['detail'] ?? '-'))) ?></p>
                            <?php if (!empty($featuredAnnouncement['image_url'])): ?>
                                <img src="<?= e((string) $featuredAnnouncement['image_url']) ?>" alt="featured announcement" class="thumb">
                            <?php endif; ?>
                            <div class="news-meta">
                                <span><?= e((string) ($featuredAnnouncement['created_at'] ?? '-')) ?></span>
                            </div>
                        </div>
                    </article>
                <?php else: ?>
                    <article class="news-featured">
                        <div class="news-featured-body">
                            <h3>ยังไม่มีประกาศ</h3>
                            <p>สามารถเพิ่มประกาศใหม่ได้จากส่วนจัดการประกาศด้านล่างของหน้า</p>
                        </div>
                    </article>
                <?php endif; ?>

                <div class="news-list-wrap">
                    <div class="section-header compact">
                        <h4 class="section-title small">ข่าวทั้งหมด</h4>
                    </div>
                    <div class="news-list">
                        <?php if (empty($recentAnnouncements)): ?>
                            <article class="news-item">
                                <div class="news-item-dot"></div>
                                <div class="news-item-body">
                                    <h4>ยังไม่มีข่าวเพิ่มเติม</h4>
                                    <div class="date">-</div>
                                </div>
                            </article>
                        <?php else: ?>
                            <?php foreach ($recentAnnouncements as $announcement): ?>
                                <article class="news-item">
                                    <div class="news-item-dot"></div>
                                    <div class="news-item-body">
                                        <h4><?= e((string) ($announcement['title'] ?? '-')) ?></h4>
                                        <div class="date"><?= e((string) ($announcement['created_at'] ?? '-')) ?></div>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <aside class="sidebar">
                <article class="card" id="service-status">
                    <div class="card-header">สถานะระบบ</div>
                    <div class="card-body">
                        <div class="status-list">
                            <div class="status-item"><span class="status-label">เครือข่ายหลัก</span><span class="status-badge badge-ok">ปกติ</span></div>
                            <div class="status-item"><span class="status-label">ระบบประกาศ</span><span class="status-badge badge-ok">ปกติ</span></div>
                            <div class="status-item"><span class="status-label">งานเร่งด่วน</span><span class="status-badge badge-warn"><?= e((string) $urgentCount) ?> รายการ</span></div>
                            <div class="status-item"><span class="status-label">งานที่ยังเปิด</span><span class="status-badge badge-err"><?= e((string) $openCount) ?> รายการ</span></div>
                        </div>
                    </div>
                </article>

                <article class="card">
                    <div class="card-header">งานแจ้งซ่อมล่าสุด</div>
                    <div class="card-body">
                        <div class="status-list">
                            <?php if (empty($recentTickets)): ?>
                                <div class="status-item"><span class="status-label">ยังไม่มีงานแจ้งซ่อม</span><span class="status-badge badge-ok">-</span></div>
                            <?php else: ?>
                                <?php foreach ($recentTickets as $ticket): ?>
                                    <div class="status-item">
                                        <span class="status-label"><?= e((string) ($ticket['name'] ?? '-')) ?></span>
                                        <span class="status-badge badge-warn"><?= e((string) ($ticket['priority'] ?? '-')) ?></span>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>

                <article class="card" id="contact-it">
                    <div class="card-header">ติดต่อฝ่าย IT</div>
                    <div class="card-body">
                        <div class="status-list">
                            <div class="status-item"><span class="status-label">Help Desk</span><span class="hotline"><?= e($contactPhone) ?></span></div>
                            <div class="status-item"><span class="status-label">เครือข่าย</span><span class="hotline">ต่อ 1235</span></div>
                            <div class="status-item"><span class="status-label">ระบบงาน</span><span class="hotline">ต่อ 1236</span></div>
                            <div class="status-item"><span class="status-label">อีเมล</span><span class="hotline"><?= e($contactEmail) ?></span></div>
                        </div>
                    </div>
                </article>
            </aside>
        </section>

        <?php if ($isAdmin): ?>
            <section class="admin-section">
                <article class="card">
                    <div class="card-header">เพิ่มประกาศ</div>
                    <div class="card-body">
                        <form method="post" action="<?= e(url('announcements')) ?>" class="report-form">
                            <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
                            <div class="form-row">
                                <label>หัวข้อประกาศ</label>
                                <input type="text" name="title" placeholder="เช่น แจ้งปิดปรับปรุงระบบ" required>
                            </div>
                            <div class="form-row">
                                <label>รายละเอียด</label>
                                <textarea name="detail" placeholder="รายละเอียดประกาศ" required></textarea>
                            </div>
                            <div class="form-row">
                                <label>ลิงก์รูปภาพ</label>
                                <input type="url" name="image_url" placeholder="https://example.com/image.jpg">
                            </div>
                            <button type="submit" class="btn-submit">บันทึกประกาศ</button>
                        </form>
                    </div>
                </article>
            </section>
        <?php endif; ?>
    </div>
</main>

<footer>
    <div class="container">
        <div class="footer-inner">
            <div class="footer-brand">
                <h3>ฝ่ายเทคโนโลยีสารสนเทศ</h3>
                <p>ให้บริการด้านเทคโนโลยีสารสนเทศอย่างครบวงจร เพื่อสนับสนุนการทำงานขององค์กรอย่างมีประสิทธิภาพ</p>
            </div>
            <div class="footer-col">
                <h4>บริการ</h4>
                <ul>
                    <li><a href="#">แจ้งซ่อมออนไลน์</a></li>
                    <li><a href="#service-status">ตรวจสอบสถานะ</a></li>
                    <li><a href="#announcements">ข่าวสาร</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>ข้อมูล</h4>
                <ul>
                    <li><a href="#contact-it">ติดต่อฝ่าย IT</a></li>
                    <li><a href="#">นโยบายไอที</a></li>
                    <li><a href="#">คู่มือการใช้งาน</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <span>© 2569 ฝ่ายเทคโนโลยีสารสนเทศ</span>
        </div>
    </div>
</footer>

<div class="modal-overlay" id="reportModal" aria-hidden="true">
    <div class="modal" role="dialog" aria-modal="true" aria-labelledby="reportModalTitle">
        <div class="modal-head">
            <h2 id="reportModalTitle">แบบฟอร์มแจ้งซ่อมออนไลน์</h2>
            <button type="button" class="modal-close" data-close-report aria-label="ปิด">×</button>
        </div>
        <form method="post" action="<?= e(url('tickets')) ?>">
            <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
            <div class="modal-body">
                <div class="modal-form">
                    <div class="form-grid-2">
                        <div class="form-row">
                            <label>ชื่อ - นามสกุล *</label>
                            <input type="text" name="name" placeholder="ชื่อ - นามสกุล" required>
                        </div>
                        <div class="form-row">
                            <label>แผนก *</label>
                            <input type="text" name="department" placeholder="ระบุฝ่าย / แผนก" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <label>รายละเอียดปัญหา *</label>
                        <textarea name="problem" placeholder="อธิบายปัญหาที่พบโดยละเอียด" required></textarea>
                    </div>
                    <div class="form-row">
                        <label>ระดับความเร่งด่วน</label>
                        <select name="priority">
                            <option value="ต่ำ">ต่ำ</option>
                            <option value="ปกติ" selected>ปกติ</option>
                            <option value="สูง">สูง</option>
                            <option value="เร่งด่วน">เร่งด่วน</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" data-close-report>ยกเลิก</button>
                <button type="submit" class="btn-submit-modal">ส่งคำร้อง</button>
            </div>
        </form>
    </div>
</div>

<!doctype html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Help Desk') ?></title>
    <link rel="stylesheet" href="<?= e(asset_url('assets/css/style.css')) ?>">
</head>
<body>
    <header class="site-header">
        <div class="container header-inner">
            <div>
                <p class="eyebrow">INTERNAL SERVICE PORTAL</p>
                <h1>IT Help Desk</h1>
                <p class="subtitle">ระบบแจ้งซ่อมและประกาศข่าวสารสำหรับการทำงานภายในองค์กร</p>
            </div>
        </div>
    </header>

    <main class="container page-content">
        <?= $content ?>
    </main>

    <footer class="site-footer">
        <div class="container footer-inner">
            <small>IT Help Desk • Standardized Internal Workflow</small>
        </div>
    </footer>

    <script src="<?= e(asset_url('assets/js/app.js')) ?>"></script>
</body>
</html>

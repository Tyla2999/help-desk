<!doctype html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Help Desk') ?></title>
    <link rel="stylesheet" href="<?= e(asset_url('assets/css/style.css')) ?>">
</head>
<body>
    <header class="topbar">
        <div class="container">
            <h1>IT Help Desk</h1>
            <p>ระบบแจ้งซ่อมและประกาศข่าวสารภายในทีมไอที</p>
        </div>
    </header>

    <main class="container">
        <?= $content ?>
    </main>

    <script src="<?= e(asset_url('assets/js/app.js')) ?>"></script>
</body>
</html>

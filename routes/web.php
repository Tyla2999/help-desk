<?php

declare(strict_types=1);

use App\Controllers\HomeController;

return [
    'GET /' => [HomeController::class, 'index'],
    'POST /announcements' => [HomeController::class, 'storeAnnouncement'],
    'POST /tickets' => [HomeController::class, 'storeTicket'],
];

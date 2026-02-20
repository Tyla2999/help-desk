<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\AdminController;

return [
    'GET /' => [HomeController::class, 'index'],
    'GET /login' => [AuthController::class, 'showLogin'],
    'POST /login' => [AuthController::class, 'login'],
    'GET /register' => [AuthController::class, 'showRegister'],
    'POST /register' => [AuthController::class, 'register'],
    'POST /logout' => [AuthController::class, 'logout'],
    'GET /dashboard' => [DashboardController::class, 'index'],
    'GET /admin/dashboard' => [DashboardController::class, 'admin'],
    'GET /supervisor/dashboard' => [DashboardController::class, 'supervisor'],
    'GET /user/dashboard' => [DashboardController::class, 'user'],
    'GET /staff/dashboard' => [DashboardController::class, 'staff'],
    'POST /user/ideas' => [DashboardController::class, 'submitIdea'],
    'POST /user/ideas/vote' => [DashboardController::class, 'voteIdea'],
    'GET /admin/users' => [AdminController::class, 'users'],
    'POST /admin/users/approve' => [AdminController::class, 'approveUser'],
    'POST /admin/users/reject' => [AdminController::class, 'rejectUser'],
    'GET /admin/content' => [AdminController::class, 'content'],
    'POST /admin/content/update' => [AdminController::class, 'updateContent'],
    'POST /admin/announcements/delete' => [AdminController::class, 'deleteAnnouncement'],
    'POST /announcements' => [HomeController::class, 'storeAnnouncement'],
    'POST /tickets' => [HomeController::class, 'storeTicket'],
];

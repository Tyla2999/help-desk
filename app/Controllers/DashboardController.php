<?php

declare(strict_types=1);

namespace App\Controllers;

class DashboardController
{
    public function index(): void
    {
        require_auth();

        $user = current_user();
        if ($user === null) {
            redirect('/login');
        }

        $role = (string) ($user['role'] ?? 'staff');

        if ($role === 'admin') {
            redirect('/admin/dashboard');
        }

        if ($role === 'supervisor') {
            redirect('/supervisor/dashboard');
        }

        redirect('/staff/dashboard');
    }

    public function admin(): void
    {
        require_role('admin');

        redirect('/admin/users');
    }

    public function supervisor(): void
    {
        require_role('supervisor');

        view('roles/supervisor/dashboard', [
            'pageTitle' => 'แดชบอร์ดหัวหน้างาน',
            'currentUser' => current_user(),
        ]);
    }

    public function staff(): void
    {
        require_role('staff');

        view('roles/staff/dashboard', [
            'pageTitle' => 'แดชบอร์ดพนักงาน',
            'currentUser' => current_user(),
        ]);
    }
}

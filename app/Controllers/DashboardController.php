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
            redirect('/admin/users');
        }

        if ($role === 'supervisor') {
            view('dashboards/supervisor', [
                'pageTitle' => 'แดชบอร์ดหัวหน้างาน',
                'currentUser' => $user,
            ]);
            return;
        }

        view('dashboards/staff', [
            'pageTitle' => 'แดชบอร์ดพนักงาน',
            'currentUser' => $user,
        ]);
    }
}

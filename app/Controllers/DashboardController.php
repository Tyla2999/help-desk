<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\EmployeeIdea;
use App\Services\Flash;

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

        redirect('/user/dashboard');
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

        redirect('/user/dashboard');
    }

    public function user(): void
    {
        require_role('staff');

        $ideaModel = new EmployeeIdea();

        view('roles/user/dashboard', [
            'pageTitle' => 'แดชบอร์ดพนักงาน',
            'currentUser' => current_user(),
            'ideas' => $ideaModel->recent(),
            'success' => Flash::get('success'),
            'error' => Flash::get('error'),
        ]);
    }

    public function submitIdea(): void
    {
        require_role('staff');

        if (!verify_csrf_token((string) ($_POST['_token'] ?? ''))) {
            Flash::error('โทเค็นความปลอดภัยไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง');
            redirect('/user/dashboard');
        }

        $title = trim((string) ($_POST['title'] ?? ''));
        $description = trim((string) ($_POST['description'] ?? ''));
        $user = current_user();

        if ($user === null) {
            redirect('/login');
        }

        if ($title === '' || $description === '') {
            Flash::error('กรุณากรอกหัวข้อและรายละเอียดไอเดียให้ครบ');
            redirect('/user/dashboard');
        }

        if (mb_strlen($title) > 120 || mb_strlen($description) > 500) {
            Flash::error('หัวข้อหรือรายละเอียดยาวเกินกำหนด');
            redirect('/user/dashboard');
        }

        $ideaModel = new EmployeeIdea();
        $ideaModel->create((int) $user['id'], $title, $description);

        Flash::success('ส่งไอเดียเรียบร้อยแล้ว ขอบคุณที่มีส่วนร่วม');
        redirect('/user/dashboard');
    }

    public function voteIdea(): void
    {
        require_role('staff');

        if (!verify_csrf_token((string) ($_POST['_token'] ?? ''))) {
            Flash::error('โทเค็นความปลอดภัยไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง');
            redirect('/user/dashboard');
        }

        $ideaId = (int) ($_POST['idea_id'] ?? 0);
        if ($ideaId <= 0) {
            Flash::error('ไม่พบไอเดียที่ต้องการโหวต');
            redirect('/user/dashboard');
        }

        $ideaModel = new EmployeeIdea();
        $ideaModel->incrementVote($ideaId);

        Flash::success('ขอบคุณสำหรับการโหวต');
        redirect('/user/dashboard');
    }
}

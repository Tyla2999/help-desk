<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Announcement;
use App\Models\SiteContent;
use App\Models\User;
use App\Services\Flash;

class AdminController
{
    private User $userModel;
    private SiteContent $siteContentModel;
    private Announcement $announcementModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->siteContentModel = new SiteContent();
        $this->announcementModel = new Announcement();
    }

    public function users(): void
    {
        require_role('admin');

        view('roles/admin/users', [
            'pageTitle' => 'จัดการผู้ใช้งาน',
            'pendingUsers' => $this->userModel->pendingUsers(),
            'success' => Flash::get('success'),
            'error' => Flash::get('error'),
            'currentUser' => current_user(),
        ]);
    }

    public function approveUser(): void
    {
        require_role('admin');

        if (!verify_csrf_token((string) ($_POST['_token'] ?? ''))) {
            Flash::error('โทเค็นความปลอดภัยไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง');
            redirect('/admin/users');
        }

        $userId = (int) ($_POST['user_id'] ?? 0);
        if ($userId <= 0) {
            Flash::error('ข้อมูลผู้ใช้ไม่ถูกต้อง');
            redirect('/admin/users');
        }

        $this->userModel->updateStatus($userId, 'approved');
        Flash::success('อนุมัติผู้ใช้งานเรียบร้อยแล้ว');
        redirect('/admin/users');
    }

    public function rejectUser(): void
    {
        require_role('admin');

        if (!verify_csrf_token((string) ($_POST['_token'] ?? ''))) {
            Flash::error('โทเค็นความปลอดภัยไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง');
            redirect('/admin/users');
        }

        $userId = (int) ($_POST['user_id'] ?? 0);
        if ($userId <= 0) {
            Flash::error('ข้อมูลผู้ใช้ไม่ถูกต้อง');
            redirect('/admin/users');
        }

        $this->userModel->updateStatus($userId, 'rejected');
        Flash::success('ปฏิเสธผู้ใช้งานเรียบร้อยแล้ว');
        redirect('/admin/users');
    }

    public function content(): void
    {
        require_role('admin');

        $keys = ['hero_title', 'hero_subtitle', 'contact_phone', 'contact_email'];
        $values = $this->siteContentModel->getMany($keys);

        view('roles/admin/content', [
            'pageTitle' => 'จัดการเนื้อหาเว็บไซต์',
            'values' => $values,
            'announcements' => $this->announcementModel->all(),
            'success' => Flash::get('success'),
            'error' => Flash::get('error'),
            'currentUser' => current_user(),
        ]);
    }

    public function updateContent(): void
    {
        require_role('admin');

        if (!verify_csrf_token((string) ($_POST['_token'] ?? ''))) {
            Flash::error('โทเค็นความปลอดภัยไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง');
            redirect('/admin/content');
        }

        $payload = [
            'hero_title' => trim((string) ($_POST['hero_title'] ?? '')),
            'hero_subtitle' => trim((string) ($_POST['hero_subtitle'] ?? '')),
            'contact_phone' => trim((string) ($_POST['contact_phone'] ?? '')),
            'contact_email' => trim((string) ($_POST['contact_email'] ?? '')),
        ];

        $this->siteContentModel->upsertMany($payload);

        Flash::success('อัปเดตเนื้อหาเว็บไซต์เรียบร้อยแล้ว');
        redirect('/admin/content');
    }

    public function deleteAnnouncement(): void
    {
        require_role('admin');

        if (!verify_csrf_token((string) ($_POST['_token'] ?? ''))) {
            Flash::error('โทเค็นความปลอดภัยไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง');
            redirect('/admin/content');
        }

        $announcementId = (int) ($_POST['announcement_id'] ?? 0);
        if ($announcementId <= 0) {
            Flash::error('ข้อมูลประกาศไม่ถูกต้อง');
            redirect('/admin/content');
        }

        $this->announcementModel->delete($announcementId);
        Flash::success('ลบประกาศเรียบร้อยแล้ว');
        redirect('/admin/content');
    }
}

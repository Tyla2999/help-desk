<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Announcement;
use App\Models\SiteContent;
use App\Models\Ticket;
use App\Services\Flash;

class HomeController
{
    private Announcement $announcementModel;
    private Ticket $ticketModel;
    private SiteContent $siteContentModel;

    public function __construct()
    {
        $this->announcementModel = new Announcement();
        $this->ticketModel = new Ticket();
        $this->siteContentModel = new SiteContent();
    }

    public function index(): void
    {
        $contentKeys = [
            'hero_title',
            'hero_subtitle',
            'contact_phone',
            'contact_email',
        ];

        $siteContents = $this->siteContentModel->getMany($contentKeys);

        view('home', [
            'pageTitle' => 'ระบบแจ้งซ่อมไอที',
            'announcements' => $this->announcementModel->all(),
            'tickets' => $this->ticketModel->all(),
            'siteContents' => $siteContents,
            'success' => Flash::get('success'),
            'error' => Flash::get('error'),
            'currentUser' => current_user(),
        ]);
    }

    public function storeAnnouncement(): void
    {
        require_role('admin');

        if (!verify_csrf_token((string) ($_POST['_token'] ?? ''))) {
            Flash::error('โทเค็นความปลอดภัยไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง');
            redirect('/');
        }

        $title = trim((string) ($_POST['title'] ?? ''));
        $detail = trim((string) ($_POST['detail'] ?? ''));
        $imageUrl = trim((string) ($_POST['image_url'] ?? ''));

        if ($title === '' || $detail === '') {
            Flash::error('กรุณากรอกหัวข้อและรายละเอียดประกาศให้ครบ');
            redirect('/');
        }

        $this->announcementModel->create([
            'title' => $title,
            'detail' => $detail,
            'image_url' => $imageUrl,
        ]);

        Flash::success('เพิ่มประกาศเรียบร้อยแล้ว');
        redirect('/');
    }

    public function storeTicket(): void
    {
        require_auth();

        $user = current_user();
        if ($user === null || (string) ($user['status'] ?? '') !== 'approved') {
            Flash::error('บัญชีของคุณยังไม่ได้รับการอนุมัติจากแอดมิน');
            redirect('/login');
        }

        if (!verify_csrf_token((string) ($_POST['_token'] ?? ''))) {
            Flash::error('โทเค็นความปลอดภัยไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง');
            redirect('/');
        }

        $name = trim((string) ($_POST['name'] ?? ''));
        $department = trim((string) ($_POST['department'] ?? ''));
        $problem = trim((string) ($_POST['problem'] ?? ''));
        $priority = trim((string) ($_POST['priority'] ?? 'ปกติ'));

        if ($name === '' || $problem === '') {
            Flash::error('กรุณากรอกชื่อผู้แจ้งและรายละเอียดปัญหา');
            redirect('/');
        }

        $this->ticketModel->create([
            'name' => $name,
            'department' => $department,
            'problem' => $problem,
            'priority' => $priority,
            'status' => 'ใหม่',
        ]);

        Flash::success('ส่งงานแจ้งซ่อมเรียบร้อยแล้ว');
        redirect('/');
    }
}

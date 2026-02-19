<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\JsonStore;
use App\Services\Flash;

class HomeController
{
    private JsonStore $announcementStore;
    private JsonStore $ticketStore;

    public function __construct()
    {
        $this->announcementStore = new JsonStore(base_path('storage/data/announcements.json'));
        $this->ticketStore = new JsonStore(base_path('storage/data/tickets.json'));
    }

    public function index(): void
    {
        view('home', [
            'pageTitle' => 'ระบบแจ้งซ่อมไอที',
            'announcements' => $this->announcementStore->all(),
            'tickets' => $this->ticketStore->all(),
            'success' => Flash::get('success'),
        ]);
    }

    public function storeAnnouncement(): void
    {
        $title = trim((string) ($_POST['title'] ?? ''));
        $detail = trim((string) ($_POST['detail'] ?? ''));
        $imageUrl = trim((string) ($_POST['image_url'] ?? ''));

        if ($title === '' || $detail === '') {
            Flash::set('success', 'กรุณากรอกหัวข้อและรายละเอียดประกาศให้ครบ');
            redirect('/');
        }

        $this->announcementStore->prepend([
            'id' => uniqid('an_', true),
            'title' => $title,
            'detail' => $detail,
            'image_url' => $imageUrl,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        Flash::set('success', 'เพิ่มประกาศเรียบร้อยแล้ว');
        redirect('/');
    }

    public function storeTicket(): void
    {
        $name = trim((string) ($_POST['name'] ?? ''));
        $department = trim((string) ($_POST['department'] ?? ''));
        $problem = trim((string) ($_POST['problem'] ?? ''));
        $priority = trim((string) ($_POST['priority'] ?? 'ปกติ'));

        if ($name === '' || $problem === '') {
            Flash::set('success', 'กรุณากรอกชื่อผู้แจ้งและรายละเอียดปัญหา');
            redirect('/');
        }

        $this->ticketStore->prepend([
            'id' => uniqid('tk_', true),
            'name' => $name,
            'department' => $department,
            'problem' => $problem,
            'priority' => $priority,
            'status' => 'ใหม่',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        Flash::set('success', 'ส่งงานแจ้งซ่อมเรียบร้อยแล้ว');
        redirect('/');
    }
}

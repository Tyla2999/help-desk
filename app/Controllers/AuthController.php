<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use App\Services\Flash;

class AuthController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function showLogin(): void
    {
        if (auth_check()) {
            redirect('/dashboard');
        }

        view('auth/login', [
            'pageTitle' => 'เข้าสู่ระบบ',
            'success' => Flash::get('success'),
            'error' => Flash::get('error'),
        ]);
    }

    public function login(): void
    {
        if (!verify_csrf_token((string) ($_POST['_token'] ?? ''))) {
            Flash::error('โทเค็นความปลอดภัยไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง');
            redirect('/login');
        }

        $email = strtolower(trim((string) ($_POST['email'] ?? '')));
        $password = (string) ($_POST['password'] ?? '');

        if ($email === '' || $password === '') {
            Flash::error('กรุณากรอกอีเมลและรหัสผ่านให้ครบ');
            redirect('/login');
        }

        $user = $this->userModel->findByEmail($email);
        if ($user === null || !password_verify($password, (string) ($user['password_hash'] ?? ''))) {
            Flash::error('อีเมลหรือรหัสผ่านไม่ถูกต้อง');
            redirect('/login');
        }

        if ((string) ($user['status'] ?? '') !== 'approved') {
            Flash::error('บัญชีของคุณยังไม่ได้รับการอนุมัติจากแอดมิน');
            redirect('/login');
        }

        login_user((int) $user['id']);
        redirect('/dashboard');
    }

    public function showRegister(): void
    {
        if (auth_check()) {
            redirect('/dashboard');
        }

        view('auth/register', [
            'pageTitle' => 'สมัครสมาชิก',
            'success' => Flash::get('success'),
            'error' => Flash::get('error'),
        ]);
    }

    public function register(): void
    {
        if (!verify_csrf_token((string) ($_POST['_token'] ?? ''))) {
            Flash::error('โทเค็นความปลอดภัยไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง');
            redirect('/register');
        }

        $fullName = trim((string) ($_POST['full_name'] ?? ''));
        $email = strtolower(trim((string) ($_POST['email'] ?? '')));
        $password = (string) ($_POST['password'] ?? '');
        $role = trim((string) ($_POST['role'] ?? 'staff'));

        $allowedRoles = ['supervisor', 'staff'];

        if ($fullName === '' || $email === '' || $password === '') {
            Flash::error('กรุณากรอกข้อมูลให้ครบถ้วน');
            redirect('/register');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Flash::error('รูปแบบอีเมลไม่ถูกต้อง');
            redirect('/register');
        }

        if (strlen($password) < 8) {
            Flash::error('รหัสผ่านต้องมีอย่างน้อย 8 ตัวอักษร');
            redirect('/register');
        }

        if (!in_array($role, $allowedRoles, true)) {
            Flash::error('บทบาทที่เลือกไม่ถูกต้อง');
            redirect('/register');
        }

        if ($this->userModel->findByEmail($email) !== null) {
            Flash::error('อีเมลนี้ถูกใช้งานแล้ว');
            redirect('/register');
        }

        $this->userModel->create([
            'full_name' => $fullName,
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'role' => $role,
            'status' => 'pending',
        ]);

        Flash::success('สมัครสมาชิกสำเร็จ รอแอดมินอนุมัติก่อนเข้าใช้งาน');
        redirect('/login');
    }

    public function logout(): void
    {
        if (!verify_csrf_token((string) ($_POST['_token'] ?? ''))) {
            Flash::error('โทเค็นความปลอดภัยไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง');
            redirect('/');
        }

        logout_user();
        Flash::success('ออกจากระบบเรียบร้อยแล้ว');
        redirect('/login');
    }
}

# Help Desk (PHP)

เว็บแจ้งซ่อมไอทีแบบง่ายด้วย PHP โครงสร้างใกล้เคียงมาตรฐาน (MVC ขนาดเล็ก)

## ความสามารถ
- ระบบสมัครสมาชิก / เข้าสู่ระบบ พร้อมรหัสผ่านแบบเข้ารหัส
- สิทธิ์ผู้ใช้ 3 ระดับ: `admin`, `supervisor`, `staff`
- ผู้สมัครใหม่ต้องรอแอดมินอนุมัติก่อนเข้าใช้งาน
- ล็อกอินแล้วจะถูกพาไปแดชบอร์ดตามบทบาท
- แอดมินอนุมัติ/ปฏิเสธผู้ใช้ และแก้เนื้อหาหน้าเว็บได้
- เพิ่ม/ลบประกาศ และส่งงานแจ้งซ่อมไอที
- ป้องกัน CSRF ในฟอร์มสำคัญ

## โครงสร้างโฟลเดอร์

```text
help-desk/
├─ app/
│  ├─ Controllers/
│  ├─ Models/
│  └─ Views/
│     └─ layouts/
├─ bootstrap/
├─ config/
├─ public/
│  ├─ assets/
│  │  ├─ css/
│  │  ├─ images/
│  │  └─ js/
│  └─ index.php
├─ routes/
└─ storage/
   └─ data/
```

## วิธีติดตั้ง
1. สร้างฐานข้อมูลจากไฟล์ `database/schema.sql`

ตัวอย่าง (MySQL):

```bash
mysql -u root -p < database/schema.sql
```

หากอัปเดตจากเวอร์ชันเดิม ให้รัน migration เพิ่มฟีเจอร์การมีส่วนร่วมของพนักงาน:

```bash
mysql -u root -p < database/migrations/20260220_add_employee_ideas.sql
```

2. หากต้องการเปลี่ยนค่าฐานข้อมูล ให้ตั้งค่า Environment Variables ต่อไปนี้:

- `DB_HOST`
- `DB_PORT`
- `DB_NAME`
- `DB_USER`
- `DB_PASS`

3. เปิดเทอร์มินัลในโฟลเดอร์โปรเจกต์ แล้วรัน:

```bash
php -S localhost:8000 -t public
```

4. เปิด `http://localhost:8000`

## บัญชีเริ่มต้น (Admin)
- Email: `admin@helpdesk.local`
- Password: `Admin@1234`

> แนะนำให้เปลี่ยนรหัสผ่านหลังติดตั้ง

> ถ้าใช้ Laragon สามารถชี้ Document Root มาที่ `public/` ได้เช่นกัน

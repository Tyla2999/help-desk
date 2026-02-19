# Help Desk (PHP)

เว็บแจ้งซ่อมไอทีแบบง่ายด้วย PHP โครงสร้างใกล้เคียงมาตรฐาน (MVC ขนาดเล็ก)

## ความสามารถ
- เพิ่มประกาศ (Announcement) พร้อมลิงก์รูปภาพได้
- แสดงแบนเนอร์หน้าแรก
- เพิ่มรายการแจ้งซ่อมไอที
- เก็บข้อมูลแบบไฟล์ JSON ใน `storage/data`

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

## วิธีรัน
1. เปิดเทอร์มินัลในโฟลเดอร์โปรเจกต์
2. รันคำสั่ง:

```bash
php -S localhost:8000 -t public
```

3. เปิด `http://localhost:8000`

> ถ้าใช้ Laragon สามารถชี้ Document Root มาที่ `public/` ได้เช่นกัน

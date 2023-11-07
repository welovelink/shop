# Shop

URL สำหรับใช้ Laravel Socialite
- http://localhost/login/google และ http://localhost/login/twitter

Postman สำหรับทดสอบ API
- https://documenter.getpostman.com/view/15206194/2s9YXfd4B9

ผู้ใช้งานที่สามารถจัดการ สินค้ามีอยู่ด้วยกัน 3 ระดับ admin editor และ viewer (แต่ viewer จะเข้าไปจัดการ 2 api ใน manage ไม่ได้)

Run Program
- docker-compose up -d
- ระบบจะ default ที่ port 80

Run schedule เพื่อให้ระบบ job queue ทำงาน
- docker exec -it demo_web php artisan schedule:work

Migrate Database
- docker exec -it demo_web php artisan migrate
- docker exec -it demo_web php artisan migrate --path=database/migrations/2023_10_30_133152_create_products_table.php (สำหรับทำทีละไฟล์)

Seed Data
- docker exec -it demo_web php artisan db:seed --class=ProductSeeder

Composer dependency
- https://drive.google.com/file/d/1EoWbbjMzw4leheB386uis4NJmL8Dutcy/view?usp=sharing
- docker exec -it demo_web composer dump-autoload (ถ้า install ใหม่ อาจจะติดปัญหา เลยให้ใช้ตัวเดิมครับ)

Unit Test ทำไว้ api เดียวคือ Create Order
- docker exec -it demo_web php artisan test --testsuite=Unit

ข้อมูลเพิ่มเติม
- ระบบ Authentication เป็น token base โดยใช้ Laravel Sanctum
- แยก Business Logic ออกจาก Controller
- ใช้ Laravel Resource ในการควบคุมการเข้าถึงข้อมูล
- มีการเก็บ Log การ request api
- ใช้ middleware ในการตรวจสอบ API KEY และ เก็บ Log
- ในส่วนของการแสดงสินค้าที่มี 5 หมื่นรายการ จะเก็บข้อมูลเป็น แคช ไว้ตามหน้า โดยจะมีอายุ 5 นาที
- เมื่อมีการสร้าง order ใหม่ จะใช้ Event & Listener ร่วมกับ ระบบ job queue เพื่อส่ง email แจ้งเตือนเมื่อมี order ใหม่

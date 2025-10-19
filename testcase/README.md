# Test Case Pilarmedia

---

## 🚀 Persyaratan

Sebelum menjalankan project ini, pastikan kamu sudah menginstal:

- PHP >= 8.2
- Composer versi terbaru
- MySQL
- Koneksi internet aktif

---

## ⚙️ Langkah Instalasi

1. **Clone Repository**
   `git clone https://github.com/AnandaCahyaRamadan/test-case-pilarmedia.git`
2. **Masuk Ke folder project**
   `cd test-case-pilarmedia/test-case`
3. **Install Dependency**
   Kalau Belum install
   `composer install`
   Kalau sudah install
   `composer update`
4. **Salin environtemt**
   `cp .env.example .env`
   Lalu Buka `.env` dan salin

   APP_NAME=Laravel
   APP_ENV=local
   APP_KEY=
   APP_DEBUG=true
   APP_URL=http://localhost:8000
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database_kamu
   DB_USERNAME=root
   DB_PASSWORD=
   RAJAONGKIR_API_KEY=4ofUfcx48de7742a176bcc905m5vXutP

5. **Buat API KEY**
   `php artisan key:generate`

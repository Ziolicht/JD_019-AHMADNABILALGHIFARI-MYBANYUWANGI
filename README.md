# **MyBanyuwangi – Aplikasi Kalender & Event Lokal**

MyBanyuwangi adalah aplikasi berbasis **Laravel 12** yang digunakan untuk menampilkan informasi event lokal Banyuwangi dan **daftar event**, dilengkapi fitur **manajemen event untuk admin** **kalender**.

---

## **Fitur Utama**

✅ **Kalender Event Interaktif**

* Navigasi bulan sebelumnya & berikutnya
* Indikator warna (status event):

  * **Hijau**: Sedang berlangsung
  * **Kuning**: Belum mulai
  * **Abu-abu**: Sudah selesai

✅ **Daftar Event dengan Filter & Pencarian**

* Cari event berdasarkan **judul**, **kategori**, atau **status**
* Sorting event berdasarkan **judul (A-Z)** dan **tanggal**

✅ **Manajemen Event (Admin)**

* Tambah, edit, hapus event
* Upload gambar event
* Pilih status publikasi

✅ **Autentikasi Pengguna**

* Login & register
* Role-based access (**admin** & **user biasa**)

✅ **Responsive Design dengan TailwindCSS**

* Navbar **elegan dengan font khusus**
* Mobile menu lengkap (termasuk tombol **+ Buat Event** untuk admin)

---

## **Tech Stack**

* **Backend:** Laravel 12
* **Frontend:** Blade + TailwindCSS + Alpine.js
* **Database:** MySQL
* **Authentication:** Laravel Breeze
* **Icons:** FontAwesome lucide

---

## **Instalasi & Setup**

### 1. **Clone Repository**

```bash
git clone https://github.com/Ziolicht/JD_019-AHMADNABILALGHIFARI-MYBANYUWANGI
cd mybanyuwangi
```

### 2. **Install Dependencies**

```bash
composer install
npm install && npm run dev
```

### 3. **Konfigurasi Environment**

Copy file `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

Edit konfigurasi database di file `.env`:

```
DB_DATABASE=mybanyuwangi
DB_USERNAME=root
DB_PASSWORD=
```

### 4. **Generate Key & Migrasi Database**

```bash
php artisan key:generate
php artisan migrate --seed
```

### 5. **Jalankan Server**

```bash
php artisan serve
```

---
### 6. **Login Admin**
```bash
php artisan tinker
$user = new App\Models\User();
$user->name = 'Admin';
$user->email = 'admin@test.com';
$user->password = bcrypt('password');
$user->is_admin = 1;
$user->save();
```

## **Cara Menggunakan**

1. **User biasa** dapat melihat event dan daftar event.
2. **Admin** dapat login, lalu mengelola event di dashboard.
3. Klik **+ Buat Event** untuk menambahkan event baru.

---

## **Tampilan Utama**

* **Kalender Event**: Menampilkan semua event per bulan.
* **Halaman Event**: Menampilkan daftar event dengan filter kategori, status, dan pencarian.

---

## **Kontribusi**

Jika ingin berkontribusi, silakan buat pull request atau issue pada repository ini.

---

## **Lisensi**

Proyek ini menggunakan lisensi **MIT**.

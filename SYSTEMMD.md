# SYSTEMMD - Peta Sistem Komers

Dokumen ini adalah panduan cepat untuk manusia/AI agar bisa memahami struktur aplikasi tanpa scan seluruh kode.

## 1) Tujuan
- Menjelaskan direktori dan file inti.
- Menjadi titik masuk analisis AI (prioritas baca berurutan).
- Mengurangi waktu eksplorasi codebase.

## 2) Stack dan Arsitektur Singkat
- Framework: Laravel (PHP)
- Frontend build: Vite + Tailwind
- Pola utama: MVC + Blade templates
- Auth: Laravel auth scaffolding (`routes/auth.php` + view auth di `resources/views/auth`)

## 3) Entry Points (Baca Dulu)
1. `routes/web.php` -> daftar route HTTP utama.
2. `app/Http/Controllers/` -> logika request per fitur.
3. `resources/views/` -> tampilan Blade yang dirender route/controller.
4. `app/Models/` -> model Eloquent dan relasi data.
5. `database/migrations/` -> struktur tabel database.
6. `database/seeders/DatabaseSeeder.php` -> data awal akun/sistem.

## 4) Peta Direktori Inti
- `app/Http/Controllers/`
  - Fungsi: menangani request, validasi alur, panggil model/service, return view/json.
- `app/Http/Requests/`
  - Fungsi: validasi input terstruktur per use case.
- `app/Models/`
  - Fungsi: representasi tabel DB dan business rule level model.
- `routes/web.php`
  - Fungsi: endpoint web + mapping ke controller/view.
- `routes/auth.php`
  - Fungsi: route autentikasi (login/register/forgot password, dll).
- `resources/views/`
  - Fungsi: template UI Blade. File penting saat ini: `welcome.blade.php`, `dashboard.blade.php`, `product.blade.php`, `search.blade.php`, `keranjang.blade.php`.
- `resources/js/` dan `resources/css/`
  - Fungsi: aset frontend yang diproses Vite.
- `database/migrations/`
  - Fungsi: definisi dan perubahan skema DB secara versioned.
- `database/seeders/`
  - Fungsi: data awal aplikasi (akun default, data bootstrap).
- `config/`
  - Fungsi: konfigurasi inti (app, db, auth, cache, queue, dll).
- `tests/Feature/`
  - Fungsi: tes integrasi alur user.
- `tests/Unit/`
  - Fungsi: tes unit logika kecil/terisolasi.

## 5) Akun Default Sistem (Seeded)
Sumber: `database/seeders/DatabaseSeeder.php`
- Admin
  - Email: `admin@komers.local`
  - Password: `Admin123!`
  - Role: `admin`
- User
  - Email: `user@komers.local`
  - Password: `User123!`
  - Role: `user`

## 6) Konvensi Role
- Kolom role ada di tabel `users`.
- Nilai yang dipakai saat ini: `admin`, `user`.
- Helper model: method `isAdmin()` pada `app/Models/User.php`.

## 7) Alur Baca AI yang Disarankan (Tanpa Full Scan)
Untuk task baru, AI cukup ikuti urutan ini:
1. Baca `SYSTEMMD.md` (dokumen ini).
2. Baca file route yang relevan (`routes/web.php` atau `routes/auth.php`).
3. Ambil controller yang dipanggil route tersebut.
4. Baca model/view yang benar-benar dipakai controller itu.
5. Jika ada isu data, baru cek migration/seeder terkait tabel.
6. Jika ada regresi, cek test di `tests/Feature` lalu `tests/Unit`.

## 8) Batasan dan Catatan
- Dokumen ini tidak menggantikan source of truth; kode tetap referensi final.
- Jika struktur fitur berubah, update file ini agar tetap akurat.
- Hindari menaruh detail sensitif tambahan di dokumen ini.

## 9) Checklist Update Saat Menambah Fitur
- Tambah route baru -> update bagian Entry Points bila perlu.
- Tambah controller/model penting -> update Peta Direktori atau daftar file penting.
- Tambah role/permission baru -> update Konvensi Role.
- Tambah flow besar -> update Alur Baca AI.

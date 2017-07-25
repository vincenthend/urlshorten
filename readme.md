# URL Shortener

## Deskripsi Aplikasi
### Deskripsi Singkat
Aplikasi URL Shortener akan melakukan shortening pada URL yang dimasukkan dengan menggunakan hash. Pengguna dapat mengedit URL yang sudah dibuat untuk mendapatkan URL custom

### Framework

* Front End : Angular.js
* Back End : Laravel 5.4

### Requirements
* Database MySQL, terdapat database yang sudah dibuat untuk menyimpan data
* Composer (sudah terinstall dependency melalui perintah 'composer install')

### Installation
1. Copy file .env.example dan rename menjadi .env
2. Ganti konfigurasi database (connection, host, port, username, password, nama database (sesuai nama database yang dibuat))
3. Jalankan perintah 'php artisan key:generate' untuk generate application key
3. Jalankan perintah 'php artisan migrate:install' untuk melakukan setup database
4. Jalankan perintah 'php artisan migrate' untuk melakukan setup tabel
4. Jalankan perintah 'php artisan serve' untuk menyalakan server

## To Do List
To Do List disertai perkiraan tanggal jadi
- [x] Menginstall Framework yang digunakan (5 Juli)
- [x] Perancangan aplikasi (basis data, gui, dsb) (6 Juli)
- [x] Pembuatan Interface dasar dengan Boostrap (8 Juli)
- [x] Pembuatan Interface secara fungsional (menggunakan Angular.js) (9 Juli)
- [x] Pembuatan fungsi hashing (POST Request untuk mendapatkan shortened URL) (16 Juli)
- [x] Pembuatan fungsi redirect (GET Request untuk redirect ke URL) (20 Juli)
- [x] Pembuatan fungsionalitas tambahan (Edit shortlink) (20 Juli)
- [x] Pembuatan unit test dengan PHP Unit (22 Juli)
- [ ] Testing final, finishing (sebelum 26 Juli)

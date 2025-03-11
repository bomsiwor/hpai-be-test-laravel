# Entity Relationship Diagram

## Struktur Tabel Users

| Kolom      | Deskripsi                                                                                                     |
| ---------- | ------------------------------------------------------------------------------------------------------------- |
| ID         | Sebagai primary key dan penanda utama untuk 1 baris data user                                                 |
| Name       | Nama user (saat ini tidak unique)                                                                             |
| Email      | Email user (unique)                                                                                           |
| Role       | Enum:<br> - Regular (user biasa)<br> - Admin<br> - Super Admin                                                |
| Created_at | Penanda kapan user ini dibuat                                                                                 |
| Updated_at | Penanda kapan user ini diperbarui                                                                             |
| Deleted_at | Penanda untuk soft deletes, kapan user ini dihapus. Tetapi tidak dihapus secara fisik, tetap ada di database. |

## First Approach: Single Role per User

Saat ini, mengingat jumlah role yang dibutuhkan sangat sedikit, hanya 3, maka solusi yang efisien adalah denormalisasi tabel sehingga menggunakan satu tabel `users` saja.

Keterbatasan dari pendekatan ini adalah setiap user hanya memiliki satu role tertentu.
Jika anda mengikuti panduan inisasi project pada `readme.md`, maka akan mendapat pre-defined users
Super admin akan menjadi satu-satunya user yang akan di-generate pertama kali ketika aplikasi diinisialisasi. User lain tidak dapat menghapus akun ini.

Super admin tidak akan dihapus oleh user lain untuk memastikan keamanan dari aplikasi. Tidak akan ada user yang dapat mengambil alih posisi super admin atau menghapusnya, memastikan tetap ada kontrol terhadap akun-akun yang memiliki role admin.

**Gambar 1: Diagram ER untuk pendekatan Single Role per User**

_(Placeholder image)_

---

## Second Approach: Multi Role per User dengan Tabel Perantara

Perbedaan pada pendekatan ini adalah pada struktur data yang dinormalisasi. Jika role yang dibutuhkan semakin banyak dan memungkinkan adanya multi-role untuk setiap user, maka kita akan menggunakan pendekatan dengan kardinalitas many-to-many.

Untuk mendukung konsep ini, dibutuhkan satu tabel `pivot` yang digunakan untuk menghubungkan tabel `users` dan `roles`. Tabel ini berfungsi sebagai penghubung agar setiap user dapat memiliki lebih dari satu role.

Tabel pivot **tidak perlu memiliki ID sebagai primary key**, cukup menggunakan kombinasi `user_id` dan `role_id` sebagai **composite primary key**. Selain itu, perlu dipasang constraint **UNIQUE** pada kombinasi `(user_id, role_id)` untuk memastikan tidak ada duplikasi role pada satu user.

**Gambar 2: Diagram ER untuk pendekatan Multi Role per User**

_(Placeholder image)_

Saat ini, implementasi dari pendekatan ini terletak pada branch `main-multirole`.

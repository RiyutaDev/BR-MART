# BR MART — GitHub Copilot Instructions

## 1. Project identity
BR MART adalah aplikasi manajemen minimarket yang mencakup POS/kasir, pengelolaan produk dan stok, transaksi, pesanan online, katalog pelanggan, serta laporan.

## 2. Wajib membaca dokumen
Sebelum mengerjakan tugas yang berkaitan dengan proyek, baca dokumen relevan berikut:
- `docs/PRDbrmart.md`
- `docs/SRS.md`
- `docs/DATABASE.md`
- `docs/BUSINESS_RULES.md`
- `docs/UI_UX_GUIDELINE.md`
- `docs/BR_MART_DASHBOARD_SPEC_v1.1.md`
- `docs/KATALOG_PELANGGAN_SPEC_v1.1.md`
- `docs/BR_MART_ROADMAP_v1.0.md`
- `docs/BR_MART_IMPLEMENTATION_BLUEPRINT.md`
- `docs/COPILOT_WORKFLOW.md`

Jangan mengarang requirement. Jika dokumen bertentangan atau belum menentukan keputusan bisnis, jelaskan konflik dan minta keputusan pengguna sebelum mengimplementasikan bagian yang terdampak.

## 3. Teknologi proyek
- CodeIgniter 4.6.5
- PHP 8.3
- MySQL 8
- Bootstrap 5
- Vanilla JavaScript dan AJAX
- Dompdf dan browser print untuk nota
- Arsitektur monolithic MVC
- Lingkungan pengembangan Windows + Laragon

Jangan mengganti framework, versi utama, dependency, atau arsitektur tanpa alasan teknis dan persetujuan pengguna.

## 4. Arsitektur dan standar kode
- Ikuti konvensi CodeIgniter 4 dan PSR yang relevan.
- Controller menangani HTTP request/response, validasi awal, otorisasi, dan pemanggilan service/model.
- Model menangani akses data.
- Service menangani proses bisnis lintas model dan transaksi database.
- Filter menangani autentikasi/otorisasi route.
- View hanya menangani presentasi; jangan meletakkan query database atau business logic di view.
- JavaScript menangani interaksi UI; server tetap sumber kebenaran untuk harga, stok, total, dan hak akses.
- Pisahkan file berdasarkan modul dan tanggung jawab. Hindari controller/model yang terlalu besar.
- Gunakan migration CI4 untuk setiap perubahan skema. Jangan mengubah skema database secara manual sebagai pengganti migration.

## 5. Aturan bisnis dan integritas data
- Ikuti `DATABASE.md` dan `BUSINESS_RULES.md`.
- `available_stock = stock_on_hand - stock_reserved`; hitung nilainya, jangan menyimpan kolom duplikat.
- Jangan menerima harga, subtotal, diskon, pajak, total, atau stok final dari browser. Hitung dan validasi ulang di server.
- Proses yang mengubah beberapa tabel terkait harus menggunakan database transaction dan rollback jika gagal.
- Gunakan row locking/strategi concurrency yang sesuai untuk operasi stok.
- Simpan snapshot nama produk, SKU, harga, kuantitas, dan unit pada item transaksi/pesanan sesuai skema.
- Pesanan online berstatus pending tidak otomatis mereservasi stok. Ikuti alur konfirmasi, reservasi, penyelesaian, dan pembatalan pada business rules.
- Status pesanan dan status pembayaran adalah dua hal berbeda.
- Jangan menghapus data transaksi atau pesanan historis secara fisik melalui UI.
- Jangan menambah kolom/tabel yang belum disetujui (contoh: `is_featured`, `is_best_seller`, atau tabel notifikasi).

## 6. Keamanan wajib
- Gunakan password hashing yang aman; jangan pernah menyimpan password plaintext.
- Terapkan autentikasi dan otorisasi pada semua route admin.
- Terapkan CSRF, validasi server-side, escaping output, dan query builder/bindings.
- Jangan mempercayai hidden input, localStorage, atau JavaScript untuk keamanan maupun perhitungan bisnis.
- Validasi upload berdasarkan MIME, ekstensi, ukuran, nama file acak, dan lokasi penyimpanan.
- Jangan commit `.env`, kredensial, token, secret, atau data pelanggan.
- Jangan menampilkan stack trace atau detail database pada production.

## 7. UI/UX
- Ikuti `docs/UI_UX_GUIDELINE.md` dan spesifikasi layar yang telah disetujui.
- Identitas visual utama: hijau, krem, dan putih.
- Gunakan Bootstrap 5 dan Vanilla JS/AJAX.
- Buat tampilan responsif untuk desktop dan mobile.
- Sediakan state loading, empty, success, dan error.
- Pastikan tombol, form, navigasi, AJAX, dan feedback benar-benar berfungsi.
- Jangan memakai data contoh/fiktif sebagai data produksi.
- Jangan mengubah desain yang telah disetujui tanpa menjelaskan alasan dan meminta persetujuan.

## 8. Cara bekerja
Untuk setiap permintaan implementasi:
1. Audit kode, struktur file, route, migration, test, dan `git status` sebelum mengubah file.
2. Tentukan ruang lingkup dan dokumen acuan.
3. Buat rencana file yang akan dibuat/diubah.
4. Implementasikan secara lengkap sesuai ruang lingkup; jangan berhenti pada skeleton jika fitur diminta selesai.
5. Buat/perbarui test yang relevan.
6. Jalankan pemeriksaan yang benar-benar tersedia dan catat hasilnya.
7. Periksa diff dan pastikan perubahan di luar ruang lingkup tidak ikut.
8. Perbarui dokumentasi bila diperlukan.

Jangan menghapus atau menimpa perubahan pengguna yang belum di-commit. Jangan menjalankan reset destruktif, force push, atau commit/push tanpa instruksi eksplisit.

## 9. Mode fase proyek
Ikuti `docs/BR_MART_ROADMAP_v1.0.md` dan `docs/COPILOT_WORKFLOW.md`.

- Selesaikan satu fase secara menyeluruh sebelum berpindah.
- Implementasikan backend dan frontend yang diperlukan agar alur fase benar-benar berfungsi.
- Lakukan analisis, pengujian, perbaikan bug, dan regression check yang relevan.
- Buat laporan di `docs/reports/PHASE_<nomor>_REPORT.md`.
- Laporan wajib memuat kebutuhan, file dibuat/diubah, migration, route, test dan output aktual, risiko, blocker, serta keputusan yang diperlukan.
- Jangan mengklaim test, migration, atau pemeriksaan berhasil jika tidak benar-benar dijalankan.
- Setelah satu fase selesai dan dilaporkan, BERHENTI. Jangan memulai fase berikutnya sampai pengguna menyetujuinya.

## 10. Kejujuran implementasi
Jika tool atau lingkungan tidak memungkinkan menjalankan test, browser, migration, atau pemeriksaan tertentu, tandai sebagai `BLOCKED` atau `NOT RUN`, jelaskan alasannya, dan berikan langkah verifikasi manual. Jangan membuat output pengujian atau bukti palsu.

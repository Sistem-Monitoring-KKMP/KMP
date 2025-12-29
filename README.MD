
---
# Koperasi Dashboard & Analitik

Platform ini adalah aplikasi dashboard analitik koperasi, dibangun dengan Laravel (backend) dan React + TypeScript (frontend). Fokus utama aplikasi adalah visualisasi data, statistik, dan insight performa koperasi.

## Fitur Utama Dashboard
- **Ringkasan KPI Koperasi**: Total koperasi, rata-rata CDI, BDI, ODI.
- **Top & Bottom Koperasi**: Grafik 10 koperasi terbaik dan terendah berdasarkan CDI.
- **Tren Indeks**: Grafik pertumbuhan CDI, BDI, ODI dari waktu ke waktu.
- **Peta Sebaran**: Visualisasi lokasi koperasi di peta.
- **Daftar Koperasi**: Tabel pencarian dan filter koperasi beserta status dan skor indeks.
- **Detail Koperasi**: Halaman detail performa, keuangan, anggota, dan prinsip koperasi.
- **Performa Bisnis**: Ringkasan finansial, tren BDI, neraca, dan pertumbuhan keuangan.
- **Performa Organisasi**: Statistik pelatihan, rapat, dan kepatuhan prinsip koperasi.
- **Sebaran Koperasi**: Scatter plot posisi koperasi berdasarkan indeks bisnis dan organisasi.

## Struktur Proyek
- **app/**: Backend Laravel (Controllers, Models, Services, dll)
- **resources/js/**: Frontend React (halaman dashboard, komponen chart, dsb)
- **routes/**: Routing Laravel
- **database/**: Migrasi & seeder database
- **public/**: Entry point aplikasi & aset publik
- **config/**: Konfigurasi aplikasi
- **tests/**: Unit test & test aplikasi

## Instalasi
1. Clone repository
   ```bash
   git clone <repo-url>
   cd kmp
   ```
2. Install dependency backend
   ```bash
   composer install
   ```
3. Install dependency frontend
   ```bash
   npm install
   ```
4. Copy file environment
   ```bash
   cp .env.example .env
   ```
5. Generate key aplikasi
   ```bash
   php artisan key:generate
   ```
6. Migrasi & seeder database
   ```bash
   php artisan migrate --seed
   ```
7. Jalankan server development
   - Backend: `php artisan serve`
   - Frontend: `npm run dev`

## Testing
- Backend: `php artisan test`
- Frontend: `npm run test`

## Konfigurasi
- Edit .env untuk database dan konfigurasi lain.
- Lihat folder config untuk setting email, cache, dsb.

## Kontribusi
Pull request dan issue sangat diterima. Silakan fork dan buat branch baru untuk kontribusi.

## Lisensi
MIT License.

---
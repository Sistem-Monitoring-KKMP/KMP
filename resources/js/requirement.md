# KMP Application Requirements & Data Structure

Dokumen ini merangkum kebutuhan data dan visualisasi untuk setiap halaman aplikasi KMP (Koperasi Multi Pihak), serta struktur data yang diperlukan untuk pengembangan frontend dan dummy data.

---

## 1. Page Dashboard (Overview)

Halaman ini memberikan gambaran umum kesehatan seluruh koperasi di wilayah tersebut.

### Data yang Dibutuhkan

- **KPI Utama:**
    - Total Koperasi (Unit Terdaftar).
    - Rata-rata CDI (Cooperative Development Index) saat ini.
    - Rata-rata BDI (Business Development Index) saat ini.
    - Rata-rata ODI (Organization Development Index) saat ini.
- **Tren Tahunan:** Data historis CDI, BDI, ODI per tahun (misal: 5 tahun terakhir).
- **Geospasial:** Koordinat (lat/long), Nama, dan Status setiap koperasi untuk peta sebaran.
- **Top Ranking:** List 10 koperasi dengan nilai CDI tertinggi.

### Visualisasi

- **Score Cards:** Angka besar untuk KPI (Total Koperasi, CDI, BDI, ODI).
- **Line Chart:** Tren Pertumbuhan Indeks (CDI, BDI, ODI) dari tahun ke tahun.
- **Interactive Map (Leaflet):** Peta sebaran lokasi koperasi dengan marker.
- **Bar Chart:** Top 10 Koperasi berdasarkan skor CDI.

---

## 2. Page Organisasi (Kelembagaan)

Fokus pada aspek manusia, keanggotaan, dan tata kelola organisasi secara agregat (keseluruhan).

### Data yang Dibutuhkan

- **Agregat Keanggotaan:**
    - Total Anggota Terdaftar (Semua Koperasi).
    - Total Anggota Aktif.
    - Total Anggota Tidak Aktif.
- **Kepatuhan Tata Kelola:** Persentase koperasi berdasarkan Status Operasional (Aktif vs Tidak Aktif).
- **Skor Prinsip Koperasi:** Rata-rata skor penerapan 7 Prinsip Koperasi dari seluruh entitas.
- **Kesehatan Manajemen:** Rata-rata jumlah pengurus dan pengawas aktif per koperasi.

### Visualisasi

- **Pie/Donut Chart:** Komposisi Anggota (Aktif vs Tidak Aktif).
- **Bar Chart:** Status Operasional (Aktif vs Tidak Aktif).
- **Radar Chart:** Rata-rata skor 7 Prinsip Koperasi (Keanggotaan Sukarela, Demokratis, dll).

---

## 3. Page Bisnis (Usaha & Keuangan)

Fokus pada performa finansial dan perkembangan bisnis secara agregat.

### Data yang Dibutuhkan

- **Komposisi Neraca (Agregat):**
    - **Aset:** Kas, Piutang, Persediaan (Lancar) dan Tanah, Bangunan, Kendaraan, Peralatan (Tetap).
    - **Liabilitas (Kewajiban):** Hutang Lancar, Hutang Jangka Panjang.
    - **Ekuitas:** Simpanan Anggota, SHU Ditahan.
- **Historis Performa Bisnis:** Tren rata-rata skor BDI dari tahun ke tahun.
- **Indikator Pertumbuhan Keuangan (Agregat):**
    - Total Pinjaman Bank
    - Total Investasi
    - Modal Kerja
    - Total Simpanan Anggota
    - Total Hibah
    - Omset (Volume Usaha)
    - Biaya Operasional
    - Surplus/Rugi (SHU)

### Visualisasi

- **Line Chart:** Tren Rata-rata Skor BDI (5 tahun terakhir).
- **Stacked Bar Chart (Pertumbuhan):** Tren indikator keuangan (Omset, Modal Kerja, dll) dari tahun ke tahun.
- **Stacked Bar Chart (Neraca):** Visualisasi keseimbangan neraca.
    - _Bar 1 (Aktiva):_ Stack dari komponen Aset.
    - _Bar 2 (Pasiva):_ Stack dari Liabilitas + Ekuitas.
- **Scatter Plot (Opsional):** Korelasi antara Jumlah Anggota vs Volume Usaha.

---

## 4. Page Detail Koperasi (Single Entity)

Halaman mendalam yang menampilkan profil lengkap satu koperasi tertentu, mencakup aspek kelembagaan (organisasi) dan bisnis (usaha & keuangan).

### A. Profil & Identitas (Header)

- **Identitas:**
    - Nama Koperasi
    - Nomor Badan Hukum
    - Tahun Berdiri
    - Kontak (Email/Telepon)
    - Status Operasional (Aktif/Tidak Aktif)
    - Ketersediaan General Manager (GM)
- **Lokasi:**
    - Alamat Lengkap
    - Kecamatan & Kelurahan
    - Koordinat (Latitude & Longitude)

### B. Performa & Indeks

- **Skor Indeks:**
    - CDI (Cooperative Development Index)
    - BDI (Business Development Index)
    - ODI (Organization Development Index)
- **Kuadran:** Posisi kuadran koperasi berdasarkan skor indeks.

### C. Sumber Daya Manusia (Organisasi)

- **Manajemen:**
    - Jumlah Pengurus
    - Jumlah Pengawas
    - Jumlah Karyawan
- **Keanggotaan:**
    - Total Anggota
    - Anggota Aktif
    - Anggota Tidak Aktif

### D. Keuangan (Neraca)

Visualisasi keseimbangan neraca (Aktiva vs Passiva) dengan rincian mendalam.

- **Aktiva (Aset):**
    - Kas
    - Piutang
    - Persediaan
    - Tanah
    - Bangunan
    - Kendaraan
    - Peralatan
    - *Total Aktiva*
- **Passiva (Kewajiban & Ekuitas):**
    - Hutang Lancar
    - Hutang Jangka Panjang
    - Simpanan Anggota
    - SHU Ditahan
    - *Total Passiva*

### E. Pertumbuhan Keuangan (Tren)

Data historis pertumbuhan keuangan dari tahun ke tahun.

- **Indikator Pertumbuhan:**
    - Total Pinjaman Bank
    - Total Investasi
    - Modal Kerja
    - Total Simpanan Anggota
    - Total Hibah
    - Omset (Volume Usaha)
    - Biaya Operasional
    - Surplus/Rugi (SHU)

### F. Prinsip Koperasi

Penilaian penerapan 7 Prinsip Koperasi.

- **Visualisasi:** Radar Chart (Skor Aktual vs Skor Maksimal).
- **Data:** Skor untuk setiap prinsip (misal: Keanggotaan Sukarela, Pengelolaan Demokratis, dll).

### G. Unit Usaha

Daftar unit usaha yang dimiliki koperasi beserta performanya.

- **Data per Unit:**
    - Nama Unit
    - Volume Usaha
    - Investasi
    - Modal Kerja
    - Surplus/Rugi
    - Jumlah SDM
    - Jumlah Anggota yang terlibat
- **Visualisasi:** Tabel detail unit usaha.



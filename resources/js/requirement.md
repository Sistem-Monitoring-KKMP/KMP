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

- **Agregat Keanggotaan (BARU):**
    - Total Anggota Terdaftar (Semua Koperasi).
    - Total Anggota Aktif.
    - Total Anggota Tidak Aktif.
- **Kepatuhan Tata Kelola:** Persentase koperasi yang sudah RAT vs Belum RAT tahun ini.
- **Skor Prinsip Koperasi:** Rata-rata skor penerapan 7 Prinsip Koperasi dari seluruh entitas.
- **Kesehatan Manajemen:** Rata-rata jumlah pengurus dan pengawas aktif per koperasi.

### Visualisasi

- **Pie/Donut Chart:** Komposisi Anggota (Aktif vs Tidak Aktif).
- **Bar Chart:** Status Kepatuhan RAT (Sudah vs Belum).
- **Radar Chart:** Rata-rata skor 7 Prinsip Koperasi (Keanggotaan Sukarela, Demokratis, dll).

---

## 3. Page Bisnis (Usaha & Keuangan)

Fokus pada performa finansial dan perkembangan bisnis secara agregat.

### Data yang Dibutuhkan

- **Agregat Finansial:**
    - Total Aset seluruh koperasi.
    - Total Omset (Volume Usaha) seluruh koperasi.
    - Total SHU (Sisa Hasil Usaha) seluruh koperasi.
- **Komposisi Neraca (Agregat):**
    - **Aset:** Aset Lancar, Aset Tetap.
    - **Liabilitas (Kewajiban):** Jangka Pendek, Jangka Panjang.
    - **Ekuitas:** Simpanan Pokok, Simpanan Wajib, Cadangan, SHU Tahun Berjalan.
- **Performa Bisnis (BDI):** Rata-rata skor BDI.
- **Pertumbuhan:** Persentase pertumbuhan aset dan omset dari tahun ke tahun.

### Visualisasi

- **Line Chart:** Tren Pertumbuhan Aset & Omset (5 tahun terakhir).
- **Stacked Bar Chart (Neraca):** Visualisasi keseimbangan neraca.
    - _Bar 1 (Aktiva):_ Stack dari Aset Lancar + Aset Tetap.
    - _Bar 2 (Pasiva):_ Stack dari Liabilitas + Ekuitas.
    - _Alternatif:_ Tren komposisi Aset/Liabilitas/Ekuitas per tahun.
- **Bar Chart:** Distribusi SHU per sektor atau wilayah.
- **Scatter Plot (Opsional):** Korelasi antara Jumlah Anggota vs Volume Usaha.

---

## 4. Page Detail Koperasi (Single Entity)

Halaman mendalam yang menampilkan profil lengkap satu koperasi tertentu.

### A. Profil & Identitas (Header)

- Nama Koperasi
- Alamat Lengkap & Kelurahan
- Tahun Berdiri
- Nomor Badan Hukum
- Ada General Manager (GM)? (Ya/Tidak)
- Status Operasional (Skala 1-3, misal: 1=Aktif, 2=Kurang Aktif, 3=Macet)

### B. Sumber Daya Manusia (Human Capital)

- Jumlah Pengurus Aktif
- Jumlah Pengawas Aktif
- Jumlah Karyawan
- **Statistik Anggota:**
    - Total Anggota Terdaftar
    - Jumlah Anggota Aktif
    - Jumlah Anggota Tidak Aktif

### C. Unit Usaha (Business Units)

Setiap koperasi bisa memiliki banyak unit usaha. Data ditampilkan dalam bentuk tabel dengan rincian sebagai berikut:

- **Kolom Data per Unit Usaha:**
    1.  **Nama Unit Usaha** (Contoh: Gerai Sembako, Klinik Desa, Gerai Obat, Jasa Logistik, Gudang/Cool Storage, Simpan Pinjam, dll).
    2.  **Volume Usaha (Rp)**
    3.  **Investasi (Rp)**
    4.  **Modal Kerja (Rp)**
    5.  **Surplus/Rugi (Rp)**
    6.  **Jumlah SDM (Orang)**
    7.  **Jumlah Anggota (Orang)**

### D. Tata Kelola & Prinsip (Governance)

- **Riwayat Rapat:** Tanggal RAT terakhir, Jumlah kehadiran anggota saat RAT.
- **Skor 7 Prinsip Koperasi (Nilai 1-100):**
    1.  Keanggotaan Sukarela & Terbuka.
    2.  Pengendalian Demokratis Anggota.
    3.  Partisipasi Ekonomi Anggota.
    4.  Otonomi & Kebebasan.
    5.  Pendidikan, Pelatihan & Informasi.
    6.  Kerjasama Antar Koperasi.
    7.  Kepedulian Terhadap Komunitas.

### E. Riwayat Performa (History)

- Nilai CDI, BDI, ODI koperasi ini selama 3-5 tahun terakhir.

### Visualisasi Detail Page

- **Card List/Table:** Daftar Unit Usaha dan performanya.
- **Radar Chart:** Visualisasi kekuatan/kelemahan penerapan 7 prinsip.
- **Line Chart:** Tren perkembangan skor indeks koperasi ini.

---

## Contoh Struktur JSON (Dummy Data)

```json
{
    "id": 1,
    "profil": {
        "nama": "Koperasi Maju Bersama",
        "alamat": "Jl. Merdeka No. 10",
        "kelurahan": "Sukamaju",
        "tahun_berdiri": 2015,
        "no_badan_hukum": "BH-123456789",
        "ada_gm": true,
        "status_operasional": 1
    },
    "sdm": {
        "pengurus_aktif": 5,
        "pengawas_aktif": 3,
        "karyawan": 12,
        "anggota": {
            "total": 250,
            "aktif": 200,
            "tidak_aktif": 50
        }
    },
    "unit_usaha": [
        {
            "nama": "Gerai Sembako",
            "volume_usaha": 500000000,
            "investasi": 150000000,
            "modal_kerja": 50000000,
            "surplus_rugi": 25000000,
            "jumlah_sdm": 3,
            "jumlah_anggota": 150
        },
        {
            "nama": "Klinik Desa",
            "volume_usaha": 200000000,
            "investasi": 300000000,
            "modal_kerja": 100000000,
            "surplus_rugi": -10000000,
            "jumlah_sdm": 5,
            "jumlah_anggota": 50
        }
    ],
    "tata_kelola": {
        "rat_terakhir": "2024-03-15",
        "skor_prinsip": {
            "sukarela": 85,
            "demokratis": 90,
            "ekonomi": 75,
            "otonomi": 80,
            "pendidikan": 60,
            "kerjasama": 70,
            "komunitas": 88
        }
    },
    "history_indeks": [
        { "tahun": 2022, "cdi": 75, "bdi": 70, "odi": 80 },
        { "tahun": 2023, "cdi": 78, "bdi": 72, "odi": 82 },
        { "tahun": 2024, "cdi": 82, "bdi": 78, "odi": 85 }
    ]
}
```

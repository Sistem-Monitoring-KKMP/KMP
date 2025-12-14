export interface UnitUsaha {
    nama: string;
    volume_usaha: number;
    investasi: number;
    modal_kerja: number;
    surplus_rugi: number;
    jumlah_sdm: number;
    jumlah_anggota: number;
}

export interface PrinsipKoperasi {
    koperasi_id: number;
    sukarela_terbuka: number;
    demokratis: number;
    ekonomi: number;
    kemandirian: number;
    pendidikan: number;
    kerja_sama: number;
    kepedulian: number;
}

export interface Anggota {
    total: number;
    aktif: number;
    tidak_aktif: number;
}

export interface Organisasi {
    jumlah_pengurus: number;
    jumlah_pengawas: number;
    jumlah_karyawan: number;
    anggota: Anggota;
}

export interface Aktiva {
    aktiva_lancar: {
        kas: number;
        piutang: number;
        total: number;
    };
    aktiva_tetap: {
        tanah: number;
        bangunan: number;
        kendaraan: number;
        total: number;
    };
    total_aktiva: number;
}

export interface Passiva {
    hutang_lancar: number;
    hutang_jangka_panjang: number;
    modal: number;
    total_passiva: number;
}

export interface Neraca {
    aktiva: Aktiva;
    passiva: Passiva;
}

export interface KeuanganItem {
    tanggal: string;
    omset: number;
    modal_kerja: number;
    investasi: number;
    simpanan_anggota: number;
    pinjaman_bank: number;
    hibah: number;
    biaya_operasional: number;
    shu: number;
}

export interface Bisnis {
    neraca: Neraca;
    pertumbuhan: {
        akumulasi: KeuanganItem[];
    };
}

export interface Performa {
    periode: string;
    cdi: number;
    bdi: number;
    odi: number;
    kuadrant: number;
    organisasi: Organisasi;
    bisnis: Bisnis;
}

export interface Lokasi {
    alamat: string;
    kecamatan: string;
    kelurahan: string;
    latitude: number;
    longitude: number;
}

export interface Cooperative {
    id: number;
    nama: string;
    kontak: string;
    no_badan_hukum: string;
    tahun: number;
    status: string;
    has_gm: boolean;
    lokasi: Lokasi;
    performa: Performa;
    unit_usaha: UnitUsaha[];
    prinsip_koperasi: PrinsipKoperasi;
}

export interface CooperativeList {
    id: number;
    nama: string;
    tahun: number;
    status: string;
    cdi: number;
    bdi: number;
    odi: number;
    kuadrant: number;
    alamat: string;
}

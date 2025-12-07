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
    key: string;
    data: number;
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
    kas: number;
    piutang: number;
    persediaan: number;
    tanah: number;
    bangunan: number;
    kendaraan: number;
    peralatan: number;
    total_aktiva: number;
}

export interface Passiva {
    hutang_lancar: number;
    hutang_jangka_panjang: number;
    simpanan_anggota: number;
    shu_ditahan: number;
    total_passiva: number;
}

export interface Neraca {
    aktiva: Aktiva;
    passiva: Passiva;
}

export interface AkumulasiItem {
    tanggal: string;
    total_pinjaman_bank: number;
    total_investasi: number;
    modal_kerja: number;
    total_simpanan_anggota: number;
    total_hibah: number;
    omset: number;
    biaya_operasional: number;
    surplus_rugi: number;
}

export interface Pertumbuhan {
    akumulasi: AkumulasiItem[];
}

export interface Bisnis {
    neraca: Neraca;
    pertumbuhan: Pertumbuhan;
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
    prinsip_koperasi: PrinsipKoperasi[];
}

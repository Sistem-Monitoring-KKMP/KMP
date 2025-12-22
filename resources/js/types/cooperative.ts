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

import type { Neraca } from './neraca';

export interface FinancialSummary {
    omset: number;
    modal_kerja: number;
    investasi: number;
    simpanan_anggota: number;
    pinjaman_bank: number;
    hibah: number;
    biaya_operasional: number;
    shu: number;
}

export interface KeuanganItem extends FinancialSummary {
    tanggal: string;
}

export interface Bisnis {
    neraca: Neraca;
    pertumbuhan: KeuanganItem;
}

export interface BdiTrend {
    periode: string;
    avg_bdi: number;
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

export interface MemberTrend {
    periode: string;
    total: number;
    aktif: number;
    tidak_aktif: number;
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
    performa: Performa[];
    unit_usaha: UnitUsaha[];
    prinsip_koperasi: PrinsipKoperasi;
}



export interface Principle {
    prinsip: string;
    skor: number;
}

export interface Training {
    sasaran: string;
    jumlah_terlaksana: number;
    total_sesi: number;
}

export interface Meeting {
    jenis_rapat: string;
    frekuensi: {
        mingguan: number;
        dua_mingguan: number;
        bulanan: number;
        dua_bulanan: number;
        tiga_bulanan_lebih: number;
    };
}

export interface OrganizationData {
    prinsip_koperasi: Principle[];
    pelatihan: Training[];
    rapat: Meeting[];
}

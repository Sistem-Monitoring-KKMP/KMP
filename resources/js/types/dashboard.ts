export interface Kpi {
    total_koperasi: number;
    odi: number;
    bdi: number;
    cdi: number;
}

export interface TrendItem {
    tanggal: string;
    cdi: number;
    bdi: number;
    odi: number;
}

export interface TopCdiItem {
    nama: string;
    cdi: number;
}

export interface DashboardData {
    kpi: Kpi;
    tren: TrendItem[];
    top_cdi: TopCdiItem[];
    low_cdi: TopCdiItem[];
}

export interface MapItem {
    id: number;
    nama: string;
    lat: number;
    lng: number;
    cdi: number;
    bdi: number;
    odi: number;
    alamat: string;
    status: string;
}

export interface NeracaData {
    aktiva: {
        aktiva_lancar: {
            kas: number;
            piutang: number;
            persediaan?: number;
            total?: number;
        };
        aktiva_tetap: {
            tanah: number;
            bangunan: number;
            kendaraan: number;
            total?: number;
        };
        total_aktiva: number;
    };
    passiva: {
        hutang_lancar: number;
        hutang_jangka_panjang: number;
        modal: number;
        total_passiva: number;
    };
}

export type { NeracaData as Neraca };

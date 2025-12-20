import { Head } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';

// Partials
import FinancialSummaryCards from './partials/FinancialSummaryCards';
import BdiTrendChart from './partials/BdiTrendChart';
import FinancialGrowthChart from '@/components/charts/FinancialGrowthChart';
import NeracaChart from '@/components/charts/NeracaChart';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Performa Bisnis',
        href: '/business',
    },
];

interface FinancialSummary {
    pinjaman_bank: number;
    investasi: number;
    modal_kerja: number;
    simpanan_anggota: number;
    hibah: number;
    omset: number;
    biaya_operasional: number;
    shu: number;
}

interface Neraca {
    aktiva: {
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
    };
    passiva: {
        hutang_lancar: number;
        hutang_jangka_panjang: number;
        modal: number;
        total_passiva: number;
    };
}

interface BdiData {
    periode: string;
    avg_bdi: number;
}

interface FinancialGrowth {
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

interface Props {
    ringkasan_finansial: FinancialSummary;
    neraca: Neraca;
    bdi_trend: BdiData[];
    pertumbuhan_financial: FinancialGrowth[];
}

export default function BusinessPage({ ringkasan_finansial, neraca, bdi_trend, pertumbuhan_financial }: Props) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Performa Bisnis" />
            <div className="p-6 space-y-6">
                {/* Header */}
                <div>
                    <h1 className="text-3xl font-bold text-gray-900 dark:text-gray-100">Performa Bisnis & Keuangan</h1>
                    <p className="text-gray-500 dark:text-gray-400 mt-1">
                        Analisis agregat kesehatan finansial dan perkembangan bisnis seluruh koperasi.
                    </p>
                </div>

                {/* Summary Cards */}
                <FinancialSummaryCards data={ringkasan_finansial} />

                {/* Charts Grid */}
                <div className="grid grid-cols-1 xl:grid-cols-2 gap-6">
                    {/* BDI Trend */}
                    <BdiTrendChart data={bdi_trend} />

                    {/* Balance Sheet */}
                    <NeracaChart data={neraca} />
                </div>

                {/* Financial Growth (Full Width) */}
                <FinancialGrowthChart data={pertumbuhan_financial} />
            </div>
        </AppLayout>
    );
}

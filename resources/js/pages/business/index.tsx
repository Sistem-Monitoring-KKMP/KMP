import { Head } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import type { Neraca, FinancialSummary, KeuanganItem, BdiTrend } from '@/types/cooperative';

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

interface Props {
    ringkasan_finansial: FinancialSummary;
    neraca: Neraca;
    bdi_trend: BdiTrend[];
    pertumbuhan_financial: KeuanganItem[];
}

/**
 * Business Performance Page
 * 
 * Provides an aggregated view of financial health across all cooperatives.
 * Features:
 * - Financial Summary Cards (Assets, Revenue, SHU, etc.)
 * - BDI Trend Analysis
 * - Aggregate Balance Sheet (Neraca)
 * - Financial Growth Charts
 */
export default function BusinessPage({ ringkasan_finansial, neraca, bdi_trend, pertumbuhan_financial }: Props) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Performa Bisnis" />
            <div className="p-6 space-y-6">
                <div>
                    <h1 className="text-3xl font-bold text-gray-900 dark:text-gray-100">Performa Bisnis & Keuangan</h1>
                    <p className="text-gray-500 dark:text-gray-400 mt-1">
                        Analisis agregat kesehatan finansial dan perkembangan bisnis seluruh koperasi.
                    </p>
                </div>

                <FinancialSummaryCards data={ringkasan_finansial} />

                <div className="grid grid-cols-1 xl:grid-cols-2 gap-6">
                    <BdiTrendChart data={bdi_trend} />

                    <NeracaChart data={neraca} />
                </div>

                <FinancialGrowthChart data={pertumbuhan_financial} />
            </div>
        </AppLayout>
    );
}

import { Head } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import businessData from '@/dummyData/business.json';

// Partials
import FinancialSummaryCards from './partials/FinancialSummaryCards';
import BdiTrendChart from './partials/BdiTrendChart';
import FinancialGrowthChart from './partials/FinancialGrowthChart';
import BalanceSheetChart from './partials/BalanceSheetChart';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Performa Bisnis',
        href: '/business',
    },
];

export default function BusinessPage() {
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
                <FinancialSummaryCards data={businessData.ringkasan_finansial} />

                {/* Charts Grid */}
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {/* BDI Trend */}
                    <BdiTrendChart data={businessData.bdi_trend} />

                    {/* Balance Sheet */}
                    <BalanceSheetChart data={businessData.neraca} />
                </div>

                {/* Financial Growth (Full Width) */}
                <FinancialGrowthChart data={businessData.pertumbuhan_finansial} />
            </div>
        </AppLayout>
    );
}

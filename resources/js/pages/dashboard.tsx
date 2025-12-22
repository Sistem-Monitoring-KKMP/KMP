import ReusableTrendChart from '@/components/charts/ReusableTrendChart';
import MyMap from '@/components/common/map';
import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes/index';
import { type BreadcrumbItem } from '@/types';
import type { DashboardData, MapItem } from '@/types/dashboard';
import { Head } from '@inertiajs/react';
import { BarChart } from 'reaviz';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

interface Props {
    dashboardData: DashboardData;
    mapData: MapItem[];
}

/**
 * Dashboard Page
 * 
 * Displays key performance indicators (KPIs), top/bottom performing cooperatives,
 * trend charts, and a geographical map of cooperatives.
 */
export default function Dashboard({ dashboardData, mapData }: Props) {


    const kpiData = dashboardData.kpi;

    const topCdiData = dashboardData.top_cdi.map((item) => ({
        key: item.nama,
        data: item.cdi,
    }));

    const lowCdiData = dashboardData.low_cdi.map((item) => ({
        key: item.nama,
        data: item.cdi,
    }));

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="grid auto-rows-min gap-4 md:grid-cols-3">
                    <div className="relative flex flex-col items-center justify-center overflow-hidden rounded-xl border border-sidebar-border/70 bg-gray-50 p-6 text-center md:col-span-1 dark:border-sidebar-border dark:bg-sidebar-accent/10">
                        <h3 className="mb-4 text-xl font-semibold">
                            Total Koperasi
                        </h3>
                        <div className="mb-2 text-6xl font-bold text-gray-900 dark:text-gray-100">
                            {kpiData.total_koperasi}
                        </div>
                        <p className="text-base text-gray-500">
                            Unit Terdaftar
                        </p>
                    </div>

                    <div className="flex flex-col justify-between gap-4 md:col-span-2">
                        <div className="relative flex flex-1 flex-row items-center justify-between rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                            <div>
                                <h3 className="mb-1 text-lg font-semibold">
                                    Rata-rata CDI
                                </h3>
                                <p className="text-sm text-gray-500">
                                    Cooperative Development Index
                                </p>
                            </div>
                            <div className="text-4xl font-bold text-blue-600">
                                {kpiData.cdi}
                            </div>
                        </div>

                        <div className="relative flex flex-1 flex-row items-center justify-between rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                            <div>
                                <h3 className="mb-1 text-lg font-semibold">
                                    Rata-rata BDI
                                </h3>
                                <p className="text-sm text-gray-500">
                                    Business Development Index
                                </p>
                            </div>
                            <div className="text-4xl font-bold text-green-600">
                                {kpiData.bdi}
                            </div>
                        </div>

                        <div className="relative flex flex-1 flex-row items-center justify-between rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                            <div>
                                <h3 className="mb-1 text-lg font-semibold">
                                    Rata-rata ODI
                                </h3>
                                <p className="text-sm text-gray-500">
                                    Organization Development Index
                                </p>
                            </div>
                            <div className="text-4xl font-bold text-purple-600">
                                {kpiData.odi}
                            </div>
                        </div>
                    </div>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6 my-8">
                    <div className="rounded-lg bg-white p-4 shadow-md">
                        <h2 className="mb-8 text-3xl font-semibold">
                            Top 10 Koperasi
                        </h2>
                        <BarChart height={300} data={topCdiData} />
                    </div>
                    <div className="rounded-lg bg-white p-4 shadow-md">
                        <h2 className="mb-8 text-3xl font-semibold">
                            Bottom 10 Koperasi
                        </h2>
                        <BarChart height={300} data={lowCdiData} />
                    </div>
                </div>

                <div className="grid gap-4 md:grid-cols-2">
                    <ReusableTrendChart
                        data={dashboardData.tren}
                        dateKey="tanggal"
                        title="Tren Pertumbuhan Indeks"
                        series={[
                            { key: 'cdi', label: 'CDI', color: '#2563eb' },
                            { key: 'bdi', label: 'BDI', color: '#16a34a' },
                            { key: 'odi', label: 'ODI', color: '#9333ea' },
                        ]}
                    />
                    <div className="relative min-h-[400px] overflow-hidden rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                        <h3 className="mb-4 font-semibold">
                            Peta Sebaran Koperasi
                        </h3>
                        <MyMap data={mapData} />
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}

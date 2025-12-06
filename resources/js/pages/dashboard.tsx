import { useState, useMemo } from 'react';
import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes/index';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import MyMap from '@/components/common/map';
import dashboardData from '@/dummyData/dashboard.json';
import mapData from '@/dummyData/map-distribution.json';
import { TrendLineChart } from '@/components/charts/line-chart';
import { BarChart } from "reaviz";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

type Kpi = {
    total_koperasi: number;
    odi: number;
    bdi: number;
    cdi: number;
};

const kpiData = dashboardData.kpi as Kpi;

// Prepare trend data with Date objects
const allTrendData = dashboardData.tren.map(item => ({
    ...item,
    dateObj: new Date(item.tanggal)
}));

const topCdiData = dashboardData.top_cdi.map(item => ({
  key: item.nama,
  data: item.cdi,
}));

// Extract unique years
const years = Array.from(new Set(allTrendData.map(d => d.dateObj.getFullYear()))).sort((a, b) => b - a);

export default function Dashboard() {
    const [filterYear, setFilterYear] = useState<number>(years[0] || new Date().getFullYear());

    const filteredTrend = useMemo(() => {
        return allTrendData
            .filter(d => d.dateObj.getFullYear() === filterYear)
            .map(d => ({
                date: d.dateObj,
                cdi: d.cdi,
                bdi: d.bdi,
                odi: d.odi
            }));
    }, [filterYear]);

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="grid auto-rows-min gap-4 md:grid-cols-3">
                    <div className="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6 flex flex-col justify-center items-center text-center bg-gray-50 dark:bg-sidebar-accent/10 md:col-span-1">
                        <h3 className="font-semibold mb-4 text-xl">Total Koperasi</h3>
                        <div className="text-6xl font-bold text-gray-900 dark:text-gray-100 mb-2">{kpiData.total_koperasi}</div>
                        <p className="text-base text-gray-500">Unit Terdaftar</p>
                    </div>

                    <div className="md:col-span-2 flex flex-col gap-4 justify-between">
                        <div className="relative flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-4 flex flex-row items-center justify-between">
                            <div>
                                <h3 className="font-semibold mb-1 text-lg">Rata-rata CDI</h3>
                                <p className="text-sm text-gray-500">Cooperative Development Index</p>
                            </div>
                            <div className="text-4xl font-bold text-blue-600">{kpiData.cdi}</div>
                        </div>

                        <div className="relative flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-4 flex flex-row items-center justify-between">
                            <div>
                                <h3 className="font-semibold mb-1 text-lg">Rata-rata BDI</h3>
                                <p className="text-sm text-gray-500">Business Development Index</p>
                            </div>
                            <div className="text-4xl font-bold text-green-600">{kpiData.bdi}</div>
                        </div>

                        <div className="relative flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-4 flex flex-row items-center justify-between">
                            <div>
                                <h3 className="font-semibold mb-1 text-lg">Rata-rata ODI</h3>
                                <p className="text-sm text-gray-500">Organization Development Index</p>
                            </div>
                            <div className="text-4xl font-bold text-purple-600">{kpiData.odi}</div>
                        </div>
                    </div>
                </div>

                <div className="my-8 p-4 bg-white rounded-lg shadow-md">
                    <h2 className="text-3xl font-semibold mb-8">Top 10 Koperasi</h2>
                    <BarChart height={300} data={topCdiData} />
                </div>

                <div className="grid gap-4 md:grid-cols-2">
                    <div className="relative min-h-[400px] overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-4 flex flex-col">
                        <div className="flex justify-between items-center mb-4">
                            <h3 className="font-semibold">Tren Pertumbuhan Indeks</h3>
                            <select
                                value={filterYear}
                                onChange={e => setFilterYear(Number(e.target.value))}
                                className="border border-gray-300 rounded px-2 py-1 text-sm dark:bg-sidebar-accent dark:border-sidebar-border"
                            >
                                {years.map((yr) => (
                                    <option key={yr} value={yr}>{yr}</option>
                                ))}
                            </select>
                        </div>
                        <div className="flex-1 w-full" style={{ minHeight: '300px' }}>
                            <TrendLineChart trend={filteredTrend} />
                        </div>
                    </div>
                    <div className="relative min-h-[400px] overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-4">
                        <h3 className="font-semibold mb-4">Peta Sebaran Koperasi</h3>
                        <MyMap data={mapData} />
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}

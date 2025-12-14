import { TrendLineChart } from '@/components/charts/line-chart';
import MyMap from '@/components/common/map';
import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes/index';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import { useMemo, useState } from 'react';
import { BarChart } from 'reaviz';

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

interface TrendItem {
    tanggal: string;
    cdi: number;
    bdi: number;
    odi: number;
}

interface TopCdiItem {
    nama: string;
    cdi: number;
}

interface DashboardData {
    kpi: Kpi;
    tren: TrendItem[];
    top_cdi: TopCdiItem[];
}

interface MapItem {
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

interface Props {
    dashboardData: DashboardData;
    mapData: MapItem[];
}

export default function Dashboard({ dashboardData, mapData }: Props) {


    const kpiData = dashboardData.kpi;

    // Prepare trend data with Date objects
    const allTrendData = useMemo(() => dashboardData.tren.map((item) => ({
        ...item,
        dateObj: new Date(item.tanggal),
    })), [dashboardData]);

    const topCdiData = dashboardData.top_cdi.map((item) => ({
        key: item.nama,
        data: item.cdi,
    }));

    // Extract unique years
    const years = useMemo(() => Array.from(
        new Set(allTrendData.map((d) => d.dateObj.getFullYear())),
    ).sort((a: number, b: number) => b - a), [allTrendData]);


    const [filterYear, setFilterYear] = useState<number>(
        years[0] || new Date().getFullYear(),
    );

    const filteredTrend = useMemo(() => {
        return allTrendData
            .filter((d) => d.dateObj.getFullYear() === filterYear)
            .map((d) => ({
                date: d.dateObj,
                cdi: d.cdi,
                bdi: d.bdi,
                odi: d.odi,
            }));
    }, [filterYear, allTrendData]);

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

                <div className="my-8 rounded-lg bg-white p-4 shadow-md">
                    <h2 className="mb-8 text-3xl font-semibold">
                        Top 10 Koperasi
                    </h2>
                    <BarChart height={300} data={topCdiData} />
                </div>

                <div className="grid gap-4 md:grid-cols-2">
                    <div className="relative flex min-h-[400px] flex-col overflow-hidden rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                        <div className="mb-4 flex items-center justify-between">
                            <h3 className="font-semibold">
                                Tren Pertumbuhan Indeks
                            </h3>
                            <select
                                value={filterYear}
                                onChange={(e) =>
                                    setFilterYear(Number(e.target.value))
                                }
                                className="rounded border border-gray-300 px-2 py-1 text-sm dark:border-sidebar-border dark:bg-sidebar-accent"
                            >
                                {years.map((yr) => (
                                    <option key={yr} value={yr}>
                                        {yr}
                                    </option>
                                ))}
                            </select>
                        </div>
                        <div
                            className="w-full flex-1"
                            style={{ minHeight: '300px' }}
                        >
                            <TrendLineChart trend={filteredTrend} />
                        </div>
                    </div>
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

import { Head, Link } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import type { Cooperative } from '@/types/cooperative';

// Partials
import HeaderSection from './partials/HeaderSection';
import PerformanceCards from './partials/PerformanceCards';
import HumanCapitalSection from './partials/HumanCapitalSection';
import UnitUsahaSection from './partials/UnitUsahaSection';
import CooperativePrinciplesChart from '@/components/charts/CooperativePrinciplesChart';
import NeracaChart from '@/components/charts/NeracaChart';
import FinancialGrowthChart from '@/components/charts/FinancialGrowthChart';

interface Props {
    data: Cooperative[];
}

export default function CooperativeShow({ data }: Props) {
    const cooperative = data[0];

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Daftar Koperasi',
            href: '/cooperatives',
        },
        {
            title: cooperative ? cooperative.nama : 'Detail Koperasi',
            href: `/cooperatives/${cooperative?.id}`,
        },
    ];

    const prinsipList = cooperative ? [
        { key: 'Keanggotaan Sukarela', data: cooperative.prinsip_koperasi.sukarela_terbuka },
        { key: 'Pengendalian Demokratis', data: cooperative.prinsip_koperasi.demokratis },
        { key: 'Partisipasi Ekonomi', data: cooperative.prinsip_koperasi.ekonomi },
        { key: 'Otonomi', data: cooperative.prinsip_koperasi.kemandirian },
        { key: 'Pendidikan', data: cooperative.prinsip_koperasi.pendidikan },
        { key: 'Kerjasama', data: cooperative.prinsip_koperasi.kerja_sama },
        { key: 'Kepedulian Komunitas', data: cooperative.prinsip_koperasi.kepedulian },
    ] : [];

    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    const neracaData = cooperative?.performa.bisnis.neraca as any;
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    const pertumbuhanData = cooperative?.performa.bisnis.pertumbuhan?.akumulasi as any[] || [];

    if (!cooperative) {
        return (
            <AppLayout breadcrumbs={breadcrumbs}>
                <Head title="Koperasi Tidak Ditemukan" />
                <div className="p-6 text-center">
                    <h1 className="text-2xl font-bold text-red-600">Koperasi tidak ditemukan</h1>
                    <Link href="/cooperatives" className="text-blue-600 hover:underline mt-4 block">
                        Kembali ke Daftar
                    </Link>
                </div>
            </AppLayout>
        );
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={cooperative.nama} />
            <div className="p-6 space-y-6">
                {/* Header Section */}
                <HeaderSection cooperative={cooperative} />

                {/* Performance Cards */}
                <PerformanceCards cooperative={cooperative} />

                {/* Human Capital Section */}
                <HumanCapitalSection cooperative={cooperative} />

                {/* Prinsip Koperasi Section */}
                <CooperativePrinciplesChart
                    data={prinsipList}
                    title="Skor Prinsip Koperasi"
                />

                {/* Unit Usaha Section */}
                <UnitUsahaSection cooperative={cooperative} />

                {/* Financial Stats & Charts */}
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {/* Neraca Chart */}
                    <NeracaChart data={neracaData} />

                    {/* Pertumbuhan Chart */}
                    <FinancialGrowthChart data={pertumbuhanData} />
                </div>
            </div>
        </AppLayout>
    );
}

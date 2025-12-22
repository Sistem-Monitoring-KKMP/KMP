import { Head, Link } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import type { Cooperative } from '@/types/cooperative';

import HeaderSection from './partials/HeaderSection';
import PerformanceCards from './partials/PerformanceCards';
import HumanCapitalSection from './partials/HumanCapitalSection';
import UnitUsahaSection from './partials/UnitUsahaSection';
import CooperativePrinciplesChart from '@/components/charts/CooperativePrinciplesChart';
import NeracaChart from '@/components/charts/NeracaChart';
import FinancialGrowthChart from '@/components/charts/FinancialGrowthChart';
import MemberGrowthChart from '@/components/charts/MemberGrowthChart';

interface Props {
    data: Cooperative[];
}

/**
 * Cooperative Detail Page
 * 
 * Displays comprehensive information about a specific cooperative, including:
 * - General information and performance cards
 * - Human capital and unit usaha details
 * - Member growth trends and cooperative principles scores
 * - Financial performance (Balance Sheet & Growth)
 */
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

    const latestPerforma = cooperative?.performa?.[0];
    const neracaData = latestPerforma?.bisnis?.neraca;
    
    const pertumbuhanData = cooperative?.performa?.map(p => ({
        ...(p.bisnis?.pertumbuhan || {}),
        tanggal: p.periode 
    })).filter(item => item.omset !== undefined) 
    .sort((a, b) => new Date(a.tanggal).getTime() - new Date(b.tanggal).getTime()) || [];

    const memberGrowthData = cooperative?.performa?.map(p => ({
        periode: p.periode,
        total: p.organisasi?.anggota?.total || 0,
        aktif: p.organisasi?.anggota?.aktif || 0,
        tidak_aktif: p.organisasi?.anggota?.tidak_aktif || 0
    })).sort((a, b) => new Date(a.periode).getTime() - new Date(b.periode).getTime()) || [];


    
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
                <HeaderSection cooperative={cooperative} />

                <PerformanceCards cooperative={cooperative} />

                <HumanCapitalSection cooperative={cooperative} />

                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {memberGrowthData.length > 0 && (
                        <MemberGrowthChart data={memberGrowthData} />
                    )}

                    <CooperativePrinciplesChart
                        data={prinsipList}
                        title="Skor Prinsip Koperasi"
                    />
                </div>

                <UnitUsahaSection cooperative={cooperative} />

                <div className="space-y-6">
                    <NeracaChart data={neracaData} />

                    <FinancialGrowthChart data={pertumbuhanData} />
                </div>
            </div>
        </AppLayout>
    );
}

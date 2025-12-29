import { useState, useMemo } from 'react';
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


export default function CooperativeShow({ data }: Props) {
    const cooperative = data[0];
    // --- Data Preparation ---
    const rawNeracaData = useMemo(() =>
        (cooperative?.performa || [])
            .map(p => ({ periode: p.periode, ...p.bisnis.neraca }))
            .sort((a, b) => new Date(b.periode).getTime() - new Date(a.periode).getTime()),
        [cooperative]
    );

    const periodOptions = useMemo(() =>
        rawNeracaData.map(item => {
            const date = new Date(item.periode);
            return {
                value: item.periode,
                label: date.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' })
            };
        }),
        [rawNeracaData]
    );

    const [selectedPeriod, setSelectedPeriod] = useState(
        rawNeracaData[0]?.periode || ''
    );

    const singleNeracaData = useMemo(
        () => rawNeracaData.find(d => d.periode === selectedPeriod),
        [selectedPeriod, rawNeracaData]
    );

    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Daftar Koperasi', href: '/cooperatives' },
        { title: cooperative.nama, href: `/cooperatives/${cooperative.id}` },
    ];

    const prinsipList = [
        { key: 'Keanggotaan Sukarela', data: cooperative.prinsip_koperasi.sukarela_terbuka },
        { key: 'Pengendalian Demokratis', data: cooperative.prinsip_koperasi.demokratis },
        { key: 'Partisipasi Ekonomi', data: cooperative.prinsip_koperasi.ekonomi },
        { key: 'Otonomi', data: cooperative.prinsip_koperasi.kemandirian },
        { key: 'Pendidikan', data: cooperative.prinsip_koperasi.pendidikan },
        { key: 'Kerjasama', data: cooperative.prinsip_koperasi.kerja_sama },
        { key: 'Kepedulian Komunitas', data: cooperative.prinsip_koperasi.kepedulian },
    ];

    const pertumbuhanData = (cooperative?.performa || [])
        .map(p => ({ ...(p.bisnis?.pertumbuhan || {}), tanggal: p.periode }))
        .filter(item => item.omset !== undefined)
        .sort((a, b) => new Date(a.tanggal).getTime() - new Date(b.tanggal).getTime());

    const memberGrowthData = (cooperative?.performa || [])
        .map(p => ({
            periode: p.periode,
            total: p.organisasi?.anggota?.total || 0,
            aktif: p.organisasi?.anggota?.aktif || 0,
            tidak_aktif: p.organisasi?.anggota?.tidak_aktif || 0
        }))
        .sort((a, b) => new Date(a.periode).getTime() - new Date(b.periode).getTime());
    if (!cooperative) {
        return (
            <AppLayout breadcrumbs={[]}>
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
                    {memberGrowthData.length > 0 && <MemberGrowthChart data={memberGrowthData} />}
                    <CooperativePrinciplesChart data={prinsipList} title="Skor Prinsip Koperasi" />
                </div>

                <UnitUsahaSection cooperative={cooperative} />

                <div className="space-y-6">
                    {/* --- NERACA SECTION (Monthly Filter) --- */}
                    {singleNeracaData ? (
                        <div className="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                            <div className="flex flex-col sm:flex-row justify-between items-center mb-6">
                                <h3 className="text-lg font-semibold text-gray-900 mb-2 sm:mb-0">Neraca Keuangan</h3>
                                <div className="flex items-center space-x-2">
                                    <label htmlFor="period-select" className="text-sm text-gray-500">Periode:</label>
                                    <select
                                        id="period-select"
                                        value={selectedPeriod}
                                        onChange={e => setSelectedPeriod(e.target.value)}
                                        className="block w-48 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    >
                                        {periodOptions.map(opt => (
                                            <option key={opt.value} value={opt.value}>{opt.label}</option>
                                        ))}
                                    </select>
                                </div>
                            </div>
                            <NeracaChart key={selectedPeriod} data={singleNeracaData} />
                        </div>
                    ) : (
                        rawNeracaData.length > 0 && (
                            <div className="bg-white p-6 rounded-lg text-center text-gray-500">
                                Data neraca tidak tersedia.
                            </div>
                        )
                    )}
                    <FinancialGrowthChart data={pertumbuhanData} />
                </div>
            </div>
        </AppLayout>
    );
}
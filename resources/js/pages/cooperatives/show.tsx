import { Head, Link } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import type { Cooperative } from '@/types/cooperative';

// Partials
import HeaderSection from './partials/HeaderSection';
import PerformanceCards from './partials/PerformanceCards';
import HumanCapitalSection from './partials/HumanCapitalSection';
import PrinsipKoperasiSection from './partials/PrinsipKoperasiSection';
import UnitUsahaSection from './partials/UnitUsahaSection';
import FinancialChartsSection from './partials/FinancialChartsSection';

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
                <PrinsipKoperasiSection cooperative={cooperative} />

                {/* Unit Usaha Section */}
                <UnitUsahaSection cooperative={cooperative} />

                {/* Financial Stats & Charts */}
                <FinancialChartsSection cooperative={cooperative} />
            </div>
        </AppLayout>
    );
}

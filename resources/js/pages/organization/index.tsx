import { Head } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';

// Partials
import MeetingFrequencyChart from './partials/MeetingFrequencyChart';
import TrainingChart from './partials/TrainingChart';
import CooperativePrinciplesChart from '@/components/charts/CooperativePrinciplesChart';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Performa Organisasi',
        href: '/organization',
    },
];

interface Principle {
    prinsip: string;
    skor: number;
}

interface Training {
    sasaran: string;
    jumlah_terlaksana: number;
    total_sesi: number;
}

interface Meeting {
    jenis_rapat: string;
    frekuensi: {
        mingguan: number;
        dua_mingguan: number;
        bulanan: number;
        dua_bulanan: number;
        tiga_bulanan_lebih: number;
    };
}

interface OrganizationData {
    prinsip_koperasi: Principle[];
    pelatihan: Training[];
    rapat: Meeting[];
}

export default function OrganizationPage({ organizationData }: { organizationData: OrganizationData }) {
    const principlesData = organizationData.prinsip_koperasi.map(p => ({
        key: p.prinsip,
        data: p.skor
    }));

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Performa Organisasi" />
            <div className="p-6 space-y-6">
                {/* Header */}
                <div>
                    <h1 className="text-3xl font-bold text-gray-900 dark:text-gray-100">Performa Organisasi</h1>
                    <p className="text-gray-500 dark:text-gray-400 mt-1">
                        Analisis kesehatan organisasi, partisipasi anggota, dan kepatuhan prinsip koperasi.
                    </p>
                </div>

                {/* Charts Grid */}
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {/* Cooperative Principles (Radar/Bar) */}
                    <CooperativePrinciplesChart
                        data={principlesData}
                        title="Rata-rata Skor Prinsip Koperasi (Skala 1-5)"
                    />

                    {/* Training Statistics */}
                    <TrainingChart data={organizationData.pelatihan} />
                </div>

                {/* Meeting Frequency (Full Width) */}
                <MeetingFrequencyChart data={organizationData.rapat} />
            </div>
        </AppLayout>
    );
}

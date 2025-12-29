import { Head } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import type { OrganizationData } from '@/types/organization';

import MeetingFrequencyChart from './partials/MeetingFrequencyChart';
import TrainingChart from './partials/TrainingChart';
import CooperativePrinciplesChart from '@/components/charts/CooperativePrinciplesChart';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Performa Organisasi',
        href: '/organization',
    },
];

/**
 * Organization Performance Page
 * 
 * Visualizes organizational health metrics including:
 * - Cooperative principles adherence (Radar Chart)
 * - Training statistics (Bar Chart)
 * - Meeting frequency distribution (Pie Chart)
 */
export default function OrganizationPage({ organizationData }: { organizationData: OrganizationData }) {
    const principlesData = organizationData.prinsip_koperasi.map(p => ({
        key: p.prinsip,
        data: p.skor
    }));

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Performa Organisasi" />
            <div className="p-6 space-y-6">
                <div>
                    <h1 className="text-3xl font-bold text-gray-900 dark:text-gray-100">Performa Organisasi</h1>
                    <p className="text-gray-500 dark:text-gray-400 mt-1">
                        Analisis kesehatan organisasi, partisipasi anggota, dan kepatuhan prinsip koperasi.
                    </p>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <CooperativePrinciplesChart
                        data={principlesData}
                        title="Rata-rata Skor Prinsip Koperasi (Skala 1-5)"
                    />

                    <TrainingChart data={organizationData.pelatihan} />
                </div>

                <MeetingFrequencyChart data={organizationData.rapat} />
            </div>
        </AppLayout>
    );
}

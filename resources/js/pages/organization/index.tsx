import { Head } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import organizationData from '@/dummyData/organization.json';

// Partials
import MeetingFrequencyChart from './partials/MeetingFrequencyChart';
import TrainingChart from './partials/TrainingChart';
import CooperativePrinciplesChart from './partials/CooperativePrinciplesChart';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Performa Organisasi',
        href: '/organization',
    },
];

export default function OrganizationPage({organizationData}) {
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
                    <CooperativePrinciplesChart data={organizationData.prinsip_koperasi} />

                    {/* Training Statistics */}
                    <TrainingChart data={organizationData.pelatihan} />
                </div>

                {/* Meeting Frequency (Full Width) */}
                <MeetingFrequencyChart data={organizationData.rapat} />
            </div>
        </AppLayout>
    );
}

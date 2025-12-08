import { Head } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import cooperativesData from '@/dummyData/cooperatives.json';

// Partials
import CooperativeScatterPlot from './partials/CooperativeScatterPlot';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Sebaran Koperasi',
        href: '/distribution',
    },
];

export default function DistributionPage() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Sebaran Koperasi" />
            <div className="p-6 space-y-6">
                {/* Header */}
                <div>
                    <h1 className="text-3xl font-bold text-gray-900 dark:text-gray-100">Peta Sebaran Koperasi</h1>
                    <p className="text-gray-500 dark:text-gray-400 mt-1">
                        Analisis posisi koperasi berdasarkan indeks pengembangan bisnis dan organisasi.
                    </p>
                </div>

                {/* Scatter Plot */}
                <CooperativeScatterPlot data={cooperativesData} />
            </div>
        </AppLayout>
    );
}

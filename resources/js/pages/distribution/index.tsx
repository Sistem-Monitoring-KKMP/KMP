import { Head } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import type { CooperativeList } from '@/types/cooperative';

import CooperativeScatterPlot from './partials/CooperativeScatterPlot';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Sebaran Koperasi',
        href: '/distribution',
    },
];

/**
 * Distribution Page
 * 
 * Visualizes the distribution of cooperatives using a scatter plot.
 * Helps identify clusters of cooperatives based on their BDI and ODI scores.
 */
export default function DistributionPage({ cooperativesData }: { cooperativesData: CooperativeList[] }) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Sebaran Koperasi" />
            <div className="p-6 space-y-6">
                <div>
                    <h1 className="text-3xl font-bold text-gray-900 dark:text-gray-100">Peta Sebaran Koperasi</h1>
                    <p className="text-gray-500 dark:text-gray-400 mt-1">
                        Analisis posisi koperasi berdasarkan indeks pengembangan bisnis dan organisasi.
                    </p>
                </div>

                <CooperativeScatterPlot data={cooperativesData} />
            </div>
        </AppLayout>
    );
}

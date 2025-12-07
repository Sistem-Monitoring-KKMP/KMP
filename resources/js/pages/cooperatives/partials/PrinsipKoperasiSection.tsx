import type { Cooperative } from '@/types/cooperative';
import { RadarChart, RadialAreaSeries } from 'reaviz';

interface Props {
    cooperative: Cooperative;
}

export default function PrinsipKoperasiSection({ cooperative }: Props) {
    const prinsipData = [
        {
            key: 'Maksimal',
            data: cooperative.prinsip_koperasi.map((p) => ({ key: p.key, data: 5 })),
        },
        {
            key: 'Skor',
            data: cooperative.prinsip_koperasi,
        },
    ];

    return (
        <div className="bg-white dark:bg-sidebar-accent/10 p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm">
            <h3 className="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4 border-b pb-2 border-gray-200 dark:border-gray-700">
                Skor Prinsip Koperasi
            </h3>
            <div style={{ height: '300px', width: '100%' }}>
                <RadarChart
                    data={prinsipData}
                    series={<RadialAreaSeries colorScheme={['transparent', '#2563eb']} />}
                />
            </div>
        </div>
    );
}

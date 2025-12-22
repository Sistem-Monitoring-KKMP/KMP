import { RadarChart, RadialAreaSeries } from 'reaviz';
import { CHART_COLORS } from '@/lib/chart-colors';
import type { Principle } from '@/types/organization';

interface Props {
    data: Principle[];
}

/**
 * Cooperative Principles Radar Chart
 * 
 * Visualizes the adherence to cooperative principles using a radar chart.
 * Compares the actual score against the maximum possible score (5).
 */
export default function CooperativePrinciplesChart({ data }: Props) {
    const chartData = [
        {
            key: 'Maksimal',
            data: data.map((p) => ({ key: p.prinsip, data: 5 })),
        },
        {
            key: 'Skor',
            data: data.map((p) => ({ key: p.prinsip, data: p.skor })),
        },
    ];

    return (
        <div className="bg-white dark:bg-sidebar-accent/10 p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm">
            <h3 className="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4 border-b pb-2 border-gray-200 dark:border-gray-700">
                Rata-rata Skor Prinsip Koperasi (Skala 1-5)
            </h3>
            <div style={{ height: '300px', width: '100%' }}>
                <RadarChart
                    data={chartData}
                    series={
                        <RadialAreaSeries
                            colorScheme={[CHART_COLORS.TRANSPARENT, CHART_COLORS.COLOR_1]}
                        />
                    }
                />
            </div>
        </div>
    );
}



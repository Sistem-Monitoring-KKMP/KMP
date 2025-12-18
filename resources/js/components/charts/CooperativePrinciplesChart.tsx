import { RadarChart, RadialAreaSeries } from 'reaviz';
import { CHART_COLORS } from '@/lib/chart-colors';

export interface PrincipleData {
    key: string;
    data: number;
}

interface Props {
    data: PrincipleData[];
    title?: string;
    className?: string;
}

export default function CooperativePrinciplesChart({ data, title = "Skor Prinsip Koperasi", className }: Props) {
    const chartData = [
        {
            key: 'Maksimal',
            data: data.map((p) => ({ key: p.key, data: 5 })),
        },
        {
            key: 'Skor',
            data: data,
        },
    ];

    return (
        <div className={`bg-white dark:bg-sidebar-accent/10 p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm ${className}`}>
            <h3 className="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4 border-b pb-2 border-gray-200 dark:border-gray-700">
                {title}
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

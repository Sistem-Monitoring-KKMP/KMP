import { BarChart, BarSeries, Bar } from 'reaviz';
import { CHART_COLORS } from '@/lib/chart-colors';
import { CustomBar } from '@/components/charts/CustomBar';

interface Training {
    sasaran: string;
    jumlah_terlaksana: number;
    total_sesi: number;
}

interface Props {
    data: Training[];
}

export default function TrainingChart({ data }: Props) {
    const chartData = data.map(d => ({
        key: d.sasaran,
        data: [
            { key: 'Jumlah Terlaksana', data: d.jumlah_terlaksana },
            { key: 'Total Sesi', data: d.total_sesi }
        ]
    }));

    const colors = [
        CHART_COLORS.COLOR_1,
        CHART_COLORS.COLOR_2,
        CHART_COLORS.COLOR_3,
        CHART_COLORS.COLOR_4,
        CHART_COLORS.COLOR_5,
        CHART_COLORS.COLOR_6,
        CHART_COLORS.COLOR_7,
        CHART_COLORS.COLOR_8,
        CHART_COLORS.COLOR_9,
        CHART_COLORS.COLOR_10
    ];

    return (
        <div className="bg-white dark:bg-sidebar-accent/10 p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm">
            <h3 className="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4 border-b pb-2 border-gray-200 dark:border-gray-700">
                Statistik Pelatihan
            </h3>
            <div style={{ height: '300px', width: '100%' }}>
                <BarChart
                    data={chartData}
                    series={
                        <BarSeries
                            type="grouped"
                            bar={<CustomBar />}
                            colorScheme={colors}
                        />
                    }
                />
            </div>
        </div>
    );
}

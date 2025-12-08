import { BarChart, BarSeries, Bar } from 'reaviz';
import { useState, type ComponentProps } from 'react';
import { CHART_COLORS } from '@/lib/chart-colors';

interface Training {
    sasaran: string;
    jumlah_terlaksana: number;
    total_sesi: number;
}

interface Props {
    data: Training[];
}

type CustomBarProps = ComponentProps<typeof Bar>;

const CustomBar = (props: CustomBarProps) => {
    const [hovered, setHovered] = useState(false);
    const { ...rest } = props;

    return (
        <Bar
            {...rest}
            active={hovered}
            onMouseEnter={(e) => {
                setHovered(true);
                rest.onMouseEnter?.(e);
            }}
            onMouseLeave={(e) => {
                setHovered(false);
                rest.onMouseLeave?.(e);
            }}
            style={{
                ...rest.style,
                cursor: 'pointer',
                stroke: hovered ? 'rgba(255,255,255,0.8)' : 'none',
                strokeWidth: hovered ? 2 : 0,
                filter: hovered ? 'brightness(1.1)' : 'none'
            }}
        />
    );
};

export default function TrainingChart({ data }: Props) {
    const chartData = [
        {
            key: 'Jumlah Terlaksana',
            data: data.map(d => ({ key: d.sasaran, data: d.jumlah_terlaksana }))
        },
        {
            key: 'Total Sesi',
            data: data.map(d => ({ key: d.sasaran, data: d.total_sesi }))
        }
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
                            colorScheme={[CHART_COLORS.MODAL_KERJA, CHART_COLORS.INVESTASI]}
                        />
                    }
                />
            </div>
        </div>
    );
}

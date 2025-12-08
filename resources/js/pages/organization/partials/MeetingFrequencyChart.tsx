import { BarChart, BarSeries, Bar } from 'reaviz';
import { useState, type ComponentProps } from 'react';
import { CHART_COLORS } from '@/lib/chart-colors';

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

interface Props {
    data: Meeting[];
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

export default function MeetingFrequencyChart({ data }: Props) {
    const chartData = [
        {
            key: 'Mingguan',
            data: data.map(d => ({ key: d.jenis_rapat, data: d.frekuensi.mingguan }))
        },
        {
            key: '2 Mingguan',
            data: data.map(d => ({ key: d.jenis_rapat, data: d.frekuensi.dua_mingguan }))
        },
        {
            key: 'Bulanan',
            data: data.map(d => ({ key: d.jenis_rapat, data: d.frekuensi.bulanan }))
        },
        {
            key: '2 Bulanan',
            data: data.map(d => ({ key: d.jenis_rapat, data: d.frekuensi.dua_bulanan }))
        },
        {
            key: '> 3 Bulanan',
            data: data.map(d => ({ key: d.jenis_rapat, data: d.frekuensi.tiga_bulanan_lebih }))
        }
    ];

    const colors = [
        CHART_COLORS.OMSET,
        CHART_COLORS.MODAL_KERJA,
        CHART_COLORS.INVESTASI,
        CHART_COLORS.SIMPANAN,
        CHART_COLORS.PINJAMAN
    ];

    return (
        <div className="bg-white dark:bg-sidebar-accent/10 p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm">
            <h3 className="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4 border-b pb-2 border-gray-200 dark:border-gray-700">
                Frekuensi Rapat
            </h3>
            <div style={{ height: '400px', width: '100%' }}>
                <BarChart
                    data={chartData}
                    series={
                        <BarSeries
                            type="stacked"
                            bar={<CustomBar />}
                            colorScheme={colors}
                        />
                    }
                />
            </div>
        </div>
    );
}

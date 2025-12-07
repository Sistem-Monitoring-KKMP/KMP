import { BarChart, BarSeries, Bar } from 'reaviz';
import { formatRupiah } from '@/lib/utils';
import { useState, type ComponentProps } from 'react';
import { CHART_COLORS } from '@/lib/chart-colors';

interface FinancialGrowth {
    tahun: string;
    omset: number;
    modal_kerja: number;
    investasi: number;
    simpanan_anggota: number;
    pinjaman_bank: number;
    hibah: number;
    biaya_operasional: number;
    shu: number;
}

interface Props {
    data: FinancialGrowth[];
}

interface CustomBarProps extends ComponentProps<typeof Bar> {
    onActiveYearChange: (year: string) => void;
    chartData: { key: string }[];
    groupIndex?: number;
}

const CustomBar = (props: CustomBarProps) => {
    const { onActiveYearChange, chartData, ...rest } = props;
    const [hovered, setHovered] = useState(false);

    const handleInteraction = () => {
        if (rest.groupIndex !== undefined && chartData) {
            const group = chartData[rest.groupIndex];
            if (group && group.key) {
                onActiveYearChange(group.key);
            }
        }
    };

    return (
        <Bar
            {...rest}
            active={hovered}
            onMouseEnter={(event) => {
                setHovered(true);
                rest.onMouseEnter?.(event);
                handleInteraction();
            }}
            onMouseLeave={(event) => {
                setHovered(false);
                rest.onMouseLeave?.(event);
            }}
            onClick={(event) => {
                rest.onClick?.(event);
                handleInteraction();
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

export default function FinancialGrowthChart({ data }: Props) {
    const [activeYear, setActiveYear] = useState<string | null>(null);

    const chartData = data.map((item) => ({
        key: item.tahun,
        data: [
            { key: 'Omset', data: item.omset },
            { key: 'Modal Kerja', data: item.modal_kerja },
            { key: 'Investasi', data: item.investasi },
            { key: 'Simpanan', data: item.simpanan_anggota },
            { key: 'Pinjaman', data: item.pinjaman_bank },
            { key: 'Hibah', data: item.hibah },
            { key: 'Biaya Ops', data: item.biaya_operasional },
            { key: 'SHU', data: item.shu },
        ],
    }));

    const getPertumbuhanDetail = (yearKey: string | null) => {
        if (!yearKey) {
            return chartData.length > 0 ? chartData[chartData.length - 1].data : [];
        }
        return chartData.find(item => item.key === yearKey)?.data || [];
    };

    const colors = [
        CHART_COLORS.OMSET,
        CHART_COLORS.MODAL_KERJA,
        CHART_COLORS.INVESTASI,
        CHART_COLORS.SIMPANAN,
        CHART_COLORS.PINJAMAN,
        CHART_COLORS.HIBAH,
        CHART_COLORS.BIAYA_OPS,
        CHART_COLORS.SHU
    ]; return (
        <div className="bg-white dark:bg-sidebar-accent/10 p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm">
            <h3 className="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4 border-b pb-2 border-gray-200 dark:border-gray-700">
                Pertumbuhan Indikator Keuangan (Agregat)
            </h3>
            <div style={{ height: '350px', width: '100%' }}>
                <BarChart
                    data={chartData}
                    series={
                        <BarSeries
                            type="stacked"
                            colorScheme={colors}
                            tooltip={null}
                            bar={
                                <CustomBar
                                    onActiveYearChange={setActiveYear}
                                    chartData={chartData}
                                />
                            }
                        />
                    }
                />
            </div>
            <div className="mt-6">
                <div className="font-bold text-gray-900 dark:text-gray-100 mb-3 border-b pb-1">
                    Detail Tahun: {activeYear || (chartData.length > 0 ? chartData[chartData.length - 1].key : '')}
                </div>
                <div className="grid grid-cols-2 md:grid-cols-4 gap-x-6 gap-y-2 text-sm">
                    {getPertumbuhanDetail(activeYear).map((item, index) => (
                        <div
                            key={index}
                            className="flex justify-between items-center p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-sidebar-accent/10 transition-colors"
                        >
                            <div className="flex items-center gap-2">
                                <div
                                    className="w-3 h-3 rounded-full"
                                    style={{ backgroundColor: colors[index % colors.length] }}
                                />
                                <span className="text-xs text-gray-600 dark:text-gray-400">
                                    {item.key}
                                </span>
                            </div>
                            <span className="font-medium text-gray-900 dark:text-gray-100">
                                {formatRupiah(item.data)}
                            </span>
                        </div>
                    ))}
                </div>
            </div>
        </div>
    );
}

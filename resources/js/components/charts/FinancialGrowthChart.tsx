import { BarChart, BarSeries, Bar, LinearYAxis, LinearYAxisTickSeries, LinearYAxisTickLabel } from 'reaviz';
import { formatRupiah } from '@/lib/utils';
import { useState, useMemo, type ComponentProps } from 'react';
import { CHART_COLORS } from '@/lib/chart-colors';

export interface FinancialGrowthData {
    tanggal: string;
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
    data: FinancialGrowthData[];
    className?: string;
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
                stroke: hovered ? CHART_COLORS.HOVER_STROKE : 'none',
                strokeWidth: hovered ? 2 : 0,
                filter: hovered ? 'brightness(1.1)' : 'none'
            }}
        />
    );
};

export default function FinancialGrowthChart({ data, className }: Props) {
    // Extract unique years from data
    const years = useMemo(() => {
        if (!data) return [];
        return Array.from(new Set(data.map(item => new Date(item.tanggal).getFullYear()))).sort((a, b) => b - a);
    }, [data]);

    const [selectedYear, setSelectedYear] = useState<number>(years[0] || new Date().getFullYear());
    const [activeMonth, setActiveMonth] = useState<string | null>(null);

    const chartData = useMemo(() => {
        if (!data) return [];
        return data
            .filter(item => new Date(item.tanggal).getFullYear() === selectedYear)
            .map((item) => {
                const month = new Date(item.tanggal).toLocaleDateString('id-ID', { month: 'short' });
                return {
                    key: month,
                    data: [
                        { key: 'Pinjaman Bank', data: item.pinjaman_bank, month },
                        { key: 'Investasi', data: item.investasi, month },
                        { key: 'Modal Kerja', data: item.modal_kerja, month },
                        { key: 'Simpanan Anggota', data: item.simpanan_anggota, month },
                        { key: 'Hibah', data: item.hibah, month },
                        { key: 'Omset', data: item.omset, month },
                        { key: 'Biaya Ops', data: item.biaya_operasional, month },
                        { key: 'SHU', data: item.shu, month },
                    ],
                };
            });
    }, [data, selectedYear]);

    const colors = [
        CHART_COLORS.COLOR_4, // Pinjaman (Red)
        CHART_COLORS.COLOR_1, // Investasi (Blue)
        CHART_COLORS.COLOR_6, // Modal Kerja (Cyan)
        CHART_COLORS.COLOR_5, // Simpanan (Violet)
        CHART_COLORS.COLOR_7, // Hibah (Pink)
        CHART_COLORS.COLOR_2, // Omset (Emerald)
        CHART_COLORS.COLOR_9, // Biaya Ops (Orange)
        CHART_COLORS.COLOR_8  // SHU (Lime)
    ];

    const yDomain = useMemo(() => {
        let maxStack = 0;
        let minStack = 0;

        chartData.forEach(group => {
            let posSum = 0;
            let negSum = 0;
            group.data.forEach(d => {
                const val = typeof d.data === 'number' ? d.data : 0;
                if (val > 0) posSum += val;
                else negSum += val;
            });
            if (posSum > maxStack) maxStack = posSum;
            if (negSum < minStack) minStack = negSum;
        });

        // Add a small buffer to the domain
        let domain: [number, number] = [minStack * 1.1, maxStack * 1.1];

        // Ensure domain is valid
        if (isNaN(domain[0]) || isNaN(domain[1]) || (domain[0] === 0 && domain[1] === 0)) {
            domain = [0, 100];
        } else if (domain[0] === domain[1]) {
            domain = [domain[0] * 0.9, domain[1] * 1.1];
        }

        return domain;
    }, [chartData]);

    const getPertumbuhanDetail = (monthKey: string | null) => {
        if (!monthKey) {
            return chartData.length > 0 ? chartData[chartData.length - 1].data : [];
        }
        return chartData.find(item => item.key === monthKey)?.data || [];
    };

    return (
        <div className={`bg-white dark:bg-sidebar-accent/10 p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm ${className}`}>
            <div className="flex justify-between items-center mb-4 border-b pb-2 border-gray-200 dark:border-gray-700">
                <h3 className="text-xl font-bold text-gray-900 dark:text-gray-100">
                    Pertumbuhan Keuangan
                </h3>
                <select
                    value={selectedYear}
                    onChange={(e) => {
                        setSelectedYear(Number(e.target.value));
                        setActiveMonth(null);
                    }}
                    className="text-sm border-gray-300 dark:border-gray-600 dark:bg-sidebar-accent dark:text-gray-200 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                >
                    {years.map(year => (
                        <option key={year} value={year}>{year}</option>
                    ))}
                </select>
            </div>
            <div style={{ height: '350px', width: '100%' }}>
                <BarChart
                    key={selectedYear}
                    data={chartData}
                    margins={20}
                    yAxis={
                        <LinearYAxis
                            type="value"
                            domain={yDomain}
                            tickSeries={
                                <LinearYAxisTickSeries
                                    label={
                                        <LinearYAxisTickLabel
                                            format={(d) => `${(d / 1000000).toLocaleString('id-ID')} Jt`}
                                        />
                                    }
                                />
                            }
                        />
                    }
                    series={
                        <BarSeries
                            type="stacked"
                            colorScheme={colors}
                            tooltip={null}
                            bar={<CustomBar onActiveYearChange={setActiveMonth} chartData={chartData} />}
                        />
                    }
                />
            </div>
            <div className="mt-6">
                <div className="font-bold text-gray-900 dark:text-gray-100 mb-3 border-b pb-1">
                    Detail Bulan: {activeMonth || 'Pilih Bulan'}
                </div>
                {activeMonth ? (
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2 text-sm">
                        {getPertumbuhanDetail(activeMonth).map((item, index) => (
                            <div key={index} className="flex justify-start items-center gap-8 p-1 rounded hover:bg-gray-50 dark:hover:bg-sidebar-accent/10 transition-colors">
                                <div className="flex items-start gap-2 w-32 shrink-0">
                                    <div
                                        className="w-3 h-3 rounded-full mt-0.5"
                                        style={{ backgroundColor: colors[index % colors.length] }}
                                    />
                                    <span className="text-xs text-gray-600 dark:text-gray-400">{item.key}</span>
                                </div>
                                <span className="font-medium text-gray-900 dark:text-gray-100 text-left">
                                    {formatRupiah(item.data)}
                                </span>
                            </div>
                        ))}
                    </div>
                ) : (
                    <div className="text-center text-gray-500 py-4 text-sm italic">
                        Arahkan kursor atau klik pada batang grafik untuk melihat detail rincian.
                    </div>
                )}
            </div>
        </div>
    );
}
import { BarChart, BarSeries, Bar, LinearYAxis, LinearYAxisTickSeries, LinearYAxisTickLabel } from 'reaviz';
import { formatRupiah } from '@/lib/utils';
import { useState, useMemo, type ComponentProps } from 'react';
import { CHART_COLORS } from '@/lib/chart-colors';

interface FinancialGrowth {
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

    // Calculate domain for stacked chart to prevent symmetric scaling
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

    if (!data || data.length === 0) return null;

    const getPertumbuhanDetail = (monthKey: string | null) => {
        if (!monthKey) {
            return chartData.length > 0 ? chartData[chartData.length - 1].data : [];
        }
        return chartData.find(item => item.key === monthKey)?.data || [];
    };

    const colors = [
        CHART_COLORS.PINJAMAN,
        CHART_COLORS.INVESTASI,
        CHART_COLORS.MODAL_KERJA,
        CHART_COLORS.SIMPANAN,
        CHART_COLORS.HIBAH,
        CHART_COLORS.OMSET,
        CHART_COLORS.BIAYA_OPS,
        CHART_COLORS.SHU
    ];

    const currentDetail = getPertumbuhanDetail(activeMonth);

    return (
        <div className="bg-white dark:bg-sidebar-accent/10 p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm col-span-1 lg:col-span-2">
            <div className="flex justify-between items-center mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
                <div>
                    <h3 className="text-xl font-bold text-gray-900 dark:text-gray-100">
                        Pertumbuhan Indikator Keuangan
                    </h3>
                    <p className="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Tren bulanan indikator finansial utama (Omset, Modal, Investasi, dll).
                    </p>
                </div>
                <div className="flex gap-2">
                    {years.map(year => (
                        <button
                            key={year}
                            onClick={() => {
                                setSelectedYear(year);
                                setActiveMonth(null);
                            }}
                            className={`px-3 py-1 text-sm rounded-md transition-colors ${selectedYear === year
                                ? 'bg-blue-600 text-white'
                                : 'bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300'
                                }`}
                        >
                            {year}
                        </button>
                    ))}
                </div>
            </div>

            <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div className="lg:col-span-2" style={{ height: '400px' }}>
                    <BarChart
                        key={selectedYear}
                        data={chartData}
                        yAxis={
                            <LinearYAxis
                                type="value"
                                domain={yDomain}
                                tickSeries={
                                    <LinearYAxisTickSeries
                                        label={
                                            <LinearYAxisTickLabel
                                                format={(d) => formatRupiah(d)}
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
                                bar={
                                    <CustomBar
                                        onActiveYearChange={setActiveMonth}
                                        chartData={chartData}
                                    />
                                }
                            />
                        }
                    />
                </div>

                <div className="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-lg border border-gray-200 dark:border-gray-700 h-fit">
                    <h4 className="font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                        <span className="w-2 h-6 bg-blue-600 rounded-full"></span>
                        Detail {activeMonth || 'Bulan Terakhir'} {selectedYear}
                    </h4>
                    <div className="space-y-3">
                        {currentDetail.map((item, index) => (
                            <div key={index} className="flex justify-between items-center p-2 hover:bg-white dark:hover:bg-gray-800 rounded transition-colors">
                                <div className="flex items-center gap-2">
                                    <div className="w-3 h-3 rounded-full" style={{ backgroundColor: colors[index % colors.length] }}></div>
                                    <span className="text-sm text-gray-600 dark:text-gray-400">{item.key}</span>
                                </div>
                                <span className="font-mono font-medium text-gray-900 dark:text-gray-200">
                                    {formatRupiah(item.data)}
                                </span>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </div>
    );
}

import { BarChart, BarSeries, Bar, LinearYAxis, LinearYAxisTickSeries, LinearYAxisTickLabel } from 'reaviz';
import { formatRupiah } from '@/lib/utils';
import { useMemo } from 'react';
import { CHART_COLORS } from '@/lib/chart-colors';
import { CustomBar } from './CustomBar';

export interface NeracaData {
    aktiva: {
        aktiva_lancar: {
            kas: number;
            piutang: number;
            persediaan?: number;
            total?: number;
        };
        aktiva_tetap: {
            tanah: number;
            bangunan: number;
            kendaraan: number;
            total?: number;
        };
        total_aktiva: number;
    };
    passiva: {
        hutang_lancar: number;
        hutang_jangka_panjang: number;
        modal: number;
        total_passiva: number;
    };
}

interface Props {
    data: NeracaData;
    className?: string;
}

export default function NeracaChart({ data, className }: Props) {
    const chartData = useMemo(() => {
        if (!data) return [];
        const safeVal = (val: unknown) => typeof val === 'number' ? val : 0;
        const aktiva = data.aktiva;
        const passiva = data.passiva;

        // Check if persediaan exists and has value
        const hasPersediaan = typeof aktiva?.aktiva_lancar?.persediaan === 'number';

        const aktivaData = [
            { key: 'Kas', data: safeVal(aktiva?.aktiva_lancar?.kas) },
            { key: 'Piutang', data: safeVal(aktiva?.aktiva_lancar?.piutang) },
        ];

        if (hasPersediaan) {
            aktivaData.push({ key: 'Persediaan', data: safeVal(aktiva?.aktiva_lancar?.persediaan) });
        }

        aktivaData.push(
            { key: 'Tanah', data: safeVal(aktiva?.aktiva_tetap?.tanah) },
            { key: 'Bangunan', data: safeVal(aktiva?.aktiva_tetap?.bangunan) },
            { key: 'Kendaraan', data: safeVal(aktiva?.aktiva_tetap?.kendaraan) }
        );

        return [
            {
                key: 'Aktiva',
                data: aktivaData
            },
            {
                key: 'Passiva',
                data: [
                    { key: 'Hutang Lancar', data: safeVal(passiva?.hutang_lancar) },
                    { key: 'Hutang Jangka Panjang', data: safeVal(passiva?.hutang_jangka_panjang) },
                    { key: 'Modal', data: safeVal(passiva?.modal) },
                ]
            }
        ];
    }, [data]);

    if (!data) return null;

    // Determine colors based on data presence
    const colors = [
        CHART_COLORS.COLOR_2, // Kas (Emerald)
        CHART_COLORS.COLOR_6, // Piutang (Cyan)
    ];

    // If persediaan is present in data, add its color
    const hasPersediaan = chartData[0]?.data.some(d => d.key === 'Persediaan');
    if (hasPersediaan) {
        colors.push(CHART_COLORS.COLOR_1); // Persediaan (Blue)
    }

    colors.push(
        CHART_COLORS.COLOR_10, // Tanah (Indigo)
        CHART_COLORS.COLOR_5, // Bangunan (Violet)
        CHART_COLORS.COLOR_7, // Kendaraan (Pink)
        CHART_COLORS.COLOR_9, // Hutang Lancar (Orange)
        CHART_COLORS.COLOR_4, // Hutang JP (Red)
        CHART_COLORS.COLOR_8  // Modal (Lime)
    );

    return (
        <div className={`bg-white dark:bg-sidebar-accent/10 p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm ${className}`}>
            <h3 className="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4 border-b pb-2 border-gray-200 dark:border-gray-700">
                Neraca (Aktiva vs Passiva)
            </h3>
            <div style={{ height: '350px', width: '100%' }}>
                <BarChart
                    data={chartData}
                    margins={20}
                    yAxis={
                        <LinearYAxis
                            type="value"
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
                            bar={<CustomBar />}
                        />
                    }
                />
            </div>
            <div className="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
                <div>
                    <div className="font-bold text-gray-900 dark:text-gray-100 mb-2 border-b pb-1">Aktiva</div>
                    <div className="space-y-1">
                        {chartData[0].data.map((item, index) => (
                            <div
                                key={item.key}
                                className="flex justify-start items-center gap-8 p-1 rounded hover:bg-gray-50 dark:hover:bg-sidebar-accent/10 transition-colors"
                            >
                                <div className="flex items-start gap-2 w-24 shrink-0">
                                    <div
                                        className="w-3 h-3 rounded-full flex-shrink-0 mt-0.5"
                                        style={{ backgroundColor: colors[index] }}
                                    />
                                    <span className="text-xs text-gray-600 dark:text-gray-400">
                                        {item.key}
                                    </span>
                                </div>
                                <span className="font-medium text-gray-900 dark:text-gray-100 text-left">
                                    {formatRupiah(item.data)}
                                </span>
                            </div>
                        ))}
                        <div className="flex justify-start items-center gap-8 font-bold pt-2 border-t mt-2">
                            <span className="w-24 shrink-0">Total</span>
                            <span className="text-left">{formatRupiah(data.aktiva.total_aktiva)}</span>
                        </div>
                    </div>
                </div>
                <div>
                    <div className="font-bold text-gray-900 dark:text-gray-100 mb-2 border-b pb-1">Passiva</div>
                    <div className="space-y-1">
                        {chartData[1].data.map((item, index) => (
                            <div
                                key={item.key}
                                className="flex justify-start items-center gap-8 p-1 rounded hover:bg-gray-50 dark:hover:bg-sidebar-accent/10 transition-colors"
                            >
                                <div className="flex items-start gap-2 w-32 shrink-0">
                                    <div
                                        className="w-3 h-3 rounded-full flex-shrink-0 mt-0.5"
                                        // Offset index by number of items in Aktiva
                                        style={{ backgroundColor: colors[index + chartData[0].data.length] }}
                                    />
                                    <span className="text-xs text-gray-600 dark:text-gray-400">
                                        {item.key}
                                    </span>
                                </div>
                                <span className="font-medium text-gray-900 dark:text-gray-100 text-left">
                                    {formatRupiah(item.data)}
                                </span>
                            </div>
                        ))}
                        <div className="flex justify-start items-center gap-8 font-bold pt-2 border-t mt-2">
                            <span className="w-32 shrink-0">Total</span>
                            <span className="text-left">{formatRupiah(data.passiva.total_passiva)}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
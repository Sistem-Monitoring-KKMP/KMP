import { PieChart, PieArcSeries, PieArc } from 'reaviz';
import { formatRupiah } from '@/lib/utils';
import { useMemo } from 'react';
import { CHART_COLORS } from '@/lib/chart-colors';

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
    const { aktivaChartData, passivaChartData, aktivaColors, passivaColors } = useMemo(() => {
        if (!data) return { aktivaChartData: [], passivaChartData: [], aktivaColors: [], passivaColors: [] };

        const safeVal = (val: unknown) => typeof val === 'number' ? val : 0;
        const aktiva = data.aktiva;
        const passiva = data.passiva;

        // Aktiva Data Construction
        const aData = [
            { key: 'Kas', data: safeVal(aktiva?.aktiva_lancar?.kas), color: CHART_COLORS.COLOR_2 },
            { key: 'Piutang', data: safeVal(aktiva?.aktiva_lancar?.piutang), color: CHART_COLORS.COLOR_6 },
        ];

        if (typeof aktiva?.aktiva_lancar?.persediaan === 'number') {
            aData.push({ key: 'Persediaan', data: safeVal(aktiva?.aktiva_lancar?.persediaan), color: CHART_COLORS.COLOR_1 });
        }

        aData.push(
            { key: 'Tanah', data: safeVal(aktiva?.aktiva_tetap?.tanah), color: CHART_COLORS.COLOR_10 },
            { key: 'Bangunan', data: safeVal(aktiva?.aktiva_tetap?.bangunan), color: CHART_COLORS.COLOR_5 },
            { key: 'Kendaraan', data: safeVal(aktiva?.aktiva_tetap?.kendaraan), color: CHART_COLORS.COLOR_7 }
        );

        // Passiva Data Construction
        const pData = [
            { key: 'Hutang Lancar', data: safeVal(passiva?.hutang_lancar), color: CHART_COLORS.COLOR_9 },
            { key: 'Hutang Jangka Panjang', data: safeVal(passiva?.hutang_jangka_panjang), color: CHART_COLORS.COLOR_4 },
            { key: 'Modal', data: safeVal(passiva?.modal), color: CHART_COLORS.COLOR_8 },
        ];

        return {
            aktivaChartData: aData.filter(d => d.data > 0),
            passivaChartData: pData.filter(d => d.data > 0),
            aktivaColors: aData.filter(d => d.data > 0).map(d => d.color),
            passivaColors: pData.filter(d => d.data > 0).map(d => d.color)
        };
    }, [data]);

    if (!data) return null;

    // Calculate size based on total value to visualize balance
    const maxTotal = Math.max(data.aktiva.total_aktiva, data.passiva.total_passiva);
    const safeMaxTotal = maxTotal > 0 ? maxTotal : 1;
    const maxSize = 300; // Max size in px

    // Scale size by square root of ratio to maintain area proportionality
    const aktivaSize = maxSize * Math.sqrt(data.aktiva.total_aktiva / safeMaxTotal);
    const passivaSize = maxSize * Math.sqrt(data.passiva.total_passiva / safeMaxTotal);

    return (
        <div className={`bg-white dark:bg-sidebar-accent/10 p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm ${className}`}>
            <h3 className="text-xl font-bold text-gray-900 dark:text-gray-100 mb-6 border-b pb-2 border-gray-200 dark:border-gray-700">
                Neraca (Aktiva vs Passiva)
            </h3>

            <div className="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                {/* Aktiva Chart */}
                <div className="flex flex-col items-center">
                    <h4 className="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Komposisi Aktiva</h4>
                    <div style={{ height: '300px', width: '100%', display: 'flex', justifyContent: 'center', alignItems: 'center' }}>
                        <PieChart
                            width={aktivaSize}
                            height={aktivaSize}
                            data={aktivaChartData}
                            series={
                                <PieArcSeries
                                    colorScheme={aktivaColors}
                                    arc={
                                        <PieArc
                                            style={{ stroke: CHART_COLORS.WHITE, strokeWidth: 2 }}
                                        />
                                    }
                                />
                            }
                        />
                    </div>
                </div>

                {/* Passiva Chart */}
                <div className="flex flex-col items-center">
                    <h4 className="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Komposisi Passiva</h4>
                    <div style={{ height: '300px', width: '100%', display: 'flex', justifyContent: 'center', alignItems: 'center' }}>
                        <PieChart
                            width={passivaSize}
                            height={passivaSize}
                            data={passivaChartData}
                            series={
                                <PieArcSeries
                                    colorScheme={passivaColors}
                                    arc={
                                        <PieArc
                                            style={{ stroke: CHART_COLORS.WHITE, strokeWidth: 2 }}
                                        />
                                    }
                                />
                            }
                        />
                    </div>
                </div>
            </div>

            <div className="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs">
                <div>
                    <div className="font-bold text-gray-900 dark:text-gray-100 mb-2 border-b pb-1 text-sm">Detail Aktiva</div>
                    <div className="space-y-1">
                        {aktivaChartData.map((item, index) => (
                            <div
                                key={item.key}
                                className="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1 sm:gap-2 p-1 rounded hover:bg-gray-50 dark:hover:bg-sidebar-accent/10 transition-colors"
                            >
                                <div className="flex items-center gap-2 min-w-0">
                                    <div
                                        className="w-2.5 h-2.5 rounded-full flex-shrink-0"
                                        style={{ backgroundColor: aktivaColors[index] }}
                                    />
                                    <span className="text-[10px] sm:text-xs text-gray-600 dark:text-gray-400 leading-tight truncate">
                                        {item.key}
                                    </span>
                                </div>
                                <span className="font-medium text-gray-900 dark:text-gray-100 pl-4.5 sm:pl-0 text-[10px] sm:text-xs whitespace-nowrap">
                                    {formatRupiah(item.data)}
                                </span>
                            </div>
                        ))}
                        <div className="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1 sm:gap-2 font-bold pt-2 border-t mt-2">
                            <span className="pl-4.5 text-[10px] sm:text-xs">Total</span>
                            <span className="pl-4.5 sm:pl-0 text-[10px] sm:text-xs whitespace-nowrap">{formatRupiah(data.aktiva.total_aktiva)}</span>
                        </div>
                    </div>
                </div>
                <div>
                    <div className="font-bold text-gray-900 dark:text-gray-100 mb-2 border-b pb-1 text-sm">Detail Passiva</div>
                    <div className="space-y-1">
                        {passivaChartData.map((item, index) => (
                            <div
                                key={item.key}
                                className="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1 sm:gap-2 p-1 rounded hover:bg-gray-50 dark:hover:bg-sidebar-accent/10 transition-colors"
                            >
                                <div className="flex items-center gap-2 min-w-0">
                                    <div
                                        className="w-2.5 h-2.5 rounded-full flex-shrink-0"
                                        style={{ backgroundColor: passivaColors[index] }}
                                    />
                                    <span className="text-[10px] sm:text-xs text-gray-600 dark:text-gray-400 leading-tight truncate">
                                        {item.key}
                                    </span>
                                </div>
                                <span className="font-medium text-gray-900 dark:text-gray-100 pl-4.5 sm:pl-0 text-[10px] sm:text-xs whitespace-nowrap">
                                    {formatRupiah(item.data)}
                                </span>
                            </div>
                        ))}
                        <div className="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1 sm:gap-2 font-bold pt-2 border-t mt-2">
                            <span className="pl-4.5 text-[10px] sm:text-xs">Total</span>
                            <span className="pl-4.5 sm:pl-0 text-[10px] sm:text-xs whitespace-nowrap">{formatRupiah(data.passiva.total_passiva)}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
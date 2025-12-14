import { BarChart, BarSeries, Bar, LinearYAxis, LinearYAxisTickSeries, LinearYAxisTickLabel } from 'reaviz';
import { formatRupiah } from '@/lib/utils';
import { useState, useMemo, type ComponentProps } from 'react';
import { CHART_COLORS } from '@/lib/chart-colors';

interface Neraca {
    aktiva: {
        aktiva_lancar: {
            kas: number;
            piutang: number;
            total: number;
        };
        aktiva_tetap: {
            tanah: number;
            bangunan: number;
            kendaraan: number;
            total: number;
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
    data: Neraca;
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

export default function BalanceSheetChart({ data }: Props) {
    const chartData = useMemo(() => {
        if (!data) return [];
        const safeVal = (val: unknown) => typeof val === 'number' ? val : 0;
        const aktiva = data.aktiva;
        const passiva = data.passiva;

        return [
            {
                key: 'Aktiva',
                data: [
                    { key: 'Kas', data: safeVal(aktiva?.aktiva_lancar?.kas) },
                    { key: 'Piutang', data: safeVal(aktiva?.aktiva_lancar?.piutang) },
                    { key: 'Tanah', data: safeVal(aktiva?.aktiva_tetap?.tanah) },
                    { key: 'Bangunan', data: safeVal(aktiva?.aktiva_tetap?.bangunan) },
                    { key: 'Kendaraan', data: safeVal(aktiva?.aktiva_tetap?.kendaraan) },
                ]
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

    const colors = [
        CHART_COLORS.KAS,
        CHART_COLORS.PIUTANG,
        CHART_COLORS.TANAH,
        CHART_COLORS.BANGUNAN,
        CHART_COLORS.KENDARAAN,
        CHART_COLORS.HUTANG_LANCAR,
        CHART_COLORS.HUTANG_JP,
        CHART_COLORS.MODAL,
    ];

    return (
        <div className="bg-white dark:bg-sidebar-accent/10 p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm">
            <h3 className="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4 border-b pb-2 border-gray-200 dark:border-gray-700">
                Komposisi Neraca (Agregat)
            </h3>
            <div style={{ height: '350px', width: '100%' }}>
                <BarChart
                    data={chartData}
                    yAxis={
                        <LinearYAxis
                            type="value"
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
                                className="flex justify-between items-center p-1 rounded hover:bg-gray-50 dark:hover:bg-sidebar-accent/10 transition-colors"
                            >
                                <div className="flex items-center gap-2">
                                    <div
                                        className="w-3 h-3 rounded-full flex-shrink-0"
                                        style={{ backgroundColor: colors[index] }}
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
                        <div className="flex justify-between font-bold pt-2 border-t mt-2">
                            <span>Total</span>
                            <span>{formatRupiah(data.aktiva.total_aktiva)}</span>
                        </div>
                    </div>
                </div>
                <div>
                    <div className="font-bold text-gray-900 dark:text-gray-100 mb-2 border-b pb-1">Passiva</div>
                    <div className="space-y-1">
                        {chartData[1].data.map((item, index) => (
                            <div
                                key={item.key}
                                className="flex justify-between items-center p-1 rounded hover:bg-gray-50 dark:hover:bg-sidebar-accent/10 transition-colors"
                            >
                                <div className="flex items-center gap-2">
                                    <div
                                        className="w-3 h-3 rounded-full flex-shrink-0"
                                        style={{ backgroundColor: colors[index + 5] }}
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
                        <div className="flex justify-between font-bold pt-2 border-t mt-2">
                            <span>Total</span>
                            <span>{formatRupiah(data.passiva.total_passiva)}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

import { BarChart, BarSeries, Bar } from 'reaviz';
import { formatRupiah } from '@/lib/utils';
import { useState, type ComponentProps } from 'react';
import { CHART_COLORS } from '@/lib/chart-colors';

interface Neraca {
    aktiva: {
        aktiva_lancar: {
            kas: number;
            piutang: number;
            persediaan: number;
            total: number;
        };
        aktiva_tetap: {
            tanah: number;
            bangunan: number;
            kendaraan: number;
            peralatan: number;
            total: number;
        };
        total_aktiva: number;
    };
    passiva: {
        kewajiban: {
            hutang_lancar: number;
            hutang_jangka_panjang: number;
            total: number;
        };
        ekuitas: {
            simpanan_anggota: number;
            shu_ditahan: number;
            total: number;
        };
        total_passiva: number;
    };
}

interface Props {
    data: Neraca;
}

interface CustomBarProps extends ComponentProps<typeof Bar> { }

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
    const chartData = [
        {
            key: 'Aktiva',
            data: [
                { key: 'Kas', data: data.aktiva.aktiva_lancar.kas },
                { key: 'Piutang', data: data.aktiva.aktiva_lancar.piutang },
                { key: 'Persediaan', data: data.aktiva.aktiva_lancar.persediaan },
                { key: 'Tanah', data: data.aktiva.aktiva_tetap.tanah },
                { key: 'Bangunan', data: data.aktiva.aktiva_tetap.bangunan },
                { key: 'Kendaraan', data: data.aktiva.aktiva_tetap.kendaraan },
                { key: 'Peralatan', data: data.aktiva.aktiva_tetap.peralatan },
            ]
        },
        {
            key: 'Passiva',
            data: [
                { key: 'Hutang Lancar', data: data.passiva.kewajiban.hutang_lancar },
                { key: 'Hutang Jangka Panjang', data: data.passiva.kewajiban.hutang_jangka_panjang },
                { key: 'Simpanan Anggota', data: data.passiva.ekuitas.simpanan_anggota },
                { key: 'SHU Ditahan', data: data.passiva.ekuitas.shu_ditahan },
            ]
        }
    ];

    const colors = [
        CHART_COLORS.KAS,
        CHART_COLORS.PIUTANG,
        CHART_COLORS.PERSEDIAAN,
        CHART_COLORS.TANAH,
        CHART_COLORS.BANGUNAN,
        CHART_COLORS.KENDARAAN,
        CHART_COLORS.PERALATAN,
        CHART_COLORS.HUTANG_LANCAR,
        CHART_COLORS.HUTANG_JP,
        CHART_COLORS.SIMPANAN_NERACA,
        CHART_COLORS.SHU_NERACA
    ];

    return (
        <div className="bg-white dark:bg-sidebar-accent/10 p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm">
            <h3 className="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4 border-b pb-2 border-gray-200 dark:border-gray-700">
                Komposisi Neraca (Agregat)
            </h3>
            <div style={{ height: '350px', width: '100%' }}>
                <BarChart
                    data={chartData}
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
                                        style={{ backgroundColor: colors[index + 7] }}
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

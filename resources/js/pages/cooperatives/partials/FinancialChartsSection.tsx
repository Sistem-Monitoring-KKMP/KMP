import type { ComponentProps } from 'react';
import { useState } from 'react';
import type { Cooperative } from '@/types/cooperative';
import { BarChart, BarSeries, Bar, LinearYAxis } from 'reaviz';
import { CHART_COLORS } from '@/lib/chart-colors';

interface Props {
    cooperative: Cooperative;
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

export default function FinancialChartsSection({ cooperative }: Props) {
    const keuanganData = cooperative.performa.bisnis.pertumbuhan?.akumulasi || [];

    // Extract unique years from data
    const years = Array.from(new Set(keuanganData.map(item => new Date(item.tanggal).getFullYear()))).sort((a, b) => b - a);
    const [selectedYear, setSelectedYear] = useState<number>(years[0] || new Date().getFullYear());
    const [activeMonth, setActiveMonth] = useState<string | null>(null);

    const neraca = cooperative.performa.bisnis.neraca;
    // Helper for safe access since backend might return empty arrays for objects
    const safeVal = (val: unknown) => typeof val === 'number' ? val : 0;
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    const aktiva = (neraca.aktiva as any);
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    const passiva = (neraca.passiva as any);

    const neracaData = [
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

    // Filter data by selected year
    const filteredPertumbuhanData = keuanganData.filter(item => new Date(item.tanggal).getFullYear() === selectedYear);

    const pertumbuhanData = filteredPertumbuhanData.map(item => {
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
                { key: 'SHU', data: item.shu, month }
            ]
        };
    });

    // Calculate domain for stacked chart to prevent symmetric scaling
    let maxStack = 0;
    let minStack = 0;

    pertumbuhanData.forEach(group => {
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
    let yDomain: [number, number] = [minStack * 1.1, maxStack * 1.1];

    // Ensure domain is valid
    if (isNaN(yDomain[0]) || isNaN(yDomain[1]) || (yDomain[0] === 0 && yDomain[1] === 0)) {
        yDomain = [0, 100];
    } else if (yDomain[0] === yDomain[1]) {
        yDomain = [yDomain[0] * 0.9, yDomain[1] * 1.1];
    }

    const getPertumbuhanDetail = (monthKey: string | null) => {
        if (!monthKey) {
            return pertumbuhanData.length > 0 ? pertumbuhanData[pertumbuhanData.length - 1].data : [];
        }
        return pertumbuhanData.find(item => item.key === monthKey)?.data || [];
    };

    const neracaColors = [
        CHART_COLORS.KAS,
        CHART_COLORS.PIUTANG,
        CHART_COLORS.PERSEDIAAN,
        CHART_COLORS.TANAH,
        CHART_COLORS.BANGUNAN,
        CHART_COLORS.KENDARAAN,
        CHART_COLORS.HUTANG_LANCAR,
        CHART_COLORS.HUTANG_JP,
        CHART_COLORS.MODAL
    ];

    const pertumbuhanColors = [
        CHART_COLORS.PINJAMAN,
        CHART_COLORS.INVESTASI,
        CHART_COLORS.MODAL_KERJA,
        CHART_COLORS.SIMPANAN,
        CHART_COLORS.HIBAH,
        CHART_COLORS.OMSET,
        CHART_COLORS.BIAYA_OPS,
        CHART_COLORS.SHU
    ];

    return (
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {/* Neraca Chart */}
            <div className="bg-white dark:bg-sidebar-accent/10 p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm">
                <h3 className="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4 border-b pb-2 border-gray-200 dark:border-gray-700">
                    Neraca (Aktiva vs Passiva)
                </h3>
                <div style={{ height: '350px', width: '100%' }}>
                    <BarChart
                        data={neracaData}
                        margins={20}
                        series={
                            <BarSeries
                                type="stacked"
                                colorScheme={neracaColors}
                                tooltip={null}
                            />
                        }
                    />
                </div>
                <div className="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
                    <div>
                        <div className="font-bold text-gray-900 dark:text-gray-100 mb-2 border-b pb-1">Aktiva</div>
                        <div className="space-y-1">
                            {neracaData[0].data.map((item, index) => (
                                <div key={item.key} className="flex justify-between items-center text-xs">
                                    <div className="flex items-center gap-2">
                                        <div
                                            className="w-3 h-3 rounded-full flex-shrink-0"
                                            style={{ backgroundColor: neracaColors[index] }}
                                        />
                                        <span className="text-gray-600 dark:text-gray-400">{item.key}</span>
                                    </div>
                                    <span className="font-medium text-gray-900 dark:text-gray-100">
                                        {item.data.toLocaleString('id-ID')}
                                    </span>
                                </div>
                            ))}
                            <div className="flex justify-between font-bold pt-2 border-t mt-2">
                                <span>Total</span>
                                <span>{cooperative.performa.bisnis.neraca.aktiva.total_aktiva.toLocaleString('id-ID')}</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div className="font-bold text-gray-900 dark:text-gray-100 mb-2 border-b pb-1">Passiva</div>
                        <div className="space-y-1">
                            {neracaData[1].data.map((item, index) => (
                                <div key={item.key} className="flex justify-between items-center text-xs">
                                    <div className="flex items-center gap-2">
                                        <div
                                            className="w-3 h-3 rounded-full flex-shrink-0"
                                            style={{ backgroundColor: neracaColors[index + 6] }}
                                        />
                                        <span className="text-gray-600 dark:text-gray-400">{item.key}</span>
                                    </div>
                                    <span className="font-medium text-gray-900 dark:text-gray-100">
                                        {item.data.toLocaleString('id-ID')}
                                    </span>
                                </div>
                            ))}
                            <div className="flex justify-between font-bold pt-2 border-t mt-2">
                                <span>Total</span>
                                <span>{cooperative.performa.bisnis.neraca.passiva.total_passiva.toLocaleString('id-ID')}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {/* Pertumbuhan Chart */}
            <div className="bg-white dark:bg-sidebar-accent/10 p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm">
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
                        data={pertumbuhanData}
                        margins={20}
                        yAxis={<LinearYAxis type="value" domain={yDomain} />}
                        series={
                            <BarSeries
                                type="stacked"
                                colorScheme={pertumbuhanColors}
                                tooltip={null}
                                bar={<CustomBar onActiveYearChange={setActiveMonth} chartData={pertumbuhanData} />}
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
                                <div key={index} className="flex justify-between items-center">
                                    <div className="flex items-center gap-2">
                                        <div
                                            className="w-3 h-3 rounded-full"
                                            style={{ backgroundColor: pertumbuhanColors[index % pertumbuhanColors.length] }}
                                        />
                                        <span className="text-gray-600 dark:text-gray-400 text-xs">{item.key}</span>
                                    </div>
                                    <span className="font-medium text-gray-900 dark:text-gray-100">
                                        {item.data.toLocaleString('id-ID')}
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
        </div>
    );
}

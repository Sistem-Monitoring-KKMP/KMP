import type { ComponentProps } from 'react';
import { useState } from 'react';
import type { Cooperative } from '@/types/cooperative';
import { BarChart, BarSeries, Bar } from 'reaviz';

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
            onMouseEnter={(event) => {
                rest.onMouseEnter?.(event);
                handleInteraction();
            }}
            onClick={(event) => {
                rest.onClick?.(event);
                handleInteraction();
            }}
            style={{ ...rest.style, cursor: 'pointer' }}
        />
    );
};

export default function FinancialChartsSection({ cooperative }: Props) {
    const [activeYear, setActiveYear] = useState<string | null>(null);

    const neracaData = [
        {
            key: 'Aktiva',
            data: [
                { key: 'Kas', data: cooperative.performa.bisnis.neraca.aktiva.kas },
                { key: 'Piutang', data: cooperative.performa.bisnis.neraca.aktiva.piutang },
                { key: 'Persediaan', data: cooperative.performa.bisnis.neraca.aktiva.persediaan },
                { key: 'Tanah', data: cooperative.performa.bisnis.neraca.aktiva.tanah },
                { key: 'Bangunan', data: cooperative.performa.bisnis.neraca.aktiva.bangunan },
                { key: 'Kendaraan', data: cooperative.performa.bisnis.neraca.aktiva.kendaraan },
                { key: 'Peralatan', data: cooperative.performa.bisnis.neraca.aktiva.peralatan },
            ]
        },
        {
            key: 'Passiva',
            data: [
                { key: 'Hutang Lancar', data: cooperative.performa.bisnis.neraca.passiva.hutang_lancar },
                { key: 'Hutang Jangka Panjang', data: cooperative.performa.bisnis.neraca.passiva.hutang_jangka_panjang },
                { key: 'Simpanan Anggota', data: cooperative.performa.bisnis.neraca.passiva.simpanan_anggota },
                { key: 'SHU Ditahan', data: cooperative.performa.bisnis.neraca.passiva.shu_ditahan },
            ]
        }
    ];

    const pertumbuhanData = cooperative.performa.bisnis.pertumbuhan.akumulasi.map(item => {
        const year = new Date(item.tanggal).getFullYear().toString();
        return {
            key: year,
            data: [
                { key: 'Pinjaman Bank', data: item.total_pinjaman_bank, year },
                { key: 'Investasi', data: item.total_investasi, year },
                { key: 'Modal Kerja', data: item.modal_kerja, year },
                { key: 'Simpanan Anggota', data: item.total_simpanan_anggota, year },
                { key: 'Hibah', data: item.total_hibah, year },
                { key: 'Omset', data: item.omset, year },
                { key: 'Biaya Ops', data: item.biaya_operasional, year },
                { key: 'Surplus', data: item.surplus_rugi, year }
            ]
        };
    });

    const getPertumbuhanDetail = (yearKey: string) => {
        return pertumbuhanData.find(item => item.key === yearKey)?.data || [];
    };

    const neracaColors = [
        '#0ea5e9', // Kas
        '#3b82f6', // Piutang
        '#6366f1', // Persediaan
        '#8b5cf6', // Tanah
        '#d946ef', // Bangunan
        '#ec4899', // Kendaraan
        '#f43f5e', // Peralatan
        '#f97316', // Hutang Lancar
        '#ef4444', // Hutang JP
        '#eab308', // Simpanan
        '#84cc16', // SHU
    ];

    const pertumbuhanColors = [
        '#f43f5e', // Pinjaman Bank
        '#8b5cf6', // Investasi
        '#0ea5e9', // Modal Kerja
        '#eab308', // Simpanan Anggota
        '#10b981', // Hibah
        '#3b82f6', // Omset
        '#ef4444', // Biaya Ops
        '#22c55e', // Surplus
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
                                            style={{ backgroundColor: neracaColors[index + 7] }}
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
                <h3 className="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4 border-b pb-2 border-gray-200 dark:border-gray-700">
                    Pertumbuhan Keuangan
                </h3>
                <div style={{ height: '350px', width: '100%' }}>
                    <BarChart
                        data={pertumbuhanData}
                        series={
                            <BarSeries
                                type="stacked"
                                colorScheme={pertumbuhanColors}
                                tooltip={null}
                                bar={<CustomBar onActiveYearChange={setActiveYear} chartData={pertumbuhanData} />}
                            />
                        }
                    />
                </div>
                <div className="mt-6">
                    <div className="font-bold text-gray-900 dark:text-gray-100 mb-3 border-b pb-1">
                        Detail Tahun: {activeYear || 'Pilih Tahun'}
                    </div>
                    {activeYear ? (
                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2 text-sm">
                            {getPertumbuhanDetail(activeYear).map((item, index) => (
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

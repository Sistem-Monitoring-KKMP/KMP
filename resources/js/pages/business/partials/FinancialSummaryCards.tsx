import { TrendingUp, Wallet, PiggyBank, Building2 } from 'lucide-react';
import { formatRupiah } from '@/lib/utils';

interface FinancialSummary {
    pinjaman_bank: number;
    investasi: number;
    modal_kerja: number;
    simpanan_anggota: number;
    hibah: number;
    omset: number;
    biaya_operasional: number;
    shu: number;
}

interface Props {
    data: FinancialSummary;
}

export default function FinancialSummaryCards({ data }: Props) {
    if (!data) return null;

    const cards = [
        {
            title: 'Rata-rata Omset',
            value: data.omset,
            icon: TrendingUp,
            color: 'text-blue-600',
            bg: 'bg-blue-100 dark:bg-blue-900/30',
        },
        {
            title: 'Rata-rata SHU',
            value: data.shu,
            icon: Wallet,
            color: 'text-green-600',
            bg: 'bg-green-100 dark:bg-green-900/30',
        },
        {
            title: 'Rata-rata Simpanan',
            value: data.simpanan_anggota,
            icon: PiggyBank,
            color: 'text-purple-600',
            bg: 'bg-purple-100 dark:bg-purple-900/30',
        },
        {
            title: 'Rata-rata Aset',
            value: data.modal_kerja + data.investasi, // Estimasi total aset
            icon: Building2,
            color: 'text-orange-600',
            bg: 'bg-orange-100 dark:bg-orange-900/30',
        },
    ];

    return (
        <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 lg:gap-6">
            {cards.map((card, index) => (
                <div key={index} className="bg-white dark:bg-sidebar-accent/10 p-4 lg:p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm flex items-center gap-3 lg:gap-4">
                    <div className={`p-2 lg:p-3 rounded-lg ${card.bg} shrink-0`}>
                        <card.icon className={`w-5 h-5 lg:w-6 lg:h-6 ${card.color}`} />
                    </div>
                    <div className="min-w-0 flex-1">
                        <p className="text-xs lg:text-sm text-gray-500 dark:text-gray-400 truncate" title={card.title}>{card.title}</p>
                        <h3 className="text-lg lg:text-xl font-bold text-gray-900 dark:text-gray-100 truncate" title={formatRupiah(card.value)}>
                            {formatRupiah(card.value)}
                        </h3>
                    </div>
                </div>
            ))}
        </div>
    );
}

import { TrendingUp, Wallet, PiggyBank, Building2 } from 'lucide-react';
import { formatRupiah } from '@/lib/utils';

interface FinancialSummary {
    mean_total_pinjaman_bank: number;
    mean_total_investasi: number;
    mean_total_modal_kerja: number;
    mean_total_simpanan_anggota: number;
    mean_total_hibah: number;
    mean_omset: number;
    mean_biaya_operasional: number;
    mean_sisa_hasil_usaha: number;
}

interface Props {
    data: FinancialSummary;
}

export default function FinancialSummaryCards({ data }: Props) {
    const cards = [
        {
            title: 'Rata-rata Omset',
            value: data.mean_omset,
            icon: TrendingUp,
            color: 'text-blue-600',
            bg: 'bg-blue-100 dark:bg-blue-900/30',
        },
        {
            title: 'Rata-rata SHU',
            value: data.mean_sisa_hasil_usaha,
            icon: Wallet,
            color: 'text-green-600',
            bg: 'bg-green-100 dark:bg-green-900/30',
        },
        {
            title: 'Rata-rata Simpanan',
            value: data.mean_total_simpanan_anggota,
            icon: PiggyBank,
            color: 'text-purple-600',
            bg: 'bg-purple-100 dark:bg-purple-900/30',
        },
        {
            title: 'Rata-rata Aset',
            value: data.mean_total_modal_kerja + data.mean_total_investasi, // Estimasi total aset
            icon: Building2,
            color: 'text-orange-600',
            bg: 'bg-orange-100 dark:bg-orange-900/30',
        },
    ];

    return (
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {cards.map((card, index) => (
                <div key={index} className="bg-white dark:bg-sidebar-accent/10 p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm flex items-center gap-4">
                    <div className={`p-3 rounded-lg ${card.bg}`}>
                        <card.icon className={`w-6 h-6 ${card.color}`} />
                    </div>
                    <div>
                        <p className="text-sm text-gray-500 dark:text-gray-400">{card.title}</p>
                        <h3 className="text-xl font-bold text-gray-900 dark:text-gray-100">
                            {formatRupiah(card.value)}
                        </h3>
                    </div>
                </div>
            ))}
        </div>
    );
}

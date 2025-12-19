import type { Cooperative } from '@/types/cooperative';
import NeracaChart from '@/components/charts/NeracaChart';
import FinancialGrowthChart from '@/components/charts/FinancialGrowthChart';

interface Props {
    cooperative: Cooperative;
}

export default function FinancialChartsSection({ cooperative }: Props) {
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    const neracaData = cooperative.performa.bisnis.neraca as any;
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    const pertumbuhanData = cooperative.performa.bisnis.pertumbuhan?.akumulasi as any[] || [];

    return (
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {/* Neraca Chart */}
            <NeracaChart data={neracaData} />

            {/* Pertumbuhan Chart */}
            <FinancialGrowthChart data={pertumbuhanData} />
        </div>
    );
}

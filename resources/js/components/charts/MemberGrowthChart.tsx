import ReusableTrendChart from '@/components/charts/ReusableTrendChart';
import { CHART_COLORS } from '@/lib/chart-colors';
import type { MemberTrend } from '@/types/cooperative';

interface Props {
    data: MemberTrend[];
}

export default function MemberGrowthChart({ data }: Props) {
    return (
        <ReusableTrendChart
            data={data}
            dateKey="periode"
            title="Pertumbuhan Anggota"
            height={250}
            className="h-fit"
            series={[
                { key: 'total', label: 'Total Anggota', color: CHART_COLORS.COLOR_1 },
                { key: 'aktif', label: 'Anggota Aktif', color: CHART_COLORS.COLOR_2 },
                { key: 'tidak_aktif', label: 'Tidak Aktif', color: CHART_COLORS.COLOR_4 },
            ]}
        />
    );
}

import ReusableTrendChart from '@/components/charts/ReusableTrendChart';
import { CHART_COLORS } from '@/lib/chart-colors';

interface BdiData {
    periode: string;
    avg_bdi: number;
}

interface Props {
    data: BdiData[];
}

export default function BdiTrendChart({ data }: Props) {
    return (
        <ReusableTrendChart
            data={data}
            dateKey="periode"
            title="Tren BDI (Bulanan)"
            height={250}
            series={[
                { key: 'avg_bdi', label: 'BDI', color: CHART_COLORS.COLOR_1 }
            ]}
        />
    );
}



import ReusableTrendChart from '@/components/charts/ReusableTrendChart';
import { CHART_COLORS } from '@/lib/chart-colors';
import type { BdiTrend } from '@/types/cooperative';

interface Props {
    data: BdiTrend[];
}

/**
 * BDI Trend Chart
 * 
 * Displays the monthly trend of the Business Development Index (BDI).
 * Uses the reusable trend chart component.
 */
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



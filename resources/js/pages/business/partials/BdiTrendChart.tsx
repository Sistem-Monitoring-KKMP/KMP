import { LineChart, LineSeries, Line, LinearXAxis, LinearXAxisTickSeries, LinearXAxisTickLabel } from 'reaviz';
import { useState, useMemo } from 'react';
import { CHART_COLORS } from '@/lib/chart-colors';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";

interface BdiTrend {
    tahun: string;
    score: number;
}

interface Props {
    data: BdiTrend[];
}

const months = [
    'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
];

export default function BdiTrendChart({ data }: Props) {
    // Sort years descending
    const years = useMemo(() => 
        [...data].sort((a, b) => Number(b.tahun) - Number(a.tahun)), 
    [data]);

    const [selectedYear, setSelectedYear] = useState<string>(years[0]?.tahun || new Date().getFullYear().toString());

    const chartData = useMemo(() => {
        const yearData = data.find(d => d.tahun === selectedYear);
        const baseScore = yearData ? yearData.score : 70;

        return months.map((month, index) => {
            // Generate a deterministic "random" variation for the demo
            // Using sin wave + some noise based on year and index
            const seed = Number(selectedYear) + index;
            const variation = Math.sin(seed) * 3 + Math.cos(seed * 2) * 2;
            
            return {
                key: new Date(Number(selectedYear), index, 1),
                data: Number((baseScore + variation).toFixed(1))
            };
        });
    }, [selectedYear, data]);

    return (
        <div className="bg-white dark:bg-sidebar-accent/10 p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm">
            <div className="flex items-center justify-between mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
                <h3 className="text-xl font-bold text-gray-900 dark:text-gray-100">
                    Tren BDI (Bulanan)
                </h3>
                <div className="w-32">
                    <Select value={selectedYear} onValueChange={setSelectedYear}>
                        <SelectTrigger>
                            <SelectValue placeholder="Pilih Tahun" />
                        </SelectTrigger>
                        <SelectContent>
                            {years.map((item) => (
                                <SelectItem key={item.tahun} value={item.tahun}>
                                    {item.tahun}
                                </SelectItem>
                            ))}
                        </SelectContent>
                    </Select>
                </div>
            </div>
            
            <div style={{ height: '300px', width: '100%' }}>
                <LineChart
                    data={chartData}
                    xAxis={
                        <LinearXAxis
                            type="time"
                            tickSeries={
                                <LinearXAxisTickSeries
                                    label={
                                        <LinearXAxisTickLabel
                                            format={(d) => new Date(d).toLocaleDateString('id-ID', { month: 'short' })}
                                        />
                                    }
                                />
                            }
                        />
                    }
                    series={
                        <LineSeries
                            colorScheme={[CHART_COLORS.OMSET]}
                            line={
                                <Line
                                    strokeWidth={3}
                                    style={{ filter: 'drop-shadow(0px 4px 6px rgba(59, 130, 246, 0.3))' }}
                                />
                            }
                        />
                    }
                />
            </div>
        </div>
    );
}



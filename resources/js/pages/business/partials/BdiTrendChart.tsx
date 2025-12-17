import { LineChart, LineSeries, Line, LinearXAxis, LinearXAxisTickSeries, LinearXAxisTickLabel, LinearYAxis, LinearYAxisTickSeries, LinearYAxisTickLabel } from 'reaviz';
import { useState, useMemo } from 'react';
import { CHART_COLORS } from '@/lib/chart-colors';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";

interface BdiData {
    periode: string;
    avg_bdi: number;
}

interface Props {
    data: BdiData[];
}

export default function BdiTrendChart({ data }: Props) {
    // Sort years descending
    const years = useMemo(() => {
        if (!data || data.length === 0) return [];
        const uniqueYears = Array.from(new Set(data.map(d => new Date(d.periode).getFullYear())));
        return uniqueYears.sort((a, b) => b - a).map(y => ({ tahun: y.toString() }));
    }, [data]);

    const [selectedYear, setSelectedYear] = useState<string>(years[0]?.tahun || new Date().getFullYear().toString());

    const chartData = useMemo(() => {
        if (!data) return [];
        return data
            .filter(d => new Date(d.periode).getFullYear().toString() === selectedYear)
            .map(d => ({
                key: new Date(d.periode),
                data: Number(d.avg_bdi.toFixed(1))
            }))
            .sort((a, b) => a.key.getTime() - b.key.getTime());
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
                    margins={[20, 20, 20, 10]}
                    xAxis={
                        <LinearXAxis
                            type="time"
                            tickSeries={
                                <LinearXAxisTickSeries
                                    tickValues={chartData.map(d => d.key)}
                                    label={
                                        <LinearXAxisTickLabel
                                            fontSize={12}
                                            className="font-bold text-black text-lg"
                                            format={(d) => new Date(d).toLocaleDateString('id-ID', { month: 'short' })}
                                        />
                                    }
                                />
                            }
                        />
                    }
                    yAxis={
                        <LinearYAxis
                            type="value"
                            tickSeries={
                                <LinearYAxisTickSeries
                                    label={
                                        <LinearYAxisTickLabel
                                            fontSize={12}
                                            className="font-bold text-black text-[18px]"
                                            format={(d) => d ? Number(d).toFixed(1) : '0'}
                                        />
                                    }
                                />
                            }
                        />
                    }
                    series={
                        <LineSeries
                            colorScheme={[CHART_COLORS.COLOR_1]}
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



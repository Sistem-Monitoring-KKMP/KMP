import { LineChart, LineSeries, Line, LinearXAxis, LinearXAxisTickSeries, LinearXAxisTickLabel, LinearYAxis, LinearYAxisTickSeries, LinearYAxisTickLabel } from 'reaviz';
import { useState, useMemo } from 'react';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import { CHART_COLORS } from '@/lib/chart-colors';

interface SeriesConfig {
    key: string;
    label: string;
    color?: string;
}

interface Props {
    data: any[];
    dateKey: string;
    series: SeriesConfig[];
    title: string;
    className?: string;
    height?: number;
}

export default function ReusableTrendChart({ data, dateKey, series, title, className, height = 300 }: Props) {
    // Sort years descending
    const years = useMemo(() => {
        if (!data || data.length === 0) return [];
        const uniqueYears = Array.from(new Set(data.map(d => new Date(d[dateKey]).getFullYear())));
        return uniqueYears.sort((a, b) => b - a).map(y => ({ tahun: y.toString() }));
    }, [data, dateKey]);

    const [selectedYear, setSelectedYear] = useState<string>(years[0]?.tahun || new Date().getFullYear().toString());

    const chartData = useMemo(() => {
        if (!data) return [];
        
        const filtered = data
            .filter(d => new Date(d[dateKey]).getFullYear().toString() === selectedYear)
            .sort((a, b) => new Date(a[dateKey]).getTime() - new Date(b[dateKey]).getTime());

        // If single series, use simple format
        if (series.length === 1) {
            return filtered.map(d => ({
                key: new Date(d[dateKey]),
                data: Number(d[series[0].key])
            }));
        }

        // If multiple series, use grouped format
        return series.map(s => ({
            key: s.label,
            data: filtered.map(d => ({
                key: new Date(d[dateKey]),
                data: Number(d[s.key])
            }))
        }));

    }, [selectedYear, data, dateKey, series]);

    // Determine colors
    const colorScheme = series.map((s, i) => s.color || Object.values(CHART_COLORS)[i % Object.values(CHART_COLORS).length]);

    return (
        <div className={`bg-white dark:bg-sidebar-accent/10 p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm flex flex-col ${className ?? 'h-full'}`}>
            <div className="flex items-center justify-between mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
                <h3 className="text-xl font-bold text-gray-900 dark:text-gray-100">
                    {title}
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

            <div className="flex-1 w-full" style={{ minHeight: `${height}px` }}>
                <LineChart
                    data={chartData}
                    margins={[20, 20, 20, 10]}
                    series={
                        <LineSeries
                            type={series.length > 1 ? "grouped" : undefined}
                            colorScheme={series.length > 1 ? colorScheme : undefined}
                            line={
                                <Line 
                                    strokeWidth={3} 
                                    style={series.length === 1 && series[0].color ? { stroke: series[0].color } : undefined}
                                />
                            }
                        />
                    }
                    xAxis={
                        <LinearXAxis
                            type="time"
                            tickSeries={
                                <LinearXAxisTickSeries
                                    // For grouped data, we need to extract dates from the first series
                                    tickValues={series.length > 1 
                                        ? (chartData[0]?.data?.map((d: any) => d.key) || [])
                                        : chartData.map((d: any) => d.key)
                                    }
                                    label={
                                        <LinearXAxisTickLabel
                                            fontSize={12}
                                            className="font-semibold text-black text-xs sm:text-sm"
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
                                            className="font-semibold text-black text-xs sm:text-sm"
                                            format={(d) => d ? Number(d).toFixed(1) : '0'}
                                        />
                                    }
                                />
                            }
                        />
                    }
                />
            </div>
        </div>
    );
}

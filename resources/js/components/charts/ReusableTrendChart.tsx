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
import type { SeriesConfig } from '@/types/charts';

interface Props {
    data: object[];
    dateKey: string;
    series: SeriesConfig[];
    title: string;
    className?: string;
    height?: number;
}

export default function ReusableTrendChart({ data, dateKey, series, title, className, height = 300 }: Props) {
    const getValue = (obj: object, key: string) => {
        return (obj as Record<string, unknown>)[key];
    };

    const years = useMemo(() => {
        if (!data || data.length === 0) return [];
        const uniqueYears = Array.from(new Set(data.map(d => {
            const val = getValue(d, dateKey);
            const date = new Date(val as string | number | Date);
            return isNaN(date.getTime()) ? null : date.getFullYear();
        }).filter((y): y is number => y !== null)));
        return uniqueYears.sort((a, b) => b - a).map(y => ({ tahun: y.toString() }));
    }, [data, dateKey]);

    const [userSelectedYear, setUserSelectedYear] = useState<string | null>(null);

    const selectedYear = useMemo(() => {
        if (userSelectedYear && years.some(y => y.tahun === userSelectedYear)) {
            return userSelectedYear;
        }
        return years[0]?.tahun || new Date().getFullYear().toString();
    }, [userSelectedYear, years]);

    const chartData = useMemo(() => {
        if (!data) return [];
        
        const filtered = data
            .filter(d => {
                const val = getValue(d, dateKey);
                const date = new Date(val as string | number | Date);
                return !isNaN(date.getTime()) && date.getFullYear().toString() === selectedYear;
            })
            .sort((a, b) => {
                const valA = getValue(a, dateKey);
                const valB = getValue(b, dateKey);
                return new Date(valA as string | number | Date).getTime() - new Date(valB as string | number | Date).getTime();
            });

        // If single series, use simple format
        if (series.length === 1) {
            return filtered.map(d => {
                const dateVal = getValue(d, dateKey);
                const dataVal = getValue(d, series[0].key);
                return {
                    key: new Date(dateVal as string | number | Date),
                    data: Number(dataVal)
                };
            });
        }

        // If multiple series, use grouped format
        return series.map(s => ({
            key: s.label,
            id: s.label,
            data: filtered.map(d => {
                const dateVal = getValue(d, dateKey);
                const dataVal = getValue(d, s.key);
                return {
                    key: new Date(dateVal as string | number | Date),
                    data: Number(dataVal)
                };
            })
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
                    <Select value={selectedYear} onValueChange={setUserSelectedYear}>
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

            <div className="flex-1 w-full" style={{ height: `${height}px` }}>
                <LineChart
                    height={height}
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

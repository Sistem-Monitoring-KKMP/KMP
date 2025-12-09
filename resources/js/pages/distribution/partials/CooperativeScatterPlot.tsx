import { ScatterPlot, ScatterSeries, ScatterPoint, ChartTooltip, LinearXAxis, LinearYAxis, LinearXAxisTickSeries, LinearYAxisTickSeries, LinearXAxisTickLabel, LinearYAxisTickLabel } from 'reaviz';
import { CHART_COLORS } from '@/lib/chart-colors';

interface Cooperative {
    id: number;
    nama: string;
    bdi: number;
    odi: number;
    cdi: number;
}

interface Props {
    data: Cooperative[];
}

interface ScatterPointData {
    key: number;
    data: number;
    metadata: {
        name: string;
        cdi: number;
    };
    x?: number;
    y?: number;
}

export default function CooperativeScatterPlot({ data }: Props) {
    const chartData = data.map(item => ({
        key: item.odi, // X-Axis: ODI
        data: item.bdi, // Y-Axis: BDI
        metadata: {
            name: item.nama,
            cdi: item.cdi
        }
    }));

    return (
        <div className="bg-white dark:bg-sidebar-accent/10 p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm relative">
            <div className="flex justify-between items-center mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
                <div>
                    <h3 className="text-xl font-bold text-gray-900 dark:text-gray-100">
                        Peta Sebaran Koperasi (Kuadran)
                    </h3>
                    <p className="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Sumbu X: Organizational Development Index (ODI) | Sumbu Y: Business Development Index (BDI)
                    </p>
                </div>
            </div>

            <div className="relative" style={{ height: '500px', width: '100%' }}>
                {/* Quadrant Backgrounds */}
                <div className="absolute inset-0 grid grid-cols-2 grid-rows-2 pointer-events-none opacity-10">
                    <div className="bg-red-500 border-r border-b border-gray-300"></div> {/* Top Left: Low ODI, High BDI (Quadrant II) */}
                    <div className="bg-green-500 border-b border-gray-300"></div>   {/* Top Right: High ODI, High BDI (Quadrant I) */}
                    <div className="bg-yellow-500 border-r border-gray-300"></div>  {/* Bottom Left: Low ODI, Low BDI (Quadrant III) */}
                    <div className="bg-blue-500"></div>                             {/* Bottom Right: High ODI, Low BDI (Quadrant IV) */}
                </div>

                {/* Quadrant Labels */}
                <div className="absolute top-4 right-4 text-xs font-bold text-green-600 opacity-50 pointer-events-none bg-white/50 px-2 py-1 rounded">
                    Kuadran I (Unggul)
                </div>
                <div className="absolute top-4 left-4 text-xs font-bold text-red-600 opacity-50 pointer-events-none ml-4 bg-white/50 px-2 py-1 rounded">
                    Kuadran II (Berkembang Bisnis)
                </div>
                <div className="absolute bottom-12 left-4 text-xs font-bold text-yellow-600 opacity-50 pointer-events-none ml-4 bg-white/50 px-2 py-1 rounded">
                    Kuadran III (Perlu Pembinaan)
                </div>
                <div className="absolute bottom-12 right-4 text-xs font-bold text-blue-600 opacity-50 pointer-events-none bg-white/50 px-2 py-1 rounded">
                    Kuadran IV (Berkembang Organisasi)
                </div>

                <ScatterPlot
                    data={chartData}
                    xAxis={
                        <LinearXAxis
                            type="value"
                            domain={[0, 1]}
                            tickSeries={<LinearXAxisTickSeries label={<LinearXAxisTickLabel />} />}
                        />
                    }
                    yAxis={
                        <LinearYAxis
                            type="value"
                            domain={[0, 1]}
                            tickSeries={<LinearYAxisTickSeries label={<LinearYAxisTickLabel />} />}
                        />
                    }
                    series={
                        <ScatterSeries
                            point={
                                <ScatterPoint
                                    color={CHART_COLORS.OMSET}
                                    style={{ fillOpacity: 0.6, stroke: '#fff', strokeWidth: 1.5 }}
                                    size={(d: unknown) => {
                                        // Scale CDI (0-100) to pixel size (5-25)
                                        const point = d as ScatterPointData;
                                        const cdi = point.metadata.cdi;
                                        return Math.max(5, (cdi / 1) * 25);
                                    }}
                                    tooltip={
                                        <ChartTooltip
                                            content={(d: unknown) => {
                                                const point = d as ScatterPointData;
                                                return (
                                                    <div className="bg-white dark:bg-gray-800 p-2 rounded shadow-lg border border-gray-200 dark:border-gray-700 text-xs">
                                                        <div className="font-bold text-gray-900 dark:text-gray-100 mb-1">{point.metadata.name}</div>
                                                        <div className="text-gray-600 dark:text-gray-400">CDI: <span className="font-mono font-medium text-gray-900 dark:text-gray-200">{point.metadata.cdi}</span></div>
                                                        <div className="text-gray-600 dark:text-gray-400">ODI: <span className="font-mono font-medium text-gray-900 dark:text-gray-200">{point.x}</span></div>
                                                        <div className="text-gray-600 dark:text-gray-400">BDI: <span className="font-mono font-medium text-gray-900 dark:text-gray-200">{point.y}</span></div>
                                                    </div>
                                                )
                                            }}
                                        />
                                    }
                                />
                            }
                        />
                    }
                />
            </div>
            <div className="mt-4 text-center text-xs text-gray-500">
                * Ukuran lingkaran merepresentasikan nilai Cooperative Development Index (CDI)
            </div>
        </div>
    );
}

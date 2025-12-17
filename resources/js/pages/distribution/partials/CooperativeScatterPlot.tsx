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

    // Top, Right, Bottom, Left
    const margins: [number, number, number, number] = [20, 20, 40, 50];

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
                <div
                    className="absolute grid grid-cols-2 grid-rows-2 pointer-events-none opacity-20"
                    style={{
                        top: margins[0],
                        right: margins[1],
                        bottom: margins[2],
                        left: margins[3]
                    }}
                >
                    <div className="border-r border-b border-gray-300" style={{ backgroundColor: CHART_COLORS.QUADRANT_II }}></div>
                    <div className="border-b border-gray-300" style={{ backgroundColor: CHART_COLORS.QUADRANT_I }}></div>
                    <div className="border-r border-gray-300" style={{ backgroundColor: CHART_COLORS.QUADRANT_IV }}></div>
                    <div style={{ backgroundColor: CHART_COLORS.QUADRANT_III }}></div>
                </div>

                {/* Quadrant Labels */}
                <div className="absolute top-8 right-8 text-xs font-bold opacity-80 pointer-events-none bg-white px-2 py-1 rounded z-10" style={{ color: CHART_COLORS.QUADRANT_TEXT_I }}>
                    Kuadran I (Unggul)
                </div>
                <div className="absolute top-8 left-16 text-xs font-bold opacity-80 pointer-events-none bg-white px-2 py-1 rounded z-10" style={{ color: CHART_COLORS.QUADRANT_TEXT_II }}>
                    Kuadran II (Berkembang Bisnis)
                </div>
                <div className="absolute bottom-16 left-16 text-xs font-bold opacity-80 pointer-events-none bg-white px-2 py-1 rounded z-10" style={{ color: CHART_COLORS.QUADRANT_TEXT_IV }}>
                    Kuadran IV (Perlu Pembinaan)
                </div>
                <div className="absolute bottom-16 right-8 text-xs font-bold opacity-80 pointer-events-none bg-white px-2 py-1 rounded z-10" style={{ color: CHART_COLORS.QUADRANT_TEXT_III }}>
                    Kuadran III (Berkembang Organisasi)
                </div>

                <ScatterPlot
                    data={chartData}
                    margins={margins}
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
                                    color={CHART_COLORS.COLOR_1}
                                    style={{ fillOpacity: 0.6, stroke: CHART_COLORS.WHITE, strokeWidth: 1.5 }}
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
                                                        <div className="font-bold text-gray-900 dark:text-gray-100 mb-1 max-w-[200px] whitespace-normal leading-tight">{point.metadata.name}</div>
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

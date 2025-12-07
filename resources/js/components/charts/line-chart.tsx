import { Line, LineChart, LineSeries } from 'reaviz';

type TrendItem = {
    date: Date;
    cdi: number;
    bdi: number;
    odi: number;
};

type TrendLineChartProps = {
    trend: TrendItem[];
};

export function TrendLineChart({ trend }: TrendLineChartProps) {
    const data = [
        {
            key: 'BDI',
            data: trend.map((item) => ({
                key: new Date(item.date),
                data: item.bdi,
            })),
        },
        {
            key: 'ODI',
            data: trend.map((item) => ({
                key: new Date(item.date),
                data: item.odi,
            })),
        },
        {
            key: 'CDI',
            data: trend.map((item) => ({
                key: new Date(item.date),
                data: item.cdi,
            })),
        },
    ];

    return (
        <LineChart
            id="trend-chart"
            data={data}
            height={400}
            series={
                <LineSeries
                    type="grouped"
                    line={<Line strokeWidth={4} />}
                    colorScheme="cybertron"
                />
            }
        />
    );
}
export default TrendLineChart;

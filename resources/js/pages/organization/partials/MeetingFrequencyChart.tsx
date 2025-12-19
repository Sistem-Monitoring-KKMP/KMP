import { PieChart, PieArcSeries } from 'reaviz';
import { CHART_COLORS } from '@/lib/chart-colors';

interface Meeting {
    jenis_rapat: string;
    frekuensi: {
        mingguan: number;
        dua_mingguan: number;
        bulanan: number;
        dua_bulanan: number;
        tiga_bulanan_lebih: number;
    };
}

interface Props {
    data: Meeting[];
}

export default function MeetingFrequencyChart({ data }: Props) {
    // Aggregate data across all meeting types
    const totals = {
        mingguan: 0,
        dua_mingguan: 0,
        bulanan: 0,
        dua_bulanan: 0,
        tiga_bulanan_lebih: 0
    };

    data.forEach(m => {
        totals.mingguan += m.frekuensi.mingguan;
        totals.dua_mingguan += m.frekuensi.dua_mingguan;
        totals.bulanan += m.frekuensi.bulanan;
        totals.dua_bulanan += m.frekuensi.dua_bulanan;
        totals.tiga_bulanan_lebih += m.frekuensi.tiga_bulanan_lebih;
    });

    const chartData = [
        { key: 'Mingguan', data: totals.mingguan },
        { key: '2 Mingguan', data: totals.dua_mingguan },
        { key: 'Bulanan', data: totals.bulanan },
        { key: '2 Bulanan', data: totals.dua_bulanan },
        { key: '> 3 Bulanan', data: totals.tiga_bulanan_lebih }
    ].filter(d => d.data > 0);

    const colors = [
        CHART_COLORS.COLOR_1, // Mingguan
        CHART_COLORS.COLOR_2, // 2 Mingguan
        CHART_COLORS.COLOR_3, // Bulanan
        CHART_COLORS.COLOR_4, // 2 Bulanan
        CHART_COLORS.COLOR_5  // > 3 Bulanan
    ];

    return (
        <div className="bg-white dark:bg-sidebar-accent/10 p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm">
            <h3 className="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4 border-b pb-2 border-gray-200 dark:border-gray-700">
                Frekuensi Rapat
            </h3>
            <div style={{ height: '400px', width: '100%', display: 'flex', justifyContent: 'center' }}>
                <PieChart
                    data={chartData}
                    series={
                        <PieArcSeries
                            colorScheme={colors}
                        />
                    }
                />
            </div>
            <div className="mt-4 flex flex-wrap justify-center gap-4">
                {chartData.map((item, index) => (
                    <div key={item.key} className="flex items-center gap-2">
                        <div
                            className="w-3 h-3 rounded-full"
                            style={{ backgroundColor: colors[index % colors.length] }}
                        />
                        <span className="text-sm text-gray-600 dark:text-gray-400">
                            {item.key}: <span className="font-semibold text-gray-900 dark:text-gray-100">{item.data}</span>
                        </span>
                    </div>
                ))}
            </div>
        </div>
    );
}

import type { Cooperative } from '@/types/cooperative';

interface Props {
    cooperative: Cooperative;
}

export default function PerformanceCards({ cooperative }: Props) {
    return (
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div className="bg-white dark:bg-sidebar-accent/10 p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm">
                <h3 className="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">CDI</h3>
                <div className="text-4xl font-bold text-blue-600 dark:text-blue-400">{cooperative.performa.cdi}</div>
                <p className="text-sm text-gray-500 mt-1">Cooperative Development Index</p>
            </div>
            <div className="bg-white dark:bg-sidebar-accent/10 p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm">
                <h3 className="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">BDI</h3>
                <div className="text-4xl font-bold text-green-600 dark:text-green-400">{cooperative.performa.bdi}</div>
                <p className="text-sm text-gray-500 mt-1">Business Development Index</p>
            </div>
            <div className="bg-white dark:bg-sidebar-accent/10 p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm">
                <h3 className="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">ODI</h3>
                <div className="text-4xl font-bold text-purple-600 dark:text-purple-400">{cooperative.performa.odi}</div>
                <p className="text-sm text-gray-500 mt-1">Organization Development Index</p>
            </div>
        </div>
    );
}

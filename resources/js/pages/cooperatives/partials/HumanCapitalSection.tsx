import type { Cooperative } from '@/types/cooperative';
import { PieChart } from 'reaviz';

interface Props {
    cooperative: Cooperative;
}

/**
 * Human Capital Section
 * 
 * Displays human resource statistics including:
 * - Number of active administrators (Pengurus) and supervisors (Pengawas)
 * - Total employees
 * - Member status breakdown (Active vs Inactive)
 */
export default function HumanCapitalSection({ cooperative }: Props) {
    const latestPerforma = cooperative?.performa?.[0];
    const organisasi = latestPerforma?.organisasi;
    const anggota = organisasi?.anggota;

    const anggotaData = [
        { key: 'Aktif', data: anggota?.aktif || 0 },
        { key: 'Tidak Aktif', data: anggota?.tidak_aktif || 0 },
    ];

    return (
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div className="bg-white dark:bg-sidebar-accent/10 p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm">
                <h3 className="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4 border-b pb-2 border-gray-200 dark:border-gray-700">
                    Sumber Daya Manusia
                </h3>
                <div className="grid grid-cols-2 gap-4 mb-6">
                    <div className="p-4 bg-gray-50 dark:bg-sidebar-accent/20 rounded-lg text-center">
                        <div className="text-2xl font-bold text-gray-900 dark:text-gray-100">{organisasi?.jumlah_pengurus || 0}</div>
                        <div className="text-sm text-gray-500">Pengurus Aktif</div>
                    </div>
                    <div className="p-4 bg-gray-50 dark:bg-sidebar-accent/20 rounded-lg text-center">
                        <div className="text-2xl font-bold text-gray-900 dark:text-gray-100">{organisasi?.jumlah_pengawas || 0}</div>
                        <div className="text-sm text-gray-500">Pengawas Aktif</div>
                    </div>
                    <div className="p-4 bg-gray-50 dark:bg-sidebar-accent/20 rounded-lg text-center col-span-2">
                        <div className="text-2xl font-bold text-gray-900 dark:text-gray-100">{organisasi?.jumlah_karyawan || 0}</div>
                        <div className="text-sm text-gray-500">Jumlah Karyawan</div>
                    </div>
                </div>
                <div className="space-y-2">
                    <div className="flex justify-between">
                        <span className="text-gray-600 dark:text-gray-400">Total Anggota</span>
                        <span className="font-semibold text-gray-900 dark:text-gray-100">{anggota?.total || 0}</span>
                    </div>
                    <div className="flex justify-between">
                        <span className="text-gray-600 dark:text-gray-400">Anggota Aktif</span>
                        <span className="font-semibold text-green-600 dark:text-green-400">{anggota?.aktif || 0}</span>
                    </div>
                    <div className="flex justify-between">
                        <span className="text-gray-600 dark:text-gray-400">Anggota Tidak Aktif</span>
                        <span className="font-semibold text-red-600 dark:text-red-400">{anggota?.tidak_aktif || 0}</span>
                    </div>
                </div>
            </div>
            <div className="bg-white dark:bg-sidebar-accent/10 p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm flex flex-col items-center justify-center">
                <h3 className="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4 w-full text-left">Komposisi Anggota</h3>
                <div style={{ height: '250px', width: '100%' }}>
                    <PieChart data={anggotaData} />
                </div>
            </div>
        </div>
    );
}

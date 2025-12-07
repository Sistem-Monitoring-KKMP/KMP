import type { Cooperative } from '@/types/cooperative';
import { PieChart } from 'reaviz';

interface Props {
    cooperative: Cooperative;
}

export default function HumanCapitalSection({ cooperative }: Props) {
    const anggotaData = [
        { key: 'Aktif', data: cooperative.performa.organisasi.anggota.aktif },
        { key: 'Tidak Aktif', data: cooperative.performa.organisasi.anggota.tidak_aktif },
    ];

    return (
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div className="bg-white dark:bg-sidebar-accent/10 p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm">
                <h3 className="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4 border-b pb-2 border-gray-200 dark:border-gray-700">
                    Sumber Daya Manusia
                </h3>
                <div className="grid grid-cols-2 gap-4 mb-6">
                    <div className="p-4 bg-gray-50 dark:bg-sidebar-accent/20 rounded-lg text-center">
                        <div className="text-2xl font-bold text-gray-900 dark:text-gray-100">{cooperative.performa.organisasi.jumlah_pengurus}</div>
                        <div className="text-sm text-gray-500">Pengurus Aktif</div>
                    </div>
                    <div className="p-4 bg-gray-50 dark:bg-sidebar-accent/20 rounded-lg text-center">
                        <div className="text-2xl font-bold text-gray-900 dark:text-gray-100">{cooperative.performa.organisasi.jumlah_pengawas}</div>
                        <div className="text-sm text-gray-500">Pengawas Aktif</div>
                    </div>
                    <div className="p-4 bg-gray-50 dark:bg-sidebar-accent/20 rounded-lg text-center col-span-2">
                        <div className="text-2xl font-bold text-gray-900 dark:text-gray-100">{cooperative.performa.organisasi.jumlah_karyawan}</div>
                        <div className="text-sm text-gray-500">Jumlah Karyawan</div>
                    </div>
                </div>
                <div className="space-y-2">
                    <div className="flex justify-between">
                        <span className="text-gray-600 dark:text-gray-400">Total Anggota</span>
                        <span className="font-semibold text-gray-900 dark:text-gray-100">{cooperative.performa.organisasi.anggota.total}</span>
                    </div>
                    <div className="flex justify-between">
                        <span className="text-gray-600 dark:text-gray-400">Anggota Aktif</span>
                        <span className="font-semibold text-green-600 dark:text-green-400">{cooperative.performa.organisasi.anggota.aktif}</span>
                    </div>
                    <div className="flex justify-between">
                        <span className="text-gray-600 dark:text-gray-400">Anggota Tidak Aktif</span>
                        <span className="font-semibold text-red-600 dark:text-red-400">{cooperative.performa.organisasi.anggota.tidak_aktif}</span>
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

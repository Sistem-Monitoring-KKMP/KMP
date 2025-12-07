import type { Cooperative } from '@/types/cooperative';

interface Props {
    cooperative: Cooperative;
}

export default function HeaderSection({ cooperative }: Props) {
    return (
        <div className="bg-white dark:bg-sidebar-accent/10 p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm">
            <div className="flex flex-col md:flex-row justify-between items-start gap-4">
                <div>
                    <h1 className="text-3xl font-bold text-gray-900 dark:text-gray-100">{cooperative.nama}</h1>
                    <p className="text-gray-500 dark:text-gray-400 mt-1">
                        {cooperative.lokasi.alamat}, {cooperative.lokasi.kelurahan}, {cooperative.lokasi.kecamatan}
                    </p>
                    <div className="flex flex-wrap gap-3 mt-4">
                        <span className="px-3 py-1 bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 rounded-full text-sm font-medium">
                            Tahun: {cooperative.tahun}
                        </span>
                        <span className="px-3 py-1 bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 rounded-full text-sm font-medium">
                            Status: {cooperative.status}
                        </span>
                        <span className="px-3 py-1 bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400 rounded-full text-sm font-medium">
                            BH: {cooperative.no_badan_hukum}
                        </span>
                        <span className={`px-3 py-1 rounded-full text-sm font-medium ${cooperative.has_gm ? 'bg-teal-100 text-teal-800 dark:bg-teal-900/30 dark:text-teal-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-400'}`}>
                            GM: {cooperative.has_gm ? 'Ada' : 'Tidak Ada'}
                        </span>
                    </div>
                </div>
                <div className="text-left md:text-right">
                    <div className="text-sm text-gray-500 dark:text-gray-400">Kontak</div>
                    <div className="font-medium text-gray-900 dark:text-gray-100">{cooperative.kontak}</div>
                </div>
            </div>
        </div>
    );
}

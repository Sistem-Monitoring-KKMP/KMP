import type { Cooperative } from '@/types/cooperative';

interface Props {
    cooperative: Cooperative;
}

export default function UnitUsahaSection({ cooperative }: Props) {
    return (
        <div className="grid grid-cols-1 gap-6">
            <div className="bg-white dark:bg-sidebar-accent/10 p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm">
                <h3 className="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4 border-b pb-2 border-gray-200 dark:border-gray-700">
                    Daftar Unit Usaha
                </h3>
                <div className="overflow-x-auto">
                    <table className="w-full text-sm text-left">
                        <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-sidebar-accent/20 dark:text-gray-300">
                            <tr>
                                <th className="px-4 py-3">Nama Unit</th>
                                <th className="px-4 py-3 text-right">Volume Usaha</th>
                                <th className="px-4 py-3 text-right">Investasi</th>
                                <th className="px-4 py-3 text-right">Modal Kerja</th>
                                <th className="px-4 py-3 text-right">Surplus/Rugi</th>
                                <th className="px-4 py-3 text-right">Jml SDM</th>
                                <th className="px-4 py-3 text-right">Jml Anggota</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-gray-200 dark:divide-gray-700">
                            {cooperative.unit_usaha.map((unit, index) => (
                                <tr key={index} className="hover:bg-gray-50 dark:hover:bg-sidebar-accent/5">
                                    <td className="px-4 py-3 font-medium text-gray-900 dark:text-gray-100">{unit.nama}</td>
                                    <td className="px-4 py-3 text-right">Rp {unit.volume_usaha.toLocaleString('id-ID')}</td>
                                    <td className="px-4 py-3 text-right">Rp {unit.investasi.toLocaleString('id-ID')}</td>
                                    <td className="px-4 py-3 text-right">Rp {unit.modal_kerja.toLocaleString('id-ID')}</td>
                                    <td className="px-4 py-3 text-right">Rp {unit.surplus_rugi.toLocaleString('id-ID')}</td>
                                    <td className="px-4 py-3 text-right">{unit.jumlah_sdm}</td>
                                    <td className="px-4 py-3 text-right">{unit.jumlah_anggota}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    );
}

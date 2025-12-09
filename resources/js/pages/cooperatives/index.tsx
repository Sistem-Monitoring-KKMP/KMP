import { useState, useMemo, useEffect } from 'react';
import AppLayout from '@/layouts/app-layout';
import { Head, Link } from '@inertiajs/react';
import { type BreadcrumbItem } from '@/types';
import cooperativesData from '@/dummyData/cooperatives.json';
import { Input } from '@/components/ui/input';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Daftar Koperasi',
        href: '/cooperatives',
    },
];

export default function KoperasiList({cooperatives}) {
        useEffect(() => {
            console.log(cooperatives);
        }, [cooperatives]);

    const [search, setSearch] = useState('');

    const filteredCooperatives = useMemo(() => {
        if (!search) return cooperatives;
        const lowerSearch = search.toLowerCase();
        return cooperatives.filter(item =>
            item.nama.toLowerCase().includes(lowerSearch) ||
            item.alamat.toLowerCase().includes(lowerSearch)
        );
    }, [search]);

    const getStatusColor = (status: string) => {
        switch (status.toLowerCase()) {
            case 'aktif':
                return 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400';
            case 'tidak aktif':
            case 'tidakaktif':
                return 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';
            case 'pembentukan':
                return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400';
            default:
                return 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-400';
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Daftar Koperasi" />

            <div className="p-6">
                <div className="flex justify-between items-center mb-6">
                    <div>
                        <h1 className="text-2xl font-bold text-gray-900 dark:text-gray-100">Daftar Koperasi</h1>
                        <p className="text-sm text-gray-500 dark:text-gray-400">
                            Total {filteredCooperatives.length} koperasi terdaftar
                        </p>
                    </div>
                    <div className="w-72">
                        <Input
                            placeholder="Cari nama atau alamat..."
                            value={search}
                            onChange={(e) => setSearch(e.target.value)}
                            className="bg-white dark:bg-sidebar-accent/10"
                        />
                    </div>
                </div>

                <div className="bg-white dark:bg-sidebar-accent/10 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border overflow-hidden shadow-sm">
                    <div className="overflow-x-auto">
                        <table className="w-full text-sm text-left">
                            <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-sidebar-accent/20 dark:text-gray-300 border-b border-sidebar-border/70 dark:border-sidebar-border">
                                <tr>
                                    <th className="px-6 py-3 font-medium">Nama Koperasi</th>
                                    <th className="px-6 py-3 font-medium">Alamat</th>
                                    <th className="px-6 py-3 font-medium">Tahun</th>
                                    <th className="px-6 py-3 font-medium">Status</th>
                                    <th className="px-6 py-3 font-medium text-center">CDI</th>
                                    <th className="px-6 py-3 font-medium text-center">BDI</th>
                                    <th className="px-6 py-3 font-medium text-center">ODI</th>
                                    <th className="px-6 py-3 font-medium text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-sidebar-border/70 dark:divide-sidebar-border">
                                {filteredCooperatives.length > 0 ? (
                                    filteredCooperatives.map((koperasi) => (
                                        <tr key={koperasi.id} className="hover:bg-gray-50 dark:hover:bg-sidebar-accent/5 transition-colors">
                                            <td className="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">
                                                {koperasi.nama}
                                            </td>
                                            <td className="px-6 py-4 text-gray-500 dark:text-gray-400 max-w-xs truncate">
                                                {koperasi.alamat}
                                            </td>
                                            <td className="px-6 py-4 text-gray-500 dark:text-gray-400">
                                                {koperasi.tahun}
                                            </td>
                                            <td className="px-6 py-4">
                                                <span className={`px-2.5 py-0.5 rounded-full text-xs font-medium ${getStatusColor(koperasi.status)}`}>
                                                    {koperasi.status}
                                                </span>
                                            </td>
                                            <td className="px-6 py-4 text-center font-semibold text-blue-600 dark:text-blue-400">
                                                {koperasi.cdi}
                                            </td>
                                            <td className="px-6 py-4 text-center font-semibold text-gray-700 dark:text-gray-300">
                                                {koperasi.bdi}
                                            </td>
                                            <td className="px-6 py-4 text-center font-semibold text-gray-700 dark:text-gray-300">
                                                {koperasi.odi}
                                            </td>
                                            <td className="px-6 py-4 text-right">
                                                <Link
                                                    href={`/cooperatives/${koperasi.id}`}
                                                    className="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium text-sm"
                                                >
                                                    Detail
                                                </Link>
                                            </td>
                                        </tr>
                                    ))
                                ) : (
                                    <tr>
                                        <td colSpan={8} className="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                            Tidak ada data koperasi yang ditemukan.
                                        </td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}

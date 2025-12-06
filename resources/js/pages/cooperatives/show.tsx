import { Head, Link } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import cooperativeDetailsData from '@/dummyData/cooperative-detail.json';
import { BarChart, PieChart, RadarChart, RadialAreaSeries } from 'reaviz';

interface UnitUsaha {
    nama: string;
    volume_usaha: number;
    investasi: number;
    modal_kerja: number;
    surplus_rugi: number;
    jumlah_sdm: number;
    jumlah_anggota: number;
}

interface PrinsipKoperasi {
    key: string;
    data: number;
}

interface Anggota {
    total: number;
    aktif: number;
    tidak_aktif: number;
}

interface Organisasi {
    jumlah_pengurus: number;
    jumlah_pengawas: number;
    jumlah_karyawan: number;
    anggota: Anggota;
    keaktifan_pengurus: number;
    efektivitas_pengendalian: number;
    kunjungan_eksternal: number;
}

interface Bisnis {
    simpanan_bersih: number;
    partisipasi_anggota: number;
    total_penjualan: number;
    pertumbuhan_penjualan: number;
}

interface Performa {
    periode: string;
    cdi: number;
    bdi: number;
    odi: number;
    kuadrant: number;
    organisasi: Organisasi;
    bisnis: Bisnis;
}

interface Lokasi {
    alamat: string;
    kecamatan: string;
    kelurahan: string;
    latitude: number;
    longitude: number;
}

interface Cooperative {
    id: number;
    nama: string;
    kontak: string;
    no_badan_hukum: string;
    tahun: number;
    status: string;
    has_gm: boolean;
    lokasi: Lokasi;
    performa: Performa;
    unit_usaha: UnitUsaha[];
    prinsip_koperasi: PrinsipKoperasi[];
}

const cooperativeDetails = cooperativeDetailsData as unknown as Cooperative[];

interface Props {
    id: string;
}

export default function CooperativeShow({ id }: Props) {
    const cooperative = cooperativeDetails.find((c) => c.id === Number(id));

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Daftar Koperasi',
            href: '/cooperatives',
        },
        {
            title: cooperative ? cooperative.nama : 'Detail Koperasi',
            href: `/cooperatives/${id}`,
        },
    ];

    if (!cooperative) {
        return (
            <AppLayout breadcrumbs={breadcrumbs}>
                <Head title="Koperasi Tidak Ditemukan" />
                <div className="p-6 text-center">
                    <h1 className="text-2xl font-bold text-red-600">Koperasi tidak ditemukan</h1>
                    <Link href="/cooperatives" className="text-blue-600 hover:underline mt-4 block">
                        Kembali ke Daftar
                    </Link>
                </div>
            </AppLayout>
        );
    }

    // Data for Visualizations
    const anggotaData = [
        { key: 'Aktif', data: cooperative.performa.organisasi.anggota.aktif },
        { key: 'Tidak Aktif', data: cooperative.performa.organisasi.anggota.tidak_aktif },
    ];

    const unitUsahaData = cooperative.unit_usaha.map((unit) => ({
        key: unit.nama,
        data: unit.volume_usaha,
    }));

    const prinsipData = [
        {
            key: 'Maksimal',
            data: cooperative.prinsip_koperasi.map((p) => ({ key: p.key, data: 5 })),
        },
        {
            key: 'Skor',
            data: cooperative.prinsip_koperasi,
        },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={cooperative.nama} />
            <div className="p-6 space-y-6">
                {/* Header Section */}
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

                {/* Performance Cards */}
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

                {/* Human Capital Section */}
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

                {/* Prinsip Koperasi Section */}
                <div className="bg-white dark:bg-sidebar-accent/10 p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm">
                    <h3 className="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4 border-b pb-2 border-gray-200 dark:border-gray-700">
                        Skor Prinsip Koperasi
                    </h3>
                    <div style={{ height: '300px', width: '100%' }}>
                        <RadarChart
                            data={prinsipData}
                            series={<RadialAreaSeries colorScheme={['transparent', '#2563eb']} />}
                        />
                    </div>
                </div>

                {/* Unit Usaha Section */}
                <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div className="lg:col-span-2 bg-white dark:bg-sidebar-accent/10 p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm">
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
                    <div className="bg-white dark:bg-sidebar-accent/10 p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm">
                        <h3 className="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Volume Usaha per Unit</h3>
                        <div style={{ height: '250px', width: '100%' }}>
                            <BarChart data={unitUsahaData} />
                        </div>
                    </div>
                </div>

                {/* Financial Stats (Existing) */}
                <div className="bg-white dark:bg-sidebar-accent/10 p-6 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border shadow-sm">
                    <h3 className="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4 border-b pb-2 border-gray-200 dark:border-gray-700">
                        Performa Bisnis & Keuangan
                    </h3>
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div className="p-4 bg-blue-50 dark:bg-blue-900/10 rounded-lg border border-blue-100 dark:border-blue-800">
                            <div className="text-sm text-blue-600 dark:text-blue-400 mb-1">Total Penjualan</div>
                            <div className="text-xl font-bold text-gray-900 dark:text-gray-100">
                                Rp {cooperative.performa.bisnis.total_penjualan.toLocaleString('id-ID')}
                            </div>
                        </div>
                        <div className="p-4 bg-green-50 dark:bg-green-900/10 rounded-lg border border-green-100 dark:border-green-800">
                            <div className="text-sm text-green-600 dark:text-green-400 mb-1">Simpanan Bersih</div>
                            <div className="text-xl font-bold text-gray-900 dark:text-gray-100">
                                Rp {cooperative.performa.bisnis.simpanan_bersih.toLocaleString('id-ID')}
                            </div>
                        </div>
                        <div className="p-4 bg-purple-50 dark:bg-purple-900/10 rounded-lg border border-purple-100 dark:border-purple-800">
                            <div className="text-sm text-purple-600 dark:text-purple-400 mb-1">Partisipasi Anggota</div>
                            <div className="text-xl font-bold text-gray-900 dark:text-gray-100">
                                {(cooperative.performa.bisnis.partisipasi_anggota * 100).toFixed(0)}%
                            </div>
                        </div>
                        <div className="p-4 bg-orange-50 dark:bg-orange-900/10 rounded-lg border border-orange-100 dark:border-orange-800">
                            <div className="text-sm text-orange-600 dark:text-orange-400 mb-1">Pertumbuhan</div>
                            <div className="text-xl font-bold text-gray-900 dark:text-gray-100">
                                +{(cooperative.performa.bisnis.pertumbuhan_penjualan * 100).toFixed(1)}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}

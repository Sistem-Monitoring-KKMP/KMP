import type { Cooperative } from '@/types/cooperative';
import CooperativePrinciplesChart from '@/components/charts/CooperativePrinciplesChart';

interface Props {
    cooperative: Cooperative;
}

export default function PrinsipKoperasiSection({ cooperative }: Props) {
    const prinsipList = [
        { key: 'Keanggotaan Sukarela', data: cooperative.prinsip_koperasi.sukarela_terbuka },
        { key: 'Pengendalian Demokratis', data: cooperative.prinsip_koperasi.demokratis },
        { key: 'Partisipasi Ekonomi', data: cooperative.prinsip_koperasi.ekonomi },
        { key: 'Otonomi', data: cooperative.prinsip_koperasi.kemandirian },
        { key: 'Pendidikan', data: cooperative.prinsip_koperasi.pendidikan },
        { key: 'Kerjasama', data: cooperative.prinsip_koperasi.kerja_sama },
        { key: 'Kepedulian Komunitas', data: cooperative.prinsip_koperasi.kepedulian },
    ];

    return (
        <CooperativePrinciplesChart
            data={prinsipList}
            title="Skor Prinsip Koperasi"
        />
    );
}

<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;

class KeuanganService
{
    
    public function getAllKeuangan(): array
    {
        $rows = DB::table('keuangan as k')
            ->join('performa_bisnis as pb', 'pb.id', '=', 'k.performa_bisnis_id')
            ->join('performa as p', 'p.id', '=', 'pb.performa_id') // ✅ SUMBER PERIODE
            ->selectRaw('
                DATE(p.periode) as periode,

                ROUND(AVG(k.omset), 0)             as omset,
                ROUND(AVG(k.modal_kerja), 0)      as modal_kerja,
                ROUND(AVG(k.investasi), 0)        as investasi,
                ROUND(AVG(k.simpanan_anggota), 0) as simpanan_anggota,
                ROUND(AVG(k.pinjaman_bank), 0)    as pinjaman_bank,
                ROUND(AVG(k.hibah), 0)            as hibah,
                ROUND(AVG(k.operasional), 0)      as biaya_operasional,
                ROUND(AVG(k.surplus), 0)          as shu
            ')
            ->groupByRaw('DATE(p.periode)')
            ->orderByRaw('DATE(p.periode) ASC')
            ->get();

        return $rows->map(function ($row) {
            return [
                'tanggal'             => $row->periode, 
                'omset'             => (int) $row->omset,
                'modal_kerja'       => (int) $row->modal_kerja,
                'investasi'         => (int) $row->investasi,
                'simpanan_anggota'  => (int) $row->simpanan_anggota,
                'pinjaman_bank'     => (int) $row->pinjaman_bank,
                'hibah'             => (int) $row->hibah,
                'biaya_operasional' => (int) $row->biaya_operasional,
                'shu'               => (int) $row->shu,
            ];
        })->toArray();
    }

    public function getKeuangan(int $koperasiId): array
    {
        $rows = DB::table('keuangan as k')
            ->join('performa_bisnis as pb', 'pb.id', '=', 'k.performa_bisnis_id')
            ->join('performa as p', 'p.id', '=', 'pb.performa_id')

            //  Filter hanya 1 koperasi
            ->where('p.koperasi_id', $koperasiId)

            ->selectRaw('
                DATE(p.periode) as periode,

                k.omset,
                k.modal_kerja,
                k.investasi,
                k.simpanan_anggota,
                k.pinjaman_bank,
                k.hibah,
                k.operasional as biaya_operasional,
                k.surplus as shu
            ')

            ->orderByRaw('DATE(p.periode) ASC')
            ->get();

        return $rows->map(function ($row) {
            return [
                'tanggal'             => (string) $row->periode, 
                'omset'             => (int) $row->omset,
                'modal_kerja'       => (int) $row->modal_kerja,
                'investasi'         => (int) $row->investasi,
                'simpanan_anggota'  => (int) $row->simpanan_anggota,
                'pinjaman_bank'     => (int) $row->pinjaman_bank,
                'hibah'             => (int) $row->hibah,
                'biaya_operasional' => (int) $row->biaya_operasional,
                'shu'               => (int) $row->shu,
            ];
        })->toArray();
    }
}

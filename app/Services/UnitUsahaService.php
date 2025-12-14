<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class UnitUsahaService
{
    public function getUnitUsaha(int $koperasiId): array
    {
        
        $latestPerforma = DB::table('performa')
            ->where('koperasi_id', $koperasiId)
            ->orderByDesc('periode')
            ->first();

        if (!$latestPerforma) {
            return [];
        }

        $performaBisnis = DB::table('performa_bisnis')
            ->where('performa_id', $latestPerforma->id)
            ->first();

        if (!$performaBisnis) {
            return [];
        }

        $units = DB::table('unit_usaha')
            ->where('performa_bisnis_id', $performaBisnis->id)
            ->get();

    
        return $units->map(function ($item) {
            return [
                'nama'            => $item->unit ?? '-',
                'volume_usaha'    => (int) ($item->volume_usaha ?? 0),
                'investasi'       => (int) ($item->investasi ?? 0),
                'modal_kerja'     => (int) ($item->model_kerja ?? 0), // mengikuti schema Anda
                'surplus_rugi'    => (int) ($item->surplus ?? 0),
                'jumlah_sdm'      => (int) ($item->jumlah_sdm ?? 0),
                'jumlah_anggota'  => (int) ($item->jumlah_anggota ?? 0),
            ];
        })->toArray();
    }
}

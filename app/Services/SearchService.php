<?php

namespace App\Services;

use app\DTO\FilterDTO;
use App\Models\Koperasi;

class SearchService {
    public function filterCooperatives(FilterDTO $filter): array
    {
        // Implement filtering logic based on the FilterDTO properties
          $query = Koperasi::query()
                  ->select([
                      'koperasi.id',
                      'koperasi.nama',
                      'koperasi.tahun',
                      'po.status',
                      'p.cdi',
                      'p.bdi',
                      'p.odi',
                      'p.kuadrant',
                      'l.alamat',
                  ])
                  ->leftJoin('lokasi as l', 'l.koperasi_id', '=', 'koperasi.id')
                  ->leftJoin('kecamatan as kec', 'kec.id', '=', 'l.kecamatan_id')
                  ->leftJoin('kelurahan as kel', 'kel.id', '=', 'l.kelurahan_id')

                  // JOIN ke performa terakhir per koperasi
                  ->leftJoin('performa as p', function ($join) {
                      $join->on('p.koperasi_id', '=', 'koperasi.id')
                          ->whereRaw('p.periode = (
                              SELECT MAX(p2.periode)
                              FROM performa p2
                              WHERE p2.koperasi_id = koperasi.id
                          )');
                  })
                  ->leftJoin('performa_organisasi as po', 'po.performa_id', '=', 'p.id');


          if ($filter->kecamatan) {
              $query->where('l.kecamatan_id', $filter->kecamatan);
          }
          if ($filter->kelurahan) {
              $query->where('l.kelurahan_id', $filter->kelurahan);
          }
          if ($filter->kuadran) {
              $query->where('p.kuadrant', $filter->kuadran);
          }
          if ($filter->status) {
              $query->where('status', $filter->status);
          }
        

        return $query->get()->toArray();
    }

    
}
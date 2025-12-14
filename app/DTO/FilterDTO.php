<?php
namespace App\DTO;

use App\Models\Kecamatan;

class FilterDTO 
{
    public function __construct(
        public ?string $kecamatan,
        public ?string $kelurahan,
        public ?string $kuadran,
        public ?string $status,
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            kecamatan: $request->input('kecamatan'),
            kelurahan: $request->input('kelurahan'),
            kuadran: $request->input('kuadran'),
            status: $request->input('status'),
        );
    }
}

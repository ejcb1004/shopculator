<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ProductsExport implements FromQuery, WithStrictNullComparison
{
    use Exportable;

    public function __construct(string $market_id)
    {
        $this->market_id = $market_id;
    }

    public function query()
    {
        return Product::query()->where('market_id', $this->market_id);
    }
}

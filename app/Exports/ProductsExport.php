<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ProductsExport implements FromQuery, WithStrictNullComparison, WithHeadings
{
    use Exportable;

    public function __construct(string $market_id)
    {
        $this->market_id = $market_id;
    }

    public function headings(): array
    {
        return [
            'product_id',
            'market_id',
            'subcategory_id', 
            'product_name', 
            'price',
            'image_path',
            'is_deleted'
        ];
    }

    public function map($row): array
    {
        return [
            $row->product_id,
            $row->market_id,
            $row->subcategory_id,
            $row->product_name,
            $row->price,
            $row->image_path,
            $row->is_deleted
        ];
    }

    public function query()
    {
        return Product::query()
        ->select('product_id', 'market_id', 'subcategory_id', 'product_name', 'price', 'image_path', 'is_deleted')
        ->where('market_id', $this->market_id);
    }
}

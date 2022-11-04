<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ProductsTemplateExport implements FromCollection, WithStrictNullComparison, WithHeadings
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

    public function collection()
    {
        return new Collection([]);
    }
}


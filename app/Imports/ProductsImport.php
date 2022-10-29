<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpsertColumns;
use Maatwebsite\Excel\Concerns\WithUpserts;

class ProductsImport implements ToModel, WithBatchInserts, WithUpserts, WithUpsertColumns, WithHeadingRow
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'product_id' => $row['product_id'],
            'market_id' => $row['market_id'],
            'subcategory_id' => $row['subcategory_id'],
            'product_name' => $row['product_name'],
            'price' => $row['price'],
            'image_path' => $row['image_path'],
            'is_deleted' => $row['is_deleted']
        ]);
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function uniqueBy()
    {
        return 'product_id';
    }

    public function upsertColumns()
    {
        return ['product_name', 'subcategory_id', 'price', 'image_path', 'is_deleted'];
    }
}

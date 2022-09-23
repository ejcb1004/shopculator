<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithUpsertColumns;
use Maatwebsite\Excel\Concerns\WithUpserts;

class ProductsImport implements ToModel, WithBatchInserts, WithUpserts, WithUpsertColumns
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
            'product_id' => $row[1],
            'market_id' => $row[2],
            'subcategory_id' => $row[3],
            'product_name' => $row[4],
            'price' => $row[5],
            'image_path' => $row[6],
            'is_deleted' => $row[7]
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
        return ['product_name', 'price', 'image_path', 'is_deleted'];
    }
}

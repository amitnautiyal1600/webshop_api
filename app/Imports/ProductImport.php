<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class ProductImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {  
        $is_product_exist =  Product::where('product_name', $row['productname'])->exists();
        if(!$is_product_exist) {
            return new Product([
                "product_name" => $row['productname'],
                "product_price" => $row['price'],
            ]);
        }
    }


     public function batchSize(): int
    {
        return 800;
    }

    public function chunkSize(): int
    {
        return 800;
    }

}

<?php

namespace App\Imports;

use App\Models\inventory\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithUpserts;

HeadingRowFormatter::default('none');

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (!isset($row['Nombre']) || !isset($row['Referencia']) || !isset($row['Stock'])){
            return null;
        }
        if (!isset($row['Impuesto IVA'])){
            $tax = 0;
        }else{
            $tax = $row['Impuesto IVA'];
        }
        if (!isset($row['Descuento'])){
            $discount = 0;
        }else{
            $discount = $row['Descuento'];
        }
        if (!isset($row['Costo'])){
            $cost = 0;
        }else{
            $cost = $row['Costo'];
        }
        if (!isset($row['Precio'])){
            $price = 0;
            $price_total = 0;
        }else{
            $price = $row['Precio'];
            $price_total = $price - ($price * $discount / 100);
        }
        $name = $row['Nombre'];
        $description = $row['Descripción'];
        $applications = $row['Aplicación'];
        $reference = $row['Referencia'];
        $stock = $row['Stock'];
        $stockMin = $row['Stock minimo'];
        $original = $row['Original']; 
        $status = $row['Estado'];
        $data = Product::latest('id')->first();
        if ($data){
            $code = $data->id + 1;
        }else{
            $code = 1;
        }
        if (in_array($original, ['no', 'No', 'NO', 'nO'])){
            $originalF = 0;
        }else{
            $originalF = 1;
        }
        if (in_array($status, ['SIN STOCK', 'Sin stock', 'sin stock', 'Sin Stock'])){
            $statusF = 'out-stock';
        }else if(in_array($status, ['BAJO STOCK', 'Bajo stock', 'bajo stock', 'Bajo Stock'])){
            $statusF = 'low-stock';
        }else{
            $statusF = 'in-stock';
        }


        $product = Product::where('reference', $row['Referencia'])->first();
        if ($product) {
            $product->update([
                'name' => $name,
                'description' => $description,
                'applications' => $applications,
                'stock' => $stock,
                'status' => $statusF,
                'original' => $originalF,
                'stockMin' => $stockMin,
                'cost' => $cost,
                'price' => $price,
                'tax' => $tax,
                'discount' => $discount,
                'price_total' => $price_total
            ]);

            return null;
        }

        return new Product([
            'code' => $code,
            'name' => $name,
            'description' => $description,
            'applications' => $applications,
            'reference' => $reference,
            'stock' => $stock,
            'status' => $statusF,
            'original' => $originalF,
            'stockMin' => $stockMin,
            'cost' => $cost,
            'price' => $price,
            'tax' => $tax,
            'discount' => $discount,
            'price_total' => $price_total
        ]);
    }

}

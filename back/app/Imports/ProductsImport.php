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

    private $productsNoSaved = [];
    private $rows = 0;

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

        $discount = @$row['Descuento'] ?? 0;
        $tax = @$row['Impuesto IVA'] ?? 0;
        $cost = @$row['Costo'] ?? 0;

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
        $code = ($data->id ?? 0) + 1; 

        $originalF = (in_array($original, ['no', 'No', 'NO', 'nO'])) ? 0 : 1;

        if (in_array($status, ['SIN STOCK', 'Sin stock', 'sin stock', 'Sin Stock'])){
            $statusF = 'out-stock';
        }else if(in_array($status, ['BAJO STOCK', 'Bajo stock', 'bajo stock', 'Bajo Stock'])){
            $statusF = 'low-stock';
        }else{
            $statusF = 'in-stock';
        }

        $product = Product::where('reference', $row['Referencia'])->first();
        if ($product) {
            $this->productsNoSaved[] = $row;
            return null;
        }

        ++$this->rows;

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

    public function getProductsNoSaved(): Object | Array
    {
        return $this->productsNoSaved;
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }

}

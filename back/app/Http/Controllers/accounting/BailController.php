<?php

namespace App\Http\Controllers\accounting;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\accounting\Bail;
use App\Models\accounting\Sale;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class BailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        $page = $request->page ? $request->page : 1;
        $limit = $request->limit ? $request->limit : 10;
        $term = $request->term;
        $sale = $request->sale;

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $data = Bail::select('bails.*')
            ->where('bails.id_sale', $sale)
            ->with(['sale','paymentMethod:id,name'])
            ->where(function ($query) use ($term) {
                $query->where('price', 'like', "%$term%");
            })->orderBy('id', 'DESC')->paginate($limit);

        $total_bails = Bail::select('bails.*')->where('bails.id_sale', $sale)->sum('bails.price');

        return ResponseHelper::GetTwo($data,$total_bails);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $data = Bail::create([
                'id_sale' => $request->input('id_sale'),
                'id_payment_method' => $request->input('id_payment_method'),
                'price' => $request->input('price')
            ]);

            $this->updateBailsSale($data);

            return ResponseHelper::CreateOrUpdate($data, 'Abono creado correctamente');
        } catch (\Throwable $th) {
            return ResponseHelper::Error($th, 'El abono no pudo ser creada');
        }
    }

    private function updateBailsSale($bail) {
        $bails = $this->getBailsTotalSale($bail->id_sale);
        $sale = Sale::find($bail->id_sale);
        if($bails == $sale->total) $sale->update(['status' => 1]);
        $sale->update([ 'total_bails' => $bails ]);
    }

    private function getBailsTotalSale(Int $idSale): string {
        return Bail::where('id_sale', $idSale)->sum('price');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

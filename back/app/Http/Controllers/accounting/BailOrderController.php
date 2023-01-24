<?php

namespace App\Http\Controllers\accounting;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\accounting\BailOrder;
use App\Models\accounting\Order;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class BailOrderController extends Controller
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
        $order = $request->order;

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $data = BailOrder::select('bails_orders.*')
            ->where('bails.id_order', $order)
            ->with(['order','paymentMethod:id,name'])
            ->where(function ($query) use ($term) {
                $query->where('price', 'like', "%$term%");
            })->orderBy('id', 'DESC')->paginate($limit);

        $total_bails = BailOrder::select('bails.*')->where('bails.id_order', $order)->sum('bails.price');

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
            $data = BailOrder::create([
                'id_order' => $request->input('id_order'),
                'id_payment_method' => $request->input('id_payment_method'),
                'price' => $request->input('price')
            ]);

            $this->updateBailsOrder($data);

            return ResponseHelper::CreateOrUpdate($data, 'Abono creado correctamente');
        } catch (\Throwable $th) {
            return ResponseHelper::Error($th, 'El abono no pudo ser creada');
        }
    }

    private function updateBailsOrder($bail) {
        $bails = $this->getBailsTotalOrder($bail->id_order);
        $order = Order::find($bail->id_order);
        if($bails == $order->total) $order->update(['payment_status' => 1]);
        $order->update([ 'total_bails' => $bails ]);
    }

    private function getBailsTotalOrder(Int $idOrder): string {
        return BailOrder::where('id_order', $idOrder)->sum('price');
    }
}

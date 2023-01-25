<?php
namespace App\Http\Controllers\accounting;

use Illuminate\Http\Request;
use App\Models\accounting\Order;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use App\helpers\ResponseHelper;
use App\Models\accounting\BailOrder;
use Carbon\Carbon;

class OrderController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        $page = $request->get('page') ? $request->get('page') : 1;
        $limit = $request->get('limit') ? $request->get('limit') : 10;
        $term = $request->get('term');

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $data = Order::with(['provider' => function ($query) { 
            $query->select('id','full_name','nit');
        },'paymentMethod:id,name'])
        ->where(function ($query) use ($term) {
            $query->where('reference', 'like', "%$term%");
            $query->orWhere('payment_status', 'like', "%$term%");
        })->orderBy('id', 'DESC')->paginate($limit);

        return ResponseHelper::Get($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $due_date = Carbon::parse($request['due_date'])->format('Y-m-d');
        $status = @$request->payment_status;

        try {
            $data = Order::create([
                'reference' => $request->input('reference'),
                'id_provider' => $request->input('id_provider'),
                'payment_status' => $request->input('payment_status'),
                'id_payment_method' => $request->input('id_payment_method'),
                'due_date' => $due_date,
                'total_bails' => $request->input('total_bails'),
                'subtotal' => $request->input('total'),
                'tax' => $request->input('tax'),
                'total' => $request->input('total'),
                'observations' => $request->input('observations'),
            ]);

            if($status == 2) $this->createBail(@$request->all(), $data);

            return ResponseHelper::CreateOrUpdate($data, 'Orden creada correctamente');
        } catch (\Throwable $th) {
            return ResponseHelper::Error($th, 'La orden no pudo ser creada');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Order::with('provider')->find($id);

        if (!$data) {
            return ResponseHelper::NoExits('No existe una orden con el id '.  $id);
        }
        return ResponseHelper::Get($data);
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
        $data = Order::find($id);

        if (!$data) {
            return ResponseHelper::NoExits('No existe una orden con el id ' .  $id);
        }
        try {
            $data->update([
                'id_provider' => $request->input('id_provider'),
                'payment_status' => $request->input('payment_status'),
                'id_payment_method' => $request->input('id_payment_method'),
                'due_date' => $request->input('due_date'),
                'total_bails' => $request->input('total_bails'),
                'subtotal' => $request->input('total'),
                'tax' => $request->input('tax'),
                'total' => $request->input('total'),
                'observations' => $request->input('observations'),
            ]);

            return  ResponseHelper::CreateOrUpdate($data, 'Información actualizada correctamente',);
        } catch (\Throwable $th) {
            return ResponseHelper::Error($th, 'La información no pudo ser actualizada');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Order::find($id);

        if (!$data) {
            return ResponseHelper::NoExits('No existe una orden con el id ' .  $id);
        }
        $data->delete();

        return ResponseHelper::Delete('Orden eliminada correctamente');
    }

    /**
     * get id latest
     */
    public function getCount()
    {
        $data = Order::withTrashed()->latest('id')->first();

        return ResponseHelper::Get($data);
    }

    private function createBail(Array $req,Order $order): Int {
        $bailNew = BailOrder::create([
            'id_order'=> $order->id,
            'id_payment_method'=> @$req['id_payment_method'],
            'price'=> @$req['bail'],
        ]);

        $this->updateBailsOrder($order);
        return $bailNew->id;
    }

    private function updateBailsOrder($order) {
        $bails = $this->getBailsTotalOrder($order->id);
        $order->update([ 'total_bails' => $bails ]);
    }

    private function getBailsTotalOrder(Int $idOrder): string {
        return BailOrder::where('id_order', $idOrder)->sum('price');
    }
}
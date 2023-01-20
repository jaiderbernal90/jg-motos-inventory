<?php

namespace App\Http\Controllers\accounting;

use App\Helpers\AuditHelper;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\accounting\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        $page = $request->input('page') ? $request->input('page') : 1;
        $limit = $request->input('limit') ? $request->input('limit') : 10;
        $term = $request->input('term');
        $type = $request->input('type');
        $date = $request->input('date');

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $expense = $this->getExpenseBypagination($term);
        if($date && $type) $expense = $this->getExpenseWithFilters($type, $date, $expense); 
        $data = $expense->orderBy('id', 'DESC')->paginate($limit);

        return ResponseHelper::Get($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $request->validate([
                'description' => 'required',
                'value' => 'required'
            ]);
            $data = Expense::create($request->all());
            
            $audit = new AuditHelper;
            $audit->auditExpense($data->id, 1);

            return ResponseHelper::CreateOrUpdate($data, 'Cargo creado correctamente');
        } catch (\Throwable $th) {
            return ResponseHelper::Error($th, 'El cargo no pudo ser creado');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->getExpenseById($id);

        if (!$data) {
            return ResponseHelper::NoExits('No existe un cargo con el id '.  $id);
        }
        return ResponseHelper::Get($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->getExpenseById($id);

        if (!$data) {
            return ResponseHelper::NoExits('No existe un  con el id ' .  $id);
        }
        try {
            $data->update([
                'description' => $request->input('description'),
                'value' => $request->input('value')
            ]);

            $audit = new AuditHelper;
            $audit->auditExpense($data->id, 2);

            return  ResponseHelper::CreateOrUpdate($data, 'Información actualizada correctamente',);
        } catch (\Throwable $th) {
            return ResponseHelper::Error($th, 'La información no pudo ser actualizada');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroydestroy($id)
    {
        $data = $this->getExpenseById($id);

        if (!$data) {
            return ResponseHelper::NoExits('No existe un cargo con el id ' .  $id);
        }

        $audit = new AuditHelper;
        $audit->auditExpense($data->id, 3);

        $data->delete();

        return ResponseHelper::Delete('Cargo eliminado correctamente');
    }


    private function getExpenseById($id): Expense { return Expense::find($id); }

    private function getExpenseWithFilters(String $type, $date, $expense) {
        if($type == 'month'){
            $rangeDates = $this->getMonthAndYear($date);
            return $expense->whereMonth('created_at', $rangeDates['month'])->whereYear('created_at', $rangeDates['year']);
        }
        return $expense->whereDate('created_at', $date);
    } 

    private function getExpenseBypagination($term) { 
        return Expense::where(function ($query) use ($term) {
            $query->where('description', 'like', "%$term%");
            $query->orWhere('value', 'like', "%$term%");
        }); 
    }

    private function getMonthAndYear($date) {
        $parseDate = Carbon::parse($date);
        $arr['month'] = $parseDate->format('m');
        $arr['year'] = $parseDate->format('Y');
        return $arr;
    }
}

<?php

namespace App\Http\Controllers\inventory;

use App\Helpers\AuditHelper;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\inventory\Row;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Throwable;

class RowController extends Controller
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
        $sectionId = $request->sectionId;

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $data = Row::where('id_section', $sectionId)
        ->where(function ($query) use ($term) {
            $query->where('code', 'like', "%$term%");
            $query->orWhere('name', 'like', "%$term%");
        })->orderBy('id', 'DESC')->paginate($limit);

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
                'code' => 'required|unique:rows',
                'name' => 'required'
            ]);
            $data = Row::create($request->all());

            $audit = new AuditHelper;
            $audit->auditRow($data->id, 1);
            
            return ResponseHelper::CreateOrUpdate($data, 'Fila creada correctamente');
        } catch (Throwable $th) {
            return ResponseHelper::Error($th, 'La fila no pudo ser creada');
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
        $data = Row::find($id);

        if (!$data) {
            return ResponseHelper::NoExits('No existe una fila con el id '.  $id);
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
        $data = Row::find($id);

        if (!$data) {
            return ResponseHelper::NoExits('No existe una fila con el id ' .  $id);
        }
        try {
            $data->update([
                'name' => $request->input('name')
            ]);

            $audit = new AuditHelper;
            $audit->auditRow($data->id, 2);

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
        $data = Row::find($id);

        if (!$data) {
            return ResponseHelper::NoExits('No existe una fila con el id ' .  $id);
        }

        $audit = new AuditHelper;
        $audit->auditRow($data->id, 3);

        $data->delete();

        return ResponseHelper::Delete('Fila eliminada correctamente');
    }

    /**
     * get id latest
     */
    public function getCount()
    {
        $data = Row::latest('id')->first();

        return ResponseHelper::Get($data);
    }
}
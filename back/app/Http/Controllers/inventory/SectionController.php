<?php

namespace App\Http\Controllers\inventory;

use App\Exports\LocalExport;
use App\Helpers\AuditHelper;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\inventory\Column;
use App\Models\inventory\Row;
use App\Models\inventory\Section;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Maatwebsite\Excel\Facades\Excel;

class SectionController extends Controller
{
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

        $data = Section::where(function ($query) use ($term) {
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
                'code' => 'required|unique:sections',
                'name' => 'required'
            ]);
            $data = Section::create($request->all());

            $audit = new AuditHelper;
            $audit->auditSection($data->id, 1);
            
            return ResponseHelper::CreateOrUpdate($data, 'Sección creada correctamente');
        } catch (\Throwable $th) {
            return ResponseHelper::Error($th, 'La sección no pudo ser creada');
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
        $data = Section::find($id);

        if (!$data) {
            return ResponseHelper::NoExits('No existe una sección con el id '.  $id);
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
        $data = Section::find($id);

        if (!$data) {
            return ResponseHelper::NoExits('No existe una sección con el id ' .  $id);
        }
        try {
            $data->update([
                'name' => $request->input('name')
            ]);

            $audit = new AuditHelper;
            $audit->auditSection($data->id, 2);

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
        $data = Section::find($id);

        if (!$data) {
            return ResponseHelper::NoExits('No existe una sección con el id ' .  $id);
        }

        $audit = new AuditHelper;
        $audit->auditSection($data->id, 3);

        $data->delete();

        return ResponseHelper::Delete('Sección eliminada correctamente');
    }

      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRowsSelect(Request $request)
    {
        $data = [];
        $page = $request->get('page') ? $request->get('page') : 1;
        $limit = $request->get('limit') ? $request->get('limit') : 10;
        $term = $request->get('term');
        $id_section = $request->get('id_section');

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $data = Row::where('id_section', $id_section)
        ->where(function ($query) use ($term) {
            $query->where('code', 'like', "%$term%");
            $query->orWhere('name', 'like', "%$term%");
        })->orderBy('id', 'DESC')->paginate($limit);

        return ResponseHelper::Get($data);
    }

          /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getColumnsSelect(Request $request)
    {
        $data = [];
        $page = $request->get('page') ? $request->get('page') : 1;
        $limit = $request->get('limit') ? $request->get('limit') : 10;
        $term = $request->get('term');
        $id_section = $request->get('id_section');

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $data = Column::where('id_section', $id_section)
        ->where(function ($query) use ($term) {
            $query->where('code', 'like', "%$term%");
            $query->orWhere('name', 'like', "%$term%");
        })->orderBy('id', 'DESC')->paginate($limit);

        return ResponseHelper::Get($data);
    }

    /**
     * get id latest
     */
    public function getCount()
    {
        $data = Section::latest('id')->first();

        return ResponseHelper::Get($data);
    }

    /**
     * Export resource data
    */
    public function exportExcel()
    {
        return Excel::download(new LocalExport, 'Listado-local.xlsx');
    }
}

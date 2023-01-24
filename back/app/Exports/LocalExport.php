<?php

namespace App\Exports;

use App\Models\inventory\Column;
use App\Models\inventory\Row;
use App\Models\inventory\Section;
use App\Models\setting\Role;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LocalExport implements FromView
{
    public function view(): View
    {
        $sections = Section::select('id', 'name as nameSection')->get();

        foreach ($sections as $section){
            $columns = Column::select('name as nameColumn')->where('id_section', $section->id)->get();
            $rows = Row::select('name as nameRow')->where('id_section', $section->id)->get();
            $section['columns'] = $columns;
            $section['sizeColumns'] = sizeof($columns);
            $section['rows'] = $rows;
            $section['sizeRows'] = sizeof($rows);
        }
        
        $data = $sections;

        return view('exportsExcel.local', ['data' => $data]);
    }
}

<?php

namespace App\Imports;

use App\Models\LaboratoryCategory;
use App\Models\Specialty;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SpecialtyImport implements ToModel, WithStartRow
{
    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $title = [];
        if($row[1]){
        $cat = Specialty::where('title->ka', $row[1])->first();
        if(!$cat){
            $title['ka'] = $row[1];
            return new Specialty([
                'title' => $title,
            ]);
        }
        }
    }
}
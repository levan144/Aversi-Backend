<?php

namespace App\Imports;

use App\Models\LaboratoryCategory;
use App\Models\LaboratoryService;
use Maatwebsite\Excel\Concerns\ToModel;

class LabCatImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $title = [];
        $cat = LaboratoryCategory::where('title->ka', $row[0])->first();
        if($cat){
            $title['ka'] = $row[3];
            $category = $cat->id;
            return new LaboratoryService([
                'title' => $title,
                'category_id' => $category
            ]);
        }
    }
}

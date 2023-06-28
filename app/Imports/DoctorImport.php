<?php
namespace App\Imports;

use App\Models\Doctor;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class DoctorImport implements ToModel, WithStartRow, WithChunkReading
{
     public function batchSize(): int
    {
        return 10; // Set to the desired batch size
    }

    public function chunkSize(): int
    {
        return 10; // Set to the desired chunk size
    }
    /**
     * @return int
     */
    public function startRow(): int
    {
        return 3;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if($row[0]){
        $name = $row[0];
        $email = $this->convertToEmail($name);
        $sid = $row[3];

        $doctor = Doctor::where('sid', $sid)
            ->orWhere('name->ka', $name)
            ->orWhere('email', $email)
            ->first();

        if (!$doctor) {
            $doctor = new Doctor;
            $doctor->setTranslation('name', 'ka', $name);
            $doctor->email = $email;
            $doctor->sid = $sid;
            $doctor->save();
        } 

        return null;
        }
    }

    /**
     * Convert name to email address.
     *
     * @param string $name
     *
     * @return string
     */
    private function convertToEmail(string $name): string
    {
        $cyrillic = ['ა', 'ბ', 'გ', 'დ', 'ე', 'ვ', 'ზ', 'თ', 'ი', 'კ', 'ლ', 'მ', 'ნ', 'ო', 'პ', 'ჟ', 'რ', 'ს', 'ტ', 'უ', 'ფ', 
            'ქ', 'ღ', 'ყ', 'შ', 'ჩ', 'ც', 'ძ', 'წ', 'ჭ', 'ღ', 'ხ', 'ჯ', 'ჰ', ' '];
        $latin = ['a', 'b', 'g', 'd', 'e', 'v', 'z', 't', 'i', 'k', 'l', 'm', 'n', 'o', 'p', 'dj', 'r', 's', 't', 'u',
            'f', 'q', 'gh', 'y', 'sh', 'ch', 'c', 'dz', 'w', 'ch', 'gh', 'kh', 'j', 'h', '.'];

        $email = str_replace($cyrillic, $latin, $name) . '@aversi.ge';

        return $email;
    }
}

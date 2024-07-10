<?php

namespace App\Imports;

use App\Models\Number;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class NumberImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        //
    }

    public function model(array $row)
    {
        // TODO: Implement model() method.
        // Ensure phone number is treated as a string
        $phoneNumber = (string) $row['phone_number'];
//     dd($phoneNumber);
        // Create the Number model
        $number = Number::create($row);

        // Assign the phone number explicitly
        $number->phone_number = $phoneNumber;

        // Save the model
        $number->save();


    }
}

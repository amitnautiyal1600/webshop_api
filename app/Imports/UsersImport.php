<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash; 
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

use Maatwebsite\Excel\Concerns\WithBatchInserts;

class UsersImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    { 

        $is_user_exist =  User::where('email', $row['email_address'])->where('phone', $row['phone'])->exists();
        if(!$is_user_exist) {
            return new User([
                "job_title" => $row['job_title'],
                "name" => $row['firstname_lastname'],
                "email" => $row['email_address'],
                "phone" => $row['phone'], 
                "registered_since" => $row['registered_since'], 
                "password" => Hash::make('password')
            ]);
        }
    }


     public function batchSize(): int
    {
        return 800;
    }

    public function chunkSize(): int
    {
        return 800;
    }

}

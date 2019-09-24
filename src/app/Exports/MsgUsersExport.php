<?php

namespace App\Exports;

use App\MsgUser;
use Maatwebsite\Excel\Concerns\FromCollection;

class MsgUsersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return MsgUser::all();
    }
}

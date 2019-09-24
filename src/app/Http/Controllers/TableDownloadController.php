<?php

namespace App\Http\Controllers;

use App\Exports\CardsExport;
use App\Exports\MsgUsersExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Excel;

class TableDownloadController extends Controller
{
    //
    public function DownloadDiscountCards()
    {
        if(Auth::check()) {
            return \Maatwebsite\Excel\Facades\Excel::download(new CardsExport, 'cards_new.xls', \Maatwebsite\Excel\Excel::XLS, [
                'Content-Type' => 'application/vnd.ms-excel',
                'Content-Disposition' => "attachment; filename='cards.xls'"
            ]);
        } else {
            echo 'Unauthorized';
        }

    }

    public function DownloadUsers()
    {
        if(Auth::check()) {
            return \Maatwebsite\Excel\Facades\Excel::download(new MsgUsersExport, 'users.xls', \Maatwebsite\Excel\Excel::XLS, [
                'Content-Type' => 'application/vnd.ms-excel',
                'Content-Disposition' => "attachment; filename='users.xls'"
            ]);
        } else {
            echo 'Unauthorized';
        }

    }
}

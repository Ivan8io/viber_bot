<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FileUploadController extends Controller
{
    /** Example of File Upload */
    public function uploadFilePost(Request $request){

        try {

            $this->validate($request, [
                'file' => 'required|mimes:xls,xlsx'
            ]);

            $request->file->store();

            if ($request->hasFile('file')) {




            }




        } catch (\Exception $ex)
        {
            Log::error($ex->getMessage());
        }

        /*

        $request->validate([
            'fileToUpload' => 'required|file|max:1024',
        ]);

        $request->fileToUpload->store('logos');

        return

        return back()
            ->with('success','You have successfully upload image.');
        */

    }
}

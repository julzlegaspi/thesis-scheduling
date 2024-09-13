<?php

namespace App\Http\Controllers;

class DownloadTempUser extends Controller
{
    public function __invoke()
    {
        // Serve the file
        return response()->download(storage_path('app/uploads/temp-users.csv'));
    }
}

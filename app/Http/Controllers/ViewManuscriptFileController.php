<?php

namespace App\Http\Controllers;

use App\Models\Manuscript;
use Illuminate\Http\Request;

class ViewManuscriptFileController extends Controller
{
    public function __invoke(Manuscript $manuscript)
    {
        //TODO create validation here

        return response()->file(storage_path('app/'. $manuscript->file_name));
    }
}

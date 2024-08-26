<?php

namespace App\Http\Controllers;

use App\Models\Rsc;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ViewRscFileController extends Controller
{
    public function __invoke(Rsc $rsc)
    {
        if ($rsc->is_admin)
        {
            return response()->file(storage_path('app/'. $rsc->file_name));
        }

        $rsc->load('team', 'uploader');

        $data = [
            'rsc' => $rsc
        ];
        $pdf = Pdf::loadView('rsc', $data);
        return $pdf->stream();
    }
}

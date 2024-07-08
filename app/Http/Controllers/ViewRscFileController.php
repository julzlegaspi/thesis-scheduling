<?php

namespace App\Http\Controllers;

use App\Models\Rsc;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ViewRscFileController extends Controller
{
    public function __invoke(Rsc $rsc)
    {
        $rsc->load('team', 'uploader');

        $data = [
            'rsc' => $rsc
        ];
        $pdf = Pdf::loadView('rsc', $data);
        return $pdf->stream();
    }
}

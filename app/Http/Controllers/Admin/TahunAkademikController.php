<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AkademikService;
use Illuminate\Http\Request;

class TahunAkademikController extends Controller
{
    protected $akademikService;

    public function __construct(AkademikService $akademikService)
    {
        $this->akademikService = $akademikService;
    }

    public function getActive()
    {
        return response()->json($this->akademikService->getActiveTahun());
    }

    public function activate($id)
    {
        $this->akademikService->activateTahun($id);
        return response()->json(['message' => 'Tahun akademik activated']);
    }
}

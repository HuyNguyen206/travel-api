<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TourResource;
use App\Models\Travel;
use App\Repository\TourRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TourController extends Controller
{
    public function index(Request $request, Travel $travel, TourRepository $tourRepository)
    {
        $request->validate([
            'sort.*' => Rule::in(['asc', 'desc'])
        ]);

        return TourResource::collection($tourRepository->getToursByTravel($travel, $request));
    }
}

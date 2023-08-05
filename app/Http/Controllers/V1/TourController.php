<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TourResource;
use App\Models\Travel;
use App\Repository\TourRepository;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function index(Request $request, Travel $travel, TourRepository $tourRepository)
    {
        return TourResource::collection($tourRepository->getToursByTravel($travel, $request));
    }
}

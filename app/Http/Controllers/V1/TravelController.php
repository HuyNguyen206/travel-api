<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TravelResource;
use App\Repository\TravelRepository;

class TravelController extends Controller
{
    public function index(TravelRepository $travelRepository)
    {
        return TravelResource::collection($travelRepository->getList());
    }
}

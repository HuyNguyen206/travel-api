<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\TravelResource;
use App\Models\Travel;
use Illuminate\Http\Request;

class TravelController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'is_public' => 'bool',
            'name' => ['required'],
            'description' => ['min:3', 'required'],
            'number_of_days' => 'required|numeric'
        ]);

        $travel = Travel::create($data);

        return TravelResource::make($travel);
    }
}

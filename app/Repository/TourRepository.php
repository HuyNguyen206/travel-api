<?php

namespace App\Repository;

use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TourRepository extends BaseRepository
{
    public Tour $model;

    public function model()
    {
        return Tour::class;
    }

    public function getToursByTravel(Travel $travel, Request $request)
    {
       return $travel->tours()
            ->when($request->start_date && $request->end_date, function (Builder $builder) use($request){
                $builder->whereDate('start_date', '>=', $request->start_date)
                        ->whereDate('end_date', '<=', $request->end_date);
            })
            ->when( $request->price_from && $request->price_to, function (Builder $builder) use($request){
                $builder->where('price', '>=', $request->price_from)
                        ->where('price', '<=', $request->price_to);
            })
           ->when($request->sort, function (Builder $builder, $sort) {
               $column = key($sort);
               $direction = current($sort);
               $builder->orderBy($column, $direction);
           })
           ->orderBy('start_date')
           ->paginate();
    }

}

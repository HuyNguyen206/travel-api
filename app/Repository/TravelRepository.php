<?php

namespace App\Repository;

use App\Models\Travel;

class TravelRepository extends BaseRepository
{
    public Travel $model;

    public function model()
    {
        return Travel::class;
    }

//    public function getList(Request $request, Travel $travel)
//    {
//        $travel->tours()
//            ->when(($startDate = $request->start_date) && ($endDate = $request->end_date), function (Builder $builder) use($startDate, $endDate){
//                $builder->whereDate('start_date', '>=', $startDate)
//                        ->whereDate('end_date', '<=', $endDate);
//            })
//            ->when(($priceFrom = $request->price_from) && ($priceTo = $request->price_to), function (Builder $builder) use($priceFrom, $priceTo){
//                $builder->where('price', '>=', $priceFrom)
//                    ->where('price', '<=', $priceTo);
//            })
//            ->paginate();
//    }

    public function getList()
    {
       return $this->model->newQuery()->public()->paginate(10);
    }

}

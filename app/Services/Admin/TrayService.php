<?php

namespace App\Services\Admin;

use App\Http\Constants\OrderConstants;
use App\Models\Categories;
use App\Models\InstrumentItems;
use App\Models\TrayCategoryInstrument;
use App\Models\Trays;
use Illuminate\Support\Facades\DB;


class TrayService
{

    public function getInstrumentSuggestionBasedOnCategory($trayCategoryId)
    {
        $instrumentCategory = DB::table(Categories::getTableName().' as c')
            ->join(TrayCategoryInstrument::getTableName().' as tci', 'tci.category_id', '=','c.id')
            ->select('c.id', 'c.category_name', 'tci.qty')
            ->where('tci.tray_category_id', '=', $trayCategoryId)
            ->orderBy('c.id', 'ASC')
            ->get();

        $instrumentSuggestions = [];
        foreach ($instrumentCategory as $item) {
            $instrumentSuggestions[$item->id]['instrument_category'] = $item->category_name;
            $instrumentSuggestions[$item->id]['qty'] = $item->qty;
            $instrumentSuggestions[$item->id]['instruments'] = InstrumentItems::where('category_id', $item->id)
                ->where('in_stock', OrderConstants::STOCK_AVAILABLE)
                ->select('id', 'barcode')->get();
        }
        return $instrumentSuggestions;
    }


}


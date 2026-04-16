<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function getLoadValue($queries){
        $loadValue = [];
        foreach($queries as $key => $q){
            if(Str::startsWith($key, 'include') and $q){
                $loadItem = preg_replace('/^include-/', '', $key);
                $loadItem = str_replace('-', '.', $loadItem);
                \array_push($loadValue,$loadItem);
            }
        }
        return $loadValue;
    }

    protected function getQueryFilter($filterItems,$table){
        $filtered = [];
        foreach ($filterItems as $item) {
            if (count($item) === 2) { // For IS NULL and IS NOT NULL
                if($item[1] == 'IS NULL'){
                    $table->whereNull($item[0]);
                } else if($item[1] == 'IS NOT NULL'){
                    $table->whereNotNull($item[0]);
                }
            } else {
                $filtered[] = $item;
            }
        }
        $table->where($filtered);  
        return $table;
    }
}

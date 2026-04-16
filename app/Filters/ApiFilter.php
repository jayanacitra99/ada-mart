<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ApiFilter {
    protected $numericOperator = ['eq', '!null', 'null', 'lt', 'lte', 'gt', 'gte'];
    
    protected $stringOperator = ['eq', '!null', 'null', 'like'];

    protected $safeParams = [];

    protected $columnMap = [];

    protected $operatorMap = [
        'eq'    => '=',
        'lt'    => '<',
        'lte'   => '<=',
        'gt'    => '>',
        'gte'   => '>=',
        'like'  => 'LIKE',
        '!null' => 'IS NOT NULL',
        'null'  => 'IS NULL',
    ];

    public function transform(Request $request){
        $eloQuery = [];

        foreach ($this->safeParams as $parm => $operators){
            $query = $request->query($parm);
    
            if (!isset($query)){
                continue;
            }
    
            $column = $this->columnMap[$parm] ?? $parm;
    
            foreach ($operators as $operator) {
                if (isset($query[$operator])) {
                    if (($operator == '!null' or $operator == 'null') and $query[$operator] == 'true') {
                        $eloQuery[] = [$column, $this->operatorMap[$operator]];
                    } else {
                        $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
                    }
                }
            }
        }
        return $eloQuery;
    }
    
}
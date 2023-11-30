<?php
namespace App\Filters; 

use Illuminate\Http\Request;

class MedcineFilter{
    protected $safeParms =[
        'category_id'=>['eq'],
        'useName'=>['eq','like'],
        'sciName'=>['eq','like'],
        'price'=>['eq','lt','gt'],
        'qtn'=>['eq','lt','gt','lte','gte']
    ];
    protected $operatorMap=[
        'eq'=>'=',
        'lt'=>'<',
        'lte'=>'<=',
        'gt'=>'>',
        'gte'=>'>=',
        'like' => 'LIKE'
    ];
    public function transform(Request $request)
    {
        $eleQuery = [];

        foreach ($this->safeParms as $parm => $operators) {
            $query = $request->query($parm);
            
            if (!isset($query)) {
                continue;
            }
            
            foreach ($operators as $operator) {
                if (isset($query[$operator])) {
                    if ($operator === 'like') {
                        $eleQuery[] = [$parm, $this->operatorMap[$operator], '%' . $query[$operator] . '%'];
                    } else {
                        $eleQuery[] = [$parm, $this->operatorMap[$operator], $query[$operator]];
                    }
                }
            }
        }
        
        return $eleQuery;
    }

}
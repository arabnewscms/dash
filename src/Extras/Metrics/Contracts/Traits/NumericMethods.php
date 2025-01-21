<?php
namespace Dash\Extras\Metrics\Contracts\Traits;
use SuperClosure\Serializer;
trait NumericMethods{

    public function count($count,$query=null){
        if(!empty($query)){
            $this->query = (new Serializer())->serialize($query);

            $this->count = $count::where($query)->count();
        }else{
            $this->count = $count::count();
        }

        $this->model = $count;
        $this->typeCalc = 'count';
        return $this;
    }

    public function progress($progress,$query=null){
        $total = $progress::count();
        if(!empty($query)){
            $this->query = (new Serializer())->serialize($query);
            $pending = $progress::where($query)->count();
        }else{
            $pending = $progress::count();
        }
        $this->progress = [$pending,$total];
        return $this;
    }

    public function sum($sum,$col='id',$query=null){
        $this->sum = $sum::sum($col);

        if(!empty($query)){
            $this->query = (new Serializer())->serialize($query);
            $this->sum = $sum::where($query)->count();
        }else{
            $this->sum = $sum::count();
        }

        $this->model = $sum;
        $this->typeCalc = 'sum';
        $this->sumCol = $col;
        return $this;
    }

    public function average($average,$col='id',$query=null){
        if(!empty($query)){
            $this->query = (new Serializer())->serialize($query);
            $this->average = [$average::where($query)->sum($col),$average::where($query)->count()];
        }else{
            $this->average = [$average::sum($col),$average::count()];
        }

        $this->model = $average;
        $this->typeCalc = 'sum';
        $this->sumCol = $col;
        return $this;
    }


}

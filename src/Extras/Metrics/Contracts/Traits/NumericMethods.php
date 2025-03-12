<?php

namespace Dash\Extras\Metrics\Contracts\Traits;

use function Opis\Closure\{serialize, unserialize};
// use function serialize;
// use Opis\Closure\SerializableClosure;

trait NumericMethods
{

    public function count($count, $query = null)
    {
        if (!empty($query)) {

            $this->query = serialize($query);

            $this->count = $count::where($query)->count();
        } else {
            $this->count = $count::count();
        }

        $this->model = $count;
        $this->typeCalc = 'count';
        return $this;
    }

    public function progress($progress, $query = null)
    {
        $total = $progress::count();
        if (!empty($query)) {
            $this->query = serialize($query);
            $pending = $progress::where($query)->count();
        } else {
            $pending = $progress::count();
        }
        $this->progress = [$pending, $total];
        return $this;
    }

    public function sum($sum, $col = 'id', $query = null)
    {
        // $this->sum = $sum::sum($col);

        if (!empty($query)) {
            $this->query = serialize($query);
            $this->sum = $sum::where($query)->sum($col);
        } else {
            $this->sum = $sum::sum($col);
        }

        $this->model = $sum;
        $this->typeCalc = 'sum';
        $this->sumCol = $col;
        return $this;
    }

    public function average($average, $col = 'id', $query = null)
    {
        if (!empty($query)) {
            $this->query = serialize($query);
            $this->average = [$average::where($query)->sum($col), $average::where($query)->count()];
        } else {
            $this->average = [$average::sum($col), $average::count()];
        }

        $this->model = $average;
        $this->typeCalc = 'sum';
        $this->sumCol = $col;
        return $this;
    }
}

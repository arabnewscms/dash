<?php
namespace Dash\Extras\Metrics;
use Dash\Extras\Metrics\Contracts\AbstractMetricsAverage;

class Average extends AbstractMetricsAverage{


    public function render(){
        return $this->chartJs();
    }

}

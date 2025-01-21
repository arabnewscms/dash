<?php
namespace Dash\Extras\Metrics;
use Dash\Extras\Metrics\Contracts\AbstractMetricsValue;

class Value extends AbstractMetricsValue{

    public function render(){
        return $this->chartJs();
    }



}

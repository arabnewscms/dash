<?php
namespace Dash\Extras\Metrics;
use Dash\Extras\Metrics\Contracts\AbstractMetricsProgress;

class Progress extends AbstractMetricsProgress{

    public function render(){
        return $this->chartJs();
    }

}

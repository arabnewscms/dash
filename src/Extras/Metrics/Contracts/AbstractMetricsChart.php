<?php
namespace Dash\Extras\Metrics\Contracts;
use Dash\Extras\Metrics\Contracts\Traits\AjaxCall;
use Dash\Extras\Metrics\Contracts\Traits\Properties;
use Dash\Extras\Metrics\Contracts\Traits\StructureMethods;
abstract class AbstractMetricsChart{
    use Properties, StructureMethods, AjaxCall;

    public function __construct()
    {
        $options = $this->options();
        if (!empty($options)) {
            foreach (['width', 'height', 'title', 'column', 'elem'] as $option) {
                if (in_array($option, array_keys($options))) {
                    $this->{$option} = $options[$option];
                }
            }
        }
        $this->calc();
    }

    public function chartJs()
    {
        $allChartData = json_encode($this->allChartData, JSON_PRETTY_PRINT);
        $subTitle = !empty($this->subtitle)?'<small class="ps-3 text-xs">'.$this->subtitle.'</small>
        ':'';

        $data = '<script src="' . url('dashboard/assets/chartjs/js/chart.js') . '"></script>';
        $data .= '

        <div class="col-md-'.$this->column.'  p-1">
            <div class="card m-0">
                <div class="card-header pt-2 p-1">
                    <div class="col-12 pt-0 p-0 m-0">
                    <div class="col-12 p-0 m-0"><h4 class="text-dark card-title text-capitalize ps-3 pb-2" style="font-size:14px;letter-spacing:0">  ';
                    if(!empty($this->href)){

                        $data .="<a href='".$this->href."' target='".$this->hrefTarget."'> ".$this->icon ." ".$this->title." </a>";
                    }else{
                         $data .= $this->icon .' ' .$this->title ;

                        }
                  $data .='</h4></div>
                    <div class="col-12 p-0 m-0"> '.$subTitle.'</div>
                    </div>
                </div>
                <div class="card-body pt-1 pm-0 ps-4">
                 <canvas id="'.$this->elem.'"></canvas>
                 <small class="text-xs">'.$this->textbody.'</small>
                </div>
            </div>
        </div>
        ';
        $data .= "
          <script>
              const ctx_".$this->elem." = document.getElementById('".$this->elem."');
              new Chart(ctx_".$this->elem.", " .$allChartData.");
          </script>
         ";

        return $data;
    }
}

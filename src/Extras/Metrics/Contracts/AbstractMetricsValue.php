<?php
namespace Dash\Extras\Metrics\Contracts;

use Dash\Extras\Metrics\Contracts\Traits\AjaxCall;
use Dash\Extras\Metrics\Contracts\Traits\NumericMethods;
use Dash\Extras\Metrics\Contracts\Traits\Properties;
use Dash\Extras\Metrics\Contracts\Traits\StructureMethods;

abstract class AbstractMetricsValue{
    use NumericMethods,Properties,StructureMethods,AjaxCall;

    public function __construct(){
         $this->calc();
         if(!empty($this->count)){
            $this->result = $this->count;
        }elseif(!empty($this->sum)){
             $this->result = $this->sum;
        }
    }


     public function chartJs(){
        $randomLabel = 'value'.\Str::random(20);
        $loadRanges  = $this->prepareRanges($randomLabel);
        $subTitle = !empty($this->subtitle)?'<small class="ps-3 text-xs">'.$this->subtitle.'</small>
       ':'';

          $data = '
          <div class="col-md-'.$this->column.' p-1">
                    <div class="card m-0">
                        <div class="card-header pt-2 p-1">
                        <div class="col-12 pt-0 p-0 m-">
                        <div class="col-12 p-0 m-0"><h6 class="text-dark card-title text-capitalize ps-3 pb-2" style="font-size:14px;letter-spacing:0">  '.$this->icon.' '.$this->title.' </h6></div>
                        <div class="col-12 p-0 m-0"> '.$subTitle.'</div>
                        </div>
                        </div>
                        <div class="card-body pt-1 pm-0 ps-4">
                       '.$loadRanges.'
                       <div class="m-2"></div>
                        ';
        $bodyData = '<h3 class="mt-1"> '.$this->prefix.' <span class="'.$randomLabel.'">  '.$this->result.' </span> '.$this->suffix.'</h3>';
                       if(!empty($this->href)){
                           $data .='<a href="'.$this->href.'" target="'.$this->hrefTarget.'">
                            '.$bodyData.'
                           </a>';
                        } else{
                            $data .= $bodyData;
                        }
                        if(!empty($this->textbody)){
                            $data .= '<small class="text-xs">'.$this->textbody.'</small>';
                        }


                        if(!empty($loadRanges)){
                            $data .= $this->prepareAjaxCall($randomLabel,$this->model,$this->typeCalc,$this->sumCol,$this->at,$this->query,$this->query_format);
                        }

                        $data .='

                        </div>
                    </div>
                  </div>
            ';



         return $data;

    }




}

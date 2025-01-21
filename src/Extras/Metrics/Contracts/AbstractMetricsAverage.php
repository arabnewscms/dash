<?php

namespace Dash\Extras\Metrics\Contracts;

use Dash\Extras\Metrics\Contracts\Traits\AjaxCall;
use Dash\Extras\Metrics\Contracts\Traits\NumericMethods;
use Dash\Extras\Metrics\Contracts\Traits\Properties;
use Dash\Extras\Metrics\Contracts\Traits\StructureMethods;

abstract class AbstractMetricsAverage
{
    use NumericMethods, Properties, StructureMethods, AjaxCall;

    public function __construct()
    {
        $this->calc();
        $this->result = isset($this->average[1]) ? $this->average[1] : 0;
    }

    public function chartJs()
    {
        $percentage = !empty($this->average[1]) && !empty($this->average[0]) ?  round($this->average[1] / $this->average[0] * 100) : 0;
        $this->height = $this->height ?? '10';
        $randomLabel = 'value' . \Str::random(20);
        $loadRanges  = $this->prepareRanges($randomLabel);
        $subTitle = !empty($this->subtitle) ? '<small class="ps-3 text-xs">' . $this->subtitle . '</small>
        ' : '';

        $data = '
           <div class="col-md-' . $this->column . '  p-1">
           <div class="card m-0">
           <div class="card-header pt-2 p-1">
           <div class="col-12 pt-0 p-0 m-0">
           <div class="col-12 p-0 m-0"><h4 class="text-dark card-title text-capitalize ps-3 pb-2" style="font-size:14px;letter-spacing:0">  ' . $this->icon . ' ' . $this->title . ' </h4></div>
           <div class="col-12 p-0 m-0"> ' . $subTitle . '</div>
           </div>
           </div>
           <div class="card-body pt-1 pm-0 ps-4">
           ' . $loadRanges . '
          <div class="m-2"></div>';
        $bodyData = '<h3 class="mt-1"> ' . $this->prefix . ' <span class="' . $randomLabel . '"> ' . $this->result . ' </span> ' . $this->suffix . '</h5>';
        if (!empty($this->href)) {
            $data .= '<a href="' . $this->href . '" target="' . $this->hrefTarget . '">
                            ' . $bodyData . '
                           </a>';
        } else {
            $data .= $bodyData;
        }

        if (!empty($this->textbody)) {
            $data .= '<small class="text-xs">' . $this->textbody . '</small>';
        }

        if (!empty($loadRanges)) {
            $data .= $this->prepareAjaxCall($randomLabel, $this->model, $this->typeCalc, $this->sumCol, $this->at, $this->query);
        }


        $data .= '

                        <div class="row">
                            <div class="col-md-9 my-auto">
                            <div class="progress" style="height: ' . $this->height . 'px;">
                            <div class="progress-bar ' . $this->bgClass . '" role="progressbar " style="width:' . $percentage . '%;height: ' . $this->height . 'px;" aria-valuenow="' . $percentage . '" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            </div>
                            <div class="col-md-3 text-xs my-auto">
                              ' . $percentage . '%
                            </div>
                        </div>
                        </div>
                    </div>
                  </div>
            ';


        return $data;
    }
}

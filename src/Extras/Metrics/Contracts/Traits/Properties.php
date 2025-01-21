<?php
namespace Dash\Extras\Metrics\Contracts\Traits;

trait Properties{

    protected $height;
    protected $width;
    protected $title; // main title for card or chart
    protected $subtitle; // sub title for card or chart
    protected $textbody; // sub text in body for card or chart
    protected $elem = 'dashchartjs';
    protected $label = '';
    protected $labels;
    protected $column;
    protected $icon;
    protected $prefix;
    protected $suffix;
    protected $model;
    protected $href; // hyper link to go to some page
    protected $ranges = [];

    // progress for progress data as array from 0 to 100 [0 => query,100 => count, total pending left ]
    protected $progress = [];

    // to set if use sum or count or avreg method to get ajax statistics
    protected $typeCalc;
    // to count values
    protected $count;
    // to sum values
    protected $sum;
    //  sum by selected column from table to get values
    protected $average = [];
    protected $sumCol;
    // this column using in date like today , week , year etc..
    protected $at = 'created_at';

    // to set main value on show
    protected $result = 0;
    protected $query;
    protected $query_format;

    protected $bgClass = 'bg-success';
    // for charts bar line etc..
    protected $allChartData =[];
    protected $hrefTarget;
}

<?php

namespace Dash\Extras\Metrics\Contracts\Traits;

use SuperClosure\Serializer;

trait StructureMethods
{

    public function width($width)
    {
        $this->width =  is_object($width) ? $width() : $width;
        return $this;
    }

    public function height($height)
    {
        $this->height = is_object($height) ? $height() : $height;
        return $this;
    }

    public function elem($elem)
    {
        $this->elem = $elem ?? 'myChart' . rand(000, 999);
        return $this;
    }
    public function bgClass($bgClass)
    {
        $this->bgClass = is_object($bgClass) ? $bgClass() : $bgClass;
        return $this;
    }
    public function label($label)
    {
        $this->label = is_object($label) ? $label() : $label;

        return $this;
    }


    public function labels(): array
    {
        return [];
    }
    public function calc()
    {
        return null;
    }

    public function options(): array
    {
        return [];
    }


    public function title($title)
    {
        $this->title = is_object($title) ? $title() : $title;
        return $this;
    }

    public function subTitle($subtitle)
    {
        $this->subtitle = is_object($subtitle) ? $subtitle() : $subtitle;
        return $this;
    }
    public function textBody($textbody)
    {
        $this->textbody = is_object($textbody) ? $textbody() : $textbody;
        return $this;
    }

    public function column($column)
    {
        $this->column = is_object($column) ? $column() : $column ?? '12';
        return $this;
    }

    public function icon($icon)
    {
        $this->icon = is_object($icon) ? $icon() : $icon;
        return $this;
    }
    public function prefix($prefix)
    {
        $this->prefix =  is_object($prefix) ? $prefix() : $prefix;
        return $this;
    }

    public function suffix($suffix)
    {
        $this->suffix = is_object($suffix) ? $suffix() : $suffix;
        return $this;
    }
    public function at($at)
    {
        $this->at = is_object($at) ? $at() : $at;
        return $this;
    }

    public function ranges()
    {
        return [];
    }


    public function data($data)
    {
        $this->allChartData = $data;
        return $this;
    }

    public function href($href, $target = '_parent')
    {
        $this->href =   is_object($href) ? $href() : $href;
        if (is_object($target)) {
            $this->hrefTarget =   $target();
        } else {
            $this->hrefTarget =   $target;
        }
        return $this;
    }

    public function formatValue($value)
    {
        if (is_object($value)) {

            $updateResult =   is_object($value) ? $value($this->result) : $value;
            $this->result =   $updateResult;

            $this->query_format = (new Serializer())->serialize(function ($v) use ($value) {
                return $value($v);
            });
            //dd($this->query_format);
        }
        return $this;
    }



    public function prepareRanges($randomResultClass)
    {
        $mp = app()->getLocale() != 'ar' ? ' m-0 p-1' : '';
        $this->ranges = $this->ranges();
        if (!empty($this->ranges) && count($this->ranges) > 0) {
            $select = '<select name="' . $randomResultClass . '" random="' . $randomResultClass . '" class="form-select ' . $mp . ' w-50 form-select-sm">';
            foreach ($this->ranges as $key => $value) {
                $select .= '<option value="' . $key . '">' . $value . '</option>';
            }
            $select .= '</select>';
            return $select;
        } else {
            return null;
        }
    }
}

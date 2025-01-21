<?php
namespace Dash\Extras\Inputs;

use Dash\Extras\Inputs\Elements;
use Dash\Extras\Inputs\InputOptions\AdditionsToElements;
use Dash\Extras\Inputs\InputOptions\AddToFiltrationDataTable;
use Dash\Extras\Inputs\InputOptions\AstrotomicTranslatable;
use Dash\Extras\Inputs\InputOptions\Column;
use Dash\Extras\Inputs\InputOptions\ContractableAndRules;
use Dash\Extras\Inputs\InputOptions\CustomHtml;
use Dash\Extras\Inputs\InputOptions\DatatableOptions;
use Dash\Extras\Inputs\InputOptions\Dropzone;
use Dash\Extras\Inputs\InputOptions\FlatPicker;
use Dash\Extras\Inputs\InputOptions\HiddenOptions;
use Dash\Extras\Inputs\InputOptions\RelatedResources;
use Dash\Extras\Inputs\InputOptions\relationMethods;
use Dash\Extras\Inputs\InputOptions\Select;
use Dash\Extras\Inputs\InputOptions\ValidationRules;
use Dash\Extras\Inputs\InputOptions\VideoJsPlayer;

class Field
{
    use Elements,
        HiddenOptions,
        AddToFiltrationDataTable,
        Column,
        RelatedResources,
        DatatableOptions,
        Select,
        VideoJsPlayer,
        AstrotomicTranslatable,
        Dropzone,
        FlatPicker,
        relationMethods,
        ValidationRules,
        AdditionsToElements,
        CustomHtml,
        ContractableAndRules;

    public function __construct($type, $name = null, $attribute = null, $input = null)
    {
        static::$type = $type;

    }

    /**
     *  check availablity input in element types
     * @param string $type
     * @return (bool)
     */
    protected static function checkElementType($type)
    {
        return in_array($type, static::$element_types);
    }

    /**
     *  this method make the input with name and attribute in views
     * @param string $name, string $attribute
     * @return self static
     */
    public static function make($name, $attribute = null, $resource = null)
    {

        $attribute = empty($attribute)?
        strtolower(str_replace(' ', '_', $name)):
        $attribute;

        // reset the option again
        static::$showInIndex           = true;
        static::$showInShow            = true;
        static::$showInCreate          = true;
        static::$showInUpdate          = true;
        static::$disablePreviewButton  = true;
        static::$disableDwonloadButton = true;
        static::$deleteable            = true;
        $inputData                      = [
            'type'          => static::$type,
            'name'          => $name,
            'attribute'     => $attribute,
            'column'        => static::$column,
            'orderable'     => true,
            'searchable'    => true,
            'addToFilter'   => false,
            'show_rules'    => [
                'showInIndex'  => true,
                'showInCreate' => true,
                'showInUpdate' => true,
                'showInShow'   => true,
            ],
        ];

        if (!empty($resource)) {
            $inputData['resource'] = $resource;
        }

        if (static::checkElementType(static::$type)) {
            static::$input[static::$index] = $inputData;
            static::$index                  = static::$index+1;

            return static::fillData();
        } else {
            throw new \Exception(static::$type.' incorrect. please write a correct element like ('.implode(',', static::$element_types).')');
        }

    }

    /**
     *
     * fill data when ran this class
     * @return new self or static Object
     */
    public static function fillData()
    {
        static::UpdateRules();

        return new static (static::$type, static::$name, static::$attribute, static::$input);
    }

    public function __call($name, $arguments)
    {
        if (!method_exists($this, $name)) {
            throw new \Exception('->'.$name.'() function undefined or not exists in dash project');
        }
    }

    public static function __callStatic($name, $arguments)
    {
        if (!method_exists(Field::class, $name)) {
            throw new \Exception('::'.$name.'() function undefined or not exists in dash project');
        }
    }

}

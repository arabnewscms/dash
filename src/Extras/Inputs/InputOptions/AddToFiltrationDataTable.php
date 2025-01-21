<?php
namespace Dash\Extras\Inputs\InputOptions;

trait AddToFiltrationDataTable
{

    /**
     * Add data to filtration.
     *
     * @param mixed $data The data to be added to filtration.
     * @param array|null $properties Additional properties for filtration (optional).
     *
     * @return mixed The result of pragmaFilter function.
     */
    public function addToFilter($data=true, array|null $properties=[])
    {
        return static::pragmaFilter($data, $properties);
    }

    /**
     * Show data in filtration.
     *
     * @param mixed $data The data to be shown in filtration.
     * @param array|null $properties Additional properties for filtration (optional).
     *
     * @return mixed The result of pragmaFilter function.
     */
    public function showInFilter($data=true, array|null $properties=[])
    {
        return static::pragmaFilter($data, $properties);
    }

    /**
     * Alias for addToFilter.
     *
     * @param mixed $data The data to be added to filtration.
     * @param array|null $properties Additional properties for filtration (optional).
     *
     * @return mixed The result of pragmaFilter function.
     */
    public function f($data=true, array|null $properties=[])
    {
        return static::pragmaFilter($data, $properties);
    }

    /**
     * Filter data.
     *
     * @param mixed $data The data to be filtered.
     * @param array|null $properties Additional properties for filtration (optional).
     *
     * @return mixed The result of pragmaFilter function.
     */
    public function filter($data=true, array|null $properties=[])
    {
        return static::pragmaFilter($data, $properties);
    }

    /**
     * Handle filtration process.
     *
     * @param mixed $data The data to be filtered.
     * @param array $properties Additional properties for filtration.
     *
     * @return mixed The result of fillData function.
     */
    protected static function pragmaFilter($data=true, array $properties)
    {
        $value = is_object($data) ? $data() : $data;
        static::$input[static::$index - 1]['addToFilter'] = $value;
        if ($value) {
            if (empty(request()->segment(4)) || !in_array(request()->segment(4), ['new','edit'])) {
                if (empty($properties)) {
                    $properties = [
                        'column' => 3
                    ];
                }
                static::$input[static::$index-1]['column'] = $properties['column'];
                static::$input[static::$index-1]['columnWhenCreate'] = $properties['column'];
                static::$input[static::$index-1]['columnWhenUpdate'] = $properties['column'];
            }
        }
        return static::fillData();
    }
}

<?php

namespace Dash;

use Illuminate\Http\Request;

abstract class Pages
{
    use Modules;
    public static $model;
    public static $icon;
    public static $displayInMenu  = true;
    public static $position       = 'top'; // top|bottom
    public static $successMessage = 'Saved';

    public function __construct()
    {
        // Use nwiDart Modules Localization && Modules Pathes from Modules Folder
        $this->initModule();
    }

    /**
     * Rule List array
     * @return array
     */
    public static function rule()
    {
        return [];
    }

    /**
     * Nicename Fields
     * @return array
     */
    public static function attribute()
    {
        return [];
    }

    /**
     * custom page name
     * @return string
     */
    public static function pageName()
    {
        return null;
    }

    /**
     * custom content page
     * @return you can ini view method to render blade file
     */
    public static function content()
    {
        return view('{{name}}', [
            'title' => static::pageName(),
            //'{{name}}' => ModelName::find(1),
        ]);
    }

    /**
     * Update Data In Model
     * @return redirect object
     */
    public static function save(Request $request, $id)
    {

        if (!empty(static::rule()) && count(static::rule()) > 0) {
            $request->validate(static::rule(), static::attribute());
        }

        $data = static::$model::find($id);
        foreach (request()->except(['_token', '_method', 'lang']) as $key => $value) {
            if (request()->hasFile($key)) {
                $data->{$key} = request()->file($key)->store(class_basename(static::$model));
            } else {
                $data->{$key} = $value;
            }
        }

        $data->save();
        session()->flash('success', static::$successMessage);
        return back();
    }
}

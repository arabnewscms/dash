<?php

if (!function_exists('dash_init_input')) {
    function dash_init_input($input_type, $name = null, $attribute = null, $resource = null)
    {
        if (!empty($name) || !empty($attribute) || !empty($resource)) {
            return (new \Dash\Extras\Inputs\Field($input_type))->make($name, $attribute, $resource);
        } else {
            return new \Dash\Extras\Inputs\Field($input_type);
        }
    }
}

if (!function_exists('field')) {
    function field($input_type = 'text', $name = null, $attribute = null, $resource = null)
    {
        return dash_init_input($input_type, $name, $attribute, $resource);
    }
}

if (!function_exists('id')) {
    function id($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('id', $name, $attribute, $resource);
    }
}

if (!function_exists('text')) {
    function text($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('text', $name, $attribute, $resource);
    }
}

if (!function_exists('hidden')) {
    function hidden($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('hidden', $name, $attribute, $resource);
    }
}

if (!function_exists('textarea')) {
    function textarea($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('textarea', $name, $attribute, $resource);
    }
}

if (!function_exists('ckeditor')) {
    function ckeditor($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('ckeditor', $name, $attribute, $resource);
    }
}

if (!function_exists('uri')) {
    function uri($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('url', $name, $attribute, $resource);
    }
}

if (!function_exists('search')) {
    function search($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('search', $name, $attribute, $resource);
    }
}

if (!function_exists('number')) {
    function number($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('number', $name, $attribute, $resource);
    }
}
if (!function_exists('week')) {
    function week($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('week', $name, $attribute, $resource);
    }
}
if (!function_exists('month')) {
    function month($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('month', $name, $attribute, $resource);
    }
}

if (!function_exists('tel')) {
    function tel($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('tel', $name, $attribute, $resource);
    }
}

if (!function_exists('select')) {
    function select($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('select', $name, $attribute, $resource);
    }
}

if (!function_exists('email')) {
    function email($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('email', $name, $attribute, $resource);
    }
}

if (!function_exists('image')) {
    function image($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('image', $name, $attribute, $resource);
    }
}

if (!function_exists('password')) {
    function password($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('password', $name, $attribute, $resource);
    }
}

if (!function_exists('checkbox')) {
    function checkbox($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('checkbox', $name, $attribute, $resource);
    }
}
if (!function_exists('fileUpload')) {
    function fileUpload($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('file', $name, $attribute, $resource);
    }
}

if (!function_exists('video')) {
    function video($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('video', $name, $attribute, $resource);
    }
}

if (!function_exists('audio')) {
    function audio($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('audio', $name, $attribute, $resource);
    }
}
if (!function_exists('color')) {
    function color($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('color', $name, $attribute, $resource);
    }
}
if (!function_exists('dropzone')) {
    function dropzone($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('dropzone', $name, $attribute, $resource);
    }
}
if (!function_exists('fullDate')) {
    function fullDate($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('date', $name, $attribute, $resource);
    }
}

if (!function_exists('fullTime')) {
    function fullTime($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('time', $name, $attribute, $resource);
    }
}

if (!function_exists('fullDateTime')) {
    function fullDateTime($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('datetime', $name, $attribute, $resource);
    }
}

if (!function_exists('hasOneThrough')) {
    function hasOneThrough($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('hasOneThrough', $name, $attribute, $resource);
    }
}

if (!function_exists('hasOne')) {
    function hasOne($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('hasOne', $name, $attribute, $resource);
    }
}

if (!function_exists('hasManyThrough')) {
    function hasManyThrough($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('hasManyThrough', $name, $attribute, $resource);
    }
}

if (!function_exists('hasMany')) {
    function hasMany($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('hasMany', $name, $attribute, $resource);
    }
}

if (!function_exists('belongsTo')) {
    function belongsTo($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('belongsTo', $name, $attribute, $resource);
    }
}

if (!function_exists('belongsToMany')) {
    function belongsToMany($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('belongsToMany', $name, $attribute, $resource);
    }
}

if (!function_exists('custom')) {
    function custom($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('customHtml', $name, $attribute, $resource);
    }
}

if (!function_exists('morphOne')) {
    function morphOne($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('morphOne', $name, $attribute, $resource);
    }
}

if (!function_exists('morphTo')) {
    function morphTo($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('morphTo', $name, $attribute, $resource);
    }
}

if (!function_exists('morphToMany')) {
    function morphToMany($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('morphToMany', $name, $attribute, $resource);
    }
}

if (!function_exists('morphMany')) {
    function morphMany($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('morphMany', $name, $attribute, $resource);
    }
}

if (!function_exists('dash')) {
    function dash($segments)
    {
        if (substr($segments, 0, 1) == '/') {
            return url(config('dash.DASHBOARD_PATH') . $segments);
        } else {
            return url(config('dash.DASHBOARD_PATH') . '/' . $segments);
        }
    }
}

if (!function_exists('admin')) {
    function admin($guard = 'dash')
    {
        $dash_guard = config('auth.guards');
        $dash_guard = array_merge(config('dash.GUARD'), $dash_guard);
        \Config::set('auth.guards', $dash_guard);
        return auth()->guard($guard)->user();
    }
}

if (!function_exists('resourceShortName')) {
    function resourceShortName($resource)
    {
        if (class_exists($resource)) {
            return (new \ReflectionClass($resource))->getShortName();
        } else {
            return $resource;
        }
    }
}


if (!function_exists('searchInFields')) {
    function searchInFields($column, $fields, $columnTarget = 'attribute')
    {
        //$key = array_search($column, array_column($fields, $columnTarget));
        //return $fields[$key]??false;
        foreach ($fields as $fetchField) {
            $attribute = explode('.', $fetchField[$columnTarget]);
            if (!empty($attribute) && count($attribute) > 0) {
                if ($attribute[0] == $column) {
                    return $fetchField;
                }
            }
        }
        return false;
    }
}


if (!function_exists('dash_check_range_date_input')) {
    function dash_check_range_date_input(string $string): array|bool
    {
        $string = strtolower($string);
        $pattern = '/\b\d{4}-\d{2}-(0[1-9]|[12][0-9]|3[01])\b/';
        $check_is_date = preg_match($pattern, $string);
        if ($check_is_date) {

            $cleaned_string = str_replace('to', '|', $string);
            $cleaned_string = str_replace('إلى', '|', $cleaned_string);
            $cleaned_string = str_replace('الى', '|', $cleaned_string);
            //$cleaned_string = str_replace(' ', '', $cleaned_string);
            $cleaned_string = explode('|', $cleaned_string);

            if (isset($cleaned_string[1]) && !empty($cleaned_string[1])) {
                $cleaned_string = [
                    date('Y-m-d H:i:s', strtotime($cleaned_string[0])),
                    date('Y-m-d H:i:s', strtotime($cleaned_string[1]))
                ];
                return ['dates' => $cleaned_string, 'multiple' => false];
            } else {
                $cleaned_string = explode(',', $string);
                if (count($cleaned_string) > 0) {
                    return ['dates' => $cleaned_string, 'multiple' => true];
                }
            }
        }
        return false;
    }
}


if (!function_exists('lara_module')) {
    function lara_module($v = '10.0.0')
    {
        if (Composer\InstalledVersions::isInstalled('nwidart/laravel-modules')) {
            $check_module_version = \Composer\InstalledVersions::getVersion('nwidart/laravel-modules');
            return version_compare($check_module_version, $v, '>');
        } else {
            return false;
        }
    }
}


// if (!function_exists(function: 'dash_update_json_setting')) {
//     function dash_update_json_setting($key, $value)
//     {
//         $filePath = '/dash/config/settings.json';
//         $configArray = dash_get_json_setting();


//         // Update the specific key
//         $configArray[$key] = $value;

//         // Save back to the file
//         \Storage::put($filePath, json_encode($configArray, JSON_PRETTY_PRINT));
//     }
// }


// if (!function_exists(function: 'ip_as_serial')) {
//     function ip_as_serial(){
//         return str_replace('.','', str_replace(':','', request()->ip()));
//     }
// }
// if (!function_exists(function: 'dash_get_json_setting')) {
//     function dash_get_json_setting($key = null)
//     {
//         $filePath = '/dash/config/settings.json';
//         $configArray = [];
//         // Load existing settings if the file exists
//         if (\Storage::exists($filePath)) {
//             $fileContents = \Storage::get($filePath);
//             $configArray = json_decode($fileContents, true);
//         } elseif (!\Storage::exists($filePath)) {
//             \Storage::put($filePath, json_encode($configArray, JSON_PRETTY_PRINT));
//             $fileContents = \Storage::get($filePath);
//             $configArray = json_decode($fileContents, true);
//         }


//         // Update the specific key
//         if (!empty($key)) {
//             if (!empty($configArray[$key])) {
//                 return $configArray[$key];
//             } else {
//                 return '';
//             }
//         } else {
//             return $configArray;
//         }
//     }


// }


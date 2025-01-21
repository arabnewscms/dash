<?php

namespace Dash\Controllers\Traits\ControllerMethods;

trait ActionsMethods
{
    /**
     * load All Action Class From Resources
     * @return array;
     */
    public function prepare_actions()
    {
        $actions = $this->resource['actions'];
        $options = [];
        foreach ($actions as $action) {
            $options[] = $action::options();
        }
        return $options;
    }

    /**
     *  execute action from index resource as a multiple ids or single id
     * @return redirect ;
     */
    public function execAction($id = null)
    {
        if (request()->has('ids') && is_array(request('ids')) && count(request('ids')) > 0) {
            $action = json_decode(request('action'));

            if (is_object($action) && isset($action->column) && isset($action->value)) {

                foreach (request('ids') as $ids) {
                    $model = $this->resource['model']::find($ids);
                    if (!empty($model)) {
                        if (!empty($model->{$action->column})) {
                            $model->{$action->column} = $action->value;
                        } elseif (!empty($model->updated_at)) {
                            $model->updated_at = now();
                        }
                        $model->save();
                    }
                }

                $message = $this->getActionMessage($action->column, $action->value);
                session()->flash($message[0], $message[1]);
            } else {
                session()->flash('error', __('dash::dash.faield_action'));
            }
        } else {
            return $this->resource['model']::find($id);
        }
        return back();
    }

    /**
     * Get Action Message From ActionClass In Resource
     * @param string $col
     * @param string $val
     * @return array;
     */
    public function getActionMessage($col, $val)
    {

        foreach ($this->prepare_actions() as $action) {

            if (in_array($col, array_keys($action))) {
                $viaType = $action[$col][$val];
                if (isset($viaType['success'])) {
                    return ['success', $viaType['success']];
                } elseif (isset($viaType['danger'])) {
                    return ['danger', $viaType['danger']];
                } elseif (isset($viaType['warning'])) {
                    return ['warning', $viaType['warning']];
                } elseif (isset($viaType['info'])) {
                    return ['info', $viaType['info']];
                } else {
                    return ['success', __('dash::dash.action_was_done')];
                }
            }
        }
    }
}

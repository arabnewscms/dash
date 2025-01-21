<?php
namespace Dash\RenderableElements\Elements;

trait CustomHtmlFromBlade {

	public function getCustomHtmlFromBladeElement($field, $model, $page) {
		return isset($field['view']) ? view($field['view'], compact('field', 'model', 'page'))->render() : '<div class="col-12">' . $field['name'] . '</div>';
	}

}

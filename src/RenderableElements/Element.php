<?php
namespace Dash\RenderableElements;
use Dash\RenderableElements\Elements\Audio;
use Dash\RenderableElements\Elements\Checkbox;
use Dash\RenderableElements\Elements\Ckeditor;
use Dash\RenderableElements\Elements\Color;
use Dash\RenderableElements\Elements\CustomHtmlFromBlade;
use Dash\RenderableElements\Elements\Date;
use Dash\RenderableElements\Elements\DateTimeElm;
use Dash\RenderableElements\Elements\Dropzone;
use Dash\RenderableElements\Elements\Email;
use Dash\RenderableElements\Elements\File;
use Dash\RenderableElements\Elements\Hidden;
use Dash\RenderableElements\Elements\Image;
use Dash\RenderableElements\Elements\Month;
use Dash\RenderableElements\Elements\Number;
use Dash\RenderableElements\Elements\Password;
use Dash\RenderableElements\Elements\Relation\BelongsTo;
use Dash\RenderableElements\Elements\Relation\BelongsToMany;
use Dash\RenderableElements\Elements\Relation\MorphTo;
use Dash\RenderableElements\Elements\Search;
use Dash\RenderableElements\Elements\Select;
use Dash\RenderableElements\Elements\Tel;
use Dash\RenderableElements\Elements\Text;
use Dash\RenderableElements\Elements\Textarea;
use Dash\RenderableElements\Elements\Time;
use Dash\RenderableElements\Elements\Url;
use Dash\RenderableElements\Elements\Video;
use Dash\RenderableElements\Elements\Week;

class Element {
	use Text, Textarea, Email, Password, Image, Tel, Url, Search, Number, Week, Month, Date, DateTimeElm, Time, Checkbox, File, Video, Audio, Color, Select, MorphTo, BelongsTo, BelongsToMany, Ckeditor, Dropzone, Hidden, CustomHtmlFromBlade;

	public $elements = [];
	public $fields   = [];
	public $model;
	public $page;

	public function __construct(array $fields, $model, $page = 'create') {
		$this->fields = $fields;
		$this->page   = $page;
		$this->model  = $model;
	}

	/**
	 * Render and perpare elements and inputs with HTML5
	 * create and update in sametime and using with specific callable
	 * @return array $this->elements
	 */
	public function render() {
		//dd($this->fields);
		foreach ($this->fields as $field) {
			if ($field['type'] == 'text') {
				$this->elements[] = $this->getTextElement($field, $this->model, $this->page);
			} elseif ($field['type'] == 'textarea') {
				$this->elements[] = $this->getTextareaElement($field, $this->model, $this->page);
			} elseif ($field['type'] == 'email') {
				$this->elements[] = $this->getEmailElement($field, $this->model, $this->page);
			} elseif ($field['type'] == 'password') {
				$this->elements[] = $this->getPasswordElement($field, $this->model, $this->page);
			} elseif ($field['type'] == 'file') {
				$this->elements[] = $this->getFileElement($field, $this->model, $this->page);
			} elseif ($field['type'] == 'image') {
				$this->elements[] = $this->getImageElement($field, $this->model, $this->page);
			} elseif ($field['type'] == 'video') {
				$this->elements[] = $this->getVideoElement($field, $this->model, $this->page);
			} elseif ($field['type'] == 'audio') {
				$this->elements[] = $this->getAudioElement($field, $this->model, $this->page);
			} elseif ($field['type'] == 'tel') {
				$this->elements[] = $this->getTelElement($field, $this->model, $this->page);
			} elseif ($field['type'] == 'url') {
				$this->elements[] = $this->getUrlElement($field, $this->model, $this->page);
			} elseif ($field['type'] == 'search') {
				$this->elements[] = $this->getSearchElement($field, $this->model, $this->page);
			} elseif ($field['type'] == 'number') {
				$this->elements[] = $this->getNumberElement($field, $this->model, $this->page);
			} elseif ($field['type'] == 'checkbox') {
				$this->elements[] = $this->getCheckboxElement($field, $this->model, $this->page);
			} elseif ($field['type'] == 'color') {
				$this->elements[] = $this->getColorElement($field, $this->model, $this->page);
			} elseif ($field['type'] == 'date') {
				$this->elements[] = $this->getDateElement($field, $this->model, $this->page);
			} elseif ($field['type'] == 'month') {
				$this->elements[] = $this->getMonthElement($field, $this->model, $this->page);
			} elseif ($field['type'] == 'week') {
				$this->elements[] = $this->getWeekElement($field, $this->model, $this->page);
			} elseif ($field['type'] == 'time') {
				$this->elements[] = $this->getTimeElement($field, $this->model, $this->page);
			} elseif ($field['type'] == 'datetime') {
				$this->elements[] = $this->getDateTimeElement($field, $this->model, $this->page);
			} elseif ($field['type'] == 'select') {
				$this->elements[] = $this->getSelectElement($field, $this->model, $this->page);
			} elseif ($field['type'] == 'morphTo') {
				$this->elements[] = $this->getmorphToElement($field, $this->model, $this->page);
			} elseif ($field['type'] == 'belongsTo') {
				$this->elements[] = $this->getbelongsToElement($field, $this->model, $this->page);
			} elseif ($field['type'] == 'belongsToMany') {
				$this->elements[] = $this->getbelongsToManyElement($field, $this->model, $this->page);
			} elseif ($field['type'] == 'ckeditor') {
				$this->elements[] = $this->getCkeditorElement($field, $this->model, $this->page);
			} elseif ($field['type'] == 'dropzone') {
				$this->elements[] = $this->getDropzoneElement($field, $this->model, $this->page);
			} elseif ($field['type'] == 'hidden') {
				$this->elements[] = $this->getHiddenElement($field, $this->model, $this->page);
			} elseif ($field['type'] == 'customHtml') {
				$this->elements[] = $this->getCustomHtmlFromBladeElement($field, $this->model, $this->page);
			}
		}
		return $this->elements;
	}
}
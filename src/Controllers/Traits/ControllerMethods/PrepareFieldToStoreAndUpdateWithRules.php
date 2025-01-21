<?php
namespace Dash\Controllers\Traits\ControllerMethods;
use SuperClosure\Serializer;
use Storage;


trait PrepareFieldToStoreAndUpdateWithRules {
	protected $fillableTypes = [
		'text', 'textarea', 'editor', 'email', 'select', 'url', 'tel', 'search', 'number', 'month', 'week', 'password', 'checkbox', 'file', 'image', 'video', 'audio', 'color', 'date', 'datetime',
		'time', 'morphTo', 'belongsTo', 'belongsToMany', 'ckeditor', 'hidden', //, 'customHtml',
	];

	public function loadField($type = "add") {
		$field_list = [];
		foreach ($this->fields() as $field) {
			if (in_array($field['type'], $this->fillableTypes)) {
				$rules = [];
				if ($type == 'add') {
					if (isset($field['rule']) && isset($field['ruleWhenCreate'])) {
						$rules = array_merge($field['rule'], $field['ruleWhenCreate']);
					} elseif (isset($field['rule'])) {
						$rules = $field['rule'];
					} elseif (isset($field['ruleWhenCreate'])) {
						$rules = $field['ruleWhenCreate'];
					} elseif (isset($field['storeRule'])) {
						$rules = $field['ruleWhenCreate'];
					}
				} elseif ($type == 'edit') {
					if (isset($field['rule']) && isset($field['ruleWhenUpdate'])) {
						$rules = array_merge($field['rule'], $field['ruleWhenUpdate']);
					} elseif (isset($field['rule'])) {
						$rules = $field['rule'];
					} elseif (isset($field['ruleWhenUpdate'])) {
						$rules = $field['ruleWhenUpdate'];
					}
				}

				$data = [
					'attribute' => $field['attribute'],
					'rules' => $rules,
					'nicename' => $field['name'],
					'type' => $field['type'],
					'translatable' => isset($field['translatable']) ? $field['translatable'] : null,
					'value' => $this->getValue($field),
					'whenStore' => isset($field['whenStore']) ? $field['whenStore'] : '',
					'whenUpdate' => isset($field['whenUpdate']) ? $field['whenUpdate'] : '',
				];

				// prepare Sub Value From MorphTo
				// morphTo get Type selected
				if ($field['type'] == 'morphTo') {
					$name = resourceShortName($this->getValue($field));

					$data['morphToValueSelect'] = request($name);
					$field_list[] = [
						'attribute' => $name,
						'rules' => $rules,
						'nicename' => $name,
						'type' => 'selectedMorphTo',
						'value' => request($name),
						'whenStore' => isset($field['whenStore']) ? $field['whenStore'] : '',
						'whenUpdate' => isset($field['whenUpdate']) ? $field['whenUpdate'] : '',
					];
				}

				$addInput = false;
				// main input data
				if ($type == 'add' && $field['show_rules']['showInCreate']) {
					$addInput = true;
				} elseif ($type == 'edit' && $field['show_rules']['showInUpdate']) {

					$addInput = true;
				}

				if ($addInput) {
					$field_list[] = $data;
				}

			} elseif ($field['type'] == 'customHtml') {
				if (isset($field['assign_fields']) && !empty($field['assign_fields'])) {
					foreach ($field['assign_fields'] as $inputName => $value) {

						if ($type == 'add') {
							$rules = isset($value['storeRule']) ? $value['storeRule'] : '';
						} else {
							$rules = isset($value['updateRule']) ? $value['updateRule'] : '';
						}
						// custom HTML input data
						$data = [
							'attribute' => $inputName,
							'rules' => $rules,
							'nicename' => $value['name'],
							'type' => $field['type'],
							'value' => request($inputName),
						];
						$field_list[] = $data;
					}
				}
			}

		}

		return $field_list;
	}

	public function getValue($field) {
		if ($field['type'] == 'password') {
			return request($field['attribute']);
		} elseif ($field['type'] == 'checkbox') {
			if (!empty(request($field['attribute']))) {
				$value = request($field['attribute']);
			} elseif (isset($field['falseVal'])) {
				$value = $field['falseVal'];
			} else {
				$value = null;
			}

			return $value;
		} elseif (in_array($field['type'], ['image', 'file', 'video', 'audio'])) {
			return [
				'file' => request()->hasFile($field['attribute']) ? request()->file($field['attribute']) : null,
				'path' => isset($field['path']) ? $field['path'] : $field['attribute'],
			];
		} elseif ($field['type'] == 'morphTo') {
			return request($field['attribute']);
		} elseif ($field['type'] == 'belongsTo') {
			return request($field['attribute']);
		} elseif ($field['type'] == 'belongsToMany') {
			return request($field['attribute']);
		} else {
			return request($field['attribute']);
		}
	}

	/**
	 * beforeStore Data
	 * @return $model object
	 */
	public function beforeStore($model) {
		foreach ($this->loadField() as $field) {

			if (!in_array($field['type'], ['file', 'image', 'video', 'audio'])) {
				/**
				 * insert morphToValue
				 * Get The SubValue Selected From Other Input
				 * To Inject Into morphID Column like user_type_id
				 */
                if (in_array($field['type'],['morphTo','selectedMorphTo'])) {
                    if(isset($field['morphToValueSelect']) && !empty($field['attribute']) && !empty($field['value'])) {
                        $model->{$field['attribute'] . '_type'} = $field['value'];
                        $model->{$field['attribute'] . '_id'} = $field['morphToValueSelect'];
                        /**
                         * Remove Additional Input From MorphTo LIKE UserType
                         * by Value Name Like \App\Models\UserType @Model
                         * from resourceShortName function
                         * @param string $field['value']
                         */
                        $name = resourceShortName($field['value']);
                        unset($model->{$name});
                    }
				}
				/**
				 * get the belongsTo value by  getForeignKeyName()
				 * from model
				 */
				elseif ($field['type'] == 'belongsTo') {
					$field['attribute'] = $model->{$field['attribute']}()->getForeignKeyName();
					$model->{$field['attribute']} = $field['value'];
				} elseif (!in_array($field['type'], ['belongsToMany','morphTo','selectedMorphTo']) && empty($field['translatable'])) {
                    $model->{$field['attribute']} = $field['value'];
				} elseif (isset($field['translatable']) && !empty($field['translatable'])) {
					/**
					 * Translatable Fill
					 */
					foreach ($field['translatable'] as $key => $value) {
						$model->{$field['attribute'] . ':' . $key} = request($key . '.' . $field['attribute']);
					}

				}

			} else if (in_array($field['type'], ['file', 'image', 'video', 'audio'])) {
				$model->{$field['attribute']} = '';
			}
		}

		// save without file uploads
		$model->save();
		return $model;
	}

	/**
	 * afterStore Data
	 * @return $model object
	 */
	public function afterStore($model) {
		foreach ($this->loadField() as $field) {

			/**
			 * belongsToMany to attach all selected multiple value
			 * @param array | $field['attribute']
			 */
			if ($field['type'] == 'belongsToMany' && method_exists($model, $field['attribute'])) {
				// attach belongsToMany
				$model->{$field['attribute']}()->attach($field['value']);
			} else if (in_array($field['type'], ['file', 'image', 'video', 'audio'])) {
				// upload when not have store function
				if (empty($field['whenStore'])) {
					// Get Serializer path
					if (is_array($field['value']['path'])) {
						if ($field['value']['path']['serialize']) {
							$path = $unserializedPath = (new Serializer())->unserialize($field['value']['path']['source']);
							// passing the model data after created
							$path = $path($model);
						} else {
							$path = $field['value']['path']['source'];
						}
					} else {
						$path = $field['attribute'];
					}

					$path = $this->replaceColumns($model, $path);

					$value = !empty($field['value']['file']) ? $field['value']['file']->store($path,config('dash.FILESYSTEM_DISK')) : '';
					$model->{$field['attribute']} = !empty($value)?Storage::disk(config('dash.FILESYSTEM_DISK'))->url($value):$value;
				}
			}

			// When Store Data unserialize Closure to do in there code
			if (isset($field['whenStore']) && !empty($field['whenStore'])) {
				$unserialized = (new Serializer())->unserialize($field['whenStore']);
				// passing the model data after created
				$data = $unserialized($model);
				if (is_string($data)) {
					$model->{$field['attribute']} = $data;
				} elseif (is_array($data)) {
					foreach ($data as $key => $val) {
						$model->{$key} = $val;
					}
				}

			}
			// save with file uploads
			$model->save();
		}
		return $model;
	}

	/**
	 *  before Update
	 * @return $model object
	 */
	public function beforeUpdate($model) {

		foreach ($this->loadField('edit') as $field) {
			if (!in_array($field['type'], ['file', 'image', 'video', 'audio'])) {
				/**
				 * insert morphToValue
				 * Get The SubValue Selected From Other Input
				 * To Inject Into morphID Column like user_type_id
				 */
                if (in_array($field['type'],['morphTo','selectedMorphTo'])) {
                    if(isset($field['morphToValueSelect']) && !empty($field['attribute']) && !empty($field['value'])) {
                        $model->{$field['attribute'] . '_type'} = $field['value'];
                        $model->{$field['attribute'] . '_id'} = $field['morphToValueSelect'];
                        /**
                         * Remove Additional Input From MorphTo LIKE UserType
                         * by Value Name Like \App\Models\UserType @Model
                         * from resourceShortName function
                         * @param string $field['value']
                         */
                        $name = resourceShortName($field['value']);
                        unset($model->{$name});
                    }
				}
				/**
				 * get the belongsTo value by  getForeignKeyName()
				 * from model
				 */
				elseif ($field['type'] == 'belongsTo') {
					$field['attribute'] = $model->{$field['attribute']}()->getForeignKeyName();
					$model->{$field['attribute']} = $field['value'];
				} elseif (!in_array($field['type'], ['belongsToMany','morphTo','selectedMorphTo']) && empty($field['translatable'])) {

                       $model->{$field['attribute']} = $field['value'];

				} elseif (isset($field['translatable']) && !empty($field['translatable'])) {
					/**
					 * Translatable Fill
					 */
					foreach ($field['translatable'] as $key => $value) {
						$model->{$field['attribute'] . ':' . $key} = request($key . '.' . $field['attribute']);
					}

				}

			}
		}
		return $model;
	}

	/**
	 *  after Update
	 * @return $model object
	 */
	public function afterUpdate($model) {
		foreach ($this->loadField('edit') as $field) {
			/**
			 * belongsToMany to attach all selected multiple value
			 * @param array | $field['attribute']
			 */
			if ($field['type'] == 'belongsToMany' && method_exists($model, $field['attribute'])) {
				// attach,detach belongsToMany
				$model->{$field['attribute']}()->detach();
				$model->{$field['attribute']}()->attach($field['value']);

			} else if (in_array($field['type'], ['file', 'image', 'video', 'audio'])) {
				// upload when not have store function
				if (empty($field['whenUpdate'])) {

					// Get Serializer path
					if (is_array($field['value']['path'])) {
						if ($field['value']['path']['serialize']) {
							$path = $unserializedPath = (new Serializer())->unserialize($field['value']['path']['source']);
							// passing the model data after created
							$path = $path($model);
						} else {
							$path = $field['value']['path']['source'];
						}
					} else {
						$path = $field['attribute'];
					}

					/**
					 * control for file upload
					 * when update values
					 */
					if (!empty($field['value']['file'])) {
						$path = $this->replaceColumns($model, $path);
						$value = $field['value']['file']->store($path,config('dash.FILESYSTEM_DISK'));
						$model->{$field['attribute']} =!empty($value)?Storage::disk(config('dash.FILESYSTEM_DISK'))->url($value):$value;
					} else {
						$model->{$field['attribute']} = $model->{$field['attribute']};
					}
				}
			}

			// When Store Data unserialize Closure to do in there code
			if (isset($field['whenUpdate']) && !empty($field['whenUpdate'])) {
				$unserialized = (new Serializer())->unserialize($field['whenUpdate']);
				// passing the model data after created
				$data = $unserialized($model);
				if (is_string($data)) {
					$model->{$field['attribute']} = $data;
				} elseif (is_array($data)) {
					foreach ($data as $key => $val) {
						$model->{$key} = $val;
					}
				}

			}
		}
		return $model;
	}

}

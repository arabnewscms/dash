<?php

namespace Dash\Controllers\Traits\Supplements;

use Illuminate\Database\Eloquent\Builder;

trait DatatableResource
{
    protected $registerForeignKeyNames       = [];
    protected $resourcesRelatedWithRelations = [];

    /**
     * Register foreign key names for relationships.
     */
    public function registerForeignKeyNames($q, $resource)
    {
        $type = '';
        foreach ($this->fields() as $fetchField) {
            if (in_array($fetchField['type'], $this->relationTypes)) {
                $attribute = explode('.', $fetchField['attribute']);
                if (!empty($attribute) && count($attribute) > 0) {
                    if ($attribute[0] == $resource) {
                        $type = $fetchField['type'];
                    }
                }
            }
        }

        if (in_array($type, $this->relationTypes)) {
            $keyRelation = null;

            foreach (['getForeignKeyName', 'getQualifiedParentKeyName', 'getQualifiedRelatedKeyName'] as $method) {
                if (method_exists($q, $method)) {
                    $keyRelation = $q->{$method}();
                    break;
                }
            }

            if ($keyRelation) {
                $this->registerForeignKeyNames[$resource] = [
                    $resource      => $keyRelation,
                    'relationType' => $type,
                ];
            }
        }
    }

    /**
     * Register related resources with URLs.
     */
    public function resourcesRelatedWithRelations()
    {
        foreach ($this->resource['fields'][0]::$input as $input) {
            if (!isset($input['resource'])) {
                continue;
            }

            $resourceName = resourceShortName($input['resource']);
            $attribute    = explode('.', $input['attribute'])[0];
            $foreign      = $this->registerForeignKeyNames[$attribute] ?? null;

            $url = '';
            if (in_array($input['type'], $this->relationOneTypes)) {
                $url = url(app()['dash']['DASHBOARD_PATH'] . '/resource/' . $resourceName) . '/';
            } elseif ($foreign) {
                $manyType = match ($foreign['relationType']) {
                    'belongsToMany'   => 'loadByResourceToMany',
                    'belongsTo'       => 'loadByResourcebelongsTo',
                    'hasOneThrough'   => 'loadByResourcehasOneThrough',
                    'hasOne'          => 'loadByResourcehasOne',
                    'hasManyThrough'  => 'loadByResourcehasManyThrough',
                    'hasMany'         => 'loadByResourcehasMany',
                    'morphTo'         => 'loadByResourcemorphTo',
                    'morphMany'       => 'loadByResourcemorphMany',
                    'morphToMany'     => 'loadByResourcemorphToMany',
                    'morphedByMany'   => 'loadByResourcemorphedByMany',
                    default           => 'loadByResourcehasMany',
                };

                $url = url(app()['dash']['DASHBOARD_PATH'] . '/resource/' . $resourceName . '?' . $manyType . '[' . array_values($foreign)[0] . ']=');
            }

            if ($foreign) {
                $this->resourcesRelatedWithRelations[$attribute] = [
                    'getForeignKeyName' => $foreign,
                    'resourceName'      => $resourceName,
                    'url'               => $url,
                ];
            }
        }
    }

    /**
     * Apply filters to the query.
     */
    public function filters(Builder $table)
    {
        if (empty(request('filters'))) {
            return $table;
        }

        $decode = json_decode(request('filters'), true);
        foreach ($decode as $filter) {
            if (empty($filter['name']) || !isset($filter['value'])) {
                continue;
            }

            $dateRange = dash_check_range_date_input($filter['value']);
            $column = $filter['name'];
            $value  = $filter['value'];

            if ($dateRange) {
                if ($dateRange['multiple']) {
                    $table->whereIn(\DB::raw('DATE(' . $column . ')'), $dateRange['dates']);
                } else {
                    $table->whereBetween($column, $dateRange['dates']);
                }
            } elseif (strtotime($value) !== false) {
                $table->whereDate($column, $value);
            } elseif (!empty($column) && !empty($value)) {
                $table->where($column, $value);
            }
        }

        return $table;
    }

    /**
     * Apply search for columns.
     */
    public function searchable(Builder $table)
    {
        $searchValue = trim(request('search.value') ?? '');
        if (empty($searchValue) || count($this->search) < 1) {
            return $table;
        }

        $table->where(function ($q) use ($searchValue) {
            foreach ($this->search as $column) {
                if (
                    !empty(app($this->resource['model'])->translatedAttributes) &&
                    in_array($column, app($this->resource['model'])->translatedAttributes)
                ) {
                    $q->orWhereTranslationLike($column, "%{$searchValue}%");
                } else {
                    $q->orWhere($column, 'LIKE', "%{$searchValue}%");
                }
            }
        });

        return $table;
    }

    /**
     * Apply search on related models efficiently.
     */
    public function searchWithRelation(Builder $table)
    {
        $searchValue = trim(request('search.value') ?? '');
        if (empty($searchValue) || empty($this->searchWithRelation)) {
            return $table;
        }

        foreach ($this->searchWithRelation as $relation => $columns) {
            $table->whereHas($relation, function ($q) use ($columns, $searchValue) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'LIKE', "%{$searchValue}%");
                }
            });
        }

        return $table;
    }

    /**
     * Apply ordering.
     */
    public function orderable(Builder $q)
    {
        if (!request()->has('order.0.column')) {
            return $q;
        }

        $multiSelectRecord = $this->resource['multiSelectRecord'] ? 1 : 0;
        $colIndex = request('order.0.column') - $multiSelectRecord;

        if (isset($this->search[$colIndex])) {
            $q->orderBy($this->search[$colIndex], request('order.0.dir'));
        }

        return $q;
    }

    /**
     * Main datatable method.
     */
    public function datatable()
    {
        // Base query
        $table = app($this->resource['model'])::query();

        // Trashed
        if (request('withTrashed') == "true") {
            $table->onlyTrashed();
        }

        // Filters
        $table = $this->filters($table);

        // Eager load relationships for searchWithRelation
        if (!empty($this->searchWithRelation)) {
            $table->with(array_keys($this->searchWithRelation));
        }

        // Search
        $table = $this->searchWithRelation($table);
        $table = $this->searchable($table);

        // Order
        $table = $this->orderable($table);

        // Custom resource query
        $table = app($this->resource['resourceNameFull'])->query($table);

        $totalRecordsWithFilter = $table->count();
        $totalRecords = $totalRecordsWithFilter;

        // Pagination
        if ($this->resource['paging']) {
            $table->skip(request('start'))->take(request('length'));
        }

        $data = $table->get()->toArray();

        // Register resources URLs
        $this->resourcesRelatedWithRelations();

        return response()->json([
            'draw'            => request('draw'),
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalRecordsWithFilter,
            'data'            => $data,
            'ForeignKeyNames' => $this->registerForeignKeyNames,
            'resources'       => $this->resourcesRelatedWithRelations,
        ]);
    }

    /**
     * SubDatatable alias.
     */
    public function SubDatatable()
    {
        return $this->datatable();
    }
}

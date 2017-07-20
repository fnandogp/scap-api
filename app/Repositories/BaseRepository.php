<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder as EloquentQueryBuilder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\AbstractPaginator;

abstract class BaseRepository
{
    /**
     * Model class for repo.
     *
     * @var string
     */
    protected $model_class;

    /**
     * @return EloquentQueryBuilder|QueryBuilder
     */
    protected function newQuery()
    {
        return app($this->model_class)->newQuery();
    }

    /**
     * @param $query
     * @param $take
     * @param $paginate
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|EloquentCollection|static[]
     */
    protected function doQuery($query = null, $take = 15, $paginate = true)
    {
        if (is_null($query)) {
            $query = $this->newQuery();
        }
        if (true == $paginate) {
            return $query->paginate($take);
        }

        if ($take > 0 || false !== $take) {
            $query->take($take);
        }

        return $query->get();
    }

    /**
     * Returns all records.
     * If $take is false then brings all records
     * If $paginate is true returns Paginator instance.
     *
     * @param int $take
     * @param bool $paginate
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|EloquentCollection|static[]
     */
    public function getAll($take = 15, $paginate = true)
    {
        return $this->doQuery(null, $take, $paginate);
    }

    /**
     * Retrieves a record by his id
     * If fail is true $ fires ModelNotFoundException.
     *
     * @param int $id
     * @param bool $fail
     *
     * @return EloquentQueryBuilder
     */
    public function find($id, $fail = true)
    {
        if ($fail) {
            return $this->newQuery()->findOrFail($id);
        }

        return $this->newQuery()->find($id);
    }

    /**
     * List the
     *
     * @param string $column
     * @param string|null $key
     *
     * @return \Illuminate\Support\Collection
     */
    public function lists($column, $key = null)
    {
        return $this->newQuery()->lists($column, $key);
    }

    /**
     * Create a model class instance
     *
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data)
    {
        return app($this->model_class)::create($data);
    }

    /**
     * Update the model class instance
     *
     * @param $id
     * @param array $data
     *
     * @return mixed
     */
    public function update($id, array $data)
    {
        $object = $this->find($id);
        $object->fill($data);
        $object->save();

        return $object;
    }

    /**
     * Delete the model class instance
     *
     * @param $id
     *
     * @return mixed
     */
    public function delete($id)
    {
        $user = $this->find($id);

        return $user->delete();
    }
}
<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\RepositoryInterface;

abstract class BaseRepository implements RepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model::all();
    }
    public function paginate($number = 10)
    {
        return $this->model->paginate($number);
    }

    public function find($id)
    {
        return $this->model->findOrFail($id)->first();
    }

    public function create($attributes = [])
    {
        return $this->model->create($attributes);
    }

    public function insert($attributes = [])
    {
        return $this->model->insert($attributes);
    }

    public function update($id, $attributes = [])
    {
        return $this->model->where('id', '=', $id)->update($attributes);
    }

    public function delete($id)
    {
        return $this->model->where('id', '=', $id)->delete();
    }
}

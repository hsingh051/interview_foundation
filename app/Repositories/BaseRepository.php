<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseRepository.
 */
class BaseRepository
{
    /**
     * @return Builder[]|Collection
     */
    public function getAll()
    {
        return $this->query()->get();
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->query()->count();
    }

    /**
     * @param $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function find($id)
    {
        return $this->query()->find($id);
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return call_user_func(static::MODEL.'::query');
    }
}

<?php

namespace CodeFin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeFin\Repositories\Interfaces\CategoryRepository;
use CodeFin\Models\Category;
use CodeFin\Validators\CategoryValidator;

/**
 * Class CategoryRepositoryEloquent
 * @package namespace CodeFin\Repositories;
 */
class CategoryRepositoryEloquent extends BaseRepository implements CategoryRepository
{
    public function create(array $attributes)
    {
        if(isset($attributes['parent_id'])){
            $skipPresenter = $this->skipPresenter;
            $this->skipPresenter(true);
            $parent = $this->find($attributes['parent_id']);
            $this->skipPresenter = $skipPresenter;
            $child = $parent->children()->create($attributes);
            return $this->parserResult($child);
        }

        return parent::create($attributes);
    }

    public function update(array $attributes, $id)
    {
        if(isset($attributes['parent_id'])){
            $skipPresenter = $this->skipPresenter;
            $this->skipPresenter(true);
            $child = $this->find($id);
            $child->parent_id = $attributes['parent_id'];
            $child->save();
            $this->skipPresenter = $skipPresenter;
            return $this->parserResult($child);
        }

        return parent::update($attributes, $id);
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Category::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter()
    {
        return \CodeFin\Presenters\CategoryPresenter::class;
    }
}

<?php

namespace CodeFin\Transformers;

use League\Fractal\TransformerAbstract;
use CodeFin\Models\Category;

/**
 * Class CategoryTransformer
 * @package namespace CodeFin\Transformers;
 */
class CategoryTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['children'];

    /**
     * Transform the \Category entity
     * @param \Category $model
     *
     * @return array
     */
    public function transform(Category $model)
    {
        return [
            'id' => (int)$model->id,
            'name' => $model->name,
            'parent_id' => $model->parent_id,
            'depth' => $model->depth,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    public function includeChildren(Category $model)
    {
        $children = $model->children()->withDepth()->get();
        return $this->collection($children, new CategoryTransformer());
    }
}

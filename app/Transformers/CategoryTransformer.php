<?php

namespace CodeFin\Transformers;

use CodeFin\Models\AbstractCategory;
use CodeFin\Models\Category;
use League\Fractal\TransformerAbstract;

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
    public function transform(AbstractCategory $model)
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

    public function includeChildren(AbstractCategory $model)
    {
        $children = $model->children()->withDepth()->get();
        return $this->collection($children, new CategoryTransformer());
    }
}

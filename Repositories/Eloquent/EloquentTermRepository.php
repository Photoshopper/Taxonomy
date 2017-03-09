<?php

namespace Modules\Taxonomy\Repositories\Eloquent;

use Modules\Taxonomy\Entities\Term;
use Modules\Taxonomy\Repositories\TermRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use ImageManager;

class EloquentTermRepository extends EloquentBaseRepository implements TermRepository
{
    /**
     * @param  mixed  $request
     * @return object
     */
    public function create($request)
    {
        $data = $request->all();

        $data['image'] = ImageManager::upload($request, 'image', 'taxonomy');

        if($request->input('parent_id') != null) {
            $model = Term::where('id', '=', $request->input('parent_id'))->first();
            $model->children()->create($request->all());
        } else {
            $model = $this->model->create($data);
        }

        return $model;
    }

    /**
     * @param $model
     * @param  array  $request
     * @return object
     */
    public function update($model, $request)
    {
        $data = $request->all();

        $data['image'] = ImageManager::upload($request, 'image', 'taxonomy', $model->image);

        $parent_id = $request->input('parent_id');

        if ($parent_id != null && $model->parent_id != $parent_id) {
            $new_parent = Term::where('id', $parent_id)->first();
            $model->makeChildOf($new_parent);
        } elseif($parent_id == null && $model->parent_id != null) {
            $model->makeRoot();
        }

        $model->update($data);

        return $model;
    }

    /**
     * @param $model
     * @return boolean
     */
    public function destroy($model)
    {
        ImageManager::delete($model->image, 'taxonomy');

        return $model->delete();
    }
}

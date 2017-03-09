<?php namespace Modules\Taxonomy\Services;

use Modules\Taxonomy\Entities\Term;

class TaxonomyOrderer
{
    /**
     * Order recursively the taxonomy menu items
     *
     * @param array $terms
     */
    public function menuOrdererHandler($terms)
    {
        foreach($terms as $parent) {
            Term::find($parent['id'])->makeRoot();

            if(isset($parent['children'])) {
                $this->handleChildrenForParent($parent);
            }
        }
    }

    /**
     * Recursive function for a taxonomy menu
     * 
     * @param array $parent
     */
    private function handleChildrenForParent($parent)
    {
        foreach ($parent['children'] as $child) {
            $new_parent = Term::find($parent['id']);

            Term::find($child['id'])->makeChildOf($new_parent);

            if(isset($child['children'])) {
                $this->handleChildrenForParent($child);
            }
        }
    }

}
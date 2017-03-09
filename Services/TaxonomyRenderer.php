<?php namespace Modules\Taxonomy\Services;


class TaxonomyRenderer
{
    private $menu = '';

    /**
     * Render a taxonomy menu for a backend
     *
     * @param $terms
     * @return string
     */
    public function renderTaxonomyMenu($terms)
    {
        if($terms->count() > 0) {
            $this->menu .= '<div class="dd">';
            $this->generateTaxonomyMenu($terms);
            $this->menu .= '</div>';
        } else {
            $this->menu .= trans('taxonomy::terms.table.no terms');
        }

        return $this->menu;
    }

    /**
     * Generate html for a list of terms for a backend
     *
     * @param $terms
     */
    private function generateTaxonomyMenu($terms)
    {
        $this->menu .= '<ol class="dd-list">';

        foreach ($terms as $term) {
            $this->menu .= "<li class=\"dd-item\" data-id=\"{$term->id}\">";
            $editLink = route('admin.taxonomy.term.edit', [$term->vocabulary_id, $term->id]);
            $deleteLink = route('admin.taxonomy.term.destroy', [$term->vocabulary_id, $term->id]);
            $this->menu .= <<<HTML
<div class="btn-group" style="float:right;">
    <a class="btn btn-sm btn-info" style="float:left;" href="{$editLink}">
        <i class="fa fa-pencil"></i>
    </a>
    <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{$deleteLink}">
        <i class="fa fa-times"></i>
    </a>
</div>
HTML;
            $this->menu .= "<div class=\"dd-handle\">$term->name</div>";

            if ($term->children->count() > 0) {
                $this->menu .= $this->generateTaxonomyMenu($term->children);
            }
            
            $this->menu .= "</li>";
        }

        $this->menu .= '</ol>';
    }
    
}

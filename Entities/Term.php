<?php

namespace Modules\Taxonomy\Entities;

use Modules\Taxonomy\Services\Translatable;
use Baum\Node;

class Term extends Node
{
    use Translatable;

    protected $table = 'taxonomy__terms';
    public $translatedAttributes = [
        'name',
        'slug',
        'description',
        'meta_title',
        'meta_keywords',
        'meta_description'
    ];
    protected $fillable = ['vocabulary_id', 'image'];

    public function vocabulary() {
        return $this->belongsTo(Vocabulary::class);
    }

    /**
     * Return an key-value array indicating the node's depth with a seperator
     *
     * @param string $vocabulary_name
     * @return array
     */
    public static function getList($vocabulary_name)
    {
        $vocabulary = Vocabulary::where('machine_name', $vocabulary_name)->first();
        $nodes = $vocabulary->terms->toArray();
        $key = 'id';
        $depthColumn = 'depth';
        $seperator = '--';
        $column = 'name';

        return array_combine(array_map(function($node) use($key) {
            return $node[$key];
        }, $nodes), array_map(function($node) use($seperator, $depthColumn, $column) {
            return str_repeat($seperator, $node[$depthColumn]) . $node[$column];
        }, $nodes));
    }

    /**
     * Render taxonomy menu
     *
     * @param string $style
     * @param string $vocabulary_name
     * @param string $route
     * @param null $entity_term
     * @return string
     */
    public static function renderTaxonomyMenu($vocabulary_name, $route, $entity_term = null)
    {
        $vocabulary = Vocabulary::where('machine_name', $vocabulary_name)->first();
        $terms = Term::roots()->where('vocabulary_id', $vocabulary->id)->get();

        return self::generateTaxonomyMenu($terms, $route, $entity_term);
    }

    /**
     * Generate html for taxonomy menu
     *
     * @param $terms
     * @param string $route
     * @param $entity_term
     * @return string $menu
     */
    private static function generateTaxonomyMenu($terms, $route, $entity_term)
    {
        $menu = '';
        $menu .= '<ul>';

        foreach ($terms as $term) {
            $menu .= '<li ' . self::activeItemClass($term, $entity_term) . '>';
            $menu .= '<a href="' . route($route, $term->slug) . '"' . self::activeItemClass($term, $entity_term) . '>' . $term->name . '</a>';

            if ($term->children->count() > 0) {
                $menu .= self::generateTaxonomyMenu($term->children, $route, $entity_term);
            }

            $menu .= '</li>';
        }

        $menu .= '</ul>';

        return $menu;
    }

    /**
     * Highlight an active item
     *
     * @param $term
     * @param $entity_term
     * @return bool|string
     */
    private static function activeItemClass($term, $entity_term)
    {
        $segment = config('laravellocalization.hideDefaultLocaleInURL') ? 3 : 4;

        $child = Term::whereTranslation('slug', request()->segment($segment))->first();

        if(request()->segment($segment) == $term->slug) {
            return 'class="active"';
        } elseif ($entity_term != null && $term->isSelfOrAncestorOf($entity_term)) {
            return 'class="active"';
        } elseif ($child != null && $term->isAncestorOf($child)) {
            return 'class="active"';
        }

        return false;
    }

}

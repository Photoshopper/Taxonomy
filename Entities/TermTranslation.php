<?php

namespace Modules\Taxonomy\Entities;

use Illuminate\Database\Eloquent\Model;

class TermTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'meta_title',
        'meta_keywords',
        'meta_description'
    ];
    protected $table = 'taxonomy__term_translations';
}

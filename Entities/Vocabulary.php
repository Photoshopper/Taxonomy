<?php

namespace Modules\Taxonomy\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Vocabulary extends Model
{
    use Translatable;

    protected $table = 'taxonomy__vocabularies';
    public $translatedAttributes = ['name'];
    protected $fillable = ['machine_name'];

    public function terms()
    {
        return $this->hasMany('Modules\Taxonomy\Entities\Term')->orderBy('lft');
    }
}

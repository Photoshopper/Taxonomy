<?php

namespace Modules\Taxonomy\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateTermRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    public function translationRules()
    {
        return [
            'name' => 'required',
            'slug' => "required|unique:taxonomy__term_translations,slug,null,term_id,locale,$this->localeKey",
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    
}

<?php

namespace Modules\Taxonomy\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateVocabularyRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'machine_name' => 'required|alpha_dash'
        ];
    }

    public function translationRules()
    {
        return [
            'name' => 'required'
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

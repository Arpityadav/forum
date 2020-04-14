<?php

namespace App\Http\Requests;

use App\Exceptions\ThrottleException;
use App\Rules\SpamFree;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class CreatePostPolicy extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('create', new \App\Reply);
    }

    protected function failedAuthorization()
    {
        throw new ThrottleException('You are posting too frequently. Please wait for a while.');
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => ['required', new SpamFree],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookmark extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'url' => 'required|active_url|unique:bookmarks,url'
        ];
    }

    public function messages() {
        return [
            'url.required' => 'Поле "Адрес сайта" обязательно для заполнения!',
            'url.active_url' => 'Поле "Адрес сайта" должно содержать ссылку на активный сайт в сети интернет!',
            'url.unique' => 'Такая закладка уже существует в базе данных!'
        ];
    }
}

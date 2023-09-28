<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ReasonRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'name' => [
                'required',
            ],
            'type' => [
                'required',
            ],
            'label' => [
                'nullable',
            ],
            'image' => [
                'nullable',
                function () {
                    $file = $this->file('image');
                    if ($file !== null) {
                        $path = 'reasons/'.Str::slug($this->get('name')).'.'.$file->extension();
                        Storage::disk('local')->put('public/'.$path, $file->getContent());

                        $this->merge(['image_path' => $path]);
                    }
                },
            ],
            'category_id' => [
                'nullable',
            ],
        ];
    }

}

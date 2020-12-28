<?php

namespace Garavel\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;


class CroppieUploadRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'croppie_image_url' => 'required'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator)
        {
            $imageUrl = request()->get('croppie_image_url');
            $imageExtension = request()->get('croppie_image_extension');
            if (is_null($imageUrl))
            {
                return false;
            }

            $configName = request()->get('config_name');
            $croppies = config('croppie');
            $diskConfig = $croppies[$configName];
            $disk = Storage::disk($diskConfig['disk']);


            if (isset($diskConfig['forced_output']) && !is_null($diskConfig['forced_output']))
            {
                $imageExtension = $diskConfig['forced_output'];
            }

            $quality = $diskConfig['quality'] * 100;

            $imageSlug = Str::slug($diskConfig['title']) . '-' . date('YmdHis') . '.' . $imageExtension;
            $manager = new ImageManager();
            $image = $manager->make($imageUrl)->encode($imageExtension, $quality);


            $path = $disk->path($imageSlug);
            $isSaved = $image->save($path);

            $uploadedFile = new  UploadedFile($path, $imageSlug, $imageExtension, 0, true);

            request()->files->add(['saved_image' => $uploadedFile]);

            $validOutputs = $diskConfig['output'];
            $validOutputs = str_replace('|', ',', $validOutputs);

            $imageRules = [
                'mimes:' . $validOutputs,
                'max:' . $diskConfig['max_size_kb'],
                'dimensions:width=' . $diskConfig['width'] . ',height=' . $diskConfig['height']
            ];

            $errorMessages = [
                'saved_image.image'      => 'Resim yüklemelisiniz',
                'saved_image.mimes'      => 'Resim ' . $validOutputs . ' formatlarından birisi olmalıdır',
                'saved_image.max'        => 'Resim boyutu en fazla ' . ($diskConfig['max_size_kb'] / 1024) . 'MB olmalıdır',
                'saved_image.dimensions' => 'Resim ebatları ' . $diskConfig['width'] . 'X' . $diskConfig['height'] . ' olmalıdır',
            ];

            $imageRules = implode('|', $imageRules);
            $imageValidator = Validator::make(request()->files->all(), [
                'saved_image' => $imageRules,
            ], $errorMessages);

            if ($imageValidator->fails())
            {
                $disk->delete($path);

                $errors = $imageValidator->errors()->getMessages();

                foreach ($errors as $errorK => $errorM)
                {
                    foreach ($errorM as $message)
                    {
                        $validator->errors()->add($errorK, $message);
                    }

                }

            }

            $this->request->set('saved_image', $imageSlug);

        });
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'croppie_image_url.required' => 'Resim seçmelisiniz',
        ];
    }
}

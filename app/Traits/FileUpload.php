<?php

namespace App\Traits;

use App\Models\Media;
use Illuminate\Http\Request;
use Str, Storage;
use Illuminate\Support\Facades\File;

trait FileUpload
{

    public function uploadFile($file)
    {
        $date = date('Y-m-d');
        $file_name = Str::random(10) . '-' . time();
        $ext = strtolower($file->getClientOriginalExtension());
        $file_full_name = $date . '/' . $file_name . '.' . $ext;
        $upload_path = 'uploads/' . $date . '/';
        if (!File::exists(public_path($upload_path))) {
            File::makeDirectory(public_path($upload_path), 0777, true);
        }
        // $file_path = $upload_path . $file_full_name;

        if (in_array($ext, ['png', 'jpeg', 'jpg', 'gif', 'svg'])) {
            \Image::make($file->getRealPath())->save(public_path('uploads/' . $file_full_name), 40,  $ext);
        } else {
            $file->move($upload_path, $file_full_name);
        }
        // dd($file_full_name);

        $data = [
            'origin_file_name' => $file->getClientOriginalName(),
            'file_name' => $file_name . '.' . $ext,
            'path' => 'uploads/' . $file_full_name,
            'full_path' => asset('uploads/' . $file_full_name),
            'extinsion' => $ext,
        ];
        return $data;
    }

    public function removeFile($file)
    {
        if (File::exists(public_path($file))) {
            File::delete(public_path($file));
        }
    }

    public function appendMediaToValidatedData($data, $request)
    {
        if (isset($data['image'])) {
            $image = Media::create($this->uploadFile($data['image']));
            $data['image_id'] = $image->id;
        }

        if (isset($data['header_media_image'])) {
            $header = Media::create($this->uploadFile($data['header_media_image']));
            $data['header_media_id'] = $header->id;
        }
        unset($data['image']);
        unset($data['header_media_image']);

        return $data;
    }

    public function uploadMedia($file, $request)
    {
        $file = $this->uploadFile($file);

        $image = Media::create($file);

        return $image;
    }
}

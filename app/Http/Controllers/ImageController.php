<?php

namespace App\Http\Controllers;

use App\Http\Requests\Image\StoreRequest;
use App\Http\Resources\Image\ImageResource;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $path = Storage::disk('public')->put('/images', $data['image']);

        $image = Image::create([
            'path' => $path,
            'user_id' => auth()->id()
        ]);

        return ImageResource::make($image)->resolve();
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Actions\JsonResponses;
use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class ItemImageController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:sanctum");
    }

    public function store(Request $request, $id)
    {
        $item = Item::find($id);

        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,jpg,png|max:1024|dimensions:min_width=256,min_height=256,max_width=2048,max_height=2048'
        ]);

        if($validator->fails()) {
            return JsonResponses::sendValidationResponse($validator->errors());
        }

        $result = $request->file('image')->store(config('staytus.images.location.upload'));

        if ($result) {
            // resize image
            $image_path = storage_path('app/' . config('staytus.images.location.upload') . '/' . basename($result));
            Image::make($image_path)->resize(config('staytus.images.size.width'), config('staytus.images.size.height'))->save();

            // remove old image if exists
            if($item->image) {
                $old_image_path = storage_path('app/' . config('staytus.images.location.upload') . '/' . $item->image);

                if (file_exists($old_image_path)) {
                    unlink($old_image_path);
                }
            }

            // add image to item
            $item->image = basename($result);
            $item->save();

            return JsonResponses::sendJsonResponse('success', 201, 'Image uploaded successfully.', ['path' => basename($result)]);
        }

        return JsonResponses::sendJsonResponse('fail', 400, 'Could not upload image.');
    }

    public function destroy($id)
    {
        $item = Item::find($id);

        $image_path = storage_path('app/' . config('staytus.images.location.upload') . '/' . basename($item->image));

        // delete image file
        if(unlink($image_path)) {
            // remove image from item
            $item->image = null;
            $item->save();

            return JsonResponses::sendJsonResponse('success', 200, 'Image deleted successfully.');
        }

        return JsonResponses::sendJsonResponse('error', 500, 'Could not delete image!');
    }
}

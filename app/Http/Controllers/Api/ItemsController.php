<?php

namespace App\Http\Controllers\Api;

use App\Actions\JsonResponses;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use App\Models\Menu;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemsController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:sanctum")->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $items = Item::with(['categories', 'menus'])->get();

        if ($request->has('sort') && in_array(strtolower($request->sort), ['asc', 'desc'])) {
            $items = Item::with(['categories', 'menus'])->orderBy('name', strtolower($request->sort))->get();
        }

        $code = 200;
        $status = 'success';
        $message = 'Records retrieved successfully.';

        if($items->count() <= 0) {
            $code = 404;
            $status = 'fail';
            $message = 'No records found!';
        }

        $data = $items->count() > 0 ? $items : null;

        return JsonResponses::sendJsonResponse($status, $code, $message, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $rules = [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return JsonResponses::sendValidationResponse($validator->errors());
        }

        $item = new Item;
        $item->name = $request->name;
        $item->description = $request->description;
        $item->price = $request->price;

        $item->save();

        // add item to category if exists
        if($request->has('categories')) {
            foreach ($request->categories as $category) {
                // check if category exists
                if(Category::find($category)) {
                    $item->categories()->attach($category);
                }
            }
        }

        // add item to menu if exists
        if($request->has('menus')) {
            foreach ($request->menus as $menu) {
                // check if menu exists
                if(Menu::find($menu)) {
                    $item->menus()->attach($menu);
                }
            }
        }

        return JsonResponses::sendJsonResponse('success', 201, 'Record created successfully.', $item->load(['categories', 'menus']));
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $item = Item::find($id);

        if(! $item) {
            return JsonResponses::sendNotFoundResponse();
        }

        return JsonResponses::sendJsonResponse('success', 200, 'Record retrieved successfully.', $item->load(['categories', 'menus']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $item = Item::find($id);

        if(! $item) {
            return JsonResponses::sendNotFoundResponse();
        }

        $rules = [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return JsonResponses::sendValidationResponse($validator->errors());
        }

        $item->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price
        ]);

        // add item to category if exists
        if($request->has('categories')) {
            foreach ($request->categories as $category) {
                // check if category exists
                if(Category::find($category) && ! $item->categories->contains($category)) {
                    $item->categories()->attach($category);
                }
            }
        }

        // add item to menu if exists
        if($request->has('menus')) {
            foreach ($request->menus as $menu) {
                // check if menu exists
                if(Menu::find($menu) && ! $item->menus->contains($menu)) {
                    $item->menus()->attach($menu);
                }
            }
        }

        return JsonResponses::sendJsonResponse('success', 200, 'Record updated successfully.', $item->load(['categories', 'menus']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $item = Item::find($id);

        if(! $item) {
            return JsonResponses::sendNotFoundResponse();
        }

        if(! $item->delete()) {
            return JsonResponses::sendJsonResponse('error', 500, 'Can not perform action!');
        }

        return JsonResponses::sendJsonResponse('success', 200, 'Record deleted successfully.');
    }
}

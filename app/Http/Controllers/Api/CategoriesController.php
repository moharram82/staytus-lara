<?php

namespace App\Http\Controllers\Api;

use App\Actions\JsonResponses;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
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
        $categories = Category::with('items')->get();

        if ($request->has('sort') && in_array(strtolower($request->sort), ['asc', 'desc'])) {
            $categories = Category::with('items')->orderBy('name', strtolower($request->sort))->get();
        }

        $code = 200;
        $status = 'success';
        $message = 'Records retrieved successfully.';

        if($categories->count() <= 0) {
            $code = 404;
            $status = 'fail';
            $message = 'No records found!';
        }

        $data = $categories->count() > 0 ? $categories : null;

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
            'name' => 'required|string'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return JsonResponses::sendValidationResponse($validator->errors());
        }

        $category = Category::create([
            'name' => $request->name
        ]);

        return JsonResponses::sendJsonResponse('success', 201, 'Record created successfully.', $category);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $category = Category::find($id);

        if(! $category) {
            return JsonResponses::sendNotFoundResponse();
        }

        return JsonResponses::sendJsonResponse('success', 200, 'Record retrieved successfully.', $category->load('items'));
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
        $category = Category::find($id);

        if(! $category) {
            return JsonResponses::sendNotFoundResponse();
        }

        $rules = [
            'name' => 'required|string'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return JsonResponses::sendValidationResponse($validator->errors());
        }

        $category->update([
            'name' => $request->name
        ]);

        return JsonResponses::sendJsonResponse('success', 200, 'Record updated successfully.', $category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $category = Category::find($id);

        if(! $category) {
            return JsonResponses::sendNotFoundResponse();
        }

        if(! $category->delete()) {
            return JsonResponses::sendJsonResponse('error', 500, 'Can not perform action!');
        }

        return JsonResponses::sendJsonResponse('success', 200, 'Record deleted successfully.');
    }
}

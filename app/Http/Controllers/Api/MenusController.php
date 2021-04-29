<?php

namespace App\Http\Controllers\Api;

use App\Actions\JsonResponses;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenusController extends Controller
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
        $menus = Menu::with('items')->get();

        if ($request->has('sort') && in_array(strtolower($request->sort), ['asc', 'desc'])) {
            $menus = Menu::with('items')->orderBy('name', strtolower($request->sort))->get();
        }

        $code = 200;
        $status = 'success';
        $message = 'Records retrieved successfully.';

        if($menus->count() <= 0) {
            $code = 404;
            $status = 'fail';
            $message = 'No records found!';
        }

        $data = $menus->count() > 0 ? $menus : null;

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

        $menu = Menu::create([
            'name' => $request->name
        ]);

        return JsonResponses::sendJsonResponse('success', 201, 'Record created successfully.', $menu);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $menu = Menu::find($id);

        if(! $menu) {
            return JsonResponses::sendNotFoundResponse();
        }

        return JsonResponses::sendJsonResponse('success', 200, 'Record retrieved successfully.', $menu->load('items'));
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
        $menu = Menu::find($id);

        if(! $menu) {
            return JsonResponses::sendNotFoundResponse();
        }

        $rules = [
            'name' => 'required|string'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return JsonResponses::sendValidationResponse($validator->errors());
        }

        $menu->update([
            'name' => $request->name
        ]);

        return JsonResponses::sendJsonResponse('success', 200, 'Record updated successfully.', $menu);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $menu = Menu::find($id);

        if(! $menu) {
            return JsonResponses::sendNotFoundResponse();
        }

        if(! $menu->delete()) {
            return JsonResponses::sendJsonResponse('error', 500, 'Can not perform action!');
        }

        return JsonResponses::sendJsonResponse('success', 200, 'Record deleted successfully.');
    }
}

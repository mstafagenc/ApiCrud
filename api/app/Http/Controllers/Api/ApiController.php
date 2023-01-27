<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\CrudApi;
use Illuminate\Http\Request;
use App\Http\Requests\ItemRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ItemUpdateRequest;
use Illuminate\Support\Facades\Response; 

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function userArticle()
    {
        $items = User::with('crud_apis')->get();
        return $items;
    }

    public function index()
    {
        $user = auth()->guard("api")->user()->id;
        // dd($user);
        $items = CrudApi::whereUser_id($user)->get();
        return ['data' => $items, 'user_id' => $user];
    }

    public function files(Request $request)
    {
        $file = $request->file('attachment');
        $photo = $file->getClientOriginalName();
        $file->move(public_path('images'), $photo);

        return response()->json(['img' => 'images/' . $photo]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItemRequest $request)
    {
        $item = new CrudApi();
        $item->user_id = $request->user_id;
        $item->title = $request->title;
        $item->desc = $request->desc;
        if($request->image){$item->image = $request->image;}

        $item->save();
        return response()->json(['messages' => 'Eleman kaydedildi!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = CrudApi::find($id);
        return $item;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ItemUpdateRequest $request, $id)
    {
        // return $request;
        $item = CrudApi::findOrFail($id);
        if(!empty($request->title)){$item->title = $request->title;}
        if(!empty($request->desc)){$item->desc = $request->desc;}
        if(!empty($request->image)){$item->image = $request->image;}
        if($request->deleteOldImage){
            $image_path = public_path($request->deleteOldImage);
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        }

        $item->save();
        return $item;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = CrudApi::findOrFail($id);
        
        $image_path = public_path($item->image);

        if (File::exists($image_path)) {
            File::delete($image_path);
        }
        $item->delete();
        return response()->json(['message' => 'Silme başarılı!']);
    }
}

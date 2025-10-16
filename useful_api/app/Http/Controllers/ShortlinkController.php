<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortenLinkRequest;
use App\Models\Shortlink;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShortlinkController extends Controller
{
    public function createShortLink(ShortenLinkRequest $request){
        $user = $request->user();
        $fields = $request->validated();
        
        if(!$fields['custom_code']){
            $fields['custom_code'] = Str::random(10);
        }
        
        $fields['user_id'] = $user->id;
        
        $link = Shortlink::create($fields);
        $clicks = $link->clicks != null ? $link->clicks : 0;
        return response()->json([
            "id" => $link->id,
            "user_id" => $link->user_id,
            "original_url" => $link->original_url,
            "code" => $link->custom_code,
            "clicks" => $clicks,
            "created_at" => $user->created_at
        ], 201);
    }

    public function redirectToLink(string $code){
        $link = Shortlink::where('custom_code', $code)->first();
        
        if(!$link){
            return response()->json([
                "error" => "Unable to redirecte code not found"
            ]);
        }

        $clicks = $link->clicks != null ? $link->clicks : 0;
        $link->clicks++;
        $link->save();

        return redirect()->away($link->original_url, 302);
    }

    public function getLinks(Request $request){
        $user = $request->user();

        return response()->json($user->links, 200);
    }

    public function delete(string $id){
        $link = Shortlink::find($id);

        if(!$link){
            return response()->json([
                "message" => "Link not found"
            ], 404);
        }

        $link->delete();
        return response()->json([
            "message" => "Link deleted successfully"
        ], 200);
    } 
}
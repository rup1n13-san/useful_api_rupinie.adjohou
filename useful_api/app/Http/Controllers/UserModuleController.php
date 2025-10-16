<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Usermodule;
use Exception;
use Illuminate\Http\Request;

class UserModuleController extends Controller
{
    /**
     * activate the specified user_module in storage.
     */
    public function activate(Request $request, string $id)
    {
        try {
            $user = $request->user();
            $module = Module::find($id);
            //$user = auth('sanctum')->user();
            if (!$module) {
                return response()->json([
                    "message" => "Module not found"
                ], 404);
                

                // $record = Usermodule::where('user_id', $user->id)
                //     ->where('module_id', $id)
                //     ->first();
                // if ($record) {
                //     if(!$record->active === true){
                //         $record->active = true;
                //         $record->save();
                //         return response()->json(["message"=>"Module activated"], 200);
                //     }
                //     return response()->json(["message" => "Module already activated"], 200);
                // } else {
                //     $userModule = Usermodule::create([
                //         'user_id'=>$user->id,
                //         'module_id'=>$id,
                //         'active'=>true
                //     ]);
                //     return response()->json(["message" => "Module activated"], 200);
                // }
            }
            Usermodule::updateOrCreate(
                ['user_id' => $user->id, 'module_id' => $id],
                ['active' => true]
            );

            return response()->json(["message" => "Module activated"], 200);
            
        } catch (Exception $err) {
            return response()->json([
                'message' => $err->getMessage()
            ], 400);
        }
    }

    /**
     * deactivate the specified user_module in storage.
     */
    public function deactivate(Request $request, string $id)
    {
        try {
            $user = $request->user();
            $module = Module::find($id);
            //$user = auth('sanctum')->user();

            if (!$module) {
                return response()->json([
                    "message" => "Module not found"
                ], 404);
            }

            Usermodule::updateOrCreate(
                ['user_id' => $user->id, 'module_id' => $id],
                ['active' => false]
            );

            return response()->json(["message" => "Module deactivated"], 200);
        } catch (Exception $err) {
            return response()->json([
                'message' => $err->getMessage()
            ], 400);
        }
    }
}
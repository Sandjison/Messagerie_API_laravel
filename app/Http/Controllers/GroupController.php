<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Http\Resources\UserResource;
use App\Interfaces\GroupInterface;
use Illuminate\Http\Request;
use App\Responces\ApiResponce;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    private GroupInterface $groupInterface;

    public function __construct(GroupInterface $groupInterface)
    {
        $this->groupInterface = $groupInterface;
    }

    /**
     * Créer un nouveau groupe
     *
     * @param  \App\Http\Requests\GroupRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createGroup(GroupRequest $request)
    {
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => $request->user_id,

        ];

        DB::beginTransaction();

        try {
            $group = $this->groupInterface->createGroup($data);
            // Mail::to($request->email)->send(new RegisterMail($request->name));
            DB::commit();
            return ApiResponce::sendResponse(
                true,
                [new UserResource($group)],
                'Opération effectuée.'
            );
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return $th;
            return ApiResponce::rollback($th);
        }
    }



    /**
     * Supprimer un groupe
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function deleteGroup(Request $request, string $id)
    {

        $group = $this->groupInterface->deleteGroup($id);
        $group->delete();

        if (!$group)
            return ApiResponce::sendResponse(false, [], 'Goupe introuvable.', $group ? 200 : 400);
        else
            $group->delete();
        return ApiResponce::sendResponse(true, [], 'Groupe supprimé.', $group ? 200 : 400);
    }

    public function showGroup()
    {

        $allGroup = $this->groupInterface->showGroup();
        return ApiResponce::sendResponse(true, [new UserResource($allGroup)], 'Groupes.', 200);
    }

    public function sendFile(GroupRequest $request, $group_id)
    {

        // $data = [
        //     'file' => $request->file,
        //     'group_id' => $request->group_id,
        //     'user_id' => $request->user_id,
        // ];

        // $file = $this->groupInterface->sendFile($group_id);

        // if (!$file)
        //     return ApiResponce::sendResponse(false, [], 'Aucun fichier', $file ? 200 : 400);
        // else
        //     return ApiResponce::sendResponse(true, [$file], 'Groupe supprimé.', $file ? 200 : 400);
    }
}

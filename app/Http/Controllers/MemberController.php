<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberRequest;
use App\Http\Resources\UserResource;
use App\Interfaces\MemberInterface;
use Illuminate\Http\Request;
use App\Responces\ApiResponce;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    private MemberInterface $memberInterface;

    public function __construct(MemberInterface $memberInterface)
    {
        $this->memberInterface = $memberInterface;
    }

    /**
     * Ajouter un nouveau membre
     *
     * @param  \App\Http\Requests\MemberRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function addMember($user_id , $group_id)
    {
        $data = [
            
            'user_id' => $user_id,
            'group_id' => $group_id,

        ];

        DB::beginTransaction();

        try {
            $member = $this->memberInterface->addMember($data);
            DB::commit();
            return ApiResponce::sendResponse(
                true,
                [new UserResource($member)],
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
     * Supprimer un membre
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteMember($id)
    {
       $member = $this->memberInterface->deleteMember($id);
       $member->delete();

       if (!$member)
            return ApiResponce::sendResponse(false, [], 'Membre introuvable.', $member ? 200 : 400);
        else
            $member->delete();
        return ApiResponce::sendResponse(true, [], 'Membre supprimé.', $member ? 200 : 400);
    }


}

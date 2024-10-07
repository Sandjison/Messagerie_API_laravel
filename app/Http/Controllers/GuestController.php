<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuestRequest;
use App\Http\Resources\UserResource;
use App\Http\Responses\ApiResponse;
use Illuminate\Support\Facades\Mail;
use App\Interfaces\GuestInterface;
use App\Mail\GuestMail;
use App\Responces\ApiResponce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuestController extends Controller
{
    private GuestInterface $guestInterface;


    public function __construct(GuestInterface $guestInterface)
    {
        $this->guestInterface = $guestInterface;
    }

    public function addGuest( $id, GuestRequest $request)
    {
        $data = [
            'email' => $request->email,
            'group_id' => $id,

        ];

        DB::beginTransaction();

        try {
            $guest = $this->guestInterface->addGuest($data);
            Mail::to($request->email)->send(new GuestMail());
            DB::commit();
            return ApiResponce::sendResponse(
                true,
                [new UserResource($guest)],
                'Opération effectuée.'
            );
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return $th;
            return ApiResponce::rollback($th);
        }
    }

    public function deleteGuest($id)
    {
        $guest = $this->guestInterface->deleteGuest($id);
        $guest->delete();

        if (!$guest)
            return ApiResponce::sendResponse(false, [], 'Invité introuvable.', $guest ? 200 : 400);
        else
            $guest->delete();
        return ApiResponce::sendResponse(true, [], 'Invité supprimé.', $guest ? 200 : 400);
    
    }


}

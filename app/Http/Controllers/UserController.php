<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Interfaces\UserInterface;
use App\Models\User;
use App\Responces\ApiResponce;
use Illuminate\Http\Request;


class UserController extends Controller
{

    private UserInterface $userInterface;

    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }

    public function deleteUser($id)
    {
        $user = $this->userInterface->deleteUser($id);
        $user->delete();

        if (!$user)
            return ApiResponce::sendResponse(false, [], 'Utilisateur introuvable.', $user ? 200 : 400);
        else
            $user->delete();
        return ApiResponce::sendResponse(true, [], 'Utilisateur supprimé.', $user ? 200 : 400);
    }

    public function updateUser(UserRequest $request, $id)
    {


        // Récupérer l'utilisateur par son ID
        $user = $this->userInterface->findUserById($id);

        if (!$user) {
            return ApiResponce::sendResponse(false, [], 'Utilisateur introuvable.', 404);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->update();

        // Retourner une réponse de succès
        return ApiResponce::sendResponse(true, [], 'Utilisateur mis à jour avec succès.', 200);
    }

    public function showUser()
    {
        $users = User::all();

    return response()->json([
    'utilisateurs' => $users
    ]);

        // $allUser = $this->userInterface->showUser();
        // return ApiResponce::sendResponse(true, [new UserResource($allUser)], 'Utilisateur.', 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Http\Resources\UserResource;
use App\Interfaces\FileInterface;
use App\Models\File ;
use App\Responces\ApiResponce;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    private FileInterface $fileInterface;

    public function __construct(FileInterface $fileInterface)
    {
        $this->fileInterface = $fileInterface;
    }

    public function addFile(FileRequest $request)
    {
        // Préparation des données

        // $user = auth()->id;

       
        $data = [
            'group_id' => $request->group_id,
        ];

        DB::beginTransaction();
        
        try {
            // Vérification et traitement du fichier
            if ($request->hasFile('file')) {
                $fichier = $request->file('file');
                $filename = time() . '.' . $fichier->getClientOriginalExtension();
                $fichier->move(public_path('uploads'), $filename);
                $data['file'] = $filename; // Ajout du nom du fichier dans les données
            }
            
            
            $file = File::create($data);

            DB::commit();

            // Retourne une réponse API avec les informations du fichier ajouté
            return ApiResponce::sendResponse(
                true,
                $file,
                'Opération effectuée avec succès.'
            );
        } catch (\Throwable $th) {
            // En cas d'erreur, rollback et retour de l'erreur
            DB::rollback();
            return ApiResponce::rollback($th);
        }
    }

    public function deleteFile($id)
    {
        $file = $this->fileInterface->deleteFile($id);
        $file->delete();

        if (!$file)
            return ApiResponce::sendResponse(false, [], 'Fichier introuvable.', $file ? 200 : 400);
        else
            $file->delete();
        return ApiResponce::sendResponse(true, [], 'Fichier supprimé.', $file ? 200 : 400);
    }

    public function showFile($group_id)
    {

        $file = $this->fileInterface->showFile($group_id);

        if (!$file)
            return ApiResponce::sendResponse(false, [], 'Aucun fichier', $file ? 200 : 400);
        else
            return ApiResponce::sendResponse(true, [$file], 'success', $file ? 200 : 400);

        // $allFile = $this->fileInterface->showFile();
        // return ApiResponce::sendResponse(true, [new UserResource($allFile)], 'Fichier.', 200);
    }
}

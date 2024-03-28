<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Profil;
use App\Models\Statut;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $profils = Profil::where('statut', 'ACTIVE')->get();
        if(!$request->user('sanctum')){
            $profils->makeHidden(['statut']);
        }

        return response()->json([
            $profils
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|max:50',
            'prenom' => 'required|max:50',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'statut' => 'required|exists:statuts',
          ],
          [
              'statut.exists' => 'The selected statut is invalid. Available statut are: '.Statut::all()->pluck('statut'),
          ]);

        $profil = Profil::create([
                'nom' => $request->input('nom'),
                'prenom' => $request->input('prenom'),
                'statut' => $request->input('statut'),
                'image' => 'url'
            ]
        );

        $file = $request->file('image');
        $profil->image = env('APP_URL').'/storage/'.$profil->id.'/image.'.$file->extension();
        
        if (!Storage::disk('public')->putFileAs('/'.$profil->id, $file, '/image.'.$file->extension())) {
            return false;
        }

        return response()->json([
            $profil
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Profil $profil, Request $request)
    {
        $request->validate([
            'nom' => 'required|max:50',
            'prenom' => 'required|max:50',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'statut' => 'required|exists:statuts',
        ],
        [
            'statut.exists' => 'The selected statut is invalid. Available statut are: '.Statut::all()->pluck('statut'),
        ]);

        Storage::disk('public')->delete($profil->id.'/image.jpg');

        $file = $request->file('image');
        if (!Storage::disk('public')->putFileAs('/'.$profil->id, $file, '/image.'.$file->extension())) {
            return false;
        }

        $profil->nom = $request->input('nom');
        $profil->prenom = $request->input('prenom');
        $profil->statut = $request->input('statut');
        $profil->image = env('APP_URL').'/storage/'.$profil->id.'/image.'.$file->extension();
        $profil->save();

        return response()->json([
            $profil
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profil $profil)
    {
        Storage::disk('public')->delete($profil->id.'/image.jpg');
        Storage::disk('public')->deleteDirectory($profil->id);
        $profil->delete();
        return response()->json([
            'result' => 'Profil '.$profil->id.' supprimé'
        ]);
    }
}

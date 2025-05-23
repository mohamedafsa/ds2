<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MapPin;  // Le modèle pour gérer les épingles
use App\Models\Goal;    // Le modèle Goal si tu as des objectifs associés à chaque épingle

class MapController extends Controller
{
    // Affiche la carte avec les épingles
    public function index()
    {
        // Assurer que l'utilisateur est connecté
        if (!auth()->check()) {
            return redirect()->route('login');
        }
    
        // Récupérer les épingles associées à l'utilisateur connecté
        $mapPins = MapPin::with('goal')
                        ->where('user_id', auth()->id()) // Assurer qu'on récupère seulement les épingles de l'utilisateur connecté
                        ->get();
    
        // Retourner la vue avec les épingles
        return view('maps.index', compact('mapPins'));
    }
    
    
    

    // Sauvegarde une nouvelle épingle
    public function store(Request $request)
    {
        // Valider les données envoyées
        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'goal_id' => 'required|exists:goals,id',  // Assure-toi que l'ID de l'objectif est valide
        ]);

        // Crée une nouvelle épingle
        MapPin::create([
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'goal_id' => $validated['goal_id'],
        ]);

        // Retourner une réponse
        return response()->json(['message' => 'Épingle ajoutée avec succès.'], 200);
    }
}

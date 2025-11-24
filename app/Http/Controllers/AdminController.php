<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    // Page de login admin
    public function loginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        if(auth()->attempt($credentials)){
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email'=>'Identifiants invalides']);
    }

    public function dashboard()
    {
        $reports = Report::all();
        return view('admin.dashboard', compact('reports'));
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('admin.login');
    }

    // Changer le statut d'un signalement
    public function updateStatus(Request $request, Report $report)
    {
        $request->validate([
            'statut' => 'required|in:en attente,en cours,résolu'
        ]);

        $oldStatus = $report->statut;
        $report->statut = $request->statut;
        $report->save();
        
        // Notifier l'utilisateur du changement de statut si un numéro de téléphone est disponible
        if ($report->telephone) {
            $this->notifyUserOfStatusChange($report, $oldStatus);
        }

        return back()->with('success','Statut mis à jour');
    }

    public function destroy(Report $report)
    {
        $report->delete();
        return redirect()->back()->with('success', 'Signalement supprimé avec succès.');
    }
    
    /**
     * Met à jour l'adresse d'un signalement à partir des coordonnées GPS
     */
    public function updateAddress(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'adresse' => 'required|string',
        ]);
        
        // Trouver tous les signalements avec ces coordonnées qui n'ont pas d'adresse
        $reports = Report::where([
            ['latitude', $request->latitude],
            ['longitude', $request->longitude],
            ['adresse', null]
        ])->get();
        
        $updated = 0;
        
        foreach ($reports as $report) {
            $report->adresse = $request->adresse;
            $report->save();
            $updated++;
        }
        
        return response()->json([
            'success' => true,
            'message' => "$updated signalements mis à jour avec l'adresse."
        ]);
    }

    
    private function notifyUserOfStatusChange(Report $report, string $oldStatus): void
    {
        try {
            $statusMessages = [
                'en attente' => 'est en attente de traitement',
                'en cours' => 'est en cours de traitement',
                'résolu' => 'a été résolu'
            ];
            
            $statusMessage = $statusMessages[$report->statut] ?? 'a changé de statut';
            
            $message = "Mise à jour de votre signalement #$report->id : ".
                      "Votre signalement $statusMessage. ";
                      
            if ($report->statut === 'résolu') {
                $message .= "Merci d'avoir utilisé notre service Gëstu Ndox Mi.";
            } else {
                $message .= "Nous vous tiendrons informé de l'évolution de la situation.";
            }
            
            // Envoi du SMS
            $smsService = new SmsService();
            $success = $smsService->send($report->telephone, $message);
            
            if ($success) {
                Log::info("Notification de changement de statut envoyée à {$report->telephone} pour le signalement #{$report->id}");
            } else {
                Log::warning("Échec de l'envoi de la notification de changement de statut à {$report->telephone} pour le signalement #{$report->id}");
            }
            
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi de la notification de changement de statut: ' . $e->getMessage());
        }
    }
}

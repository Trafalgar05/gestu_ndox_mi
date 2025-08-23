<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    // Formulaire de signalement
    public function create()
    {
        return view('reports.create');
    }

    // Sauvegarde du signalement
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'nullable|email',
            'telephone' => 'nullable|string|max:20',
            'type_probleme' => 'required|string|max:255',
            'description' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'adresse' => 'nullable|string|max:255',
        ]);

        $description = htmlspecialchars_decode($request->description, ENT_QUOTES);

        // Créer le signalement
        $report = Report::create([
            'nom' => $validated['nom'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'],
            'type_probleme' => $validated['type_probleme'],
            'description' => $description,
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'adresse' => $validated['adresse'],
        ]);
        
        // Notifier l'administrateur du nouveau signalement
        $this->notifyAdmin($report);
        
        // Envoyer un SMS de confirmation si un numéro de téléphone est fourni
        if ($report->telephone) {
            $this->sendSmsConfirmation($report);
        }
        
        // Envoyer un email de confirmation si un email est fourni
        if ($report->email) {
            $this->sendEmailConfirmation($report);
        }

        return response()->json([
            'success' => true,
            'message' => 'Signalement enregistré avec succès'
        ]);
    }
    
    /**
     * Notifie l'administrateur d'un nouveau signalement
     */
    private function notifyAdmin(Report $report)
    {
        try {
            // Récupérer tous les utilisateurs admin
            $admins = User::all();
            
            if ($admins->isEmpty()) {
                Log::warning('Aucun administrateur trouvé pour envoyer la notification de signalement #' . $report->id);
                return;
            }
            
            foreach ($admins as $admin) {
                // Envoyer un email à l'administrateur
                Mail::raw(
                    "Nouveau signalement reçu de {$report->nom}\n" .
                    "Type de problème: {$report->type_probleme}\n" .
                    "Description: {$report->description}\n" .
                    "Contact: {$report->telephone}\n" .
                    "Coordonnées: {$report->latitude}, {$report->longitude}",
                    function ($message) use ($admin, $report) {
                        $message->to($admin->email)
                                ->subject('Nouveau signalement #' . $report->id);
                    }
                );
            }
            
            Log::info('Notification envoyée aux administrateurs pour le signalement #' . $report->id);
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi de la notification admin: ' . $e->getMessage());
        }
    }
    
    /**
     * Envoie un SMS de confirmation à l'utilisateur
     */
    private function sendSmsConfirmation(Report $report)
    {
        try {
            // Message à envoyer
            $message = "Merci pour votre signalement concernant un problème d'eau. ".
                      "Votre signalement a été enregistré avec succès. ".
                      "Référence: #{$report->id}. ".
                      "Nous vous tiendrons informé de son traitement.";
            
            // Utilisation du service SMS
            $success = SmsService::send($report->telephone, $message);
            
            if ($success) {
                Log::info("SMS de confirmation envoyé avec succès à {$report->telephone} pour le signalement #{$report->id}");
            } else {
                Log::warning("Échec de l'envoi du SMS de confirmation à {$report->telephone} pour le signalement #{$report->id}");
            }
            
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi du SMS de confirmation: ' . $e->getMessage());
        }
    }
    
    /**
     * Envoie un email de confirmation à l'utilisateur
     */
    private function sendEmailConfirmation(Report $report)
    {
        try {
            // Sujet de l'email
            $subject = "Confirmation de votre signalement #{$report->id}";
            
            // Message à envoyer
            $message = "Bonjour {$report->nom},\n\n".
                      "Merci pour votre signalement concernant un problème d'eau. ".
                      "Votre signalement a été enregistré avec succès. ".
                      "Référence: #{$report->id}.\n\n".
                      "Type de problème: {$report->type_probleme}\n".
                      "Adresse: {$report->adresse}\n\n".
                      "Nous vous tiendrons informé de son traitement.\n\n".
                      "Cordialement,\n".
                      "L'équipe Gëstu Ndox Mi";
            
            // Envoi de l'email
            Mail::raw($message, function ($mail) use ($report, $subject) {
                $mail->to($report->email)
                     ->subject($subject);
            });
            
            Log::info("Email de confirmation envoyé avec succès à {$report->email} pour le signalement #{$report->id}");
            
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi de l\'email de confirmation: ' . $e->getMessage());
        }
    }
}

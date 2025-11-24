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
        try {
            // Validation
            $validated = $request->validate([
                'type_probleme' => 'required|string',
                'description' => 'nullable|string',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'adresse' => 'nullable|string',
                'nom' => 'required|string',
                'telephone' => 'required|string',
                'email' => 'nullable|email'
            ]);

            if (empty($validated['latitude'])) {
                $validated['latitude'] = 0;
            }
            if (empty($validated['longitude'])) {
                $validated['longitude'] = 0;
            }
            $report = Report::create($validated);

            // Envoyer le SMS immédiatement après la création
            if ($request->telephone) {
                $smsService = new SmsService();
                $message = "Merci pour votre signalement sur GestuNdoxMi. Votre signalement #{$report->id} a été enregistré et sera traité dans les plus brefs délais.";
                
                // Log pour debug
                \Log::info('Tentative d\'envoi de SMS', [
                    'telephone' => $request->telephone,
                    'message' => $message
                ]);

                $sent = $smsService->send($request->telephone, $message);
                
                if (!$sent) {
                    \Log::error('Échec de l\'envoi du SMS');
                    throw new \Exception('Erreur lors de l\'envoi du SMS');
                }
            }

            // Notifier l'admin
            $this->notifyAdmin($report);

            return response()->json([
                'success' => true,
                'message' => 'Signalement enregistré avec succès',
                'report' => $report
            ]);

        } catch (\Exception $e) {
            \Log::error('Erreur complète: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue: ' . $e->getMessage()
            ], 500);
        }
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

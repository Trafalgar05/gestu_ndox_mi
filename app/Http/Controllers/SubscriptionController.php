<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function initializePayment(Request $request)
    {
        try {
            // Configuration Wave
            $waveConfig = [
                'api_key' => config('services.wave.api_key'),
                'merchant_id' => config('services.wave.merchant_id'),
                'secret_key' => config('services.wave.secret_key'),
                'environment' => config('services.wave.environment', 'sandbox')
            ];

            // Données du paiement
            $paymentData = [
                'amount' => 5000, // 5000 FCFA
                'currency' => 'XOF',
                'error_url' => route('admin.dashboard'),
                'success_url' => route('subscription.callback'),
                'client_reference' => 'SUB_' . auth()->id() . '_' . time(),
            ];

            // Log pour debug
            Log::info('Tentative d\'initialisation du paiement Wave', [
                'user' => auth()->id(),
                'payment_data' => $paymentData
            ]);

            // En mode sandbox, simulez une réponse de Wave
            if ($waveConfig['environment'] === 'sandbox') {
                return response()->json([
                    'success' => true,
                    'payment_url' => 'https://wave.com/sandbox/checkout/' . uniqid()
                ]);
            }

            // En production, utilisez l'API Wave réelle
            $waveResponse = $this->initializeWavePayment($waveConfig, $paymentData);

            return response()->json([
                'success' => true,
                'payment_url' => $waveResponse['payment_url']
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'initialisation du paiement: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'initialisation du paiement',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function initializeWavePayment($config, $paymentData)
    {
        // Endpoint Wave (à adapter selon la documentation Wave)
        $endpoint = $config['environment'] === 'production' 
            ? 'https://api.wave.com/v1/checkout/sessions'
            : 'https://api.wave.com/v1/sandbox/checkout/sessions';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $config['api_key'],
            'Content-Type' => 'application/json'
        ])->post($endpoint, $paymentData);

        if (!$response->successful()) {
            throw new \Exception('Erreur API Wave: ' . $response->body());
        }

        return $response->json();
    }

    public function handleCallback(Request $request)
    {
        try {
            Log::info('Callback Wave reçu', $request->all());

            // Vérifier la validité du paiement
            if ($request->status === 'success') {
                // Créer l'abonnement
                $subscription = Subscription::create([
                    'user_id' => auth()->id(),
                    'plan_type' => 'premium',
                    'amount' => 5000,
                    'wave_transaction_id' => $request->transaction_id,
                    'starts_at' => now(),
                    'expires_at' => now()->addMonth(),
                    'is_active' => true
                ]);

                return redirect()->route('admin.dashboard')
                    ->with('success', 'Votre abonnement premium a été activé avec succès !');
            }

            return redirect()->route('admin.dashboard')
                ->with('error', 'Le paiement n\'a pas pu être validé.');

        } catch (\Exception $e) {
            Log::error('Erreur callback Wave: ' . $e->getMessage());
            
            return redirect()->route('admin.dashboard')
                ->with('error', 'Une erreur est survenue lors de la validation du paiement.');
        }
    }
}

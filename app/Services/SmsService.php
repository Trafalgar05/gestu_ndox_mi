<?php

namespace App\Services;

use Twilio\Rest\Client as TwilioClient;
use Vonage\Client as VonageClient;
use Vonage\Client\Credentials\Basic;
use Vonage\SMS\Message\SMS;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class SmsService
{
    protected $client;
    protected $from;

    public function __construct()
    {
        if (config('sms.default') === 'twilio') {
            $this->client = new TwilioClient(
                config('sms.services.twilio.sid'),
                config('sms.services.twilio.token')
            );
            $this->from = config('sms.services.twilio.from');
        } elseif (config('sms.default') === 'vonage') {
            $this->client = new VonageClient(new Basic(
                config('sms.services.vonage.key'),
                config('sms.services.vonage.secret')
            ));
            $this->from = config('sms.services.vonage.from');
        }
    }

    /**
     * Envoie un SMS au numéro spécifié
     *
     * @param string $to Numéro de téléphone du destinataire
     * @param string $message Message à envoyer
     * @return bool Succès de l'envoi
     */
    public function send(string $to, string $message): bool
    {
        try {
            if (!$this->client) {
                Log::error('Service SMS non configuré');
                return false;
            }

            // Formatage du numéro au format international
            $to = $this->formatPhoneNumber($to);

            if (config('sms.default') === 'twilio') {
                $this->client->messages->create($to, [
                    'from' => $this->from,
                    'body' => $message
                ]);

                Log::info("SMS envoyé à $to avec succès");
                return true;
            } elseif (config('sms.default') === 'vonage') {
                $response = $this->client->sms()->send(
                    new SMS($to, $this->from, $message)
                );

                $message = $response->current();

                if ($message->getStatus() == 0) {
                    Log::info("SMS envoyé à $to avec succès", [
                        'message_id' => $message->getMessageId(),
                        'to' => $to
                    ]);
                    return true;
                }

                Log::error('Échec envoi SMS', [
                    'status' => $message->getStatus(),
                    'error' => $message->getStatusMessage()
                ]);
                return false;
            }

        } catch (\Exception $e) {
            Log::error('Erreur envoi SMS: ' . $e->getMessage());
            return false;
        }
    }

    private function formatPhoneNumber($number)
    {
        // Supprimer tous les caractères non numériques
        $number = preg_replace('/[^0-9]/', '', $number);
        
        // Si le numéro commence par 221, on le garde tel quel
        // Sinon on l'ajoute
        if (!str_starts_with($number, '221')) {
            $number = '221' . $number;
        }
        
        // Log pour debug
        Log::info('Numéro formaté', [
            'original' => $number,
            'formaté' => '+' . $number
        ]);
        
        return '+' . $number;
    }

    /**
     * Envoie un SMS via Twilio
     */
    private static function sendViaTwilio(string $to, string $message): bool
    {
        // Implémentation de l'envoi via Twilio
        // Nécessite l'installation du package twilio/sdk
        
        // Exemple d'implémentation:
        // $sid = Config::get('sms.services.twilio.sid');
        // $token = Config::get('sms.services.twilio.token');
        // $from = Config::get('sms.services.twilio.from');
        // 
        // $client = new \Twilio\Rest\Client($sid, $token);
        // $client->messages->create($to, [
        //     'from' => $from,
        //     'body' => $message
        // ]);
        
        Log::info("[TWILIO] SMS qui serait envoyé à {$to}: {$message}");
        return true;
    }
    
    /**
     * Envoie un SMS via Vonage (ex-Nexmo)
     */
    private static function sendViaVonage(string $to, string $message): bool
    {
        // Implémentation de l'envoi via Vonage
        // Nécessite l'installation du package vonage/client
        
        // Exemple d'implémentation:
        // $key = Config::get('sms.services.vonage.key');
        // $secret = Config::get('sms.services.vonage.secret');
        // $from = Config::get('sms.services.vonage.from');
        // 
        // $client = new \Vonage\Client(new \Vonage\Client\Credentials\Basic($key, $secret));
        // $client->sms()->send(new \Vonage\SMS\Message\SMS($to, $from, $message));
        
        Log::info("[VONAGE] SMS qui serait envoyé à {$to}: {$message}");
        return true;
    }
    
    /**
     * Enregistre le SMS dans les logs (pour le développement)
     */
    private static function sendViaLog(string $to, string $message): bool
    {
        $channel = Config::get('sms.services.log.channel', 'stack');
        Log::channel($channel)->info("SMS qui serait envoyé à {$to}: {$message}");
        return true;
    }
}
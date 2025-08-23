<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class SmsService
{
    /**
     * Envoie un SMS au numéro spécifié
     *
     * @param string $to Numéro de téléphone du destinataire
     * @param string $message Message à envoyer
     * @return bool Succès de l'envoi
     */
    public static function send(string $to, string $message): bool
    {
        $service = Config::get('sms.default', 'log');
        
        try {
            switch ($service) {
                case 'twilio':
                    return self::sendViaTwilio($to, $message);
                case 'vonage':
                    return self::sendViaVonage($to, $message);
                case 'log':
                default:
                    return self::sendViaLog($to, $message);
            }
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi du SMS: ' . $e->getMessage());
            return false;
        }
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
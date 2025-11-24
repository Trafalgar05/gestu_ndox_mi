<?php

namespace App\Http\Controllers;

use PDF;
use OpenAI\Client;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PremiumFeatureController extends Controller
{
    public function __construct()
    {
        $this->middleware('premium');
    }

    public function generatePDF(Request $request)
    {
        $reports = Report::with('user')
            ->whereBetween('created_at', [
                $request->start_date,
                $request->end_date
            ])->get();

        $data = [
            'reports' => $reports,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'generated_at' => now()
        ];

        $pdf = PDF::loadView('premium.reports-pdf', $data);
        
        return $pdf->download('rapport-signalements.pdf');
    }

    public function analyzeData(Request $request)
    {
        $client = OpenAI::client(config('services.openai.api_key'));

        $stats = Report::selectRaw('
            COUNT(*) as total,
            COUNT(CASE WHEN status = "résolu" THEN 1 END) as resolved,
            AVG(TIMESTAMPDIFF(HOUR, created_at, updated_at)) as avg_resolution_time
        ')->first();

        $prompt = "Analysez ces statistiques des signalements d'eau:\n" .
                 "Total: {$stats->total}\n" .
                 "Résolus: {$stats->resolved}\n" .
                 "Temps moyen de résolution: {$stats->avg_resolution_time} heures\n" .
                 "Fournissez une analyse détaillée en français.";

        $response = $client->chat()->create([
            'model' => 'gpt-4',
            'messages' => [
                ['role' => 'system', 'content' => 'Vous êtes un expert en analyse de données de services publics.'],
                ['role' => 'user', 'content' => $prompt]
            ]
        ]);

        return response()->json([
            'analysis' => $response->choices[0]->message->content,
            'stats' => $stats
        ]);
    }
}

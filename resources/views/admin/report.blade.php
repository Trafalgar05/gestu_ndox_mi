<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .stats-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .report-item { margin-bottom: 15px; padding: 10px; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Rapport des Signalements</h1>
        <p>Période : {{ $start_date }} - {{ $end_date }}</p>
    </div>

    <div class="stats-grid">
        <div>
            <h3>Statistiques Globales</h3>
            <p>Total des signalements : {{ $reports->count() }}</p>
            <p>Résolus : {{ $reports->where('status', 'résolu')->count() }}</p>
        </div>
    </div>

    <h3>Liste des Signalements</h3>
    @foreach($reports as $report)
        <div class="report-item">
            <p><strong>#{{ $report->id }}</strong> - {{ $report->created_at->format('d/m/Y') }}</p>
            <p>Type : {{ $report->type_probleme }}</p>
            <p>Status : {{ $report->status }}</p>
            <p>Adresse : {{ $report->adresse }}</p>
        </div>
    @endforeach

    <footer>
        <p>Généré le {{ $generated_at->format('d/m/Y H:i') }}</p>
        <p>GëstuNdoxMi - Rapport Premium</p>
    </footer>
</body>
</html>
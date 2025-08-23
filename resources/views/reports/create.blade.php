<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gëstu Ndox Mi</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

         body {
            font-family: -apple-system, BlinkMacSystemFont, 'Inter', sans-serif;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            min-height: 100vh;
            min-height: 100dvh; 
            position: relative;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            padding-top: env(safe-area-inset-top, 0px);
            padding-bottom: env(safe-area-inset-bottom, 0px);
        }

        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(59, 130, 246, 0.08) 0%, transparent 50%),
                        radial-gradient(circle at 80% 20%, rgba(16, 185, 129, 0.06) 0%, transparent 50%),
                        radial-gradient(circle at 40% 80%, rgba(139, 92, 246, 0.04) 0%, transparent 50%);
            pointer-events: none;
            
        }


        .back-button {
            position: fixed;
            top: calc(1rem + env(safe-area-inset-top, 0px));
            left: 1rem;
            width: 44px;
            height: 44px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.2s ease-out;
            z-index: 1000;
            text-decoration: none;
            touch-action: manipulation;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            user-select: none;
        }

        .back-button:hover,
        .back-button:active {
            background: rgba(255, 255, 255, 0.25);
            transform: scale(0.95);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem;
            position: relative;
            z-index: 1;
        }

        .header-section {
            text-align: center;
            margin-bottom: 3rem;
            color: white;
        }

        .progress-indicator {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .step {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .step.active {
            background: white;
            color: #0284c7;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.4);
        }

        .step-line {
            width: 60px;
            height: 2px;
            background: rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .step-line.completed {
            background: white;
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .hero-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 500px;
            margin: 0 auto;
            line-height: 1.5;
        }

        .form-container {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
        }

       .form-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, transparent, #3b82f6, transparent);
    background-size: 200% 100%;
    animation: blueWave 2s ease-in-out infinite;
    border-radius: 2px 2px 0 0;
}

@keyframes blueWave {
    0% { 
        background-position: -200% 0;
        opacity: 0.6;
    }
    50% {
        opacity: 1;
    }
    100% { 
        background-position: 200% 0;
        opacity: 0.6;
    }
}

/* Alternative 1 : Pulsation simple */
.form-container.pulse-style::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: #2563eb;
    animation: bluePulse 2s ease-in-out infinite;
}

@keyframes bluePulse {
    0%, 100% { 
        opacity: 0.4;
        transform: scaleX(0.8);
    }
    50% { 
        opacity: 1;
        transform: scaleX(1);
    }
}

/* Alternative 2 : Effet de chargement */
.form-container.loading-style::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #e5f3ff 0%, #3b82f6 50%, #e5f3ff 100%);
    background-size: 200% 100%;
    animation: blueProgress 1.5s linear infinite;
}

@keyframes blueProgress {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
}

/* Alternative 3 : Effet subtil et moderne */
.form-container.subtle-style::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 2px;
    background: #3b82f6;
    animation: blueExpand 2.5s ease-in-out infinite;
    border-radius: 1px;
}

@keyframes blueExpand {
    0%, 100% { 
        width: 60px;
        opacity: 0.5;
    }
    50% { 
        width: 120px;
        opacity: 1;
    }
}

        .form-content {
            padding: 3rem;
        }

        .form-step {
            display: none;
        }

        .form-step.active {
            display: block;
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .step-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .step-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #0ea5e9, #10b981);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 10px 30px rgba(14, 165, 233, 0.3);
        }

        .step-icon i {
            font-size: 2rem;
            color: white;
        }

        .step-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.5rem;
        }

        .step-description {
            color: #64748b;
            font-size: 1rem;
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 1rem 1.5rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: #0ea5e9;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
            transform: translateY(-1px);
        }

        .form-textarea {
            resize: vertical;
            min-height: 120px;
        }

        .problem-types {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .problem-type {
            position: relative;
        }

        .problem-type input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .problem-type-card {
            padding: 1.5rem;
            border: 2px solid #e5e7eb;
            border-radius: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            background: white;
        }

        .problem-type input[type="radio"]:checked + .problem-type-card {
            border-color: #0ea5e9;
            background: linear-gradient(135deg, #0ea5e9, #10b981);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(14, 165, 233, 0.3);
        }

        .problem-type-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            opacity: 0.8;
        }

        .problem-type input[type="radio"]:checked + .problem-type-card .problem-type-icon {
            opacity: 1;
        }

        .problem-type-title {
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        .problem-type-desc {
            font-size: 0.85rem;
            opacity: 0.8;
        }

        .location-status {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            padding: 1.5rem;
            background: #f8fafc;
            border-radius: 16px;
            border: 2px dashed #cbd5e1;
            margin: 1.5rem 0;
            transition: all 0.3s ease;
        }

        .location-status.success {
            background: #ecfdf5;
            border-color: #10b981;
            color: #065f46;
        }

        .location-status.error {
            background: #fef2f2;
            border-color: #ef4444;
            color: #991b1b;
        }

        .location-icon {
            font-size: 1.5rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: space-between;
            margin-top: 2.5rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            min-width: 140px;
            justify-content: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0ea5e9, #10b981);
            color: white;
            box-shadow: 0 4px 15px rgba(14, 165, 233, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(14, 165, 233, 0.4);
        }

        .btn-secondary {
            background: #f1f5f9;
            color: #475569;
            border: 2px solid #e2e8f0;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
            transform: translateY(-1px);
        }

        .btn-submit {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            font-size: 1.1rem;
            padding: 1.2rem 2.5rem;
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.4);
        }

        .success-message {
            text-align: center;
            padding: 2rem;
        }

        .success-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            animation: successPulse 2s ease-out;
        }

        @keyframes successPulse {
            0% { transform: scale(0); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .success-icon i {
            font-size: 3rem;
            color: white;
        }

        .encouragement {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            padding: 1.5rem;
            border-radius: 16px;
            text-align: center;
            margin: 2rem 0;
            border-left: 4px solid #f59e0b;
        }

        .encouragement-text {
            color: #92400e;
            font-weight: 500;
            font-size: 1rem;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .form-content {
                padding: 2rem 1.5rem;
            }

            .hero-title {
                font-size: 2rem;
            }

            .problem-types {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }

            .progress-indicator {
                gap: 0.5rem;
            }

            .step {
                width: 35px;
                height: 35px;
            }

            .step-line {
                width: 40px;
            }
        }
    </style>
</head>
<body>

        <a href="/" class="back-button" title="Retour à l'accueil" aria-label="Retour à l'accueil">
    <i class="fas fa-arrow-left"></i>
</a>

    <div class="container">
        <div class="header-section">
            <div class="progress-indicator">
                <div class="step active" id="step-1">1</div>
                <div class="step-line" id="line-1"></div>
                <div class="step" id="step-2">2</div>
                <div class="step-line" id="line-2"></div>
                <div class="step" id="step-3">3</div>
            </div>
            <h1 class="hero-title">🔔 Votre signalement compte</h1>
            <p class="hero-subtitle">Ensemble, améliorons l'accès à l'eau pour tous. Votre contribution fait la différence dans votre communauté.</p>
        </div>

        <div class="form-container">
            <form id="reportForm" action="{{ route('reports.store') }}" method="POST" accept-charset="UTF-8">
                @csrf
                <div class="form-content">
                    
                    <!-- ÉTAPE 1: TYPE DE PROBLÈME -->
                    <div class="form-step active" id="form-step-1">
                        <div class="step-header">
                            <div class="step-icon">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <h2 class="step-title">Quel est le problème ?</h2>
                            <p class="step-description">Sélectionnez le type de problème que vous rencontrez</p>
                        </div>

                        <div class="problem-types">
                            <label class="problem-type">
                                <input type="radio" name="type_probleme" value="coupure" required>
                                <div class="problem-type-card">
                                    <div class="problem-type-icon">🚱</div>
                                    <div class="problem-type-title">Coupure d'eau</div>
                                    <div class="problem-type-desc">Plus d'eau du robinet</div>
                                </div>
                            </label>

                            <label class="problem-type">
                                <input type="radio" name="type_probleme" value="penurie" required>
                                <div class="problem-type-card">
                                    <div class="problem-type-icon">💧</div>
                                    <div class="problem-type-title">Pénurie</div>
                                    <div class="problem-type-desc">Débit très faible</div>
                                </div>
                            </label>

                            <label class="problem-type">
                                <input type="radio" name="type_probleme" value="fuite" required>
                                <div class="problem-type-card">
                                    <div class="problem-type-icon">🔧</div>
                                    <div class="problem-type-title">Fuite</div>
                                    <div class="problem-type-desc">Tuyau défectueux</div>
                                </div>
                            </label>

                            <label class="problem-type">
                                <input type="radio" name="type_probleme" value="fosse" required>
                                <div class="problem-type-card">
                                    <div class="problem-type-icon">🏠</div>
                                    <div class="problem-type-title">Fosse septique</div>
                                    <div class="problem-type-desc">Fosse pleine</div>
                                </div>
                            </label>

                            <label class="problem-type">
                                <input type="radio" name="type_probleme" value="qualite" required>
                                <div class="problem-type-card">
                                    <div class="problem-type-icon">⚠️</div>
                                    <div class="problem-type-title">Qualité</div>
                                    <div class="problem-type-desc">Eau de mauvaise qualité</div>
                                </div>
                            </label>

                            <label class="problem-type">
                                <input type="radio" name="type_probleme" value="autre" required>
                                <div class="problem-type-card">
                                    <div class="problem-type-icon">❓</div>
                                    <div class="problem-type-title">Autre</div>
                                    <div class="problem-type-desc">Autre problème</div>
                                </div>
                            </label>
                        </div>

                        <div class="encouragement">
                            <div class="encouragement-text">
                                <i class="fas fa-lightbulb"></i>
                                Chaque signalement aide les autorités à prioriser les interventions
                            </div>
                        </div>
                    </div>

                    <!-- ÉTAPE 2: LOCALISATION -->
                    <div class="form-step" id="form-step-2">
                        <div class="step-header">
                            <div class="step-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <h2 class="step-title">Où ça se passe ?</h2>
                            <p class="step-description">Nous localisons <strong>automatiquement</strong> votre position pour un traitement plus rapide</p>
                        </div>

                        <div class="encouragement" style="background: linear-gradient(135deg, #e0f2fe, #bae6fd); border-left: 4px solid #0ea5e9; margin-bottom: 1.5rem;">
                            <div class="encouragement-text" style="color: #0c4a6e;">
                                <i class="fas fa-info-circle"></i>
                                <strong>Important :</strong> Veuillez activer la localisation (GPS) sur votre appareil pour que nous puissions identifier précisément l'emplacement du problème. Sans cette information, nous ne pourrons pas traiter efficacement votre signalement.
                            </div>
                        </div>
                        
                        <div class="important-notice" style="background-color: #f0f9ff; border: 2px solid #0ea5e9; padding: 1.2rem; margin-bottom: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);">
                            <h4 style="margin-top: 0; color: #0369a1; font-size: 1.1rem; display: flex; align-items: center; gap: 0.5rem;"><i class="fas fa-location-arrow"></i> Guide de localisation</h4>
                            <ul style="margin: 0.8rem 0 0; padding-left: 1.5rem; color: #0c4a6e; line-height: 1.5;">
                                <li><strong>Activez le GPS</strong> dans les paramètres de votre appareil</li>
                                <li>Lorsque votre navigateur demande l'autorisation, cliquez sur <strong>"Autoriser"</strong></li>
                                <li>Restez à l'endroit exact où se trouve le problème pour une meilleure précision</li>
                                <li>Si la localisation échoue, décrivez précisément l'emplacement dans le champ ci-dessous</li>
                            </ul>
                        </div>

                        <div id="location-status" class="location-status">
                            <i class="fas fa-satellite-dish location-icon"></i>
                            <span>Recherche de votre position...</span>
                        </div>

                        <div class="form-group">
                            <label for="description" class="form-label">Description détaillée (optionnel)</label>
                            <textarea 
                                name="description" 
                                id="description" 
                                class="form-textarea" 
                                placeholder="Décrivez le problème plus précisément : depuis quand, intensité, zone affectée..."
                                spellcheck="true"
                                data-gramm="false"
                            ></textarea>
                            <div class="description-counter" style="font-size: 0.8rem; color: #6b7280; margin-top: 0.25rem; text-align: right;">
                                <span id="description-length">0</span> caractères
                                <span id="description-status" style="margin-left: 0.5rem;"></span>
                            </div>
                            <script>
                                // Mise à jour du compteur de caractères et indication si suffisant pour validation
                                document.getElementById('description').addEventListener('input', function() {
                                    const length = this.value.trim().length;
                                    const counter = document.getElementById('description-length');
                                    const status = document.getElementById('description-status');
                                    
                                    counter.textContent = length;
                                    
                                    if (length >= 20 && document.getElementById('latitude').value === '') {
                                        status.textContent = '✓ Suffisant pour continuer sans localisation';
                                        status.style.color = '#059669';
                                    } else if (length > 0 && length < 20 && document.getElementById('latitude').value === '') {
                                        status.textContent = 'Ajoutez plus de détails sur l\'emplacement';
                                        status.style.color = '#d97706';
                                    } else {
                                        status.textContent = '';
                                    }
                                });
                            </script>
                        </div>

                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                        <input type="hidden" name="adresse" id="adresse">
                    </div>

                    <!-- ÉTAPE 3: VOS INFORMATIONS -->
                    <div class="form-step" id="form-step-3">
                        <div class="step-header">
                            <div class="step-icon">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <h2 class="step-title">Vos coordonnées</h2>
                            <p class="step-description">Pour vous tenir informé du suivi de votre signalement</p>
                        </div>

                        <div class="form-group">
                            <label for="nom" class="form-label">Nom complet *</label>
                            <input 
                                type="text" 
                                name="nom" 
                                id="nom" 
                                class="form-input" 
                                required 
                                placeholder="Votre nom complet"
                            >
                        </div>

                        <div class="form-group">
                            <label for="telephone" class="form-label">Numéro de téléphone *</label>
                            <input 
                                type="tel" 
                                name="telephone" 
                                id="telephone" 
                                class="form-input" 
                                required 
                                placeholder="+221 XX XXX XX XX"
                            >
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email (optionnel)</label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                class="form-input" 
                                placeholder="votre@email.com"
                            >
                        </div>

                        <div class="encouragement">
                            <div class="encouragement-text">
                                <i class="fas fa-shield-alt"></i>
                                Vos informations sont protégées et utilisées uniquement pour le suivi de votre signalement
                            </div>
                        </div>
                    </div>

                    <!-- ÉTAPE 4: CONFIRMATION -->
                    <div class="form-step" id="form-step-4">
                        <div class="success-message">
                            <div class="success-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <h2 class="step-title">Signalement envoyé avec succès !</h2>
                            <p class="step-description">
                                Merci pour votre contribution citoyenne. Votre signalement a été transmis aux autorités compétentes.
                                Vous recevrez une confirmation par SMS/email si vous avez fourni vos coordonnées.
                            </p>
                            
                            <div class="encouragement">
                                <div class="encouragement-text">
                                    <i class="fas fa-heart"></i>
                                    Grâce à vous, notre communauté avance vers un meilleur accès à l'eau pour tous !
                                </div>
                            </div>
                            
                            <a href="/" class="btn btn-primary" style="margin-top: 2rem;">
                                <i class="fas fa-home"></i>
                                Retour à l'accueil
                            </a>
                        </div>
                    </div>

                    <!-- BOUTONS DE NAVIGATION -->
                    <div class="form-actions" id="form-actions">
                        <button type="button" class="btn btn-secondary" id="prev-btn" style="display: none;">
                            <i class="fas fa-arrow-left"></i>
                            Précédent
                        </button>
                        
                        <button type="button" class="btn btn-primary" id="next-btn">
                            Continuer
                            <i class="fas fa-arrow-right"></i>
                        </button>
                        
                        <button type="submit" class="btn btn-submit" id="submit-btn" style="display: none;">
                            <i class="fas fa-paper-plane"></i>
                            Envoyer le signalement
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentStep = 1;
        const totalSteps = 3;

        // Gestion des étapes
        function showStep(step) {
            // Cacher toutes les étapes
            document.querySelectorAll('.form-step').forEach(s => s.classList.remove('active'));
            
            // Afficher l'étape courante
            document.getElementById(`form-step-${step}`).classList.add('active');
            
            // Mettre à jour les indicateurs
            updateProgressIndicator(step);
            
            // Mettre à jour les boutons
            updateButtons(step);
        }

        function updateProgressIndicator(step) {
            for (let i = 1; i <= totalSteps; i++) {
                const stepElement = document.getElementById(`step-${i}`);
                const lineElement = document.getElementById(`line-${i}`);
                
                if (i <= step) {
                    stepElement.classList.add('active');
                    if (lineElement) lineElement.classList.add('completed');
                } else {
                    stepElement.classList.remove('active');
                    if (lineElement) lineElement.classList.remove('completed');
                }
            }
        }

        function updateButtons(step) {
            const prevBtn = document.getElementById('prev-btn');
            const nextBtn = document.getElementById('next-btn');
            const submitBtn = document.getElementById('submit-btn');
            
            prevBtn.style.display = step === 1 ? 'none' : 'inline-flex';
            nextBtn.style.display = step === totalSteps ? 'none' : 'inline-flex';
            submitBtn.style.display = step === totalSteps ? 'inline-flex' : 'none';
        }

        // Validation des étapes
        function validateStep(step) {
            switch(step) {
                case 1:
                    return document.querySelector('input[name="type_probleme"]:checked') !== null;
                case 2:
                    // Permettre de continuer si la géolocalisation est disponible OU si une description détaillée est fournie
                    const hasLocation = document.getElementById('latitude').value !== '';
                    const hasDescription = document.getElementById('description').value.trim().length > 20; // Au moins 20 caractères
                    return hasLocation || hasDescription;
                case 3:
                    const nom = document.getElementById('nom').value.trim();
                    const telephone = document.getElementById('telephone').value.trim();
                    return nom !== '' && telephone !== '';
                default:
                    return true;
            }
        }

        // Event listeners
        document.getElementById('next-btn').addEventListener('click', function() {
            if (validateStep(currentStep)) {
                if (currentStep < totalSteps) {
                    currentStep++;
                    showStep(currentStep);
                }
            } else {
                // Animation d'erreur
                const currentStepElement = document.getElementById(`form-step-${currentStep}`);
                currentStepElement.style.animation = 'none';
                setTimeout(() => {
                    currentStepElement.style.animation = 'shake 0.5s ease-in-out';
                }, 10);
                
                // Message d'erreur contextuel
                showValidationError(currentStep);
            }
        });

        document.getElementById('prev-btn').addEventListener('click', function() {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        });

        function showValidationError(step) {
            let message = '';
            switch(step) {
                case 1:
                    message = 'Veuillez sélectionner un type de problème';
                    break;
                case 2:
                    message = 'Veuillez soit autoriser la géolocalisation (activez le GPS de votre appareil), soit fournir une description détaillée de l\'emplacement du problème (au moins 20 caractères).';
                    break;
                case 3:
                    message = 'Veuillez remplir votre nom et téléphone';
                    break;
            }
            
            // Afficher temporairement le message
            const errorDiv = document.createElement('div');
            errorDiv.className = 'alert alert-danger';
            errorDiv.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; background: #fef2f2; border: 2px solid #ef4444; color: #991b1b; padding: 1rem; border-radius: 8px;';
            errorDiv.innerHTML = `<i class="fas fa-exclamation-triangle"></i> ${message}`;
            document.body.appendChild(errorDiv);
            
            setTimeout(() => {
                document.body.removeChild(errorDiv);
            }, 3000);
        }

        // Géolocalisation
        document.addEventListener('DOMContentLoaded', function () {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(async function (position) {
                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;

                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = lon;
                    
                    const locationStatus = document.getElementById('location-status');
                    locationStatus.className = 'location-status success';
                    locationStatus.innerHTML = '<i class="fas fa-check-circle location-icon"></i><span>Position détectée avec succès</span>';

                    try {
                        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lon}&format=json`);
                        const data = await response.json();
                        if (data && data.display_name) {
                            document.getElementById('adresse').value = data.display_name;
                            const addressDisplay = document.createElement('div');
                            addressDisplay.id = 'address-display';
                            addressDisplay.style.cssText = 'margin-top: 0.5rem; font-size: 0.9rem; background: rgba(255,255,255,0.2); padding: 0.5rem; border-radius: 8px;';
                            addressDisplay.innerHTML = `<i class="fas fa-map-marker-alt" style="margin-right: 0.25rem;"></i>${data.display_name}`;
                            locationStatus.appendChild(addressDisplay);
                            locationStatus.innerHTML = '<i class="fas fa-map-marker-alt location-icon"></i><span>Adresse: ' + data.display_name.split(',').slice(0, 3).join(', ') + '</span>';
                        }
                    } catch (error) {
                        console.error("Erreur lors de la récupération de l'adresse :", error);
                    }

                }, function (error) {
                    const locationStatus = document.getElementById('location-status');
                    locationStatus.className = 'location-status error';
                    
                    let errorMessage = '';
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            errorMessage = 'Accès à la localisation refusé. Veuillez activer la localisation dans les paramètres de votre appareil et autoriser l\'accès dans votre navigateur.';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            errorMessage = 'Information de localisation indisponible. Vérifiez que votre GPS est activé et que vous êtes dans une zone avec une bonne réception.';
                            break;
                        case error.TIMEOUT:
                            errorMessage = 'Délai d\'attente dépassé pour obtenir la localisation. Veuillez réessayer.';
                            break;
                        default:
                            errorMessage = 'Erreur inconnue lors de la localisation. Veuillez réessayer.';
                    }
                    
                    locationStatus.innerHTML = `<i class="fas fa-exclamation-triangle location-icon"></i><span>${errorMessage}</span>`;
                    
            
                    const retryButton = document.createElement('button');
                    retryButton.className = 'btn btn-secondary';
                    retryButton.style.marginLeft = '10px';
                    retryButton.style.marginTop = '10px';
                    retryButton.innerHTML = '<i class="fas fa-redo"></i> Réessayer';
                    retryButton.onclick = function() {
                       
                        locationStatus.className = 'location-status';
                        locationStatus.innerHTML = '<i class="fas fa-satellite-dish location-icon"></i><span>Recherche de votre position...</span>';
                        
                        
                        navigator.geolocation.getCurrentPosition(
                            arguments.callee.caller.arguments[0], 
                            arguments.callee.caller.arguments[1], 
                            {timeout: 10000, enableHighAccuracy: true}
                        );
                    };
                    locationStatus.appendChild(retryButton);
                    
                    console.error(error);
                });
            } else {
                const locationStatus = document.getElementById('location-status');
                locationStatus.className = 'location-status error';
                locationStatus.innerHTML = '<i class="fas fa-times-circle location-icon"></i><span>Votre navigateur ne prend pas en charge la géolocalisation. Veuillez essayer avec un navigateur plus récent comme Chrome, Firefox, Safari ou Edge.</span>';
                
                
                const helpDiv = document.createElement('div');
                helpDiv.className = 'encouragement';
                helpDiv.style.marginTop = '1rem';
                helpDiv.style.background = 'linear-gradient(135deg, #fee2e2, #fecaca)';
                helpDiv.style.borderLeft = '4px solid #ef4444';
                
                helpDiv.innerHTML = `
                    <div class="encouragement-text" style="color: #7f1d1d;">
                        <i class="fas fa-info-circle"></i>
                        <strong>Conseil :</strong> Si vous ne pouvez pas activer la géolocalisation, vous pouvez tout de même soumettre votre signalement, mais veuillez décrire précisément l'emplacement du problème dans le champ description.
                    </div>
                `;
                
                document.getElementById('form-step-2').insertBefore(helpDiv, document.querySelector('#form-step-2 .form-group'));
            }
        });

     
        const shakeKeyframes = `
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                25% { transform: translateX(-5px); }
                75% { transform: translateX(5px); }
            }
        `;
        const style = document.createElement('style');
        style.textContent = shakeKeyframes;
        document.head.appendChild(style);

        // Soumission du formulaire
        document.getElementById('reportForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (validateStep(3)) {
                const submitBtn = document.getElementById('submit-btn');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Envoi en cours...';
                submitBtn.disabled = true;
                
                // Utiliser fetch pour soumettre le formulaire...
                fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this),
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Cacher les actions
                    document.getElementById('form-actions').style.display = 'none';
                    
                    // Afficher l'étape de confirmation
                    document.getElementById('form-step-4').classList.add('active');
                    document.getElementById('form-step-3').classList.remove('active');
                    
                    // Mettre à jour l'indicateur de progression
                    document.getElementById('step-3').innerHTML = '<i class="fas fa-check"></i>';
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                    
                    // Afficher un message d'erreur
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'alert alert-danger';
                    errorDiv.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; background: #fef2f2; border: 2px solid #ef4444; color: #991b1b; padding: 1rem; border-radius: 8px;';
                    errorDiv.innerHTML = `<i class="fas fa-exclamation-triangle"></i> Une erreur est survenue. Veuillez réessayer.`;
                    document.body.appendChild(errorDiv);
                    
                    setTimeout(() => {
                        document.body.removeChild(errorDiv);
                    }, 3000);
                });
            } else {
                showValidationError(3);
            }
        });

        
        function focusFirstInput(step) {
            setTimeout(() => {
                const currentStep = document.getElementById(`form-step-${step}`);
                const firstInput = currentStep.querySelector('input:not([type="hidden"]), textarea, select');
                if (firstInput && firstInput.type !== 'radio') {
                    firstInput.focus();
                }
            }, 300);
        }

        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && e.target.tagName !== 'TEXTAREA') {
                e.preventDefault();
                if (currentStep < totalSteps) {
                    document.getElementById('next-btn').click();
                } else {
                    document.getElementById('submit-btn').click();
                }
            }
        });

        // Validation en temps réel pour l'étape 3
        const requiredFields = ['nom', 'telephone'];
        requiredFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.addEventListener('input', function() {
                    if (this.value.trim()) {
                        this.style.borderColor = '#10b981';
                    } else {
                        this.style.borderColor = '#e5e7eb';
                    }
                });
            }
        });

        // Format automatique pour le numéro de téléphone
        document.getElementById('telephone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // Supprimer les non-chiffres
            
           
            if (value.startsWith('221')) {
                value = value.substring(3);
            }
            
            if (value.length > 0) {
                if (value.length <= 2) {
                    value = `+221 ${value}`;
                } else if (value.length <= 5) {
                    value = `+221 ${value.substring(0, 2)} ${value.substring(2)}`;
                } else if (value.length <= 7) {
                    value = `+221 ${value.substring(0, 2)} ${value.substring(2, 5)} ${value.substring(5)}`;
                } else if (value.length <= 9) {
                    value = `+221 ${value.substring(0, 2)} ${value.substring(2, 5)} ${value.substring(5, 7)} ${value.substring(7)}`;
                } else {
                    value = `+221 ${value.substring(0, 2)} ${value.substring(2, 5)} ${value.substring(5, 7)} ${value.substring(7, 9)}`;
                }
            }
            
            e.target.value = value;
        });

        // Analytics et feedback utilisateur
        function trackStep(step) {
            console.log(`Utilisateur à l'étape ${step}`);
            
        }

        // Messages d'encouragement dynamiques
        const encouragementMessages = [
            {
                icon: "fas fa-users",
                text: "C'est un geste citoyen important pour votre communauté !" 
            },
            {
                icon: "fas fa-clock",
                text: "Signalement rapide = intervention rapide"
            },
            {
                icon: "fas fa-chart-line",
                text: "Votre signalement contribue à améliorer les services d'eau"
            },
            {
                icon: "fas fa-handshake",
                text: "Votre commune vous remercie pour votre engagement"
            }
        ];

        // Changer le message d'encouragement toutes les 5 secondes
        let messageIndex = 0;
        setInterval(() => {
            const encouragements = document.querySelectorAll('.encouragement-text');
            encouragements.forEach(el => {
                const message = encouragementMessages[messageIndex % encouragementMessages.length];
                el.innerHTML = `<i class="${message.icon}"></i> ${message.text}`;
            });
            messageIndex++;
        }, 5000);

        // Initialisation
        showStep(1);
        trackStep(1);
    </script>

    @if(session('success'))
    <div style="position: fixed; top: 20px; right: 20px; z-index: 9999; background: #ecfdf5; border: 2px solid #10b981; color: #065f46; padding: 1rem; border-radius: 8px;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

</body>
</html>
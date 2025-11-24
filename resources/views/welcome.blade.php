<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gëstu Ndox Mi</title>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* HEADER STYLES */
        .header {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(20px);
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(14, 165, 233, 0.05) 0%, rgba(16, 185, 129, 0.05) 100%);
            animation: headerShimmer 8s ease-in-out infinite;
        }

        @keyframes headerShimmer {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }

        .header-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            text-decoration: none;
            color: white;
            transition: all 0.3s ease;
            z-index: 2;
        }

        .logo:hover {
            transform: scale(1.02);
            filter: brightness(1.1);
        }

        .logo-icon {
            width: 65px;
            height: 65px;
            background: linear-gradient(135deg, #0ea5e9, #10b981);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 32px rgba(14, 165, 233, 0.4);
            position: relative;
            overflow: hidden;
        }

        .logo-icon::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            animation: iconRotate 3s linear infinite;
        }

        @keyframes iconRotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .logo-icon i {
            font-size: 2rem;
            color: white;
            position: relative;
            z-index: 1;
        }

        .logo-text {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, #ffffff, #e0f2fe);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .logo-subtitle {
            font-size: 0.9rem;
            opacity: 0.9;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-top: 0.25rem;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            z-index: 2;
        }

        .btn-header {
            background: linear-gradient(135deg, #ffffff, #f0f9ff);
            color: #0284c7;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(255, 255, 255, 0.3);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1rem;
            position: relative;
            overflow: hidden;
        }

        .btn-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(14, 165, 233, 0.3), transparent);
            transition: left 0.5s;
        }

        .btn-header:hover::before {
            left: 100%;
        }

        .btn-header:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(255, 255, 255, 0.4);
            color: #0284c7;
        }

        /* HERO SECTION */
        .hero-section {
            min-height: 90vh;
            display: flex;
            align-items: center;
            position: relative;
            background: 
                radial-gradient(circle at 20% 80%, rgba(14, 165, 233, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(16, 185, 129, 0.15) 0%, transparent 50%);
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 20"><circle cx="20" cy="10" r="2" fill="rgba(14,165,233,0.1)"/><circle cx="80" cy="10" r="2" fill="rgba(16,185,129,0.1)"/></svg>') repeat;
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .hero-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 4rem 2rem;
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 4rem;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .hero-content {
            animation: slideInLeft 1s ease-out;
        }

        @keyframes slideInLeft {
            from { transform: translateX(-50px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(14, 165, 233, 0.1));
            color: #0d9488;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 2rem;
            border: 2px solid rgba(16, 185, 129, 0.2);
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #0f172a 0%, #334155 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: #64748b;
            line-height: 1.7;
            margin-bottom: 3rem;
            font-weight: 400;
        }

        .action-buttons {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 1.25rem 2.5rem;
            border-radius: 16px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.1rem;
            position: relative;
            overflow: hidden;
        }

        .btn-primary-action {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            box-shadow: 0 8px 32px rgba(16, 185, 129, 0.3);
        }

        .btn-primary-action::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-primary-action:hover::before {
            left: 100%;
        }

        .btn-primary-action:hover {
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 15px 50px rgba(16, 185, 129, 0.4);
            color: white;
        }

        .btn-secondary-action {
            background: rgba(255, 255, 255, 0.9);
            color: #475569;
            border: 2px solid #e2e8f0;
            backdrop-filter: blur(10px);
        }

        .btn-secondary-action:hover {
            background: white;
            transform: translateY(-4px);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
            color: #475569;
        }

        /* HERO VISUAL */
        .hero-visual {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            animation: slideInRight 1s ease-out;
        }

        @keyframes slideInRight {
            from { transform: translateX(50px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        .hero-graphic {
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, #0ea5e9, #10b981);
            border-radius: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            box-shadow: 0 20px 60px rgba(14, 165, 233, 0.3);
            animation: pulse 4s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .hero-graphic::before {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.1), rgba(16, 185, 129, 0.1));
            border-radius: 60px;
            z-index: -1;
            animation: rotate 20s linear infinite;
        }

        .hero-graphic i {
            font-size: 8rem;
            color: white;
            text-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        /* FEATURES SECTION */
        .features-section {
            padding: 6rem 2rem;
            background: white;
            position: relative;
        }

        .features-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.1), rgba(16, 185, 129, 0.1));
            color: #0284c7;
            padding: 0.5rem 1.25rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .section-title {
            font-size: 3rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 1rem;
        }

        .section-subtitle {
            font-size: 1.2rem;
            color: #64748b;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2.5rem;
            margin-top: 4rem;
        }

        .feature-card {
            background: white;
            padding: 3rem 2.5rem;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            text-align: center;
            transition: all 0.4s ease;
            border: 1px solid #f1f5f9;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--card-gradient);
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .feature-card:nth-child(1) {
            --card-gradient: linear-gradient(135deg, #ef4444, #dc2626);
        }

        .feature-card:nth-child(2) {
            --card-gradient: linear-gradient(135deg, #0ea5e9, #0284c7);
        }

        .feature-card:nth-child(3) {
            --card-gradient: linear-gradient(135deg, #10b981, #059669);
        }

        .feature-icon {
            width: 90px;
            height: 90px;
            background: var(--card-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .feature-icon i {
            font-size: 2.5rem;
            color: white;
        }

        .feature-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 1.5rem;
        }

        .feature-description {
            color: #64748b;
            line-height: 1.7;
            font-size: 1.1rem;
        }

        /* FAQ SECTION */
        .faq-section {
            padding: 6rem 2rem;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .faq-container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .faq-grid {
            display: grid;
            gap: 1.5rem;
            margin-top: 3rem;
        }

        .faq-item {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .faq-item:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .faq-question {
            padding: 2rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: white;
            border: none;
            width: 100%;
            text-align: left;
            font-size: 1.1rem;
            font-weight: 600;
            color: #0f172a;
            transition: all 0.3s ease;
        }

        .faq-question:hover {
            background: #f8fafc;
        }

        .faq-question i {
            color: #0ea5e9;
            transition: transform 0.3s ease;
        }

        .faq-item.active .faq-question i {
            transform: rotate(180deg);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .faq-item.active .faq-answer {
            max-height: 300px;
        }

        .faq-content {
            padding: 0 2rem 2rem;
            color: #64748b;
            line-height: 1.7;
            font-size: 1rem;
        }

        /* FOOTER */
        .footer {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: white;
            padding: 4rem 0 2rem;
            position: relative;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        }

        .footer-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 3rem;
            margin-bottom: 2rem;
        }

        .footer-section h3 {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 2rem;
            color: white;
        }

        .contact-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: #cbd5e1;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .contact-info:hover {
            color: #0ea5e9;
            transform: translateX(5px);
        }

        .contact-info i {
            color: #0ea5e9;
            width: 20px;
            font-size: 1.1rem;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 2rem;
            text-align: center;
        }

        .footer-bottom p {
            color: #94a3b8;
            margin: 0;
            font-size: 0.9rem;
        }

        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .hero-container {
                grid-template-columns: 1fr;
                gap: 3rem;
                text-align: center;
            }

            .hero-graphic {
                width: 300px;
                height: 300px;
            }

            .hero-graphic i {
                font-size: 6rem;
            }
        }

        @media (max-width: 768px) {
            .header-container {
                padding: 1rem;
            }

            .nav-menu {
                gap: 0.5rem;
            }

            .btn-header {
                padding: 0.75rem 1.5rem;
                font-size: 0.9rem;
            }

            .hero-title {
                font-size: 2.5rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .action-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn-action {
                width: 100%;
                max-width: 300px;
                justify-content: center;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .hero-container {
                padding: 2rem 1rem;
            }

            .features-section {
                padding: 4rem 1rem;
            }

            .faq-section {
                padding: 4rem 1rem;
            }
        }

        @media (max-width: 480px) {
            .logo-text {
                font-size: 1.5rem;
            }

            .logo-icon {
                width: 50px;
                height: 50px;
            }

            .hero-title {
                font-size: 2rem;
            }

            .hero-graphic {
                width: 250px;
                height: 250px;
            }

            .hero-graphic i {
                font-size: 4rem;
            }

            .feature-card {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>

   
    <header class="header">
        <div class="header-container">
            <a href="/" class="logo">
                <div class="logo-icon">
                    <i class="fas fa-tint"></i>
                </div>
                <div>
                    <div class="logo-text">Gëstu Ndox Mi</div>
                    <div class="logo-subtitle">Signaler pour mieux gérer l’eau</div>
                </div>
            </a>
            
            <nav class="nav-menu">
                <a href="{{ route('reports.create') }}" class="btn-header">
                    <i class="fas fa-plus-circle"></i>
                    Signaler un problème
                </a>
            </nav>
        </div>
    </header>

    
    <section class="hero-section">
        <div class="hero-container">
            <div class="hero-content">
                <div class="hero-badge">
                    <i class="fas fa-water"></i>
                    Solution citoyenne pour l'eau
                </div>
                
                <h1 class="hero-title">
                    Ensemble pour un accès équitable à l'eau
                </h1>
                
                <p class="hero-subtitle">
                    Signalez facilement les problèmes d'eau dans votre quartier et contribuez à améliorer l'accès à l'eau potable pour tous les citoyens du Sénégal.
                </p>
                
                <div class="action-buttons">
                    <a href="{{ route('reports.create') }}" class="btn-action btn-primary-action">
                        <i class="fas fa-map-marker-alt"></i>
                        Signaler un problème
                    </a>
                    <a href="{{ route('admin.login') }}" class="btn-action btn-secondary-action">
                        <i class="fas fa-cog"></i>
                        Espace Administrateur
                    </a>
                </div>
            </div>

            <div class="hero-visual">
                <div class="hero-graphic">
                    <i class="fas fa-tint"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURES SECTION -->
    <section class="features-section">
        <div class="features-container">
            <div class="section-header">
                <div class="section-badge">
                    <i class="fas fa-star"></i>
                    Fonctionnalités
                </div>
                <h2 class="section-title">Comment ça marche ?</h2>
                <p class="section-subtitle">
                    Une approche simple et efficace pour signaler et résoudre les problèmes d'eau dans nos communautés
                </p>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3 class="feature-title">Signalement facile</h3>
                    <p class="feature-description">
                        Signalez un problème d'eau en quelques clics grâce à la géolocalisation automatique et une interface intuitive adaptée à tous.
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <h3 class="feature-title">Suivi en temps réel(Espace administrateur)</h3>
                    <p class="feature-description">
                        L'administrateur peut suivre les signalements en temps réel, visualiser les problèmes sur une carte et prioriser les interventions.
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h3 class="feature-title">Résolution rapide</h3>
                    <p class="feature-description">
                        Les autorités locales et les ONG peuvent intervenir rapidement pour résoudre les problèmes signalés, garantissant un accès continu à l'eau potable.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ SECTION -->
    <section class="faq-section" id="faq">
        <div class="faq-container">
            <div class="section-header">
                <div class="section-badge">
                    <i class="fas fa-question-circle"></i>
                    Questions fréquentes
                </div>
                <h2 class="section-title">FAQ</h2>
                <p class="section-subtitle">
                    Trouvez rapidement des réponses aux questions les plus courantes sur Gëstu Ndox Mi
                </p>
            </div>

            <div class="faq-grid">
                <div class="faq-item">
                    <button class="faq-question">
                        Comment signaler un problème d'eau ?
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-content">
                            Cliquez sur le bouton "Signaler un problème", suivez les étapes selon les instructions. Votre position sera automatiquement détectée pour faciliter le signalement.
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question">
                        Qui peut voir mes signalements ?
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-content">
                            Vos signalements sont visibles par les administrateurs autorisés (autorités municipales, ONG, services techniques). Vos données personnelles restent confidentielles et ne sont utilisées que pour les interventions nécessaires.
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question">
                        Combien de temps faut-il pour une intervention ?
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-content">
                            Le délai d'intervention dépend de la nature du problème...
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question">
                        L'utilisation de la plateforme est-elle gratuite ?
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-content">
                            Oui, Gëstu Ndox Mi est entièrement gratuit pour tous les citoyens. C'est un service public numérique développé pour améliorer l'accès à l'eau dans nos communautés.
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question">
                        Que faire en cas d'urgence liée à l'eau ?
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-content">
                            En cas d'urgence (fuite importante, contamination grave), contactez immédiatement les services d'urgence locaux en plus de faire votre signalement sur la plateforme. Pour les urgences, précisez-le clairement dans votre description.
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question">
                        Comment accéder à l'espace administrateur ?
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-content">
                            L'espace administrateur est réservé aux autorités compétentes (ONG, municipalités, services techniques). Les identifiants sont fournis par l'équipe de développement uniquement aux organismes autorisés.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Gëstu Ndox Mi</h3>
                    <p style="color: #cbd5e1; line-height: 1.6; margin-bottom: 1.5rem;">
                        Plateforme citoyenne dédiée à l'amélioration de l'accès à l'eau potable au Sénégal. Ensemble, construisons un avenir où chaque citoyen a accès à une eau de qualité.
                    </p>
                    <div class="contact-info">
                        <i class="fas fa-heart"></i>
                        <span>Fait avec passion pour le Sénégal</span>
                    </div>
                </div>

                <div class="footer-section">
                    <h3>Contact & Support</h3>
                    <div class="contact-info">
                        <i class="fas fa-envelope"></i>
                        <span>support@gestundoxmi.sn</span>
                    </div>
                    <div class="contact-info">
                        <i class="fas fa-code"></i>
                        <span>Développement technique</span>
                    </div>
                    <div class="contact-info">
                        <i class="fas fa-shield-alt"></i>
                        <span>Assistance administrateurs</span>
                    </div>
                    <div class="contact-info">
                        <i class="fas fa-question-circle"></i>
                        <span>FAQ disponible ci-dessus</span>
                    </div>
                </div>

                <div class="footer-section">
                    <h3>Informations utiles</h3>
                    <div class="contact-info">
                        <i class="fas fa-clock"></i>
                        <span>Service disponible 24h/24</span>
                    </div>
                    <div class="contact-info">
                        <i class="fas fa-mobile-alt"></i>
                        <span>Compatible tous appareils</span>
                    </div>
                    <div class="contact-info">
                        <i class="fas fa-lock"></i>
                        <span>Données sécurisées</span>
                    </div>
                    <div class="contact-info">
                        <i class="fas fa-users"></i>
                        <span>Solution collaborative</span>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Gëstu Ndox Mi - Plateforme citoyenne pour l'eau au Sénégal. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script>
        
        document.addEventListener('DOMContentLoaded', function() {
            const faqItems = document.querySelectorAll('.faq-item');
            
            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question');
                
                question.addEventListener('click', () => {
                    const isActive = item.classList.contains('active');
                    
                    
                    faqItems.forEach(otherItem => {
                        otherItem.classList.remove('active');
                    });
                    
                  
                    if (!isActive) {
                        item.classList.add('active');
                    }
                });
            });

           
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

           
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            
            document.querySelectorAll('.feature-card, .faq-item').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(el);
            });
        });
    </script>

</body>
</html>
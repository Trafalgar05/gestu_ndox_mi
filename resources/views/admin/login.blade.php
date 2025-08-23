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
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
        }

        /* HEADER */
        .header {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: white;
            text-decoration: none;
        }

        .brand-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #0ea5e9, #10b981);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(14, 165, 233, 0.3);
        }

        .brand-icon i {
            font-size: 1.5rem;
            color: white;
        }

        .brand-text h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
        }

        .brand-subtitle {
            font-size: 0.9rem;
            opacity: 0.8;
            margin: 0;
        }

        .btn-home {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            padding: 0.75rem 1.5rem;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-home:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
        }

        /* MAIN CONTENT */
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 3rem 2rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: start;
        }

        /* INFO SECTION */
        .info-section {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            border-top: 5px solid #0ea5e9;
        }

        .info-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .info-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            border: 3px solid #3b82f6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .info-icon i {
            font-size: 2rem;
            color: #3b82f6;
        }

        .info-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.5rem;
        }

        .info-subtitle {
            color: #64748b;
            font-size: 1.1rem;
        }

        .info-cards {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .info-card {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 16px;
            padding: 1.5rem;
            border-left: 4px solid var(--card-color);
        }

        .info-card.admin {
            --card-color: #3b82f6;
        }

        .info-card.security {
            --card-color: #ef4444;
        }

        .info-card.contact {
            --card-color: #10b981;
        }

        .card-title {
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.1rem;
        }

        .card-title i {
            color: var(--card-color);
        }

        .card-text {
            color: #475569;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .card-highlight {
            background: rgba(59, 130, 246, 0.1);
            padding: 1rem;
            border-radius: 10px;
            font-size: 0.9rem;
            color: #1e40af;
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

       
        .citizen-notice {
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
            border: 2px solid #10b981;
            border-radius: 16px;
            padding: 1.5rem;
            margin-top: 2rem;
            text-align: center;
        }

        .citizen-title {
            color: #065f46;
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .citizen-text {
            color: #047857;
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        .btn-citizen {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 0.875rem 2rem;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .btn-citizen:hover {
            background: linear-gradient(135deg, #059669, #047857);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
            color: white;
            text-decoration: none;
        }

        
        .login-section {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            border-top: 5px solid #10b981;
            height: fit-content;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
            border: 3px solid #10b981;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .login-icon i {
            font-size: 2rem;
            color: #10b981;
        }

        .login-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
            color: #64748b;
            font-size: 1rem;
        }

       
        .login-form {
            margin-top: 2rem;
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

        .form-control {
            width: 100%;
            padding: 1rem 1.25rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        .form-control:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
            background: white;
        }

        .error-alert {
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            color: #dc2626;
            border: 2px solid #f87171;
            padding: 1rem 1.25rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
        }

        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: none;
            padding: 1.25rem;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #059669, #047857);
            transform: translateY(-2px);
            box-shadow: 0 10px 40px rgba(16, 185, 129, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .main-container {
                grid-template-columns: 1fr;
                gap: 2rem;
                padding: 2rem;
            }
        }

        @media (max-width: 768px) {
            .header-content {
                padding: 0 1rem;
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .main-container {
                padding: 1.5rem 1rem;
            }

            .info-section,
            .login-section {
                padding: 2rem 1.5rem;
            }

            .info-title,
            .login-title {
                font-size: 1.5rem;
            }

            .brand-text h1 {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .info-section,
            .login-section {
                padding: 1.5rem 1rem;
            }

            .form-control {
                padding: 0.875rem 1rem;
            }

            .btn-login {
                padding: 1rem;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    
    <header class="header">
        <div class="header-content">
            <a href="/" class="brand">
                <div class="brand-icon">
                    <i class="fas fa-tint"></i>
                </div>
                <div class="brand-text">
                    <h1>Gëstu Ndox Mi</h1>
                    <p class="brand-subtitle">Signaler pour mieux gérer l’eau</p>
                </div>
            </a>
            
            <a href="/" class="btn-home">
                <i class="fas fa-home"></i>
                Retour à l'accueil
            </a>
        </div>
    </header>

    
    <div class="main-container">
        
        <div class="info-section">
            <div class="info-header">
                <div class="info-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h2 class="info-title">Espace Administrateur</h2>
                <p class="info-subtitle">Accès sécurisé et contrôlé</p>
            </div>

            <div class="info-cards">
                <div class="info-card admin">
                    <div class="card-title">
                        <i class="fas fa-users-cog"></i>
                        Qui peut accéder ?
                    </div>
                    <div class="card-text">
                        Cet espace est exclusivement réservé aux <strong>administrateurs autorisés</strong> : ONG, autorités municipales, services techniques de l'eau, et partenaires institutionnels.
                    </div>
                </div>

                <div class="info-card security">
                    <div class="card-title">
                        <i class="fas fa-lock"></i>
                        Sécurité & Accès
                    </div>
                    <div class="card-text">
                        Un seul compte administrateur est disponible pour garantir la traçabilité et la sécurité des interventions sur les signalements citoyens.
                    </div>
                    <div class="card-highlight">
                        <i class="fas fa-key"></i> 
                        <strong>Identifiants fournis uniquement par l'équipe technique</strong>
                    </div>
                </div>

                <div class="info-card contact">
                    <div class="card-title">
                        <i class="fas fa-headset"></i>
                        Besoin d'aide ?
                    </div>
                    <div class="card-text">
                        Pour obtenir vos identifiants de connexion ou signaler un problème technique, contactez l'équipe de développement système.
                    </div>
                </div>
            </div>

            
            <div class="citizen-notice">
                <div class="citizen-title">
                    <i class="fas fa-info-circle"></i>
                    Vous êtes un citoyen ?
                </div>
                <p class="citizen-text">
                    Cette page est réservée aux administrateurs. Vous pouvez signaler vos problèmes d'eau directement en cliquant sur le bouton ci-dessous.
                </p>
                <a href="{{ route('reports.create') }}" class="btn-citizen">
                    <i class="fas fa-plus-circle"></i>
                    Faire un signalement
                </a>
            </div>
        </div>

        
        <div class="login-section">
            <div class="login-header">
                <div class="login-icon">
                    <i class="fas fa-sign-in-alt"></i>
                </div>
                <h2 class="login-title">Connexion</h2>
                <p class="login-subtitle">Accédez au dashboard administrateur</p>
            </div>

            <form method="POST" action="{{ route('admin.login.post') }}" class="login-form">
                @csrf
                
                @if($errors->any())
                    <div class="error-alert">
                        <i class="fas fa-exclamation-triangle"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-envelope"></i> Adresse Email
                    </label>
                    <input type="email" name="email" class="form-control" placeholder="Entrez votre email administrateur" required value="{{ old('email') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-lock"></i> Mot de Passe
                    </label>
                    <input type="password" name="password" class="form-control" placeholder="Entrez votre mot de passe" required>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i>
                    Se connecter au dashboard
                </button>
            </form>
        </div>
    </div>
</body>
</html>
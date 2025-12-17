<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Co-op ERP</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* Left Side - Green Background */
        .left-panel {
            flex: 1;
            background: linear-gradient(135deg, #1a5f3f 0%, #2d7a52 100%);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 3rem;
            color: white;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 40%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 800"><rect fill="%231a5f3f" width="1200" height="800"/></svg>') no-repeat bottom;
            background-size: cover;
            opacity: 0.3;
            filter: blur(2px);
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 3rem;
            position: relative;
            z-index: 1;
        }

        .logo-icon {
            width: 32px;
            height: 32px;
            background: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .promo-content {
            position: relative;
            z-index: 1;
            max-width: 500px;
        }

        .promo-title {
            font-size: 3rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }

        .promo-description {
            font-size: 1.125rem;
            line-height: 1.6;
            opacity: 0.95;
        }

        .carousel-indicators {
            display: flex;
            gap: 0.5rem;
            position: relative;
            z-index: 1;
        }

        .indicator {
            width: 12px;
            height: 4px;
            background: rgba(255, 255, 255, 0.4);
            border-radius: 2px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .indicator.active {
            background: white;
            width: 24px;
        }

        /* Right Side - Login Form */
        .right-panel {
            flex: 1;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            overflow-y: auto;
        }

        .login-container {
            width: 100%;
            max-width: 440px;
        }

        .login-header {
            margin-bottom: 2.5rem;
        }

        .login-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
            color: #6b7280;
            font-size: 0.9375rem;
        }

        .login-form {
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .input-wrapper {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 0.875rem 3rem 0.875rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 0.9375rem;
            transition: all 0.2s;
            background: white;
        }

        .form-input:focus {
            outline: none;
            border-color: #2d7a52;
            box-shadow: 0 0 0 3px rgba(45, 122, 82, 0.1);
        }

        .input-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            pointer-events: none;
            color: #9ca3af;
        }

        .password-toggle {
            pointer-events: all;
            cursor: pointer;
        }

        .password-toggle:hover {
            color: #2d7a52;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .checkbox-input {
            width: 16px;
            height: 16px;
            cursor: pointer;
            accent-color: #2d7a52;
        }

        .checkbox-label {
            font-size: 0.875rem;
            color: #374151;
            cursor: pointer;
        }

        .forgot-password-link {
            font-size: 0.875rem;
            color: #2d7a52;
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-password-link:hover {
            text-decoration: underline;
        }

        .submit-button {
            width: 100%;
            padding: 0.875rem;
            background: #2d7a52;
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .submit-button:hover {
            background: #1a5f3f;
        }

        .submit-button:active {
            transform: scale(0.98);
        }

        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.875rem;
            color: #6b7280;
        }

        .register-link a {
            color: #2d7a52;
            text-decoration: none;
            font-weight: 500;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .copyright {
            text-align: center;
            margin-top: 3rem;
            font-size: 0.75rem;
            color: #9ca3af;
        }

        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .left-panel {
                display: none;
            }

            .right-panel {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Left Panel -->
    <div class="left-panel">
        <div>
            <div class="logo-section">
                <div class="logo-icon">🍃</div>
                <div class="logo-text">Co-op ERP</div>
            </div>
            <div class="promo-content">
                <h1 class="promo-title">Grandir ensemble, gérer plus intelligemment.</h1>
                <p class="promo-description">
                    Rationalisez les opérations de votre coopérative avec notre tableau de bord de gestion unifié. Sécurisé, efficace et conçu pour la croissance.
                </p>
            </div>
        </div>
        <div class="carousel-indicators">
            <div class="indicator active"></div>
            <div class="indicator"></div>
            <div class="indicator"></div>
        </div>
    </div>

    <!-- Right Panel -->
    <div class="right-panel">
        <div class="login-container">
            <div class="login-header">
                <h1 class="login-title">Bon retour</h1>
                <p class="login-subtitle">Veuillez entrer vos informations pour vous connecter.</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Adresse e-mail</label>
                    <div class="input-wrapper">
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-input" 
                            placeholder="nom@coop.com"
                            value="{{ old('email') }}"
                            required 
                            autofocus
                        >
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Mot de passe</label>
                    <div class="input-wrapper">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-input" 
                            placeholder="********"
                            required
                        >
                        <svg 
                            class="input-icon password-toggle" 
                            id="password-toggle"
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-options">
                    <div class="checkbox-wrapper">
                        <input 
                            type="checkbox" 
                            id="remember" 
                            name="remember" 
                            class="checkbox-input"
                        >
                        <label for="remember" class="checkbox-label">Se souvenir pendant 30 jours</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="forgot-password-link">Mot de passe oublié ?</a>
                </div>

                <button type="submit" class="submit-button">Se connecter</button>
            </form>

            <div class="register-link">
                Vous n'avez pas de compte ? <a href="#">Contacter l'administrateur</a>
            </div>

            <div class="copyright">
                © 2023 Cooperative Management Systems. v2.4.0
            </div>
        </div>
    </div>

    <script>
        // Password visibility toggle
        const passwordToggle = document.getElementById('password-toggle');
        const passwordInput = document.getElementById('password');

        passwordToggle.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle icon between eye and eye-slash
            if (type === 'text') {
                passwordToggle.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
            } else {
                passwordToggle.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
            }
        });
    </script>
</body>
</html>

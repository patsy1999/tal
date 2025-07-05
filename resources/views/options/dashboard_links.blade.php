<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard - Options</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --verification: #10B981;
            --maintenance: #3B82F6;
            --suivi: #8B5CF6;
            --sachet: #F59E0B;
            --fiche: #EF4444;
            --etalonnage: #64748B;
            --moustiquaire: #059669;
            --chlore: #D97706;
            --text-light: #F8FAFC;
            --text-dark: #1E293B;
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.04);
            --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 15px rgba(0,0,0,0.1);
            --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: #F1F5F9;
            margin: 0;
            padding: 2rem;
            min-height: 100vh;
            position: relative;
        }

        /* Fixed Back Button */
        .back-button {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
            background: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-md);
            cursor: pointer;
            transition: var(--transition);
            color: #3B82F6;
        }

        .back-button:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            color: #2563EB;
        }

        .back-button i {
            font-size: 1.2rem;
        }

        .header {
            text-align: center;
            margin-bottom: 2.5rem;
            padding-top: 1rem;
        }

        .header h1 {
            color: #1E293B;
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .header p {
            color: #64748B;
            font-size: 1rem;
            margin: 0;
        }

        .container {
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: var(--shadow-md);
            padding: 1.75rem;
            text-align: center;
            color: var(--text-light);
            font-weight: 600;
            font-size: 1.125rem;
            text-decoration: none;
            transition: var(--transition);
            cursor: pointer;
            user-select: none;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 140px;
            position: relative;
            overflow: hidden;
            border: none;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: currentColor;
            opacity: 0.8;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .card:active {
            transform: translateY(0);
        }

        .card i {
            font-size: 2rem;
            margin-bottom: 0.75rem;
        }

        /* Card Colors */
        .verification { background: var(--verification); color: white; }
        .maintenance { background: var(--maintenance); color: white; }
        .suivi { background: var(--suivi); color: white; }
        .sachet { background: var(--sachet); color: white; }
        .fiche { background: var(--fiche); color: white; }
        .etalonnage { background: var(--etalonnage); color: white; }
        .controle-moustiquaire { background: var(--moustiquaire); color: white; }
        .controle-chlore { background: var(--chlore); color: white; }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            }
            .card {
                min-height: 120px;
                padding: 1.5rem;
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 1.5rem;
            }
            .back-button {
                top: 10px;
                left: 10px;
                width: 36px;
                height: 36px;
            }
            .header h1 {
                font-size: 1.5rem;
            }
            .container {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Fixed Back Button -->
    <button class="back-button" onclick="window.history.back()" aria-label="Retour">
        <i class="fas fa-arrow-left"></i>
    </button>

    <div class="header">
        <h1>Tableau de Bord</h1>
        <p>Sélectionnez un module à utiliser</p>
    </div>

    <div class="container">
        <a href="{{route('daily_equipments.index')}}" class="card verification" title="Vérification">
            <i class="fas fa-check-circle"></i>
            VERIFICATION
        </a>

        <a href="{{route('temperature_log.show')}}" class="card maintenance" title="Temperature Log">
            <i class="fas fa-thermometer-half"></i>
            Temperature Log
        </a>

        <a href="{{route('trap-checks.index')}}" class="card suivi" title="Suivi">
            <i class="fas fa-chart-line"></i>
            SUIVI
        </a>

        <a href="{{route('stock.history')}}" class="card sachet" title="Sachet">
            <i class="fas fa-vial"></i>
            SACHET REACTIF
        </a>

       @auth
    @if(auth()->user()->role === 'admin')
        <a href="{{route('maintenance.index')}}" class="card fiche" title="Fiche d'intervention">
            <i class="fas fa-clipboard-check"></i>
            FICHE D'INTERVENTION
        </a>
    @endif
@endauth


        <a href="{{route('calibrations.index')}}" class="card etalonnage" title="Étalonnage">
            <i class="fas fa-tools"></i>
            ÉTALONNAGE
        </a>

        <a href="{{route('mosquito.index')}}" class="card controle-moustiquaire" title="Contrôle moustiquaire">
            <i class="fas fa-bug"></i>
            CONTRÔLE MOUSTIQUAIRES
        </a>

        <a href="{{route('chlorine-controls.index')}}" class="card controle-chlore" title="Contrôle chlore">
            <i class="fas fa-tint"></i>
            CONTRÔLE DU CHLORE
        </a>
    </div>

    <script>
        // Ensure back button stays visible even on scroll
        window.addEventListener('scroll', function() {
            const backButton = document.querySelector('.back-button');
            if (window.scrollY > 100) {
                backButton.style.transform = 'translateY(0)';
            } else {
                backButton.style.transform = 'translateY(0)';
            }
        });
    </script>
</body>
</html>

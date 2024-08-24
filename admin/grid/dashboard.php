<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Santé</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }

        header {
            background: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
            animation: fadeIn 2s ease-in-out;
        }

        main {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            animation: fadeInUp 2s ease-in-out;
        }

        section {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            flex: 1 1 300px;
            animation: bounceIn 1s ease-in-out;
        }

        .card {
            background: #e9ecef;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 10px;
            text-align: center;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        h1, h2, h3 {
            margin: 0;
        }

        #trend-chart {
            width: 100%;
            height: 300px;
            animation: fadeIn 2s ease-in-out;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounceIn {
            from {
                opacity: 0;
                transform: scale(0.5);
            }
            50% {
                opacity: 1;
                transform: scale(1.1);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="animate__animated animate__fadeIn">
            <h1>Dashboard Santé</h1>
        </header>
        <main>
            <section id="summary" class="animate__animated animate__fadeInUp">
                <h2>Vue d'Ensemble</h2>
                <div class="card animate__animated animate__bounceIn">
                    <h3>Fréquence Cardiaque</h3>
                    <p id="heart-rate">75 BPM</p>
                </div>
                <div class="card animate__animated animate__bounceIn">
                    <h3>Tension Artérielle</h3>
                    <p id="blood-pressure">120/80 mmHg</p>
                </div>
                <div class="card animate__animated animate__bounceIn">
                    <h3>Poids</h3>
                    <p id="weight">70 kg</p>
                </div>
            </section>
            <section id="trends" class="animate__animated animate__fadeInUp">
                <h2>Tendances</h2>
                <canvas id="trend-chart"></canvas>
            </section>
            <section id="activity" class="animate__animated animate__fadeInUp">
                <h2>Activité Physique</h2>
                <div class="card animate__animated animate__bounceIn">
                    <h3>Pas Quotidiens</h3>
                    <p id="steps">10,000</p>
                </div>
            </section>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Exemple de données de tendance
            const ctx = document.getElementById('trend-chart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
                    datasets: [{
                        label: 'Fréquence Cardiaque',
                        data: [70, 72, 68, 75, 74, 73, 71],
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>

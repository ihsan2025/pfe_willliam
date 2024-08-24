<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Team</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #28a745;
            color: white;
            padding: 20px;
            text-align: center;
        }

        main {
            padding: 20px;
            display: flex;
            justify-content: center;
        }

        .team-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            max-width: 1200px;
        }

        .team-member {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
            text-align: center;
        }

        .team-member img {
            width: 100%;
            height: auto;
            border-radius: 50%;
        }

        .team-member h3 {
            margin: 10px 0;
            color: #333;
        }

        .team-member p {
            color: #666;
        }
    </style>
</head>

<body>
    <header>
        <h1>Meet Our Team</h1>
    </header>
    <main>
        <div id="team-container" class="team-container">
            <!-- Team members will be dynamically inserted here -->
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetch('team.php')
                .then(response => response.json())
                .then(data => {
                    const teamContainer = document.getElementById('team-container');
                    teamContainer.innerHTML = data.map(member => `
                        <div class="team-member">
                            <img src="${member.image}" alt="${member.name}">
                            <h3>${member.name}</h3>
                            <p>${member.position}</p>
                        </div>
                    `).join('');
                })
                .catch(error => console.error('Error fetching team data:', error));
        });
    </script>
</body>

</html>

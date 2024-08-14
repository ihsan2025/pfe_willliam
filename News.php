<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News - Health Center</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        header {
            position: relative;
            background: url('images/news-banner.jpg') no-repeat center center/cover;
            height: 100vh;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        header::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1;
        }
        header h1, header p, header .btn, nav {
            position: relative;
            z-index: 2;
        }
        header h1 {
            font-size: 3rem;
            margin: 0;
        }
        header p {
            font-size: 1.5rem;
            margin: 10px 0;
        }
        header .btn {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 1.2rem;
            cursor: pointer;
            margin-top: 20px;
            text-decoration: none;
        }
        header .btn:hover {
            background-color: #218838;
        }
        nav {
            position: absolute;
            top: 10px;
            right: 20px;
            background-color: transparent;
            padding: 10px 20px;
            border-radius: 5px;
            z-index: 2;
        }
        nav a {
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            font-weight: bold;
        }
        nav a:hover {
            color: #28a745;
        }
        .news-section {
            padding: 50px;
            background-color: white;
        }
        .news-section h2 {
            font-size: 2rem;
            color: #333;
        }
        .news-section p {
            font-size: 1rem;
            color: #555;
            margin: 10px 0;
        }
        .news-article {
            margin-bottom: 20px;
            padding: 20px;
            border-bottom: 1px solid #ddd;
        }
        .news-article h3 {
            font-size: 1.5rem;
            color: #333;
            margin: 0;
        }
        .news-article p {
            font-size: 1rem;
            color: #555;
        }
        .form-section {
            padding: 50px;
            background-color: #f9f9f9;
        }
        .form-section h2 {
            font-size: 2rem;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-size: 1rem;
            color: #333;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-group button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 1.2rem;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<header>
    <nav>
        <a href="Home.html">Home</a>
        <a href="about.html">About Us</a>
        <a href="doctors.PHP">Doctors</a>
        <a href="News.php">News</a>
        <a href="contact.html">Contact</a>
        <a href="login.php" class="btn">Login</a>
    </nav>
    <h1>Latest News</h1>
    <p>Stay updated with the latest happenings at our Health Center</p>
</header>

<div class="news-section">
    <h2>Recent News and Updates</h2>
    
    <div id="news-articles">
        <?php
        // Database configuration
        $servername = "localhost"; // Replace with your database server name
        $username = "root"; // Replace with your database username
        $password = ""; // Replace with your database password
        $dbname = "pfe_william";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve news articles from the database
        $sql = "SELECT title, content FROM news_articles ORDER BY created_at DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="news-article">';
                echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
                echo '<p>' . htmlspecialchars($row['content']) . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p>No news articles found.</p>';
        }

        $conn->close();
        ?>
    </div>
</div>

<div class="form-section">
    <h2>Submit Your News</h2>
    <form id="news-form" action="submit_news.php" method="post">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="content">Content:</label>
            <textarea id="content" name="content" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <button type="submit">Submit News</button>
        </div>
    </form>
</div>

</body>
</html>

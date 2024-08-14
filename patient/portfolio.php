<?php
// Include the connection file
include 'connexion.php';

// Query to retrieve portfolio items
$sql = "SELECT * FROM portfolio_items";
$result = mysqli_query($conn, $sql);

// Check if query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Display portfolio items
while ($row = mysqli_fetch_assoc($result)) {
    ?>
    <div class="portfolio-item">
        <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
        <div class="info">
            <h3><?php echo htmlspecialchars($row['title']); ?></h3>
            <p><?php echo htmlspecialchars($row['description']); ?></p>
            <div class="links">
                <a href="<?php echo htmlspecialchars($row['linkedin']); ?>" target="_blank"><i class="fab fa-linkedin"></i>LinkedIn</a>
                <a href="<?php echo htmlspecialchars($row['project_link']); ?>" target="_blank">Project Link</a>
            </div>
            <div class="business-card">
                <h4><?php echo htmlspecialchars($row['doctor_name']); ?></h4>
                <p>Specialty: <?php echo htmlspecialchars($row['specialty']); ?></p>
                <p>University: <?php echo htmlspecialchars($row['university']); ?></p>
                <div class="contact">
                    <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>"><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($row['email']); ?></a>
                    <a href="tel:<?php echo htmlspecialchars($row['phone']); ?>"><i class="fas fa-phone"></i> <?php echo htmlspecialchars($row['phone']); ?></a>
                </div>
            </div>
            <div class="video-container">
                <iframe src="<?php echo htmlspecialchars($row['video_link']); ?>" allowfullscreen></iframe>
            </div>
        </div>
    </div>
    <?php
}

// Close connection
mysqli_close($conn);
?>

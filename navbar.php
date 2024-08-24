<?php
$docEmail = $_COOKIE['doc_email'];
$superDoctor = false;

if ($docEmail == "aadiipatil10z@gmail.com") {
    $superDoctor = true;
}
?>
<header>
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm">
      <div class="container">
        <a class="navbar-brand" href="#"><span class="text-primary">Tech</span>Care</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupport" aria-controls="navbarSupport" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupport">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="patients.php">Patients</a>
            </li>
            <li class="nav-item">
              <?php
              if($superDoctor){
              echo ' <a class="nav-link" href="ambulance_booking.php">Ambulance Bookings</a>';
              }?>
             
            </li>
            <li class="nav-item">
              <?php
              if($superDoctor){
              echo ' <a class="nav-link" href="labBookings.php">Lab Bookings</a>';
              }?>
             
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link" href="more.php">Ambulance</a>
            </li> -->
            <li class="nav-item">
              <button class="btn btn-primary ml-lg-3" onclick="logout()">Log Out</button>
            </li>
            
          </ul>
        </div> 
      </div> 
    </nav>
  </header>
  <script>
    function logout() {
        // Clear "user_email" cookie
        document.cookie = "doc_email=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";

        // Redirect to index.php
        window.location.href = "index.php";
    }
</script>
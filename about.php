<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About | SafeRoute</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">SafeRoute</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="about.php">About</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <?php if(isset($_SESSION['user_email']) || isset($_SESSION['police_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="profile.php">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="btn btn-primary me-2" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-light" href="register.php">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h1 class="text-center mb-4">About SafeRoute</h1>
                
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="card-title">Our Mission</h3>
                        <p class="card-text">
                            SafeRoute was created with the mission to make urban navigation safer for everyone. 
                            We combine real-time crime data, community reports, and advanced algorithms to 
                            provide the safest possible routes to your destination.
                        </p>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="card-title">How It Works</h3>
                        <p class="card-text">
                            Our system analyzes multiple data sources including police reports, user submissions, 
                            and historical crime data to identify potentially dangerous areas. When you request 
                            a route, our algorithm calculates paths that minimize exposure to these areas while 
                            still providing efficient navigation.
                        </p>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="card-title">For Law Enforcement</h3>
                        <p class="card-text">
                            Police officers and administrators have access to a dedicated dashboard where they can 
                            view incident reports, update incident statuses, and contribute to the safety database. 
                            This collaboration helps keep the community informed and safe.
                        </p>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Join Our Community</h3>
                        <p class="card-text">
                            Your reports make SafeRoute more effective for everyone. By sharing information about 
                            incidents or suspicious activities, you're helping to create a safer environment for 
                            your community.
                        </p>
                        <?php if(!isset($_SESSION['user_email']) && !isset($_SESSION['police_id'])): ?>
                            <a href="register.php" class="btn btn-primary">Register Now</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p>&copy; 2023 SafeRoute Finder. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
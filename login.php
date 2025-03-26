<?php
session_start();
require_once 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login_type = $_POST['login_type'];
    
    if ($login_type == 'user') {
        // User login with email and password
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        
        $stmt = $conn->prepare("SELECT id, name, email, password, image, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_image'] = $user['image'];
                $_SESSION['user_role'] = $user['role'];
                
                if ($user['role'] == 'admin') {
                    header("Location: admin_dashboard.php");
                } else {
                    header("Location: user_page.php");
                }
                exit();
            } else {
                $error = "Invalid email or password.";
            }
        } else {
            $error = "Invalid email or password.";
        }
    } elseif ($login_type == 'police') {
        // Police login with police_id and password
        $police_id = trim($_POST['police_id']);
        $password = $_POST['password'];
        
        $stmt = $conn->prepare("SELECT id, name, email, police_id, password, image, role FROM users WHERE police_id = ? AND role = 'admin'");
        $stmt->bind_param("s", $police_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['police_id'] = $user['police_id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_image'] = $user['image'];
                $_SESSION['user_role'] = $user['role'];
                
                header("Location: admin_dashboard.php");
                exit();
            } else {
                $error = "Invalid police ID or password.";
            }
        } else {
            $error = "Invalid police ID or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SafeRoute</title>
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
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="btn btn-outline-light me-2" href="register.php">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Login</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <ul class="nav nav-tabs mb-3" id="loginTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="user-tab" data-bs-toggle="tab" data-bs-target="#user-login" type="button" role="tab">User Login</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="police-tab" data-bs-toggle="tab" data-bs-target="#police-login" type="button" role="tab">Police Login</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="loginTabsContent">
                            <div class="tab-pane fade show active" id="user-login" role="tabpanel">
                                <form action="login.php" method="post">
                                    <input type="hidden" name="login_type" value="user">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email address</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Login</button>
                                </form>
                                <div class="text-center mt-3">
                                    <p>Don't have an account? <a href="register.php">Register here</a></p>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="police-login" role="tabpanel">
                                <form action="login.php" method="post">
                                    <input type="hidden" name="login_type" value="police">
                                    <div class="mb-3">
                                        <label for="police_id" class="form-label">Police ID</label>
                                        <input type="text" class="form-control" id="police_id" name="police_id" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="police_password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="police_password" name="password" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Login</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
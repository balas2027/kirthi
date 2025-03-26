<?php
session_start();
require_once 'session.php';

if (!isset($_SESSION['user_email']) && !isset($_SESSION['police_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'db_config.php';

// Get user data
if (isset($_SESSION['user_email'])) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $_SESSION['user_email']);
} else {
    $stmt = $conn->prepare("SELECT * FROM users WHERE police_id = ?");
    $stmt->bind_param("s", $_SESSION['police_id']);
}

$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    $errors = [];
    
    // Validate inputs
    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    
    // Check if email is being changed and if it already exists
    if ($email != $user['email']) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $errors[] = "Email already in use by another account.";
        }
    }
    
    // Handle password change if any password field is filled
    if (!empty($current_password) || !empty($new_password) || !empty($confirm_password)) {
        if (!password_verify($current_password, $user['password'])) {
            $errors[] = "Current password is incorrect.";
        }
        
        if (empty($new_password)) {
            $errors[] = "New password is required.";
        } elseif (strlen($new_password) < 8) {
            $errors[] = "New password must be at least 8 characters long.";
        }
        
        if ($new_password != $confirm_password) {
            $errors[] = "New passwords do not match.";
        }
    }
    
    // Handle image upload
    $image_path = $user['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        $file_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $file_name = uniqid() . '.' . $file_ext;
        $target_path = $upload_dir . $file_name;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            // Delete old image if it exists
            if ($image_path && file_exists($image_path)) {
                unlink($image_path);
            }
            $image_path = $target_path;
        }
    }
    
    // Update profile if no errors
    if (empty($errors)) {
        $hashed_password = !empty($new_password) ? password_hash($new_password, PASSWORD_DEFAULT) : $user['password'];
        
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, password = ?, image = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $name, $email, $hashed_password, $image_path, $user['id']);
        
        if ($stmt->execute()) {
            // Update session variables
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_image'] = $image_path;
            
            $success = "Profile updated successfully!";
            
            // Refresh user data
            if (isset($_SESSION['user_email'])) {
                $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
                $stmt->bind_param("s", $_SESSION['user_email']);
            } else {
                $stmt = $conn->prepare("SELECT * FROM users WHERE police_id = ?");
                $stmt->bind_param("s", $_SESSION['police_id']);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
        } else {
            $errors[] = "Failed to update profile. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | SafeRoute</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .profile-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block sidebar collapse bg-light">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <?php if (!empty($user['image'])): ?>
                            <img src="<?php echo $user['image']; ?>" alt="Profile Image" class="profile-img mb-2">
                        <?php else: ?>
                            <div class="profile-img mb-2 bg-secondary d-flex align-items-center justify-content-center text-white">
                                <span class="display-4"><?php echo substr($user['name'], 0, 1); ?></span>
                            </div>
                        <?php endif; ?>
                        <h5><?php echo $user['name']; ?></h5>
                        <span class="badge <?php echo $user['role'] == 'admin' ? 'bg-danger' : 'bg-primary'; ?>">
                            <?php echo ucfirst($user['role']); ?>
                        </span>
                        <?php if (!empty($user['police_id'])): ?>
                            <div class="mt-2">
                                <small>Police ID: <?php echo $user['police_id']; ?></small>
                            </div>
                        <?php endif; ?>
                    </div>
                    <ul class="nav flex-column">
                        <?php if ($user['role'] == 'admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="admin_dashboard.php">
                                    Dashboard
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="user_page.php">
                                    Dashboard
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="profile.php">
                                Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Profile Settings</h1>
                </div>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors as $error): ?>
                            <p class="mb-0"><?php echo $error; ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($success)): ?>
                    <div class="alert alert-success">
                        <?php echo $success; ?>
                    </div>
                <?php endif; ?>

                <div class="card mb-4">
                    <div class="card-body">
                        <form action="profile.php" method="post" enctype="multipart/form-data">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                </div>
                            </div>
                            
                            <?php if (!empty($user['police_id'])): ?>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="police_id" class="form-label">Police ID</label>
                                        <input type="text" class="form-control" id="police_id" value="<?php echo htmlspecialchars($user['police_id']); ?>" readonly>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="image" class="form-label">Profile Image</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <input type="password" class="form-control" id="current_password" name="current_password">
                                    <small class="text-muted">Leave blank to keep current password</small>
                                </div>
                                <div class="col-md-4">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password">
                                </div>
                                <div class="col-md-4">
                                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
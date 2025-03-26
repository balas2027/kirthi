<?php
session_start();
require_once 'session.php';

if (!isset($_SESSION['user_email']) && !isset($_SESSION['police_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_SESSION['user_role']) ){
    if ($_SESSION['user_role'] == 'user') {
        header("Location: user_page.php");
        exit();
    }
}

require_once 'db_config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | SafeRoute</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
        }
        .profile-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
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
                        <?php if (!empty($_SESSION['user_image'])): ?>
                            <img src="<?php echo $_SESSION['user_image']; ?>" alt="Profile Image" class="profile-img mb-2">
                        <?php else: ?>
                            <div class="profile-img mb-2 bg-secondary d-flex align-items-center justify-content-center text-white">
                                <span class="display-4"><?php echo substr($_SESSION['user_name'], 0, 1); ?></span>
                            </div>
                        <?php endif; ?>
                        <h5><?php echo $_SESSION['user_name']; ?></h5>
                        <span class="badge bg-danger">Admin</span>
                        <?php if (isset($_SESSION['police_id'])): ?>
                            <div class="mt-2">
                                <small>Police ID: <?php echo $_SESSION['police_id']; ?></small>
                            </div>
                        <?php endif; ?>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="admin_dashboard.php">
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="profile.php">
                                Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="chat/users.php">
                                User requests
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Manage Incidents
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Manage Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Analytics
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
                    <h1 class="h2">Admin Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card text-white bg-primary h-100">
                            <div class="card-body">
                                <h5 class="card-title">Total Users</h5>
                                <?php
                                $stmt = $conn->prepare("SELECT COUNT(*) as total_users FROM users WHERE role = 'user'");
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $total_users = $result->fetch_assoc()['total_users'];
                                ?>
                                <h1 class="display-4"><?php echo $total_users; ?></h1>
                                <a href="#" class="text-white">View all users</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card text-white bg-success h-100">
                            <div class="card-body">
                                <h5 class="card-title">Active Incidents</h5>
                                <h1 class="display-4">12</h1>
                                <a href="#" class="text-white">Manage incidents</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card text-white bg-warning h-100">
                            <div class="card-body">
                                <h5 class="card-title">Pending Reports</h5>
                                <h1 class="display-4">5</h1>
                                <a href="#" class="text-white">Review reports</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Recent Incident Reports</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Location</th>
                                        <th>Type</th>
                                        <th>Reported By</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#1234</td>
                                        <td>Main Street</td>
                                        <td>Theft</td>
                                        <td>user@example.com</td>
                                        <td><span class="badge bg-warning">Pending</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary">View</button>
                                            <button class="btn btn-sm btn-success">Resolve</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#1233</td>
                                        <td>Central Park</td>
                                        <td>Suspicious Activity</td>
                                        <td>user2@example.com</td>
                                        <td><span class="badge bg-success">Resolved</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary">View</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#1232</td>
                                        <td>Downtown Area</td>
                                        <td>Accident</td>
                                        <td>user3@example.com</td>
                                        <td><span class="badge bg-success">Resolved</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary">View</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
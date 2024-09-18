<?php
session_start();
include './includes/conn.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}

// Fetch user information from the database
$user_id = $_SESSION['user_id'];
try {
    $stmt = $pdo->prepare("SELECT username FROM Users WHERE id = :id");
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $username = htmlspecialchars($user['username']);
    } else {
        $username = 'Unknown User'; // Fallback if user not found
    }
} catch (PDOException $e) {
    $error_message = "Failed to retrieve user information: " . $e->getMessage();
    $username = 'Unknown User'; // Fallback in case of error
}
?>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/dashboard" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fa fa-cog"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
      <i class="fa fa-check-circle text-info mx-3" aria-hidden="true"></i> 
      <span class="brand-text font-weight-bold text-white">PFMS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="/dashboard" class="d-block"><?php echo htmlspecialchars($username); ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="fa fa-users"></i>
              <p>
                Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/users" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manage </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/donations" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Donations</p>
                </a>
              </li>              
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="fa fa-bell"></i>
              <p>
                Notifications
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/notification" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Send notification</p>
                </a>
              </li>
            </ul>
          </li>             
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="fa fa-cog"></i>
              <p>
                Settings
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Profile</p>
                </a>
              </li>
            </ul>
          </li>          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
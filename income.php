<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>incomes</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="../dist/img/logo1.jpg" type="image/jpeg">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css" integrity="sha512-3JRrEUwaCkFUBLK1N8HehwQgu8e23jTH4np5NHOmQOobuC4ROQxFwFgBLTnhcnQRMs84muMh0PnnwXlPq5MGjg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- iCheck -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.3/skins/all.min.css" integrity="sha512-wcKDxok85zB8F9HzgUwzzzPKJhHG7qMfC7bSKrZcFTC2wZXVhmgKNXYuid02cHVnFSC8KOJCXQ8M83UVA7v5Bw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<?php
include "./includes/header.php";
// Get userId from the URL parameter
$userId = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
$type = "income";
if ($userId > 0) {
    // Fetch data from the database
    try {
        $stmt = $pdo->prepare("
            SELECT
                t.description,
                t.amount,
                t.type,
                t.category,
                t.createdAt,
                t.userId
            FROM
                transactions t
            WHERE
                t.userId = :userId and t.type = :type
        ");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':type', $type);
        $stmt->execute();
        $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error_message = "Failed to retrieve transactions: " . $e->getMessage();
    }
} else {
    $error_message = "Invalid user ID.";
}
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Manage User Incomes</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Manage User Incomes</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <?php if (isset($error_message)): ?>
                <div class="alert alert-danger">
                  <?php echo htmlspecialchars($error_message); ?>
                </div>
              <?php endif; ?>
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>N<sup><u>o</u></sup></th>
                  <th>Description</th>
                  <th>Amount</th>
                  <th>Type</th>
                  <th>Category</th>
                  <th>Income made at</th>
                  <th>Options</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($transactions)): ?>
                  <?php foreach ($transactions as $index => $transaction): ?>
                    <tr>
                      <td><?php echo $index + 1; ?></td>
                      <td><?php echo htmlspecialchars($transaction['description']); ?></td>
                      <td><?php echo htmlspecialchars($transaction['amount']); ?></td>
                      <td><?php echo htmlspecialchars($transaction['type']); ?></td>
                      <td><?php echo htmlspecialchars($transaction['category']); ?></td>
                      <td><?php echo htmlspecialchars($transaction['createdAt']); ?></td>
                      <td>
                    <!-- Dropdown Menu -->
                      <span class="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <a href = "">...</a>
                      </span>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="income.php?user_id=<?php echo $transaction['userId']; ?>">View Income</a>
                        <a class="dropdown-item" href="expense.php?user_id=<?php echo $transaction['userId']; ?>">View Expenses</a>
                        <a class="dropdown-item" href="savings.php?user_id=<?php echo $transaction['userId']; ?>">View Savings</a>
                        <a class="dropdown-item" href="sessions.php?user_id=<?php echo $transaction['userId']; ?>">View Sessions</a>
                      </div>
                    </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="5">No transactions found.</td>
                  </tr>
                <?php endif; ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php
include "./includes/footer.php";
?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
</script>
</body>
</html>

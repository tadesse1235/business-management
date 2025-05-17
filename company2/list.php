<?php 
require_once 'config.php';
require_once 'auth.php';

$title = 'Employees';
$page = 'employees';

// Get all employees
$stmt = $pdo->prepare("SELECT * FROM employee ORDER BY last_name, first_name");
$stmt->execute();
$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include 'sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Employees</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="add.php" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-plus"></i> Add Employee
                    </a>
                </div>
            </div>

            <?php flash(); ?>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Position</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($employees as $employee): ?>
                        <tr>
                            <td><?= $employee['id'] ?></td>
                            <td><?= htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name']) ?></td>
                            <td><?= htmlspecialchars($employee['email']) ?></td>
                            <td><?= htmlspecialchars($employee['position']) ?></td>
                            <td><?= htmlspecialchars($employee['department']) ?></td>
                            <td>
                                <span class="badge bg-<?= $employee['status'] == 'active' ? 'success' : ($employee['status'] == 'on_leave' ? 'warning' : 'danger') ?>">
                                    <?= ucfirst($employee['status']) ?>
                                </span>
                            </td>
                            <td>
                                <a href="edit.php?id=<?= $employee['id'] ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if ($employee['id'] != $_SESSION['user_id']): ?>
                                <a href="includes/delete_employee.php?id=<?= $employee['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<?php include 'footer.php'; ?>
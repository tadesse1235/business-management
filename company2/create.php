<?php 
require_once 'config.php';
require_once 'auth.php';

$title = 'Create Support Ticket';
$page = 'tickets';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject = trim($_POST['subject']);
    $description = trim($_POST['description']);
    $priority = $_POST['priority'];
    
    if (empty($subject) || empty($description)) {
        flash('ticket_error', 'Please fill in all fields', 'alert alert-danger');
    } else {
        $stmt = $pdo->prepare("INSERT INTO support_tickets (customer_id NOT NULL, subject, description, priority) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$_SESSION['user_id'], $subject, $description, $priority])) {
            flash('ticket_success', 'Ticket created successfully! We will get back to you soon.');
            redirect(BASE_URL . '/customer/tickets/list.php');
        } else {
            flash('ticket_error', 'Error creating ticket. Please try again.', 'alert alert-danger');
        }
    }
}
?>

<?php include 'header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-3">
            <?php include 'sidebar.php'; ?>
        </div>
        <div class="col-md-9">
            <h2>Create Support Ticket</h2>
            <hr>
            
            <?php flash('ticket_error'); ?>
            <?php flash('ticket_success'); ?>
            
            <form method="POST">
                <div class="mb-3">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" class="form-control" id="subject" name="subject" required>
                </div>
                <div class="mb-3">
                    <label for="priority" class="form-label">Priority</label>
                    <select class="form-select" id="priority" name="priority">
                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                        <option value="critical">Critical</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Ticket</button>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
<?php
include 'db.php';
include 'header.php';

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $issue_type = $_POST['issue_type'] ?? '';
    $location = trim($_POST['location'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $image_url = '';
    
    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
        
        $filename = time() . '_' . basename($_FILES['image']['name']);
        $target = $upload_dir . $filename;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $image_url = $target;
        }
    }
    
    if ($issue_type && $location && $description) {
        $stmt = $pdo->prepare("INSERT INTO complaints (issue_type, location, description, image_url) VALUES (?, ?, ?, ?)");
        $stmt->execute([$issue_type, $location, $description, $image_url]);
        $success = true;
    } else {
        $error = 'Please fill in all required fields.';
    }
}
?>

<div class="form-page">
    <div class="container">
        <div class="page-header">
            <h1>Report an Issue</h1>
            <p>Fill out the form below to report a street light or road damage issue</p>
        </div>
        
        <?php if ($success): ?>
            <div class="alert alert-success">Your complaint has been submitted successfully!</div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <div class="card">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="issue_type">Issue Type *</label>
                    <select name="issue_type" id="issue_type" required>
                        <option value="">Select issue type</option>
                        <option value="Street Light Problem">Street Light Problem</option>
                        <option value="Road Damage">Road Damage</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="location">Location *</label>
                    <input type="text" name="location" id="location" placeholder="Enter the location of the issue" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Description *</label>
                    <textarea name="description" id="description" rows="4" placeholder="Describe the issue in detail" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="image">Upload Image (Optional)</label>
                    <input type="file" name="image" id="image" accept="image/*">
                </div>
                
                <button type="submit" class="btn btn-primary btn-full">Submit Report</button>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
<?php
include 'db.php';

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['complaint_id'], $_POST['status'])) {
    $stmt = $pdo->prepare("UPDATE complaints SET status = ? WHERE id = ?");
    $stmt->execute([$_POST['status'], $_POST['complaint_id']]);
    header("Location: admin.php?updated=1");
    exit;
}

include 'header.php';

$stmt = $pdo->query("SELECT * FROM complaints ORDER BY created_at DESC");
$complaints = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Count stats
$pending = count(array_filter($complaints, fn($c) => $c['status'] === 'Pending'));
$progress = count(array_filter($complaints, fn($c) => $c['status'] === 'In Progress'));
$resolved = count(array_filter($complaints, fn($c) => $c['status'] === 'Resolved'));
?>

<div class="table-page">
    <div class="container">
        <div class="page-header">
            <div class="card-icon" style="margin: 0 auto 1rem;">🛡️</div>
            <h1>Admin Dashboard</h1>
            <p>Manage and update complaint statuses</p>
        </div>
        
        <?php if (isset($_GET['updated'])): ?>
            <div class="alert alert-success">Status updated successfully!</div>
        <?php endif; ?>
        
        <div class="stats-grid">
            <div class="card stat-card">
                <p class="number pending"><?= $pending ?></p>
                <p class="label">Pending</p>
            </div>
            <div class="card stat-card">
                <p class="number progress"><?= $progress ?></p>
                <p class="label">In Progress</p>
            </div>
            <div class="card stat-card">
                <p class="number resolved"><?= $resolved ?></p>
                <p class="label">Resolved</p>
            </div>
        </div>
        
        <div class="card" style="padding: 0; overflow: hidden;">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Issue Type</th>
                            <th>Location</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($complaints)): ?>
                            <tr>
                                <td colspan="7" class="empty-state">No complaints to manage</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($complaints as $c): ?>
                                <tr>
                                    <td>#<?= $c['id'] ?></td>
                                    <td><?= htmlspecialchars($c['issue_type']) ?></td>
                                    <td style="max-width: 150px; overflow: hidden; text-overflow: ellipsis;"><?= htmlspecialchars($c['location']) ?></td>
                                    <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;"><?= htmlspecialchars($c['description']) ?></td>
                                    <td>
                                     <?php if (!empty($c['image_url'])): ?>
                                            <img src="<?= htmlspecialchars($c['image_url']) ?>" width="100" style="border-radius:6px;"
                                             onclick="window.open('<?= htmlspecialchars($c['image_url']) ?>','_blank')">>
                                        <?php else: ?>
                                            No Image
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('M d', strtotime($c['created_at'])) ?></td>
                                    <td>
                                        <?php
                                        $badgeClass = match($c['status']) {
                                            'Pending' => 'badge-pending',
                                            'In Progress' => 'badge-progress',
                                            'Resolved' => 'badge-resolved',
                                            default => ''
                                        };
                                        ?>
                                        <span class="badge <?= $badgeClass ?>"><?= $c['status'] ?></span>
                                    </td>
                                    <td>
                                        <form method="POST" style="display: flex; gap: 0.5rem;">
                                            <input type="hidden" name="complaint_id" value="<?= $c['id'] ?>">
                                            <select name="status" onchange="this.form.submit()" style="padding: 0.5rem; border-radius: 0.25rem; border: 1px solid #e2e8f0;">
                                                <option value="Pending" <?= $c['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                                <option value="In Progress" <?= $c['status'] === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                                                <option value="Resolved" <?= $c['status'] === 'Resolved' ? 'selected' : '' ?>>Resolved</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
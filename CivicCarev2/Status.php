<?php
include 'db.php';
include 'header.php';

$stmt = $pdo->query("SELECT * FROM complaints ORDER BY created_at DESC");
$complaints = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="table-page">
    <div class="container">
        <div class="page-header">
            <h1>Complaint Status</h1>
            <p>Track the status of all reported issues</p>
        </div>
        
        <div class="card" style="padding: 0; overflow: hidden;">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Issue Type</th>
                            <th>Location</th>
                            <th>Image</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($complaints)): ?>
                            <tr>
                                <td colspan="5" class="empty-state">No complaints found</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($complaints as $c): ?>
                                <tr>
                                    <td>#<?= $c['id'] ?></td>
                                    <td><?= htmlspecialchars($c['issue_type']) ?></td>
                                    <td><?= htmlspecialchars($c['location']) ?></td>
                                    <td>
                                        <?php if (!empty($c['image_url'])): ?>
                                            <img src="<?= htmlspecialchars($c['image_url']) ?>" 
                                                width="80" 
                                                style="border-radius:6px; cursor:pointer;"
                                                onclick="window.open('<?= htmlspecialchars($c['image_url']) ?>','_blank')">
                                        <?php else: ?>
                                            No Image
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('M d, Y', strtotime($c['created_at'])) ?></td>
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
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <p style="text-align: center; margin-top: 1.5rem; color: #64748b; font-size: 0.875rem;">
            Total Complaints: <?= count($complaints) ?>
        </p>
    </div>
</div>

<?php include 'footer.php'; ?>
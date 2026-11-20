<?php $title = 'Teaching Assignments'; $page = 'assignments'; ?>
<?php require __DIR__ . '/../layouts/header.php'; ?>

<!-- Halaman daftar jadwal mengajar dosen -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Teaching Assignment List</h2>
    <a href="index.php?page=assignments&action=create" class="btn btn-primary">+ Add Assignment</a>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Lecturer</th>
                <th>Course</th>
                <th>Academic Year</th>
                <th>Day</th>
                <th>Time</th>
                <th>Room</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($assignments)): ?>
                <tr><td colspan="8" class="text-center text-muted">Belum ada data jadwal mengajar.</td></tr>
            <?php else: ?>
                <?php $no = 1; foreach ($assignments as $a): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td>
                        <strong><?= htmlspecialchars($a['lecturer_name']) ?></strong><br>
                        <small class="text-muted">NIDN: <?= htmlspecialchars($a['nidn']) ?></small>
                    </td>
                    <td>
                        <span class="badge bg-info"><?= htmlspecialchars($a['course_code']) ?></span>
                        <?= htmlspecialchars($a['course_name']) ?><br>
                        <small class="text-muted"><?= $a['credits'] ?> SKS</small>
                    </td>
                    <td><?= htmlspecialchars($a['academic_year']) ?></td>
                    <td><span class="badge bg-secondary"><?= htmlspecialchars($a['day']) ?></span></td>
                    <td><?= substr($a['start_time'], 0, 5) ?> - <?= substr($a['end_time'], 0, 5) ?></td>
                    <td><?= htmlspecialchars($a['room'] ?? '-') ?></td>
                    <td>
                        <a href="index.php?page=assignments&action=edit&id=<?= $a['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <form method="POST" action="index.php?page=assignments&action=delete" class="d-inline"
                              onsubmit="return confirm('Yakin hapus jadwal ini?')">
                            <input type="hidden" name="id" value="<?= $a['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>

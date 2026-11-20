<?php $title = 'Courses'; $page = 'courses'; ?>
<?php require __DIR__ . '/../layouts/header.php'; ?>

<!-- Halaman daftar mata kuliah -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Course List</h2>
    <a href="index.php?page=courses&action=create" class="btn btn-primary">+ Add Course</a>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Code</th>
                <th>Course Name</th>
                <th>Credits (SKS)</th>
                <th>Semester</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($courses)): ?>
                <tr><td colspan="7" class="text-center text-muted">Belum ada data mata kuliah.</td></tr>
            <?php else: ?>
                <?php $no = 1; foreach ($courses as $c): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><span class="badge bg-info"><?= htmlspecialchars($c['code']) ?></span></td>
                    <td><?= htmlspecialchars($c['name']) ?></td>
                    <td><?= $c['credits'] ?></td>
                    <td><?= $c['semester'] ?></td>
                    <td><?= htmlspecialchars($c['description'] ?? '-') ?></td>
                    <td>
                        <a href="index.php?page=courses&action=edit&id=<?= $c['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <form method="POST" action="index.php?page=courses&action=delete" class="d-inline"
                              onsubmit="return confirm('Yakin hapus mata kuliah ini?')">
                            <input type="hidden" name="id" value="<?= $c['id'] ?>">
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

<?php $title = 'Lecturers'; $page = 'lecturers'; ?>
<?php require __DIR__ . '/../layouts/header.php'; ?>

<!-- Halaman daftar dosen -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Lecturer List</h2>
    <a href="index.php?page=lecturers&action=create" class="btn btn-primary">+ Add Lecturer</a>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>NIDN</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Specialization</th>
                <th>Join Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($lecturers)): ?>
                <tr><td colspan="8" class="text-center text-muted">Belum ada data dosen.</td></tr>
            <?php else: ?>
                <?php $no = 1; foreach ($lecturers as $l): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($l['name']) ?></td>
                    <td><?= htmlspecialchars($l['nidn']) ?></td>
                    <td><?= htmlspecialchars($l['email'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($l['phone'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($l['specialization'] ?? '-') ?></td>
                    <td><?= $l['join_date'] ?></td>
                    <td>
                        <a href="index.php?page=lecturers&action=edit&id=<?= $l['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <form method="POST" action="index.php?page=lecturers&action=delete" class="d-inline"
                              onsubmit="return confirm('Yakin hapus dosen ini?')">
                            <input type="hidden" name="id" value="<?= $l['id'] ?>">
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

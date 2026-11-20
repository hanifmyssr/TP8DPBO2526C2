<?php $title = 'Edit Lecturer'; $page = 'lecturers'; ?>
<?php require __DIR__ . '/../layouts/header.php'; ?>

<!-- Form edit data dosen -->
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h4 class="mb-0">Edit Lecturer</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required
                               value="<?= htmlspecialchars($lecturer['name']) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">NIDN <span class="text-danger">*</span></label>
                        <input type="text" name="nidn" class="form-control" required
                               value="<?= htmlspecialchars($lecturer['nidn']) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"
                               value="<?= htmlspecialchars($lecturer['email'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control"
                               value="<?= htmlspecialchars($lecturer['phone'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Specialization</label>
                        <input type="text" name="specialization" class="form-control"
                               value="<?= htmlspecialchars($lecturer['specialization'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Join Date <span class="text-danger">*</span></label>
                        <input type="date" name="join_date" class="form-control" required
                               value="<?= htmlspecialchars($lecturer['join_date']) ?>">
                    </div>
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="index.php?page=lecturers" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>

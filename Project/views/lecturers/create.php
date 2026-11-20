<?php $title = 'Add Lecturer'; $page = 'lecturers'; ?>
<?php require __DIR__ . '/../layouts/header.php'; ?>

<!-- Form tambah dosen baru -->
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Add New Lecturer</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required
                               value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">NIDN <span class="text-danger">*</span></label>
                        <input type="text" name="nidn" class="form-control" required
                               value="<?= htmlspecialchars($_POST['nidn'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control"
                               value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Specialization</label>
                        <input type="text" name="specialization" class="form-control"
                               value="<?= htmlspecialchars($_POST['specialization'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Join Date <span class="text-danger">*</span></label>
                        <input type="date" name="join_date" class="form-control" required
                               value="<?= htmlspecialchars($_POST['join_date'] ?? '') ?>">
                    </div>
                    <button type="submit" class="btn btn-success">Save</button>
                    <a href="index.php?page=lecturers" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>

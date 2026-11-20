<?php $title = 'Add Course'; $page = 'courses'; ?>
<?php require __DIR__ . '/../layouts/header.php'; ?>

<!-- Form tambah mata kuliah baru -->
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Add New Course</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Code <span class="text-danger">*</span></label>
                        <input type="text" name="code" class="form-control" required placeholder="e.g. IF101"
                               value="<?= htmlspecialchars($_POST['code'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Course Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required
                               value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Credits (SKS) <span class="text-danger">*</span></label>
                        <input type="number" name="credits" class="form-control" min="1" max="6" required
                               value="<?= htmlspecialchars($_POST['credits'] ?? '2') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Semester <span class="text-danger">*</span></label>
                        <input type="number" name="semester" class="form-control" min="1" max="8" required
                               value="<?= htmlspecialchars($_POST['semester'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Save</button>
                    <a href="index.php?page=courses" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>

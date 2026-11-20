<?php $title = 'Edit Teaching Assignment'; $page = 'assignments'; ?>
<?php require __DIR__ . '/../layouts/header.php'; ?>

<!-- Form edit data jadwal mengajar -->
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h4 class="mb-0">Edit Teaching Assignment</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Lecturer <span class="text-danger">*</span></label>
                        <select name="lecturer_id" class="form-select" required>
                            <?php foreach ($lecturers as $l): ?>
                                <option value="<?= $l['id'] ?>" <?= $assignment['lecturer_id'] == $l['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($l['name']) ?> (NIDN: <?= htmlspecialchars($l['nidn']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Course <span class="text-danger">*</span></label>
                        <select name="course_id" class="form-select" required>
                            <?php foreach ($courses as $c): ?>
                                <option value="<?= $c['id'] ?>" <?= $assignment['course_id'] == $c['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($c['code']) ?> - <?= htmlspecialchars($c['name']) ?> (<?= $c['credits'] ?> SKS)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Academic Year <span class="text-danger">*</span></label>
                            <input type="text" name="academic_year" class="form-control" required
                                   value="<?= htmlspecialchars($assignment['academic_year']) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Day <span class="text-danger">*</span></label>
                            <select name="day" class="form-select" required>
                                <?php foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $d): ?>
                                    <option value="<?= $d ?>" <?= $assignment['day'] === $d ? 'selected' : '' ?>>
                                        <?= $d ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Start Time <span class="text-danger">*</span></label>
                            <input type="time" name="start_time" class="form-control" required
                                   value="<?= substr($assignment['start_time'], 0, 5) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">End Time <span class="text-danger">*</span></label>
                            <input type="time" name="end_time" class="form-control" required
                                   value="<?= substr($assignment['end_time'], 0, 5) ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Room</label>
                        <input type="text" name="room" class="form-control"
                               value="<?= htmlspecialchars($assignment['room'] ?? '') ?>">
                    </div>

                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="index.php?page=assignments" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>

<?php
$title = 'Kelola Pertanyaan';
ob_start();
?>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>📋 Kelola Pertanyaan</h2>
        </div>
        
        <div style="margin-bottom: 20px;">
            <button onclick="showAddModal()" class="btn btn-primary">+ Tambah Pertanyaan Baru</button>
            <a href="/admin/dashboard" class="btn btn-secondary">Kembali ke Dashboard</a>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 15%;">Kategori</th>
                    <th style="width: 50%;">Pertanyaan</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 20%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($questions)): ?>
                <tr>
                    <td colspan="5" style="text-align: center;">Belum ada pertanyaan</td>
                </tr>
                <?php else: ?>
                    <?php foreach ($questions as $index => $question): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo htmlspecialchars($question['category_name']); ?></td>
                        <td><?php echo htmlspecialchars($question['question_text']); ?></td>
                        <td>
                            <?php if ($question['is_active']): ?>
                                <span style="color: var(--success); font-weight: 600;">✓ Aktif</span>
                            <?php else: ?>
                                <span style="color: var(--gray-600);">○ Nonaktif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <button onclick='editQuestion(<?php echo json_encode($question); ?>)' 
                                    class="btn btn-secondary" style="padding: 5px 10px; font-size: 0.9rem; margin-right: 5px;">
                                Edit
                            </button>
                            <form method="POST" action="/admin/questions" style="display: inline;">
                                <input type="hidden" name="action" value="toggle">
                                <input type="hidden" name="question_id" value="<?php echo $question['id']; ?>">
                                <button type="submit" class="btn btn-secondary" style="padding: 5px 10px; font-size: 0.9rem; margin-right: 5px;">
                                    <?php echo $question['is_active'] ? 'Nonaktifkan' : 'Aktifkan'; ?>
                                </button>
                            </form>
                            <form method="POST" action="/admin/questions" style="display: inline;" 
                                  onsubmit="return confirm('Yakin ingin menghapus pertanyaan ini?');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="question_id" value="<?php echo $question['id']; ?>">
                                <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 0.9rem;">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Modal -->
<div id="addModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
    <div class="card" style="max-width: 600px; width: 90%; max-height: 90vh; overflow-y: auto;">
        <div class="card-header">
            <h2>Tambah Pertanyaan Baru</h2>
        </div>
        <form method="POST" action="/admin/questions">
            <input type="hidden" name="action" value="add">
            
            <div class="form-group">
                <label for="add_category_id">Kategori *</label>
                <select id="add_category_id" name="category_id" class="form-control" required>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="add_question_text">Pertanyaan *</label>
                <textarea id="add_question_text" name="question_text" class="form-control" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="add_order_num">Urutan</label>
                <input type="number" id="add_order_num" name="order_num" class="form-control" value="0">
            </div>
            
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" onclick="hideAddModal()" class="btn btn-secondary">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
    <div class="card" style="max-width: 600px; width: 90%; max-height: 90vh; overflow-y: auto;">
        <div class="card-header">
            <h2>Edit Pertanyaan</h2>
        </div>
        <form method="POST" action="/admin/questions">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" id="edit_question_id" name="question_id">
            
            <div class="form-group">
                <label for="edit_category_id">Kategori *</label>
                <select id="edit_category_id" name="category_id" class="form-control" required>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="edit_question_text">Pertanyaan *</label>
                <textarea id="edit_question_text" name="question_text" class="form-control" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="edit_order_num">Urutan</label>
                <input type="number" id="edit_order_num" name="order_num" class="form-control">
            </div>
            
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Update</button>
                <button type="button" onclick="hideEditModal()" class="btn btn-secondary">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
function showAddModal() {
    document.getElementById('addModal').style.display = 'flex';
}

function hideAddModal() {
    document.getElementById('addModal').style.display = 'none';
}

function editQuestion(question) {
    document.getElementById('edit_question_id').value = question.id;
    document.getElementById('edit_category_id').value = question.category_id;
    document.getElementById('edit_question_text').value = question.question_text;
    document.getElementById('edit_order_num').value = question.order_num;
    document.getElementById('editModal').style.display = 'flex';
}

function hideEditModal() {
    document.getElementById('editModal').style.display = 'none';
}

// Close modals when clicking outside
document.getElementById('addModal').addEventListener('click', function(e) {
    if (e.target === this) hideAddModal();
});

document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) hideEditModal();
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';
?>

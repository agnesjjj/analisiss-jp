<?php
$title = 'Kuesioner Minat Jepang';
ob_start();
?>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>📊 Kuesioner Minat Terhadap Jepang</h2>
        </div>
        
        <div class="alert alert-info">
            <strong>Petunjuk Pengisian:</strong><br>
            Silakan pilih jawaban yang paling sesuai dengan minat dan pendapat Anda menggunakan skala berikut:
            <div style="margin-top: 10px;">
                <strong>1</strong> = Sangat Tidak Setuju | 
                <strong>2</strong> = Tidak Setuju | 
                <strong>3</strong> = Netral | 
                <strong>4</strong> = Setuju | 
                <strong>5</strong> = Sangat Setuju
            </div>
        </div>
        
        <form method="POST" action="/student/questionnaire">
            <?php foreach ($questions_by_category as $cat_id => $data): ?>
                <div style="margin: 30px 0;">
                    <div class="category-badge">
                        <?php echo htmlspecialchars($data['category']['name']); ?>
                    </div>
                    
                    <?php if (!empty($data['category']['description'])): ?>
                        <p style="color: var(--gray-600); margin-bottom: 20px;">
                            <?php echo htmlspecialchars($data['category']['description']); ?>
                        </p>
                    <?php endif; ?>
                    
                    <?php foreach ($data['questions'] as $index => $question): ?>
                        <div class="question-card">
                            <div class="question-number">
                                Pertanyaan <?php echo $index + 1; ?>
                            </div>
                            <div class="question-text">
                                <?php echo htmlspecialchars($question['question_text']); ?>
                            </div>
                            
                            <div class="likert-scale">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <div class="likert-item">
                                        <input type="radio" 
                                               id="question_<?php echo $question['id']; ?>_<?php echo $i; ?>" 
                                               name="question_<?php echo $question['id']; ?>" 
                                               value="<?php echo $i; ?>"
                                               <?php echo (isset($responses[$question['id']]) && $responses[$question['id']] == $i) ? 'checked' : ''; ?>
                                               required>
                                        <label for="question_<?php echo $question['id']; ?>_<?php echo $i; ?>">
                                            <div style="font-size: 1.5rem; margin-bottom: 5px;"><?php echo $i; ?></div>
                                            <div style="font-size: 0.8rem;">
                                                <?php
                                                $labels = [
                                                    1 => 'Sangat Tidak Setuju',
                                                    2 => 'Tidak Setuju',
                                                    3 => 'Netral',
                                                    4 => 'Setuju',
                                                    5 => 'Sangat Setuju'
                                                ];
                                                echo $labels[$i];
                                                ?>
                                            </div>
                                        </label>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
            
            <div style="display: flex; gap: 15px; margin-top: 30px; justify-content: center;">
                <button type="submit" class="btn btn-primary" style="padding: 15px 40px; font-size: 1.1rem;">
                    💾 Simpan Jawaban
                </button>
                <a href="/student/dashboard" class="btn btn-secondary" style="padding: 15px 40px; font-size: 1.1rem;">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<script>
// Add smooth scrolling and visual feedback
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    
    form.addEventListener('submit', function(e) {
        // Check if all questions are answered
        const questions = document.querySelectorAll('.question-card');
        let allAnswered = true;
        
        questions.forEach(function(questionCard) {
            const radioInputs = questionCard.querySelectorAll('input[type="radio"]');
            const isAnswered = Array.from(radioInputs).some(input => input.checked);
            
            if (!isAnswered) {
                allAnswered = false;
                questionCard.style.borderColor = 'var(--danger)';
                questionCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
            } else {
                questionCard.style.borderColor = '';
            }
        });
        
        if (!allAnswered) {
            e.preventDefault();
            alert('Mohon jawab semua pertanyaan sebelum menyimpan.');
        }
    });
    
    // Add change event to all radio buttons
    const radioButtons = document.querySelectorAll('input[type="radio"]');
    radioButtons.forEach(function(radio) {
        radio.addEventListener('change', function() {
            const questionCard = this.closest('.question-card');
            questionCard.style.borderColor = 'var(--success)';
            setTimeout(function() {
                questionCard.style.borderColor = '';
            }, 500);
        });
    });
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';
?>

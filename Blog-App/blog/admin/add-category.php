<?php 
include 'partials/header.php';

// Repopulate form data if validation fails
$title = $_SESSION['add-category-data']['title'] ?? '';
$description = $_SESSION['add-category-data']['description'] ?? '';

unset($_SESSION['add-category-data']); // Clear the repopulation data
?>

<section class="form__section">
    <div class="container form__section-container">
        <!-- Error Message Display -->
        <?php if (isset($_SESSION['add-category'])): ?>
            <div class="alert__message error">
                <p><?= htmlspecialchars($_SESSION['add-category']); ?></p>
                <?php unset($_SESSION['add-category']); ?>
            </div>
        <?php endif; ?>

        <form action="<?= ROOT_URL ?>admin/add-category-logic.php" method="POST">
            <input type="text" name="title" value="<?= htmlspecialchars($title); ?>" placeholder="Title">
            <textarea name="description" rows="4" placeholder="Description"><?= htmlspecialchars($description); ?></textarea>
            <button type="submit" name="submit" class="btn">Add Category</button>
        </form>
    </div>
</section>

<?php 
include '../partials/footer.php';
?>

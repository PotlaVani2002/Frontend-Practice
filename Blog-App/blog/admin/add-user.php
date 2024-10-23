<?php 
 include 'partials/header.php';
//   get form data if there was an error
$firstname = $_SESSION['add-user-data']['firstname'] ?? null;
$lastname = $_SESSION['add-user-data']['lastname'] ?? null;
$username = $_SESSION['add-user-data']['username'] ?? null;
$email = $_SESSION['add-user-data']['email'] ?? null;
$createpassword = $_SESSION['add-user-data']['createpassword'] ?? null;
$confirmpassowrd = $_SESSION['add-user-data']['confirmpassword'] ?? null;
// $userrole = $_SESSION['add-user-data']['userrole'] ?? null;
// $avatar = $_SESSION['add-user-data']['avatar'] ?? null;

// delete session data
unset($_SESSION['add-user-data']);
?>

    <section class="form__section">
    <div class="container form__section-container">
        <h2>Add User</h2>
         <!-- Error Message Display -->
         <?php if (isset($_SESSION['add-user'])): ?>
                <div class="alert__message error">
                    <p><?= htmlspecialchars($_SESSION['add-user']); ?></p>
                    <?php unset($_SESSION['add-user']); ?>
                </div>
         <?php endif; ?>
        <form action="<?=ROOT_URL ?>admin/add-user-logic.php" enctype="multipart/form-data" method='POST'>
            <input type="text" name="firstname" placeholder="First Name" value="<?= $firstname?>">
            <input type="text" name="lastname" placeholder="Last Name" value="<?= $lastname?>" >
            <input type="text" name="username" placeholder="Username" value="<?= $username?>">
            <input type="email" name="email" placeholder="Email" value="<?= $email?>">
            <input type="password" name="createpassword" placeholder="Create Password" value="<?= $createpassword?>">
            <input type="password" name="confirmpassword" placeholder="Confirm Password" value="<?= $confirmpassowrd?>" >
            <select name="userrole" id="">
                <option value="0">Author</option>
                <option value="1">Admin</option>
            </select>
            <div class="form__control">
                <label for="avatar">Add  avatar</label>
                <input type="file" name="avatar" id="avatar">
            </div>
            <button type="submit" name="submit" class="btn user-btn">Add User</button>
        </form>
    </div>
  </section>
<?php 
 include '../partials/footer.php';
?>
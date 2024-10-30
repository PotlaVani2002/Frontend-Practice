<?php 
 include 'partials/header.php';
 if(isset($_GET['id'])){
    $id=filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
    $query="select * from users where id=$id";
    $result=mysqli_query($connection,$query);
    $user=mysqli_fetch_assoc($result);
 }
 else{
    header('location:'.ROOT_URL. 'admin/manage-users.php');
    die();
 }
?>

    <section class="form__section">
    <div class="container form__section-container">
        <h2>Edit User</h2>
        <form action="<?=ROOT_URL ?>admin/edit-user-logic.php" method="POST">
            <input type="hidden" name="id" value="<?= $user['id'] ?>">
            <input type="text" placeholder="First Name" name="firstname" value="<?= $user['firstname'] ?>">
            <input type="text" placeholder="Last Name" name="lastname" value="<?= $user['lastname'] ?>">
            <select name="userrole" id="">
                <option value="0">Author</option>
                <option value="1">Admin</option>
            </select>
            <button type="submit" name="submit" class="btn user-btn">Update User</button>
        </form>
    </div>
  </section>
<?php 
 include '../partials/footer.php';
?>
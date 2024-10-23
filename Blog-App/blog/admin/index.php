<?php 
session_start();
 include 'partials/header.php';
?>


    <section class="dashboard">
    <div class="container dashboard__container">
        <button class="sidebar__toggle" id="show__sidebar-btn"><i class="uil uil-angle-right-b"></i></button>
        <button class="sidebar__toggle" id="hide__sidebar-btn"><i class="uil uil-angle-left-b"></i></button>
        <aside>
            <ul>
                <li><a href="<?= ROOT_URL?>admin/add-post.php"><i class="uil uil-pen"></i>
                        <h5>Add Post</h5></a></li>
                <li><a href="<?= ROOT_URL?>admin/" class="active"><i class="uil uil-postcard"></i>
                       <h5> Manage Posts</h5></a></li>
                       <?php if(isset($_SESSION['user_is_admin'])) : ?>
                <li><a href="<?= ROOT_URL?>admin/add-user.php"><i class="uil uil-user-plus"></i>
                        <h5>Add User</h5></a></li>
                <li><a href="<?= ROOT_URL?>admin/manage-users.php"><i class="uil uil-users-alt"></i>
                        <h5>Manage Users</h5></a></li>
                <li><a href="<?= ROOT_URL?>admin/add-category.php"><i class="uil uil-edit"></i>
                        <h5>Add Category</h5></a></li>
                <li><a href="<?= ROOT_URL?>admin/manage-categories.php" ><i class="uil uil-list-ul"></i>
                        <h5>Manage Categories</h5></a></li>
                <?php endif; ?>
            </ul>
        </aside>
        <main>
            <h2>Manage Posts</h2>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Loreum ipsum, dolor sir amet consectetur adipisicing elit. </td>
                        <td>Wild Life</td>
                        <td><a href="edit-post.php" class="btn sm">Edit</a></td>
                        <td><a href="delete-category.php" class="btn sm danger">Delete</a></td>
                    </tr>
                    <tr>
                        <td>Loreum ipsum, dolor sir amet consectetur adipisicing elit. </td>
                        <td>Wild Life</td>
                        <td><a href="edit-post.php" class="btn sm">Edit</a></td>
                        <td><a href="delete-category.php" class="btn sm danger">Delete</a></td>
                    </tr>
                    <tr>
                        <td>Loreum ipsum, dolor sir amet consectetur adipisicing elit. </td>
                        <td>Wild Life</td>
                        <td><a href="edit-post.php" class="btn sm">Edit</a></td>
                        <td><a href="delete-category.php" class="btn sm danger">Delete</a></td>
                    </tr>
                </tbody>
            </table>
        </main>
    </div>
    </section>

    
<?php 
 include '../partials/footer.php';
?>
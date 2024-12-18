<?php
  include  'partials/header.php';
  if(isset($_GET['id'])){
    $id=filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
    $query="select * from posts where category_id=$id order by date_time DESC";
    $posts=mysqli_query($connection,$query);
  }else{
    header('location:'.ROOT_URL.'blog.php');
    die();
  }
?> 

    <header class="category__title">
    <h2><?php
            // Fetch category from categories table using category_id of post
                $category_id = $id;
                $category_query = "SELECT * FROM categories WHERE id=$id";
                $category_result = mysqli_query($connection, $category_query);
                $category = mysqli_fetch_assoc($category_result);
                $category_title = $category['title'];
                echo $category['title']
                ?>
                </h2>
    </header>

<!-- Posts -->
 <?php if(mysqli_num_rows($posts)> 0 ): ?>
<section class="posts">
        <div class="container posts__container">
            <?php while($post=mysqli_fetch_assoc($posts)) :?>
            <article class="post">
                <div class="post__thumbnail">
                    <img src="./images/<?= htmlspecialchars($post['thumbnail']) ?>" alt="No image">
                </div>
                <div class="post__info">
                    <h3 class="post__title"><a href="<?= ROOT_URL ?>post.php?id=<?= $post['id']?>"><?= $post['title']?></a></h3>
                    <p class="post__body"><?= substr($post['body'], 0, 150) ?>...</p>
                    <div class="post__author">
                    <?php
                    // Fetch author from users table using author_id
                    $author_id = $post['author_id'];
                    $author_query = "SELECT * FROM users WHERE id=$author_id";
                    $author_result = mysqli_query($connection, $author_query);
                    $author = mysqli_fetch_assoc($author_result);
                    ?>
                        <div class="post__author-avatar">
                            <img src="./images/<?= htmlspecialchars($author['avatar']) ?>" alt="">
                        </div>
                        <div class="post__author-info">
                            <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                            <small><?= date("M d, Y - H:i", strtotime($post['date_time'])) ?></small>
                        </div>
                    </div>
                </div>
            </article>
            <?php endwhile ?>
        </div>
    </section>
<?php else: ?>
    <div class="alert__message error lg">
        <p>No posts found for this category</p>
    </div>
    <?php endif ?>
<!-- Category Buttons -->
<section class="category__buttons">
        <div class="container category__buttons-container">
            <?php
                $all_categories_query="select * from categories";
                $all_categories=mysqli_query($connection,$all_categories_query);
             ?>
             <?php while($category= mysqli_fetch_assoc($all_categories)) :?>
            <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $category['id']?> " class="category__button"><?=$category['title']?></a>
            <?php endwhile ?>
        </div>
    </section>
<!-- Footer -->
<?php
  include  'partials/footer.php';

?> 
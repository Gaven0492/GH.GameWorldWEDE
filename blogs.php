<?php
require_once "Inc/functions.php";
session_start();

// handle Form Submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Handle Delete Request
    if (isset($_POST['delete_post'])) {
        DeleteBlogPost($_POST['post_id']);
        header("Location: blogs.php");
        exit();
    }
    
    if (isset($_POST['post_comment'])) {
        AddBlogComment($_POST['post_id'], $_POST['commenterName'], $_POST['commentBody']);
        header("Location: blogs.php");
        exit();
    }
}


HTMLhead();
HTMLnavBar();
HTMLcategories();
?>

<main class="blogContainer">
    
    <section class="blog-add-post">
        <h2>Add a new blog post</h2>
        <form method="POST" action="blogs.php" class="blog-form">
            <input type="text" name="title" placeholder="Title" required class="blog-input">
            <input type="text" name="author" placeholder="Author" class="blog-input">
            <select name="category" class="blog-select">
                <option value="1">Game Review</option>
                <option value="2">Console Review</option>
            </select>
            <textarea name="content" placeholder="Blog post content" required class="blog-textarea"></textarea>
            <button type="submit" name="publish_post" class="blog-button">Publish</button>
        </form>
    </section>

<section id="postDetail">
    <?php
    // 1. Fetch all posts from the database using your function
    $posts = GetBlogPosts();

    if (!empty($posts)): 
        foreach ($posts as $post): 
            $current_post_id = $post['postId']; // Store ID to fetch related comments
    ?>
        <article class="blog-article">
            <div id="fullPost">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <h1><?php echo htmlspecialchars($post['postTitle']); ?></h1>
                    
                    <form method="POST" action="blogs.php" onsubmit="return confirm('Are you sure you want to delete this post?');">
                        <input type="hidden" name="post_id" value="<?php echo $post['postId']; ?>">
                        <button type="submit" name="delete_post" class="blog-button" style="background-color: #d94b4b; padding: 5px 10px; font-size: 0.8rem;">
                            <i class="fa-solid fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
                
                <small class="blog-meta">
                    By <?php echo htmlspecialchars($post['postAuthor']); ?> 
                    on <?php echo date("F j, Y", strtotime($post['createdAt'])); ?>
                </small>
                
                <div class="blog-content">
                    <?php echo nl2br(htmlspecialchars($post['postContent'])); ?>
                </div>
            </div>

            <div class="blog-comments-wrapper">
                <h3>Comments</h3>
                <?php
                // 2. Fetch comments specifically for THIS post
                $comments = GetCommentsByPostId($current_post_id);
                
                if (empty($comments)): ?>
                    <p>No comments yet. Be the first!</p>
                <?php else: 
                    foreach($comments as $comment): ?>
                        <div class="blog-comment-item">
                            <span class="blog-comment-author"><?php echo htmlspecialchars($comment['commentAuthor']); ?>:</span>
                            <p class="blog-comment-text"><?php echo nl2br(htmlspecialchars($comment['commentText'])); ?></p>
                        </div>
                    <?php endforeach; 
                endif; ?>
            </div>

            <h4>Add new comment</h4>
            <form method="POST" action="blogs.php" class="blog-form blog-comment-form">
                <input type="hidden" name="post_id" value="<?php echo $current_post_id; ?>">
                
                <input type="text" name="commenterName" placeholder="Your Name" required class="blog-input">
                <textarea name="commentBody" placeholder="Comment" required class="blog-textarea"></textarea>
                <button type="submit" name="post_comment" class="blog-button">Post Comment</button>
            </form>
        </article>
    <?php 
        endforeach; 
    else: 
        echo "<p>No blog posts found. Use the form above to write the first one!</p>";
    endif; 
    ?>
</section>
</main>

<?php HTMLfoot(); ?>
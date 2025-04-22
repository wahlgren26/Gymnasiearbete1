<?php
// Initialize session
include 'session_handler.php';

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION["user_id"])) {
    header("location: auth/signin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymLog - Your Personal Workout Journal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/sidebarstyle.css">
    <link rel="stylesheet" href="assets/css/social.css">
    <!-- Add any additional CSS/JS imports here -->
</head>

<body>
    <div class="wrapper">

        <?php include 'sidebar.php'; ?>

        <div class="main p-3">
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-12">

                            <div class="page-title">
                    <h2>Social Feed</h2>
                    <p>Discover what other users are training and share your progress!</p>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Main content area (posts) -->
            <div class="col-lg-8">
                <!-- New post form -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Share something with the community</h5>
                        <form id="new-post-form">
                            <div class="mb-3">
                                <textarea class="form-control" id="post-content" rows="3" placeholder="What's happening on your fitness journey?"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Post</button>
                        </form>
                    </div>
                </div>

                <!-- Posts container -->
                <div id="posts-container">
                    <div class="text-center my-5" id="loading-indicator">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Loading posts...</p>
                    </div>
                </div>

                <!-- Load more posts button -->
                <div class="text-center mb-4" id="load-more-container" style="display: none;">
                    <button id="load-more-btn" class="btn btn-outline-primary">Load more posts</button>
                </div>
            </div>

            <!-- Sidebar (stats and trends) -->
            <div class="col-lg-4">
                <!-- User stats card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Your Stats</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Published posts:</span>
                            <span id="user-post-count">0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Kudos given:</span>
                            <span id="kudos-given-count">0</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Kudos received:</span>
                            <span id="kudos-received-count">0</span>
                        </div>
                    </div>
                </div>

                <!-- Trending tags card -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Trending Tags</h5>
                    </div>
                    <div class="card-body">
                        <div id="trending-tags">
                            <div class="text-center my-3">
                                <div class="spinner-border spinner-border-sm" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2">Loading tags...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Comments Modal -->
<div class="modal fade" id="commentsModal" tabindex="-1" aria-labelledby="commentsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commentsModalLabel">Comments</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="comments-container">
                    <div class="text-center my-3" id="comments-loading">
                        <div class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Loading comments...</p>
                    </div>
                </div>
                <form id="new-comment-form" class="mt-3">
                    <input type="hidden" id="comment-post-id">
                    <div class="mb-3">
                        <textarea class="form-control" id="comment-content" rows="2" placeholder="Write a comment..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Comment</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Post Template -->
<template id="post-template">
    <div class="card mb-4 post-card">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <img src="" alt="Profile picture" class="post-profile-image rounded-circle me-2" width="40" height="40">
                <div>
                    <h6 class="mb-0"><a href="#" class="post-username text-decoration-none"></a></h6>
                    <small class="text-muted post-time"></small>
                </div>
                <div class="post-actions ms-auto d-none">
                    <button class="btn btn-sm btn-outline-danger delete-post-btn">
                        <i class="lni lni-trash-can"></i> Delete
                    </button>
                </div>
            </div>
            <p class="post-content"></p>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <button class="btn btn-outline-primary btn-sm kudos-btn">
                    <i class="lni lni-thumbs-up"></i> <span class="kudos-count">0</span> Kudos
                </button>
                <button class="btn btn-outline-secondary btn-sm comments-btn">
                    <i class="lni lni-comments"></i> <span class="comments-count">0</span> Comments
                </button>
            </div>
        </div>
    </div>
</template>

<!-- Comment Template -->
<template id="comment-template">
    <div class="comment-item mb-3">
        <div class="d-flex">
            <img src="" alt="Profile picture" class="comment-profile-image rounded-circle me-2" width="32" height="32">
            <div class="comment-content flex-grow-1">
                <div class="d-flex align-items-baseline justify-content-between">
                    <div>
                        <h6 class="mb-0 me-2"><a href="#" class="comment-username text-decoration-none"></a></h6>
                        <small class="text-muted comment-time"></small>
                    </div>
                    <div class="comment-actions d-none">
                        <button class="btn btn-sm text-danger delete-comment-btn p-0" title="Delete comment">
                            <i class="lni lni-trash-can"></i>
                        </button>
                    </div>
                </div>
                <p class="comment-text mb-0"></p>
            </div>
        </div>
    </div>
</template>

<script>
    let currentPage = 1;
    
    // Document ready
    document.addEventListener('DOMContentLoaded', function() {
        // Load initial posts
        loadPosts(1);
        
        // Load user stats
        loadUserStats();
        
        // Load trending tags
        loadTrendingTags();
        
        // Set up event listeners
        setupEventListeners();
    });
    
    // Load posts from API
    function loadPosts(page) {
        const loadingIndicator = document.getElementById('loading-indicator');
        if (loadingIndicator) {
            loadingIndicator.style.display = 'block';
        }
        
        fetch(`api/social_api.php?action=get_posts&page=${page}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (page === 1) {
                        document.getElementById('posts-container').innerHTML = '';
                    }
                    
                    if (data.posts.length > 0) {
                        renderPosts(data.posts);
                        document.getElementById('load-more-container').style.display = 'block';
                    } else if (page === 1) {
                        document.getElementById('posts-container').innerHTML = '<div class="alert alert-info">No posts to display. Be the first to share something!</div>';
                    } else {
                        document.getElementById('load-more-container').style.display = 'none';
                    }
                } else {
                    console.error('Error fetching posts:', data.error);
                    const loadingIndicator = document.getElementById('loading-indicator');
                    if (loadingIndicator) {
                        loadingIndicator.style.display = 'none';
                    }
                    document.getElementById('posts-container').innerHTML = '<div class="alert alert-warning">Could not load posts at this time. Try refreshing the page.</div>';
                }
            })
            .catch(error => {
                console.error('Error fetching posts:', error);
                const loadingIndicator = document.getElementById('loading-indicator');
                if (loadingIndicator) {
                    loadingIndicator.style.display = 'none';
                }
                document.getElementById('posts-container').innerHTML = '<div class="alert alert-warning">Could not load posts at this time. Try refreshing the page.</div>';
            });
    }
    
    // Render posts to the container
    function renderPosts(posts) {
        const postsContainer = document.getElementById('posts-container');
        const template = document.getElementById('post-template');
        const currentUserId = <?php echo $_SESSION['user_id']; ?>;
        
        posts.forEach(post => {
            const clone = document.importNode(template.content, true);
            
            // Set post data
            const usernameLink = clone.querySelector('.post-username');
            usernameLink.textContent = post.username;
            usernameLink.href = `profile.php?user_id=${post.user_id}`;
            
            clone.querySelector('.post-content').textContent = post.content;
            clone.querySelector('.post-time').textContent = formatDate(post.created_at);
            clone.querySelector('.kudos-count').textContent = post.kudos_count;
            clone.querySelector('.comments-count').textContent = post.comment_count;
            
            // Set profile image with proper error handling
            const profileImageElement = clone.querySelector('.post-profile-image');
            if (post.profile_picture) {
                // Extract only the filename from the full path if needed
                let profileImagePath = post.profile_picture;
                if (profileImagePath.includes('/')) {
                    // If it's a full path, get just the filename
                    profileImagePath = profileImagePath.split('/').pop();
                }
                
                // Check if the profile picture file exists
                const img = new Image();
                img.onerror = function() {
                    // Set default image if profile picture doesn't exist
                    profileImageElement.src = 'assets/img/default-profile.png';
                };
                img.onload = function() {
                    // Image exists, set it
                    profileImageElement.src = 'uploads/profile_images/' + profileImagePath;
                };
                img.src = 'uploads/profile_images/' + profileImagePath;
            } else {
                profileImageElement.src = 'assets/img/default-profile.png';
            }
            
            // Set post ID as data attribute
            const postCard = clone.querySelector('.post-card');
            postCard.dataset.postId = post.post_id;
            
            // Show delete button if the post belongs to the current user
            if (post.user_id == currentUserId) {
                const postActions = clone.querySelector('.post-actions');
                postActions.classList.remove('d-none');
            }
            
            // Set kudos button state
            const kudosBtn = clone.querySelector('.kudos-btn');
            if (post.user_has_kudos) {
                kudosBtn.classList.remove('btn-outline-primary');
                kudosBtn.classList.add('btn-primary');
            }
            
            // Append to container
            postsContainer.appendChild(clone);
        });
        
        const loadingIndicator = document.getElementById('loading-indicator');
        if (loadingIndicator) {
            loadingIndicator.style.display = 'none';
        }
    }
    
    // Setup event listeners
    function setupEventListeners() {
        // New post form submission
        document.getElementById('new-post-form').addEventListener('submit', function(e) {
            e.preventDefault();
            createPost();
        });
        
        // Load more button
        document.getElementById('load-more-btn').addEventListener('click', function() {
            currentPage++;
            loadPosts(currentPage);
        });
        
        // Comment form submission
        document.getElementById('new-comment-form').addEventListener('submit', function(e) {
            e.preventDefault();
            addComment();
        });
        
        // Delegated event listeners for dynamic content
        document.getElementById('posts-container').addEventListener('click', function(e) {
            // Kudos button click
            if (e.target.closest('.kudos-btn')) {
                const postCard = e.target.closest('.post-card');
                toggleKudos(postCard.dataset.postId);
            }
            
            // Comments button click
            if (e.target.closest('.comments-btn')) {
                const postCard = e.target.closest('.post-card');
                openCommentsModal(postCard.dataset.postId);
            }
            
            // Delete post button click
            if (e.target.closest('.delete-post-btn')) {
                const postCard = e.target.closest('.post-card');
                deletePost(postCard.dataset.postId);
            }
        });
        
        // Delegated event listener for comment actions
        document.getElementById('comments-container').addEventListener('click', function(e) {
            // Delete comment button click
            if (e.target.closest('.delete-comment-btn')) {
                const commentItem = e.target.closest('.comment-item');
                const commentId = commentItem.dataset.commentId;
                const postId = document.getElementById('comment-post-id').value;
                deleteComment(commentId, postId);
            }
        });
    }
    
    // Create a new post
    function createPost() {
        const content = document.getElementById('post-content').value.trim();
        
        if (!content) {
            showError('Write something before posting.');
            return;
        }
        
        const formData = new FormData();
        formData.append('content', content);
        
        fetch('api/social_api.php?action=create_post', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Clear form
                document.getElementById('post-content').value = '';
                
                // Prepend new post
                const postsContainer = document.getElementById('posts-container');
                const noPostsMsg = postsContainer.querySelector('.alert');
                if (noPostsMsg) {
                    postsContainer.innerHTML = '';
                }
                
                renderPosts([data.post]);
                
                // Update stats
                loadUserStats();
            } else {
                console.error('Error creating post:', data.message);
                showError('An error occurred. Please check your connection and try again.');
            }
        })
        .catch(error => {
            console.error('Error creating post:', error);
            showError('An error occurred. Please check your connection and try again.');
        });
    }
    
    // Delete a post
    function deletePost(postId) {
        if (!confirm('Are you sure you want to delete this post? This action cannot be undone.')) {
            return;
        }
        
        const formData = new FormData();
        formData.append('post_id', postId);
        
        fetch('api/social_api.php?action=delete_post', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove post from DOM
                const postCard = document.querySelector(`.post-card[data-post-id="${postId}"]`);
                postCard.remove();
                
                // Update stats
                loadUserStats();
                
                // Show empty state if no posts left
                const postsContainer = document.getElementById('posts-container');
                if (postsContainer.children.length === 0) {
                    postsContainer.innerHTML = '<div class="alert alert-info">No posts to display. Be the first to share something!</div>';
                }
            } else {
                console.error('Error deleting post:', data.message);
                showError('Could not delete the post. Please try again later.');
            }
        })
        .catch(error => {
            console.error('Error deleting post:', error);
            showError('Could not delete the post. Please try again later.');
        });
    }
    
    // Toggle kudos on a post
    function toggleKudos(postId) {
        const formData = new FormData();
        formData.append('post_id', postId);
        
        fetch('api/social_api.php?action=toggle_kudos', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const postCard = document.querySelector(`.post-card[data-post-id="${postId}"]`);
                const kudosBtn = postCard.querySelector('.kudos-btn');
                const kudosCount = kudosBtn.querySelector('.kudos-count');
                
                if (data.has_kudos) {
                    kudosBtn.classList.remove('btn-outline-primary');
                    kudosBtn.classList.add('btn-primary');
                    kudosCount.textContent = parseInt(kudosCount.textContent) + 1;
                } else {
                    kudosBtn.classList.remove('btn-primary');
                    kudosBtn.classList.add('btn-outline-primary');
                    kudosCount.textContent = parseInt(kudosCount.textContent) - 1;
                }
                
                // Update stats
                loadUserStats();
            } else {
                console.error('Error handling kudos:', data.message);
                showError('An error occurred. Please check your connection and try again.');
            }
        })
        .catch(error => {
            console.error('Error handling kudos:', error);
            showError('An error occurred. Please check your connection and try again.');
        });
    }
    
    // Open comments modal and load comments
    function openCommentsModal(postId) {
        const modal = new bootstrap.Modal(document.getElementById('commentsModal'));
        document.getElementById('comment-post-id').value = postId;
        document.getElementById('comments-container').innerHTML = `
            <div class="text-center my-3" id="comments-loading">
                <div class="spinner-border spinner-border-sm" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Loading comments...</p>
            </div>
        `;
        modal.show();
        
        loadComments(postId);
    }
    
    // Load comments for a post
    function loadComments(postId) {
        fetch(`api/social_api.php?action=get_comments&post_id=${postId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const commentsContainer = document.getElementById('comments-container');
                    commentsContainer.innerHTML = '';
                    
                    if (data.comments.length === 0) {
                        commentsContainer.innerHTML = '<div class="alert alert-info">No comments yet. Be the first to comment!</div>';
                    } else {
                        renderComments(data.comments);
                    }
                } else {
                    console.error('Error fetching comments:', data.message);
                    document.getElementById('comments-container').innerHTML = '<div class="alert alert-warning">Could not load comments at this time. Please try again.</div>';
                }
            })
            .catch(error => {
                console.error('Error fetching comments:', error);
                document.getElementById('comments-container').innerHTML = '<div class="alert alert-warning">Could not load comments at this time. Please try again.</div>';
            });
    }
    
    // Render comments to the container
    function renderComments(comments) {
        const commentsContainer = document.getElementById('comments-container');
        const template = document.getElementById('comment-template');
        const currentUserId = <?php echo $_SESSION['user_id']; ?>;
        
        comments.forEach(comment => {
            const clone = document.importNode(template.content, true);
            
            // Set comment data
            const usernameLink = clone.querySelector('.comment-username');
            usernameLink.textContent = comment.username;
            usernameLink.href = `profile.php?user_id=${comment.user_id}`;
            
            clone.querySelector('.comment-text').textContent = comment.content;
            clone.querySelector('.comment-time').textContent = formatDate(comment.created_at);
            
            // Store comment ID
            const commentItem = clone.querySelector('.comment-item');
            commentItem.dataset.commentId = comment.comment_id;
            
            // Show delete button if the comment belongs to the current user
            if (comment.user_id == currentUserId) {
                const commentActions = clone.querySelector('.comment-actions');
                commentActions.classList.remove('d-none');
            }
            
            // Set profile image with proper error handling
            const profileImageElement = clone.querySelector('.comment-profile-image');
            if (comment.profile_picture) {
                // Extract only the filename from the full path if needed
                let profileImagePath = comment.profile_picture;
                if (profileImagePath.includes('/')) {
                    // If it's a full path, get just the filename
                    profileImagePath = profileImagePath.split('/').pop();
                }
                
                // Check if the profile picture file exists
                const img = new Image();
                img.onerror = function() {
                    // Set default image if profile picture doesn't exist
                    profileImageElement.src = 'assets/img/default-profile.png';
                };
                img.onload = function() {
                    // Image exists, set it
                    profileImageElement.src = 'uploads/profile_images/' + profileImagePath;
                };
                img.src = 'uploads/profile_images/' + profileImagePath;
            } else {
                profileImageElement.src = 'assets/img/default-profile.png';
            }
            
            // Append to container
            commentsContainer.appendChild(clone);
        });
    }
    
    // Add a new comment
    function addComment() {
        const postId = document.getElementById('comment-post-id').value;
        const content = document.getElementById('comment-content').value.trim();
        
        if (!content) {
            showError('Write something before commenting.');
            return;
        }
        
        const formData = new FormData();
        formData.append('post_id', postId);
        formData.append('content', content);
        
        fetch('api/social_api.php?action=add_comment', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Clear form
                document.getElementById('comment-content').value = '';
                
                // Reload comments
                loadComments(postId);
                
                // Update comment count in post
                const postCard = document.querySelector(`.post-card[data-post-id="${postId}"]`);
                const commentsCount = postCard.querySelector('.comments-count');
                commentsCount.textContent = parseInt(commentsCount.textContent) + 1;
            } else {
                console.error('Error creating comment:', data.message);
                showError('An error occurred. Please check your connection and try again.');
            }
        })
        .catch(error => {
            console.error('Error creating comment:', error);
            showError('An error occurred. Please check your connection and try again.');
        });
    }
    
    // Load user statistics
    function loadUserStats() {
        fetch('api/social_api.php?action=get_user_stats')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('user-post-count').textContent = data.stats.post_count;
                    document.getElementById('kudos-given-count').textContent = data.stats.kudos_given;
                    document.getElementById('kudos-received-count').textContent = data.stats.kudos_received;
                }
            })
            .catch(error => {
                console.error('Could not load user statistics:', error);
            });
    }
    
    // Load trending tags
    function loadTrendingTags() {
        fetch('api/social_api.php?action=get_trending_tags')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const tagsContainer = document.getElementById('trending-tags');
                    tagsContainer.innerHTML = '';
                    
                    if (data.tags.length === 0) {
                        tagsContainer.innerHTML = '<p class="text-muted">No trending tags right now.</p>';
                    } else {
                        const tagsList = document.createElement('div');
                        tagsList.className = 'd-flex flex-wrap gap-2';
                        
                        data.tags.forEach(tag => {
                            const tagBadge = document.createElement('a');
                            tagBadge.href = `?tag=${encodeURIComponent(tag.name)}`;
                            tagBadge.className = 'badge bg-primary text-white';
                            tagBadge.textContent = `#${tag.name}`;
                            tagsList.appendChild(tagBadge);
                        });
                        
                        tagsContainer.appendChild(tagsList);
                    }
                }
            })
            .catch(error => {
                document.getElementById('trending-tags').innerHTML = '<p class="text-muted">Could not load trends.</p>';
            });
    }
    
    // Helper function to format dates
    function formatDate(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const diff = Math.floor((now - date) / 1000); // diff in seconds
        
        if (diff < 60) {
            return 'Just now';
        } else if (diff < 3600) {
            const minutes = Math.floor(diff / 60);
            return `${minutes} ${minutes === 1 ? 'minute' : 'minutes'} ago`;
        } else if (diff < 86400) {
            const hours = Math.floor(diff / 3600);
            return `${hours} ${hours === 1 ? 'hour' : 'hours'} ago`;
        } else if (diff < 604800) {
            const days = Math.floor(diff / 86400);
            return `${days} ${days === 1 ? 'day' : 'days'} ago`;
        } else {
            return date.toLocaleDateString('en-US');
        }
    }
    
    // Show error message
    function showError(message) {
        alert(message);
    }
    
    // Delete a comment
    function deleteComment(commentId, postId) {
        if (!confirm('Är du säker på att du vill ta bort den här kommentaren? Detta kan inte ångras.')) {
            return;
        }
        
        const formData = new FormData();
        formData.append('comment_id', commentId);
        
        fetch('api/social_api.php?action=delete_comment', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove comment from DOM
                const commentItem = document.querySelector(`.comment-item[data-comment-id="${commentId}"]`);
                commentItem.remove();
                
                // Update comment count in post
                const postCard = document.querySelector(`.post-card[data-post-id="${postId}"]`);
                if (postCard) {
                    const commentsCount = postCard.querySelector('.comments-count');
                    commentsCount.textContent = Math.max(0, parseInt(commentsCount.textContent) - 1);
                }
                
                // Show empty state if no comments left
                const commentsContainer = document.getElementById('comments-container');
                if (commentsContainer.children.length === 0) {
                    commentsContainer.innerHTML = '<div class="alert alert-info">Inga kommentarer än. Var först med att kommentera!</div>';
                }
            } else {
                console.error('Error deleting comment:', data.error);
                showError('Kunde inte ta bort kommentaren. Försök igen senare.');
            }
        })
        .catch(error => {
            console.error('Error deleting comment:', error);
            showError('Kunde inte ta bort kommentaren. Försök igen senare.');
        });
    }
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>
</html>
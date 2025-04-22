<?php
// Initialize session
include 'session_handler.php';

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION["user_id"])) {
    header("location: auth/signin.php");
    exit;
}

// Include header
include_once 'header.php';
// Include sidebar
include_once 'sidebar.php';
?>

<link rel="stylesheet" href="assets/css/social.css">

<div class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2>Socialt flöde</h2>
                    <p>Upptäck vad andra användare tränar och dela dina framsteg!</p>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Main content area (posts) -->
            <div class="col-lg-8">
                <!-- New post form -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Dela något med gemenskapen</h5>
                        <form id="new-post-form">
                            <div class="mb-3">
                                <textarea class="form-control" id="post-content" rows="3" placeholder="Vad händer på din träningsresa?"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Publicera</button>
                        </form>
                    </div>
                </div>

                <!-- Posts container -->
                <div id="posts-container">
                    <div class="text-center my-5" id="loading-indicator">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Laddar...</span>
                        </div>
                        <p class="mt-2">Laddar inlägg...</p>
                    </div>
                </div>

                <!-- Load more posts button -->
                <div class="text-center mb-4" id="load-more-container" style="display: none;">
                    <button id="load-more-btn" class="btn btn-outline-primary">Ladda fler inlägg</button>
                </div>
            </div>

            <!-- Sidebar (stats and trends) -->
            <div class="col-lg-4">
                <!-- User stats card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Din statistik</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Publicerade inlägg:</span>
                            <span id="user-post-count">0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Kudos givna:</span>
                            <span id="kudos-given-count">0</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Kudos mottagna:</span>
                            <span id="kudos-received-count">0</span>
                        </div>
                    </div>
                </div>

                <!-- Trending tags card -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Trendande taggar</h5>
                    </div>
                    <div class="card-body">
                        <div id="trending-tags">
                            <div class="text-center my-3">
                                <div class="spinner-border spinner-border-sm" role="status">
                                    <span class="visually-hidden">Laddar...</span>
                                </div>
                                <p class="mt-2">Laddar taggar...</p>
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
                <h5 class="modal-title" id="commentsModalLabel">Kommentarer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Stäng"></button>
            </div>
            <div class="modal-body">
                <div id="comments-container">
                    <div class="text-center my-3" id="comments-loading">
                        <div class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Laddar...</span>
                        </div>
                        <p class="mt-2">Laddar kommentarer...</p>
                    </div>
                </div>
                <form id="new-comment-form" class="mt-3">
                    <input type="hidden" id="comment-post-id">
                    <div class="mb-3">
                        <textarea class="form-control" id="comment-content" rows="2" placeholder="Skriv en kommentar..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Kommentera</button>
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
                <img src="" alt="Profilbild" class="post-profile-image rounded-circle me-2" width="40" height="40">
                <div>
                    <h6 class="post-username mb-0"></h6>
                    <small class="text-muted post-time"></small>
                </div>
            </div>
            <p class="post-content"></p>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <button class="btn btn-outline-primary btn-sm kudos-btn">
                    <i class="lni lni-thumbs-up"></i> <span class="kudos-count">0</span> Kudos
                </button>
                <button class="btn btn-outline-secondary btn-sm comments-btn">
                    <i class="lni lni-comments"></i> <span class="comments-count">0</span> Kommentarer
                </button>
            </div>
        </div>
    </div>
</template>

<!-- Comment Template -->
<template id="comment-template">
    <div class="comment-item mb-3">
        <div class="d-flex">
            <img src="" alt="Profilbild" class="comment-profile-image rounded-circle me-2" width="32" height="32">
            <div class="comment-content">
                <div class="d-flex align-items-baseline">
                    <h6 class="comment-username mb-0 me-2"></h6>
                    <small class="text-muted comment-time"></small>
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
        document.getElementById('loading-indicator').style.display = 'block';
        
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
                        document.getElementById('posts-container').innerHTML = '<div class="alert alert-info">Inga inlägg att visa. Var först med att dela något!</div>';
                    } else {
                        document.getElementById('load-more-container').style.display = 'none';
                    }
                } else {
                    showError('Det gick inte att ladda inlägg: ' + data.error);
                }
                document.getElementById('loading-indicator').style.display = 'none';
            })
            .catch(error => {
                showError('Det gick inte att ansluta till servern. Försök igen senare.');
                document.getElementById('loading-indicator').style.display = 'none';
            });
    }
    
    // Render posts to the container
    function renderPosts(posts) {
        const postsContainer = document.getElementById('posts-container');
        const template = document.getElementById('post-template');
        
        posts.forEach(post => {
            const clone = document.importNode(template.content, true);
            
            // Set post data
            clone.querySelector('.post-username').textContent = post.username;
            clone.querySelector('.post-content').textContent = post.content;
            clone.querySelector('.post-time').textContent = formatDate(post.created_at);
            clone.querySelector('.kudos-count').textContent = post.kudos_count;
            clone.querySelector('.comments-count').textContent = post.comment_count;
            
            // Set profile image
            const profileImageElement = clone.querySelector('.post-profile-image');
            profileImageElement.src = post.profile_picture ? 'uploads/profile_images/' + post.profile_picture : 'assets/img/default-profile.png';
            
            // Set post ID as data attribute
            const postCard = clone.querySelector('.post-card');
            postCard.dataset.postId = post.post_id;
            
            // Set kudos button state
            const kudosBtn = clone.querySelector('.kudos-btn');
            if (post.user_has_kudos) {
                kudosBtn.classList.remove('btn-outline-primary');
                kudosBtn.classList.add('btn-primary');
            }
            
            // Append to container
            postsContainer.appendChild(clone);
        });
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
        });
    }
    
    // Create a new post
    function createPost() {
        const content = document.getElementById('post-content').value.trim();
        
        if (!content) {
            showError('Skriv något innan du publicerar.');
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
                showError('Det gick inte att skapa inlägg: ' + data.error);
            }
        })
        .catch(error => {
            showError('Det gick inte att ansluta till servern. Försök igen senare.');
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
                showError('Det gick inte att ge kudos: ' + data.error);
            }
        })
        .catch(error => {
            showError('Det gick inte att ansluta till servern. Försök igen senare.');
        });
    }
    
    // Open comments modal and load comments
    function openCommentsModal(postId) {
        const modal = new bootstrap.Modal(document.getElementById('commentsModal'));
        document.getElementById('comment-post-id').value = postId;
        document.getElementById('comments-container').innerHTML = `
            <div class="text-center my-3" id="comments-loading">
                <div class="spinner-border spinner-border-sm" role="status">
                    <span class="visually-hidden">Laddar...</span>
                </div>
                <p class="mt-2">Laddar kommentarer...</p>
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
                        commentsContainer.innerHTML = '<div class="alert alert-info">Inga kommentarer än. Var först med att kommentera!</div>';
                    } else {
                        renderComments(data.comments);
                    }
                } else {
                    document.getElementById('comments-container').innerHTML = `<div class="alert alert-danger">Kunde inte ladda kommentarer: ${data.error}</div>`;
                }
            })
            .catch(error => {
                document.getElementById('comments-container').innerHTML = '<div class="alert alert-danger">Kunde inte ansluta till servern. Försök igen senare.</div>';
            });
    }
    
    // Render comments to the container
    function renderComments(comments) {
        const commentsContainer = document.getElementById('comments-container');
        const template = document.getElementById('comment-template');
        
        comments.forEach(comment => {
            const clone = document.importNode(template.content, true);
            
            // Set comment data
            clone.querySelector('.comment-username').textContent = comment.username;
            clone.querySelector('.comment-text').textContent = comment.content;
            clone.querySelector('.comment-time').textContent = formatDate(comment.created_at);
            
            // Set profile image
            const profileImageElement = clone.querySelector('.comment-profile-image');
            profileImageElement.src = comment.profile_picture ? 'uploads/profile_images/' + comment.profile_picture : 'assets/img/default-profile.png';
            
            // Append to container
            commentsContainer.appendChild(clone);
        });
    }
    
    // Add a new comment
    function addComment() {
        const postId = document.getElementById('comment-post-id').value;
        const content = document.getElementById('comment-content').value.trim();
        
        if (!content) {
            showError('Skriv något innan du kommenterar.');
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
                showError('Det gick inte att lägga till kommentar: ' + data.error);
            }
        })
        .catch(error => {
            showError('Det gick inte att ansluta till servern. Försök igen senare.');
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
                console.error('Kunde inte ladda användarstatistik');
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
                        tagsContainer.innerHTML = '<p class="text-muted">Inga trendande taggar just nu.</p>';
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
                document.getElementById('trending-tags').innerHTML = '<p class="text-muted">Kunde inte ladda trender.</p>';
            });
    }
    
    // Helper function to format dates
    function formatDate(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const diff = Math.floor((now - date) / 1000); // diff in seconds
        
        if (diff < 60) {
            return 'Just nu';
        } else if (diff < 3600) {
            const minutes = Math.floor(diff / 60);
            return `${minutes} ${minutes === 1 ? 'minut' : 'minuter'} sedan`;
        } else if (diff < 86400) {
            const hours = Math.floor(diff / 3600);
            return `${hours} ${hours === 1 ? 'timme' : 'timmar'} sedan`;
        } else if (diff < 604800) {
            const days = Math.floor(diff / 86400);
            return `${days} ${days === 1 ? 'dag' : 'dagar'} sedan`;
        } else {
            return date.toLocaleDateString('sv-SE');
        }
    }
    
    // Show error message
    function showError(message) {
        alert(message);
    }
</script>

<?php
include_once 'footer.php';
?> 
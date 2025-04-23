<?php
// Initialize the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'User is not logged in']);
    exit;
}

// Include database connection
require_once '../config/db_connect.php';

// Set content type to JSON
header('Content-Type: application/json');

// Get request method
$method = $_SERVER['REQUEST_METHOD'];

// Process request based on method and action
if ($method === 'GET') {
    // Handle GET requests
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    
    switch ($action) {
        case 'get_posts':
            getPosts($conn);
            break;
        case 'get_comments':
            getComments($conn);
            break;
        case 'get_user_stats':
            getUserStats($conn);
            break;
        case 'get_trending_tags':
            getTrendingTags($conn);
            break;
        default:
            echo json_encode(['success' => false, 'error' => 'Invalid action']);
            break;
    }
} elseif ($method === 'POST') {
    // Handle POST requests
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    
    switch ($action) {
        case 'create_post':
            createPost($conn);
            break;
        case 'toggle_kudos':
            toggleKudos($conn);
            break;
        case 'add_comment':
            addComment($conn);
            break;
        case 'delete_post':
            deletePost($conn);
            break;
        case 'delete_comment':
            deleteComment($conn);
            break;
        default:
            echo json_encode(['success' => false, 'error' => 'Invalid action']);
            break;
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid HTTP request']);
}

/**
 * Get posts for the social feed
 */
function getPosts($conn) {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;
    $user_id = $_SESSION['user_id'];
    $tag = isset($_GET['tag']) ? trim($_GET['tag']) : null;
    
    try {
        // Basic SQL query
        $sql = "
            SELECT p.*, 
                   u.username, 
                   u.profile_image AS profile_picture,
                   (SELECT COUNT(*) FROM kudos WHERE post_id = p.post_id) AS kudos_count,
                   (SELECT COUNT(*) FROM comments WHERE post_id = p.post_id) AS comment_count,
                   (SELECT COUNT(*) FROM kudos WHERE post_id = p.post_id AND user_id = :user_id) AS user_has_kudos
            FROM social_posts p
            JOIN users u ON p.user_id = u.user_id
        ";
        
        // Add filtering if a tag is specified
        if ($tag) {
            $sql .= " WHERE p.content LIKE :tag_pattern";
        }
        
        // Add sorting and pagination
        $sql .= " ORDER BY p.created_at DESC LIMIT :limit OFFSET :offset";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        
        // Bind tag parameter if it exists
        if ($tag) {
            $tag_pattern = "%#" . $tag . "%";
            $stmt->bindParam(':tag_pattern', $tag_pattern, PDO::PARAM_STR);
        }
        
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Format posts for response
        foreach ($posts as &$post) {
            $post['user_has_kudos'] = (bool)$post['user_has_kudos'];
        }
        
        echo json_encode(['success' => true, 'posts' => $posts]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Error fetching posts: ' . $e->getMessage()]);
    }
}

/**
 * Get comments for a post
 */
function getComments($conn) {
    $post_id = isset($_GET['post_id']) ? (int)$_GET['post_id'] : 0;
    
    if (!$post_id) {
        echo json_encode(['success' => false, 'error' => 'Post ID is required']);
        return;
    }
    
    try {
        // Verify post exists
        $stmt = $conn->prepare("SELECT post_id FROM social_posts WHERE post_id = :post_id");
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->rowCount() === 0) {
            echo json_encode(['success' => false, 'error' => 'Post not found']);
            return;
        }
        
        // Get comments with user data
        $stmt = $conn->prepare("
            SELECT c.*, 
                   u.username, 
                   u.profile_image AS profile_picture
            FROM comments c
            JOIN users u ON c.user_id = u.user_id
            WHERE c.post_id = :post_id
            ORDER BY c.created_at ASC
        ");
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode(['success' => true, 'comments' => $comments]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Error getting comments: ' . $e->getMessage()]);
    }
}

/**
 * Create a new post
 */
function createPost($conn) {
    $content = isset($_POST['content']) ? trim($_POST['content']) : '';
    $post_type = isset($_POST['post_type']) ? $_POST['post_type'] : 'workout';
    $workout_id = isset($_POST['workout_id']) ? intval($_POST['workout_id']) : null;
    $user_id = $_SESSION['user_id'];
    
    if (empty($content)) {
        echo json_encode(['success' => false, 'error' => 'Content is required']);
        return;
    }
    
    try {
        // Insert the post
        $stmt = $conn->prepare("
            INSERT INTO social_posts (user_id, content, post_type, workout_id, created_at) 
            VALUES (:user_id, :content, :post_type, :workout_id, NOW())
        ");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->bindParam(':post_type', $post_type, PDO::PARAM_STR);
        $stmt->bindParam(':workout_id', $workout_id, $workout_id ? PDO::PARAM_INT : PDO::PARAM_NULL);
        $stmt->execute();
        
        $post_id = $conn->lastInsertId();
        
        // Get the newly created post with user data
        $stmt = $conn->prepare("
            SELECT p.*, 
                   u.username, 
                   u.profile_image AS profile_picture,
                   0 AS kudos_count,
                   0 AS comment_count,
                   0 AS user_has_kudos
            FROM social_posts p
            JOIN users u ON p.user_id = u.user_id
            WHERE p.post_id = :post_id
        ");
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
        $post['user_has_kudos'] = false;
        
        echo json_encode(['success' => true, 'post' => $post]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Error creating post: ' . $e->getMessage()]);
    }
}

/**
 * Toggle kudos for a post
 */
function toggleKudos($conn) {
    $post_id = isset($_POST['post_id']) ? (int)$_POST['post_id'] : 0;
    $user_id = $_SESSION['user_id'];
    
    if (!$post_id) {
        echo json_encode(['success' => false, 'error' => 'Post ID is required']);
        return;
    }
    
    try {
        // Check if post exists
        $stmt = $conn->prepare("SELECT post_id FROM social_posts WHERE post_id = :post_id");
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->rowCount() === 0) {
            echo json_encode(['success' => false, 'error' => 'Post not found']);
            return;
        }
        
        // Check if user has already given kudos
        $stmt = $conn->prepare("
            SELECT kudos_id FROM kudos 
            WHERE post_id = :post_id AND user_id = :user_id
        ");
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $hasKudos = $stmt->rowCount() > 0;
        
        if ($hasKudos) {
            // Remove kudos
            $stmt = $conn->prepare("
                DELETE FROM kudos 
                WHERE post_id = :post_id AND user_id = :user_id
            ");
            $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            
            $hasKudos = false;
        } else {
            // Add kudos
            $stmt = $conn->prepare("
                INSERT INTO kudos (post_id, user_id, created_at) 
                VALUES (:post_id, :user_id, NOW())
            ");
            $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            
            $hasKudos = true;
        }
        
        // Get updated kudos count
        $stmt = $conn->prepare("
            SELECT COUNT(*) AS kudos_count 
            FROM kudos 
            WHERE post_id = :post_id
        ");
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $kudos_count = $result['kudos_count'];
        
        echo json_encode([
            'success' => true, 
            'has_kudos' => $hasKudos, 
            'kudos_count' => $kudos_count
        ]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Error handling kudos: ' . $e->getMessage()]);
    }
}

/**
 * Add a comment to a post
 */
function addComment($conn) {
    $post_id = isset($_POST['post_id']) ? (int)$_POST['post_id'] : 0;
    $content = isset($_POST['content']) ? trim($_POST['content']) : '';
    $user_id = $_SESSION['user_id'];
    
    if (!$post_id) {
        echo json_encode(['success' => false, 'error' => 'Post ID is required']);
        return;
    }
    
    if (empty($content)) {
        echo json_encode(['success' => false, 'error' => 'Content is required']);
        return;
    }
    
    try {
        // Verify post exists
        $stmt = $conn->prepare("SELECT post_id FROM social_posts WHERE post_id = :post_id");
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->rowCount() === 0) {
            echo json_encode(['success' => false, 'error' => 'Post not found']);
            return;
        }
        
        // Insert the comment
        $stmt = $conn->prepare("
            INSERT INTO comments (post_id, user_id, content, created_at) 
            VALUES (:post_id, :user_id, :content, NOW())
        ");
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->execute();
        
        $comment_id = $conn->lastInsertId();
        
        // Get the newly created comment with user data
        $stmt = $conn->prepare("
            SELECT c.*, 
                   u.username, 
                   u.profile_image AS profile_picture
            FROM comments c
            JOIN users u ON c.user_id = u.user_id
            WHERE c.comment_id = :comment_id
        ");
        $stmt->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $comment = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo json_encode(['success' => true, 'comment' => $comment]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Error creating comment: ' . $e->getMessage()]);
    }
}

/**
 * Get user statistics
 */
function getUserStats($conn) {
    $user_id = $_SESSION['user_id'];
    
    try {
        // Get post count
        $stmt = $conn->prepare("
            SELECT COUNT(*) AS post_count 
            FROM social_posts 
            WHERE user_id = :user_id
        ");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $postCountResult = $stmt->fetch(PDO::FETCH_ASSOC);
        $postCount = $postCountResult['post_count'];
        
        // Get kudos given count
        $stmt = $conn->prepare("
            SELECT COUNT(*) AS kudos_given 
            FROM kudos 
            WHERE user_id = :user_id
        ");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $kudosGivenResult = $stmt->fetch(PDO::FETCH_ASSOC);
        $kudosGiven = $kudosGivenResult['kudos_given'];
        
        // Get kudos received count
        $stmt = $conn->prepare("
            SELECT COUNT(*) AS kudos_received 
            FROM kudos k
            JOIN social_posts p ON k.post_id = p.post_id
            WHERE p.user_id = :user_id
        ");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $kudosReceivedResult = $stmt->fetch(PDO::FETCH_ASSOC);
        $kudosReceived = $kudosReceivedResult['kudos_received'];
        
        $stats = [
            'post_count' => $postCount,
            'kudos_given' => $kudosGiven,
            'kudos_received' => $kudosReceived
        ];
        
        echo json_encode(['success' => true, 'stats' => $stats]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Error getting user statistics: ' . $e->getMessage()]);
    }
}

/**
 * Get trending tags
 */
function getTrendingTags($conn) {
    try {
        // Extract hashtags from posts and find the most popular ones
        // This is a simple implementation - in a real app, you might have a separate tags table
        $stmt = $conn->prepare("
            SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(content, '#', -1), ' ', 1) AS tag,
                   COUNT(*) as tag_count
            FROM social_posts
            WHERE content LIKE '%#%'
            AND created_at > DATE_SUB(NOW(), INTERVAL 7 DAY)
            GROUP BY tag
            ORDER BY tag_count DESC
            LIMIT 10
        ");
        $stmt->execute();
        
        $tags = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (!empty($row['tag'])) {
                // Clean up the tag (remove punctuation at the end, etc.)
                $tag = preg_replace('/[^\w]$/', '', $row['tag']);
                if (!empty($tag)) {
                    $tags[] = [
                        'name' => $tag,
                        'count' => $row['tag_count']
                    ];
                }
            }
        }
        
        echo json_encode(['success' => true, 'tags' => $tags]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Error getting trending tags: ' . $e->getMessage()]);
    }
}

/**
 * Delete a post
 */
function deletePost($conn) {
    $post_id = isset($_POST['post_id']) ? (int)$_POST['post_id'] : 0;
    $user_id = $_SESSION['user_id'];
    
    if (!$post_id) {
        echo json_encode(['success' => false, 'error' => 'Post ID is required']);
        return;
    }
    
    try {
        // Verify post exists and belongs to the current user
        $stmt = $conn->prepare("
            SELECT post_id FROM social_posts 
            WHERE post_id = :post_id AND user_id = :user_id
        ");
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->rowCount() === 0) {
            echo json_encode(['success' => false, 'error' => 'Post not found or you are not authorized to delete it']);
            return;
        }
        
        // Begin transaction
        $conn->beginTransaction();
        
        // Delete related comments
        $stmt = $conn->prepare("DELETE FROM comments WHERE post_id = :post_id");
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->execute();
        
        // Delete related kudos
        $stmt = $conn->prepare("DELETE FROM kudos WHERE post_id = :post_id");
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->execute();
        
        // Delete the post
        $stmt = $conn->prepare("DELETE FROM social_posts WHERE post_id = :post_id");
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->execute();
        
        // Commit transaction
        $conn->commit();
        
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        // Rollback transaction on error
        if ($conn->inTransaction()) {
            $conn->rollBack();
        }
        echo json_encode(['success' => false, 'error' => 'Error deleting post: ' . $e->getMessage()]);
    }
}

/**
 * Delete a comment
 */
function deleteComment($conn) {
    $comment_id = isset($_POST['comment_id']) ? (int)$_POST['comment_id'] : 0;
    $user_id = $_SESSION['user_id'];
    
    if (!$comment_id) {
        echo json_encode(['success' => false, 'error' => 'Comment ID is required']);
        return;
    }
    
    try {
        // Verify comment exists and belongs to the current user
        $stmt = $conn->prepare("
            SELECT comment_id FROM comments 
            WHERE comment_id = :comment_id AND user_id = :user_id
        ");
        $stmt->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->rowCount() === 0) {
            echo json_encode(['success' => false, 'error' => 'Comment not found or you are not authorized to delete it']);
            return;
        }
        
        // Delete the comment
        $stmt = $conn->prepare("DELETE FROM comments WHERE comment_id = :comment_id");
        $stmt->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
        $stmt->execute();
        
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Error deleting comment: ' . $e->getMessage()]);
    }
} 
<?php
// Initialize the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Användaren är inte inloggad']);
    exit;
}

// Include database connection
require_once '../config/database.php';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Databasanslutningen misslyckades: ' . $e->getMessage()]);
    exit;
}

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
            echo json_encode(['success' => false, 'error' => 'Ogiltig åtgärd']);
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
        default:
            echo json_encode(['success' => false, 'error' => 'Ogiltig åtgärd']);
            break;
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Ogiltigt HTTP-anrop']);
}

/**
 * Get posts for the social feed
 */
function getPosts($conn) {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;
    $user_id = $_SESSION['user_id'];
    
    try {
        // Get posts with user data, kudos count, and comment count
        $stmt = $conn->prepare("
            SELECT p.*, 
                   u.username, 
                   u.profile_image AS profile_picture,
                   (SELECT COUNT(*) FROM social_kudos WHERE post_id = p.post_id) AS kudos_count,
                   (SELECT COUNT(*) FROM social_comments WHERE post_id = p.post_id) AS comment_count,
                   (SELECT COUNT(*) FROM social_kudos WHERE post_id = p.post_id AND user_id = :user_id) AS user_has_kudos
            FROM social_posts p
            JOIN users u ON p.user_id = u.user_id
            ORDER BY p.created_at DESC
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
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
        echo json_encode(['success' => false, 'error' => 'Fel vid hämtning av inlägg: ' . $e->getMessage()]);
    }
}

/**
 * Get comments for a post
 */
function getComments($conn) {
    $post_id = isset($_GET['post_id']) ? (int)$_GET['post_id'] : 0;
    
    if (!$post_id) {
        echo json_encode(['success' => false, 'error' => 'Inläggs-ID krävs']);
        return;
    }
    
    try {
        // Verify post exists
        $stmt = $conn->prepare("SELECT post_id FROM social_posts WHERE post_id = :post_id");
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->rowCount() === 0) {
            echo json_encode(['success' => false, 'error' => 'Inlägg hittades inte']);
            return;
        }
        
        // Get comments with user data
        $stmt = $conn->prepare("
            SELECT c.*, 
                   u.username, 
                   u.profile_image AS profile_picture
            FROM social_comments c
            JOIN users u ON c.user_id = u.user_id
            WHERE c.post_id = :post_id
            ORDER BY c.created_at ASC
        ");
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode(['success' => true, 'comments' => $comments]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Fel vid hämtning av kommentarer: ' . $e->getMessage()]);
    }
}

/**
 * Create a new post
 */
function createPost($conn) {
    $content = isset($_POST['content']) ? trim($_POST['content']) : '';
    $user_id = $_SESSION['user_id'];
    
    if (empty($content)) {
        echo json_encode(['success' => false, 'error' => 'Innehåll krävs']);
        return;
    }
    
    try {
        // Insert the post
        $stmt = $conn->prepare("
            INSERT INTO social_posts (user_id, content, created_at) 
            VALUES (:user_id, :content, NOW())
        ");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
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
        echo json_encode(['success' => false, 'error' => 'Fel vid skapande av inlägg: ' . $e->getMessage()]);
    }
}

/**
 * Toggle kudos for a post
 */
function toggleKudos($conn) {
    $post_id = isset($_POST['post_id']) ? (int)$_POST['post_id'] : 0;
    $user_id = $_SESSION['user_id'];
    
    if (!$post_id) {
        echo json_encode(['success' => false, 'error' => 'Inläggs-ID krävs']);
        return;
    }
    
    try {
        // Check if post exists
        $stmt = $conn->prepare("SELECT post_id FROM social_posts WHERE post_id = :post_id");
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->rowCount() === 0) {
            echo json_encode(['success' => false, 'error' => 'Inlägg hittades inte']);
            return;
        }
        
        // Check if user has already given kudos
        $stmt = $conn->prepare("
            SELECT kudos_id FROM social_kudos 
            WHERE post_id = :post_id AND user_id = :user_id
        ");
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $hasKudos = $stmt->rowCount() > 0;
        
        if ($hasKudos) {
            // Remove kudos
            $stmt = $conn->prepare("
                DELETE FROM social_kudos 
                WHERE post_id = :post_id AND user_id = :user_id
            ");
            $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            
            $hasKudos = false;
        } else {
            // Add kudos
            $stmt = $conn->prepare("
                INSERT INTO social_kudos (post_id, user_id, created_at) 
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
            FROM social_kudos 
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
        echo json_encode(['success' => false, 'error' => 'Fel vid hantering av kudos: ' . $e->getMessage()]);
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
        echo json_encode(['success' => false, 'error' => 'Inläggs-ID krävs']);
        return;
    }
    
    if (empty($content)) {
        echo json_encode(['success' => false, 'error' => 'Innehåll krävs']);
        return;
    }
    
    try {
        // Verify post exists
        $stmt = $conn->prepare("SELECT post_id FROM social_posts WHERE post_id = :post_id");
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->rowCount() === 0) {
            echo json_encode(['success' => false, 'error' => 'Inlägg hittades inte']);
            return;
        }
        
        // Insert the comment
        $stmt = $conn->prepare("
            INSERT INTO social_comments (post_id, user_id, content, created_at) 
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
            FROM social_comments c
            JOIN users u ON c.user_id = u.user_id
            WHERE c.comment_id = :comment_id
        ");
        $stmt->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $comment = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo json_encode(['success' => true, 'comment' => $comment]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Fel vid skapande av kommentar: ' . $e->getMessage()]);
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
            FROM social_kudos 
            WHERE user_id = :user_id
        ");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $kudosGivenResult = $stmt->fetch(PDO::FETCH_ASSOC);
        $kudosGiven = $kudosGivenResult['kudos_given'];
        
        // Get kudos received count
        $stmt = $conn->prepare("
            SELECT COUNT(*) AS kudos_received 
            FROM social_kudos k
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
        echo json_encode(['success' => false, 'error' => 'Fel vid hämtning av användarstatistik: ' . $e->getMessage()]);
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
        echo json_encode(['success' => false, 'error' => 'Fel vid hämtning av trendande taggar: ' . $e->getMessage()]);
    }
} 
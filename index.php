<?php
session_start();
include ('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Pagination setup
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 10;
$start = ($page - 1) * $limit;

// Query to get threads with pagination
$sql = "SELECT t.*, COUNT(p.thread_id) as comments_count
        FROM threads t
        LEFT JOIN posts p ON t.id = p.thread_id
        GROUP BY t.id
        ORDER BY created_at DESC
        LIMIT $start, $limit";

$result = $conn->query($sql);

// Count total number of threads for pagination
$total_threads_sql = "SELECT COUNT(*) as total FROM threads";
$total_threads_result = $conn->query($total_threads_sql);
$total_threads = $total_threads_result->fetch_assoc()['total'];
$total_pages = ceil($total_threads / $limit);

include 'header.php';
?>

<div class="content">
    <div class="container">
        <h1>Threads</h1>
        <div class="button-container">
            
        </div>
    <ul class="thread-list">
            <?php while ($row = $result->fetch_assoc()): ?>
                        <li class="thread-li" onclick="location.href='view_thread.php?thread_id=<?php echo htmlspecialchars($row['id']); ?>'">
                            <?php echo htmlspecialchars($row['title']); ?>
                        </li>
            <?php endwhile; ?>
        </ul>
        <div class="pagination">
            <?php if ($page > 1): ?>
                                        <a href="?page=<?php echo $page - 1; ?>">Previous</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                        <a <?php if ($i === $page)
                                            echo 'class="active"'; ?> href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
            <?php if ($page < $total_pages): ?>
                                        <a href="?page=<?php echo $page + 1; ?>">Next</a>
            <?php endif; ?>
        </div>
       
    </div>
</div>

<?php include 'footer.php'; ?>

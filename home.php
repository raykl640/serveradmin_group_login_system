<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'db_config.php';


$sql = "SELECT id, username, email, created_at FROM users ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Registered Users</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }
        .navbar {
            background: blue
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .navbar h1 {
            font-size: 24px;
        }
        .navbar .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .navbar .username {
            font-weight: bold;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            background: rgba(255,255,255,0.2);
            border-radius: 5px;
            transition: background 0.3s;
        }
        .navbar a:hover {
            background: rgba(255,255,255,0.3);
        }
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .welcome {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .welcome h2 {
            color: #333;
            margin-bottom: 10px;
        }
        .welcome p {
            color: #666;
        }
        .users-table {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .users-table h3 {
            color: #333;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            font-weight: bold;
        }
        tbody tr {
            border-bottom: 1px solid #eee;
        }
        tbody tr:hover {
            background: #f9f9f9;
        }
        tbody tr:last-child {
            border-bottom: none;
        }
        .no-users {
            text-align: center;
            padding: 40px;
            color: #999;
        }
        .current-user {
            background: #e8f5e9 !important;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>User Management System</h1>
        <div class="user-info">
            <span class="username"> <?php echo htmlspecialchars($_SESSION['username']); ?></span>
            <a href="logout.php">Logout</a>
        </div>
    </div>
    
    <div class="container">
        <div class="welcome">
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>! </h2>
            <p>You are successfully logged in. Below is a list of all registered users.</p>
        </div>
        
        <div class="users-table">
            <h3>Registered Users (<?php echo $result->num_rows; ?>)</h3>
            
            <?php if ($result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Registered On</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = $result->fetch_assoc()): ?>
                            <tr <?php echo ($user['id'] == $_SESSION['user_id']) ? 'class="current-user"' : ''; ?>>
                                <td><?php echo htmlspecialchars($user['id']); ?></td>
                                <td>
                                    <?php echo htmlspecialchars($user['username']); ?>
                                    <?php if ($user['id'] == $_SESSION['user_id']): ?>
                                        <strong>(You)</strong>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo date('M d, Y - H:i', strtotime($user['created_at'])); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-users">
                    <p>No users registered yet.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
<?php $conn->close(); ?>

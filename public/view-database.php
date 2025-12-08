<?php
/**
 * Simple Database Viewer
 * Access at: http://localhost:8000/view-database.php
 * 
 * WARNING: Remove this file in production for security!
 */

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Simple authentication (change this password!)
$password = 'admin123'; // CHANGE THIS IN PRODUCTION!
$authenticated = false;

if (isset($_POST['password']) && $_POST['password'] === $password) {
    $_SESSION['db_viewer_auth'] = true;
    $authenticated = true;
} elseif (isset($_SESSION['db_viewer_auth']) && $_SESSION['db_viewer_auth'] === true) {
    $authenticated = true;
}

if (!$authenticated) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Database Viewer - Login</title>
        <style>
            body { font-family: Arial, sans-serif; max-width: 400px; margin: 100px auto; padding: 20px; }
            input { width: 100%; padding: 10px; margin: 10px 0; }
            button { background: #007bff; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        </style>
    </head>
    <body>
        <h2>Database Viewer Login</h2>
        <form method="POST">
            <input type="password" name="password" placeholder="Enter password" required>
            <button type="submit">Login</button>
        </form>
        <p style="color: red; font-size: 12px;">Default password: admin123 (CHANGE THIS!)</p>
    </body>
    </html>
    <?php
    exit;
}

// Get database connection info
$connection = config('database.default');
$config = config("database.connections.{$connection}");

?>
<!DOCTYPE html>
<html>
<head>
    <title>Database Viewer - Fisheries Management System</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px; }
        .container { max-width: 1400px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #333; margin-bottom: 20px; }
        .info { background: #e7f3ff; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .info p { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #007bff; color: white; }
        tr:hover { background: #f5f5f5; }
        .section { margin: 30px 0; }
        .section h2 { color: #007bff; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid #007bff; }
        .badge { display: inline-block; padding: 3px 8px; border-radius: 3px; font-size: 12px; font-weight: bold; }
        .badge-admin { background: #dc3545; color: white; }
        .badge-manager { background: #28a745; color: white; }
        .count { font-size: 24px; font-weight: bold; color: #007bff; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🗄️ Database Viewer - Fisheries Management System</h1>
        
        <div class="info">
            <p><strong>Database Type:</strong> <?php echo strtoupper($connection); ?></p>
            <?php if ($connection === 'sqlite'): ?>
                <p><strong>Database File:</strong> <?php echo $config['database']; ?></p>
            <?php else: ?>
                <p><strong>Host:</strong> <?php echo $config['host']; ?></p>
                <p><strong>Database:</strong> <?php echo $config['database']; ?></p>
            <?php endif; ?>
            <p><strong>Connection Status:</strong> <span style="color: green;">✓ Connected</span></p>
        </div>

        <!-- Users Section -->
        <div class="section">
            <h2>👥 Users (<?php echo \App\Models\User::count(); ?>)</h2>
            <?php
            $users = \App\Models\User::all();
            if ($users->count() > 0):
            ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>District</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user->id; ?></td>
                        <td><?php echo htmlspecialchars($user->name); ?></td>
                        <td><?php echo htmlspecialchars($user->email); ?></td>
                        <td><span class="badge badge-<?php echo $user->role === 'admin' ? 'admin' : 'manager'; ?>"><?php echo ucfirst($user->role); ?></span></td>
                        <td><?php echo $user->district ? htmlspecialchars($user->district->name) : 'N/A'; ?></td>
                        <td><?php echo $user->created_at->format('Y-m-d H:i'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
                <p>No users found.</p>
            <?php endif; ?>
        </div>

        <!-- Districts Section -->
        <div class="section">
            <h2>🌍 Districts (<?php echo \App\Models\District::count(); ?>)</h2>
            <?php
            $districts = \App\Models\District::withCount(['farms', 'managers'])->get();
            if ($districts->count() > 0):
            ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Farms</th>
                        <th>Managers</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($districts as $district): ?>
                    <tr>
                        <td><?php echo $district->id; ?></td>
                        <td><?php echo htmlspecialchars($district->name); ?></td>
                        <td><span class="count"><?php echo $district->farms_count; ?></span></td>
                        <td><span class="count"><?php echo $district->managers_count; ?></span></td>
                        <td><?php echo $district->created_at->format('Y-m-d H:i'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
                <p>No districts found.</p>
            <?php endif; ?>
        </div>

        <!-- Farms Section -->
        <div class="section">
            <h2>🏭 Farms (<?php echo \App\Models\Farm::count(); ?>)</h2>
            <?php
            $farms = \App\Models\Farm::with(['district', 'manager'])->get();
            if ($farms->count() > 0):
            ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>District</th>
                        <th>Manager</th>
                        <th>Location</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($farms as $farm): ?>
                    <tr>
                        <td><?php echo $farm->id; ?></td>
                        <td><?php echo htmlspecialchars($farm->name); ?></td>
                        <td><?php echo htmlspecialchars($farm->district->name); ?></td>
                        <td><?php echo htmlspecialchars($farm->manager->name); ?></td>
                        <td><?php echo htmlspecialchars($farm->location ?? 'N/A'); ?></td>
                        <td><?php echo $farm->created_at->format('Y-m-d H:i'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
                <p>No farms found.</p>
            <?php endif; ?>
        </div>

        <!-- Entries Section -->
        <div class="section">
            <h2>📊 Daily Entries (<?php echo \App\Models\Entry::count(); ?>)</h2>
            <?php
            $entries = \App\Models\Entry::with('farm')->orderBy('date', 'desc')->limit(50)->get();
            if ($entries->count() > 0):
            ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Farm</th>
                        <th>Date</th>
                        <th>Fish Stock</th>
                        <th>Feed (kg)</th>
                        <th>Mortality</th>
                        <th>Water Temp</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($entries as $entry): ?>
                    <tr>
                        <td><?php echo $entry->id; ?></td>
                        <td><?php echo htmlspecialchars($entry->farm->name); ?></td>
                        <td><?php echo $entry->date->format('Y-m-d'); ?></td>
                        <td><?php echo number_format($entry->fish_stock); ?></td>
                        <td><?php echo number_format($entry->feed_quantity, 2); ?></td>
                        <td><?php echo $entry->mortality; ?></td>
                        <td><?php echo $entry->water_temp ?? 'N/A'; ?></td>
                        <td><?php echo $entry->created_at->format('Y-m-d H:i'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
                <p>No entries found.</p>
            <?php endif; ?>
        </div>

        <div style="margin-top: 40px; padding-top: 20px; border-top: 2px solid #ddd; text-align: center; color: #666;">
            <p>⚠️ <strong>Security Warning:</strong> Remove this file in production!</p>
            <p>Access this page at: <code>http://localhost:8000/view-database.php</code></p>
        </div>
    </div>
</body>
</html>


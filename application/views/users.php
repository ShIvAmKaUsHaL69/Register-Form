<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="container">
    <h2>Users List</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Created At</th>
                <!-- Add more columns based on your user table structure -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user->id; ?></td>
                <td><?php echo $user->username; ?></td>
                <td><?php echo $user->email; ?></td>
                <td><?php echo $user->created_at; ?></td>
                <!-- Add more columns based on your user table structure -->
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
// app/Views/HR/employee/index.php

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee List</title>
</head>
<body>
    <h1>Employee List</h1>
    <a href="<?= base_url('public/hr/employees/create') ?>">Add New Employee</a>
    <table>
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Position</th>
                <th>Salary</th>
                <th>Date Joined</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employees as $employee): ?>
                <tr>
                    <td><?= $employee->name ?></td>
                    <td><?= $employee->email ?></td>
                    <td><?= $employee->phone ?></td>
                    <td><?= $employee->address ?></td>
                    <td><?= $employee->created_at ?></td>
                    <td><?= $employee->updated_at ?></td>
                    <td>
                        <a href="<?= base_url('public/hr/employees/edit/' . $employee->id) ?>">Edit</a> |
                        <a href="<?= base_url('public/hr/employees/delete/' . $employee->id) ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

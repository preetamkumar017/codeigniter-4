// app/Modules/HR/Views/employee/create.php

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Employee</title>
</head>
<body>
    <h1>Add New Employee</h1>
    <form action="<?= base_url('public/hr/employees/store') ?>" method="post">
    <label for="name">Name:</label>
        <input type="text" id="name" name="name" required maxlength="255">
        <br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required maxlength="255">
        <br><br>

        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" maxlength="20">
        <br><br>

        <label for="address">Address:</label>
        <textarea id="address" name="address" rows="4" cols="50"></textarea>
        <br><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>

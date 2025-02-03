// app/Modules/HR/Views/employee/edit.php

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Employee</title>
</head>
<body>
    <h1>Edit Employee</h1>
    
    <form action="<?= base_url('public/hr/employees/update') ?>" method="post">
        
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required maxlength="255" value="<?= $employee->name ?>">
        <input type="hidden" id="id" name="id" required  value="<?= $employee->id ?>">
        <br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required maxlength="255" value="<?= $employee->email ?>">
        <br><br>

        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" maxlength="20" value="<?= $employee->phone ?>">
        <br><br>

        <label for="address">Address:</label>
        <textarea id="address" name="address" rows="4" cols="50"><?= $employee->address ?></textarea>
        <br><br>

        <button type="submit">Submit</button>

    </form>
</body>
</html>

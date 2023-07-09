<?php
$conn = mysqli_connect("localhost","root","","group03");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Add Category
if (isset($_POST['add_category'])) {
    $category_name = $_POST['category_name'];

    // Check if category name is empty
    if (empty($category_name)) {
        ?>
        <script type="text/javascript">
            alert("Please enter a category name.");
        </script>
        <?php
    } else {
        // Check if category name already exists
        $check_sql = "SELECT * FROM categories WHERE name = '$category_name'";
        $check_result = mysqli_query($conn, $check_sql);

        if (mysqli_num_rows($check_result) > 0) {
            ?>
            <script type="text/javascript">
                alert("Category <?php echo $category_name; ?> already exists.");
            </script>
            <?php
        } else {
            $sql = "INSERT INTO categories (name) VALUES ('$category_name')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                ?>
                <script type="text/javascript">
                    alert("Category <?php echo $category_name; ?> saved.");
                </script>
                <?php
            } else {
                ?>
                <script type="text/javascript">
                    alert("Error");
                </script>
                <?php
            }
        }
    }
}


// Edit Category
if (isset($_POST['edit_category'])) {
    $category_id = $_POST['category_id'];
    $new_category_name = $_POST['new_category_name'];

    $sql = "UPDATE categories SET name = '$new_category_name' WHERE id = '$category_id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        ?>
        <script type="text/javascript">
			alert("<?php echo "Categories ".$new_category_name." saved"?>");
		</script>
        <?php
    } else {
        ?>
        <script type="text/javascript">
			alert("<?php "Error"?>");
		</script>
        <?php
    }
}

// Delete Category
if (isset($_POST['delete_category'])) {
    $category_id = $_POST['category_id'];

    $sql = "DELETE FROM categories WHERE id = '$category_id'";
    $result = mysqli_query($conn, $sql);

}


$sql = "SELECT * FROM categories";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $categories = [];
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <title>Manage Category Page</title>
</head>

<body>
    <aside class="side">
    <h1><strong>Admin</strong></h1>
    <ul>
      <li><a href="index.html">Home</a></li>
      <li><a href="Dashboard.html">Admin Landing</a></li>
      <li><a href="manage category page.php">Manage Category</a></li>
      <li><a href="manage product page.html">Manage Product</a></li>
      <li><a href="manage order page.html">Manage Order</a></li>
      <li><a href="manage_user.php">Manage User</a></li>
      <li><a href="Change password.php">Change Password</a></li>
      <li><a href="manage_staff.php">Manage Staff</a></li>
    </ul>
  </aside>

  <main>
        <h2>Manage Category</h2>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category) : ?>
                    <tr>
                        <td><?php echo $category['name']; ?></td>
                        <td>
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <input type="hidden" name="category_id" value="<?php echo $category['id']; ?>">
                                <input type="text" name="new_category_name" placeholder="New category name">
                                <button class="btn-edit" name="edit_category">Edit</button>
                                <button onclick="return confirmation()" class="btn-delete" name="delete_category">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="add-category">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="text" name="category_name" placeholder="Enter category name">
                <button class="btn-add" name="add_category">Add Category</button>
            </form>
        </div>
    </main>
    <script type="text/javascript">
        function confirmation()
        {
	        answer = confirm("Do you want to delete this category?");
	        return answer;
        }

</script>
</body>

</html>

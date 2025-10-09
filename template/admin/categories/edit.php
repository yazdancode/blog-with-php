<?php
require_once(realpath(dirname(__FILE__) . "/../layouts/head-tag.php"));
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>ویرایش دسته‌بندی</title>
    <link rel="stylesheet" href="/project/assets/css/style.css"> <!-- اگر فایل استایل داری -->
</head>
<body>
    <section class="pt-3 pb-1 mb-2 border-bottom">
        <h1 class="h5">Edit Category</h1>
    </section>

    <section class="row my-3">
        <section class="col-12">
            <form method="post" action="/project/category/update/<?php echo htmlspecialchars($category['id']); ?>">
                <div class="form-group">
                    <label for="name">Title</label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="<?php echo htmlspecialchars($category['name']); ?>"
                        placeholder="Enter category name..." required>
                </div>
                <button type="submit" class="btn btn-primary btn-sm mt-2">Update</button>
                <a href="/project/category" class="btn btn-secondary btn-sm mt-2">Back</a>
            </form>
        </section>
    </section>
</body>
</html>

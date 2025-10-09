<?php
require_once(dirname(__DIR__) . "/layouts/head-tag.php");
?>

<div class="d-flex justify-content-between flex-md-nowrap align-items-center pt-2 mb-3 border-bottom">
    <h1 class="h5"><i class="fas fa-newspaper"></i> Categories</h1>
    <div>
        <a role="button" href="#" class="btn btn-sm btn-success">Create</a>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-sm">
        <caption>List of categories</caption>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Setting</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?php echo $category["id"]; ?></td>
                    <td><?php echo $category["name"]; ?></td>
                    <td>
                        <a role="button" href="http:://localhost/project/category/edit/<?php echo $category['id'];?>" class="btn btn-sm btn-info">ویرایش</a>
                        <a role="button" href="http:://localhost/project/category/delete/<?php echo $category['id'];?>" class="btn btn-sm btn-danger">حذف</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">هیچ دسته‌بندی‌ای یافت نشد.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?php
require_once(dirname(__FILE__, 2) . "/layouts/footer.php");
?>

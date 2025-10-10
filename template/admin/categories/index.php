<a href="/project/category/create" class="btn btn-sm btn-success">create</a>
<?php if (!empty($categories)): ?>
    <?php foreach ($categories as $category): ?>
        <tr>
            <td><?php echo $category["id"]; ?></td>
            <td><?php echo $category["name"]; ?></td>
            <td>
                <a href="/project/category/edit/<?php echo $category["id"]; ?>" class="btn btn-sm btn-info">ویرایش</a>
                <a href="/project/category/delete/<?php echo $category["id"]; ?>" class="btn btn-sm btn-danger">حذف</a>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="3">هیچ دسته‌بندی‌ای یافت نشد.</td>
    </tr>
<?php endif; ?>

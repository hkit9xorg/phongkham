<div class="breadcrumbs text-sm mb-4">
    <ul>
        <li><a href="/index.php">Trang chủ</a></li>
        <li><a href="/index.php#articles">Bài viết</a></li>
        <?php if ($article): ?>
            <li><?= htmlspecialchars($article['title']) ?></li>
        <?php else: ?>
            <li>Không tìm thấy</li>
        <?php endif; ?>
    </ul>
</div>

<?php if (!$article): ?>
    <div class="alert alert-warning shadow-lg">
        <div>
            <i class="ri-alert-line"></i>
            <span>Xin lỗi, chúng tôi không tìm thấy bài viết bạn đang tìm.</span>
        </div>
        <a class="btn btn-sm" href="/index.php#articles">Quay lại trang chủ</a>
    </div>
<?php else: ?>
    <article class="bg-base-100 rounded-2xl shadow-lg overflow-hidden">
        <?php if (!empty($article['thumbnail'])): ?>
            <img src="<?= htmlspecialchars($article['thumbnail']) ?>" alt="<?= htmlspecialchars($article['title']) ?>" class="w-full h-72 object-cover">
        <?php endif; ?>

        <div class="p-6 space-y-4">
            <div class="flex items-center gap-3 text-sm text-base-content/70">
                <span class="badge badge-outline"><?= htmlspecialchars($article['category'] ?? 'Tin tức') ?></span>
                <?php if (!empty($article['author_name'])): ?>
                    <span class="flex items-center gap-1"><i class="ri-user-line"></i> <?= htmlspecialchars($article['author_name']) ?></span>
                <?php endif; ?>
                <?php if (!empty($article['created_at'])): ?>
                    <span class="flex items-center gap-1"><i class="ri-calendar-line"></i> <?= date('d/m/Y', strtotime($article['created_at'])) ?></span>
                <?php endif; ?>
            </div>

            <h1 class="text-3xl font-bold leading-tight"><?= htmlspecialchars($article['title']) ?></h1>

            <div class="prose max-w-none">
                <?= nl2br(htmlspecialchars($article['content'])) ?>
            </div>

            <div class="pt-4 border-t">
                <a class="btn btn-ghost" href="/index.php#articles"><i class="ri-arrow-left-line"></i> Quay lại tin tức</a>
            </div>
        </div>
    </article>
<?php endif; ?>

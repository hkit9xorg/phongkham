<section class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-base-content/60 mb-1">Thao tác nhanh</p>
            <h1 class="text-3xl font-bold">Viết bài mới</h1>
        </div>
        <a class="btn btn-ghost" href="/index.php?page=dashboard"><i class="ri-arrow-go-back-line mr-2"></i>Về dashboard</a>
    </div>

    <div class="bg-base-100 rounded-box shadow p-6 space-y-4">
        <p class="text-base-content/70">Chia sẻ kiến thức và cập nhật ưu đãi tới khách hàng.</p>
        <form id="article-form" method="post" class="grid md:grid-cols-2 gap-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::token()) ?>">
            <div class="form-control md:col-span-2">
                <label class="label"><span class="label-text">Tiêu đề</span></label>
                <input name="title" class="input input-bordered" placeholder="Nhập tiêu đề ngắn gọn" required>
            </div>
            <div class="form-control">
                <label class="label"><span class="label-text">Chuyên mục</span></label>
                <input name="category" class="input input-bordered" value="tuvan" placeholder="news, tuvan, promotion...">
            </div>
            <div class="form-control">
                <label class="label"><span class="label-text">Trạng thái</span></label>
                <select name="status" class="select select-bordered">
                    <option value="published">Đăng ngay</option>
                    <option value="draft">Lưu nháp</option>
                </select>
            </div>
            <div class="form-control md:col-span-2">
                <label class="label"><span class="label-text">Nội dung</span></label>
                <textarea name="content" rows="6" class="textarea textarea-bordered" placeholder="Soạn nội dung bài viết" required></textarea>
            </div>
            <div class="md:col-span-2 flex gap-3">
                <button class="btn btn-primary" type="submit"><i class="ri-save-line mr-2"></i>Lưu bài viết</button>
                <a class="btn btn-outline" href="/index.php?page=admin&module=articles"><i class="ri-list-check mr-2"></i>Danh sách bài viết</a>
            </div>
        </form>
    </div>
</section>

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
        <form id="article-form" method="post" enctype="multipart/form-data" class="grid md:grid-cols-2 gap-4">
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
                <label class="label flex items-center justify-between">
                    <span class="label-text">Nội dung</span>
                    <span class="text-xs text-base-content/60">Hỗ trợ định dạng cơ bản, ảnh đính kèm riêng</span>
                </label>
                <div class="space-y-2" data-wysiwyg>
                    <div class="wysiwyg-toolbar">
                        <button type="button" class="btn btn-xs" data-command="bold"><i class="ri-bold"></i></button>
                        <button type="button" class="btn btn-xs" data-command="italic"><i class="ri-italic"></i></button>
                        <button type="button" class="btn btn-xs" data-command="underline"><i class="ri-underline"></i></button>
                        <button type="button" class="btn btn-xs" data-command="insertUnorderedList"><i class="ri-list-unordered"></i></button>
                        <button type="button" class="btn btn-xs" data-command="insertOrderedList"><i class="ri-list-ordered"></i></button>
                        <button type="button" class="btn btn-xs" data-command="createLink"><i class="ri-link"></i></button>
                    </div>
                    <div class="wysiwyg-editor" data-editor contenteditable="true" aria-label="Trình soạn thảo bài viết"></div>
                    <textarea name="content" rows="6" class="textarea textarea-bordered hidden" placeholder="Soạn nội dung bài viết" required></textarea>
                </div>
            </div>
            <div class="form-control md:col-span-2">
                <label class="label"><span class="label-text">Ảnh thumbnail</span></label>
                <input type="file" name="thumbnail" accept="image/*" class="file-input file-input-bordered">
                <p class="text-xs text-base-content/60">Hỗ trợ PNG, JPG, GIF, WebP (tối đa 2MB)</p>
                <img data-preview-thumb class="mt-2 rounded-lg hidden h-32 w-full object-cover" alt="Xem trước ảnh" />
            </div>
            <div class="md:col-span-2 flex gap-3">
                <button class="btn btn-primary" type="submit"><i class="ri-save-line mr-2"></i>Lưu bài viết</button>
                <a class="btn btn-outline" href="/index.php?page=admin&module=articles"><i class="ri-list-check mr-2"></i>Danh sách bài viết</a>
            </div>
        </form>
    </div>
</section>

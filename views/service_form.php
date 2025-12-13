<section class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-base-content/60 mb-1">Thao tác nhanh</p>
            <h1 class="text-3xl font-bold">Thêm dịch vụ mới</h1>
        </div>
        <a class="btn btn-ghost" href="/index.php?page=dashboard"><i class="ri-arrow-go-back-line mr-2"></i>Về dashboard</a>
    </div>

    <div class="bg-base-100 rounded-box shadow p-6 space-y-4">
        <p class="text-base-content/70">Nhập thông tin dịch vụ để xuất hiện trong danh sách đặt lịch và tư vấn.</p>
        <form id="service-form" method="post" class="grid md:grid-cols-2 gap-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::token()) ?>">
            <div class="form-control md:col-span-2">
                <label class="label"><span class="label-text">Tên dịch vụ</span></label>
                <input name="name" class="input input-bordered" placeholder="Ví dụ: Niềng răng mắc cài" required>
            </div>
            <div class="form-control">
                <label class="label"><span class="label-text">Giá tham khảo</span></label>
                <input name="price" type="number" step="1000" class="input input-bordered" placeholder="Nhập giá hoặc để trống">
            </div>
            <div class="form-control">
                <label class="label"><span class="label-text">Trạng thái hiển thị</span></label>
                <select name="is_active" class="select select-bordered">
                    <option value="1">Hiển thị</option>
                    <option value="0">Ẩn</option>
                </select>
            </div>
            <div class="form-control md:col-span-2">
                <label class="label"><span class="label-text">Mô tả ngắn</span></label>
                <textarea name="description" rows="4" class="textarea textarea-bordered" placeholder="Thông tin nổi bật giúp khách hàng hiểu rõ dịch vụ"></textarea>
            </div>
            <div class="md:col-span-2 flex gap-3">
                <button class="btn btn-primary" type="submit"><i class="ri-add-line mr-2"></i>Lưu dịch vụ</button>
                <a class="btn btn-outline" href="/index.php?page=admin&module=services"><i class="ri-list-check mr-2"></i>Danh sách dịch vụ</a>
            </div>
        </form>
    </div>
</section>

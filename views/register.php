<div class="max-w-xl mx-auto mt-10">
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title"><i class="ri-user-add-line mr-2"></i>Đăng ký khách hàng</h2>
            <p class="text-sm text-gray-500">Tài khoản đăng ký mới sẽ dùng số điện thoại làm tên đăng nhập và được gán vai trò khách hàng.</p>
            <?php if ($errors): ?>
                <div class="alert alert-error">
                    <ul class="list-disc ml-4">
                        <?php foreach ($errors as $err): ?>
                            <li><?= htmlspecialchars($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            <form method="POST" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::token()) ?>">
                <div class="form-control">
                    <label class="label"><span class="label-text">Họ tên *</span></label>
                    <input type="text" name="full_name" class="input input-bordered" required>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Số điện thoại *</span></label>
                    <input type="tel" name="phone" class="input input-bordered" required placeholder="09xx">
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Mật khẩu *</span></label>
                    <input type="password" name="password" class="input input-bordered" required placeholder="••••••">
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Nhập lại mật khẩu *</span></label>
                    <input type="password" name="password_confirm" class="input input-bordered" required placeholder="••••••">
                </div>
                <button class="btn btn-primary w-full" type="submit"><i class="ri-user-add-line mr-2"></i>Tạo tài khoản</button>
            </form>
            <div class="text-center text-sm">Đã có tài khoản? <a class="link" href="/index.php?page=login">Đăng nhập</a></div>
        </div>
    </div>
</div>

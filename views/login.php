<div class="max-w-xl mx-auto mt-10">
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title"><i class="ri-shield-keyhole-line mr-2"></i>Đăng nhập</h2>
            <p class="text-sm text-gray-500">Tài khoản mẫu: admin@example.com, doctor@example.com, user@example.com. Mật khẩu mặc định: 123456.</p>
            <?php if ($errors): ?>
                <div class="alert alert-error">
                    <ul class="list-disc ml-4">
                        <?php foreach ($errors as $err): ?>
                            <li><?= htmlspecialchars($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <form method="POST" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::token()) ?>">
                <div class="form-control">
                    <label class="label"><span class="label-text">Email</span></label>
                    <input type="email" name="email" class="input input-bordered" required placeholder="admin@example.com">
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Mật khẩu</span></label>
                    <input type="password" name="password" class="input input-bordered" required placeholder="123456">
                </div>
                <button class="btn btn-primary w-full" type="submit"><i class="ri-login-circle-line mr-2"></i>Đăng nhập</button>
            </form>
            <div class="text-center text-sm">Chưa có tài khoản? <a class="link" href="/index.php?page=register">Đăng ký khách hàng</a></div>
        </div>
    </div>
</div>

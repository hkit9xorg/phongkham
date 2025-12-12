<div class="max-w-lg mx-auto mt-10">
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title"><i class="ri-shield-keyhole-line mr-2"></i>Đăng nhập quản trị</h2>
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
        </div>
    </div>
</div>

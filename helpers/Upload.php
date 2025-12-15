<?php

class Upload
{
    public static function image(array $file, string $subDirectory = ''): array
    {
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            return ['status' => 'none'];
        }

        if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
            return ['status' => 'error', 'message' => 'Tải ảnh thất bại. Vui lòng thử lại.'];
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $fileType = mime_content_type($file['tmp_name']);
        if (!in_array($fileType, $allowedTypes, true)) {
            return ['status' => 'error', 'message' => 'Định dạng ảnh không hợp lệ.'];
        }

        $maxSize = 2 * 1024 * 1024; // 2MB
        if (($file['size'] ?? 0) > $maxSize) {
            return ['status' => 'error', 'message' => 'Ảnh vượt quá dung lượng 2MB.'];
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION) ?: 'jpg';
        $safeExtension = preg_replace('/[^a-zA-Z0-9]/', '', $extension);
        $fileName = uniqid('article_', true) . '.' . strtolower($safeExtension);

        $targetDir = rtrim(__DIR__ . '/../uploads', '/');
        if ($subDirectory !== '') {
            $targetDir .= '/' . trim($subDirectory, '/');
        }

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $targetPath = $targetDir . '/' . $fileName;
        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            return ['status' => 'error', 'message' => 'Không thể lưu tệp ảnh.'];
        }

        $publicPath = '/uploads' . ($subDirectory ? '/' . trim($subDirectory, '/') : '') . '/' . $fileName;

        return ['status' => 'success', 'path' => $publicPath];
    }
}

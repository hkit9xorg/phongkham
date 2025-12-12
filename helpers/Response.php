<?php

class Response
{
    public static function json(string $status, string $message, $data = null): void
    {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ]);
        exit;
    }
}

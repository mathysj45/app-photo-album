<?php

namespace App\Core;

class Logger {
    private static ?string $logFile = null;

    private static function init(): void {
        if (self::$logFile === null) {
            self::$logFile = __DIR__ . '/../../storage/logs/app.log';
            $dir = dirname(self::$logFile);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
        }
    }

    public static function log(string $message, string $level = 'INFO'): void {
        self::init();
        $userId = $_SESSION['user_id'] ?? 'ANONYMOUS';
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
        $timestamp = date('Y-m-d H:i:s');
        $entry = sprintf("[%s] [%s] [User: %s] [IP: %s] %s\n", $timestamp, strtoupper($level), $userId, $ip, $message);
        file_put_contents(self::$logFile, $entry, FILE_APPEND);
    }
}
<?php

namespace App\Interfaces;

interface AiServiceInterface
{
    public function validateMessages(array $messages): array;
    public function simpleChat(array $messages): array;
    public static function parseResponse($answer): array;
    public static function handleError(\Throwable $exception): array;
}

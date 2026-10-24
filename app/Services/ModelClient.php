<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ModelClient
{
    public function generate(string $prompt): string
    {
        $c = config('services.gemma');
        $url = rtrim($c['url'], '/') . '/' . $c['model'] . ':generateContent';

        $res = Http::timeout(60)
    ->retry(3, 2000, function ($e) {
        return $e instanceof \Illuminate\Http\Client\ConnectionException
            || ($e instanceof \Illuminate\Http\Client\RequestException
                && in_array($e->response->status(), [429, 500, 503]));
    }, throw: false)
    ->withHeaders(['x-goog-api-key' => $c['key']])
    ->post($url, [
        'contents' => [['parts' => [['text' => $prompt]]]],
    ]);

if ($res->failed()) {
    \Log::error('Gemma call failed', [
        'status' => $res->status(),
        'body' => $res->body(),
    ]);
    throw new \RuntimeException('The AI is busy. Please try again.');
}

        $parts = $res->json('candidates.0.content.parts') ?? [];

        return trim(collect($parts)
            ->reject(fn ($p) => $p['thought'] ?? false)
            ->pluck('text')
            ->implode(''));
    }
}
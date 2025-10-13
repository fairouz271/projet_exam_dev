<?php

namespace App\Service;

class CommentFilter
{
    private array $forbiddenWords;

    public function __construct(array $forbiddenWords)
    {
        $this->forbiddenWords = $forbiddenWords;
    }

    public function containsForbiddenWords(string $text): bool
    {
        foreach ($this->forbiddenWords as $word) {
            if (preg_match('/\b' . preg_quote($word, '/') . '\b/i', $text)) {
                return true;
            }
        }
        return false;
    }

    public function cleanComment(string $text): string
    {
        foreach ($this->forbiddenWords as $word) {
            $text = preg_replace(
                '/\b' . preg_quote($word, '/') . '\b/i',
                str_repeat('*', mb_strlen($word)),
                $text
            );
        }
        return $text;
    }
}

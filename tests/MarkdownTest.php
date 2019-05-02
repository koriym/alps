<?php

declare(strict_types=1);

namespace Koriym\Alps;

use PHPUnit\Framework\TestCase;

class MarkdownTest extends TestCase
{
    public function testMarkdown() : void
    {
        $md = new Markdown(new Alps(__DIR__ . '/profile.json'));
        $this->assertContains('[id](https://schema.org/identifier)', (string) $md);
    }
}

<?php

declare(strict_types=1);

namespace Koriym\Alps;

use const PHP_EOL;
use function implode;
use function sprintf;

final class Markdown
{
    /**
     * @var AbstractAlps
     */
    private $alps;

    public function __construct(AbstractAlps $alps)
    {
        $this->alps = $alps;
    }

    public function __toString()
    {
        $semantics = $this->semantics($this->alps->semantics);
        $rels = $this->semantics($this->alps->rels);

        return <<<EOT
# Descriptor

## Semantic

{$semantics}

## Relation

{$rels}
EOT;
    }

    private function semantics(array $semantics) : string
    {
        $lines = [];
        ksort($semantics);
        foreach ($semantics as $id => $semantic) {
            if ($semantic->def) {
                $lines[] .= sprintf("### %s\n\n[%s](%s)\n", $id, $id, $semantic->def) . PHP_EOL;

                continue;
            }
            $name = $this->getName($semantic);
            $lines[] = sprintf("### %s\n\n%s\n", $id, $name) . PHP_EOL;
        }

        return implode($lines);
    }

    private function getName(\stdClass $semantic) : string
    {
        $desc = [];
        if ($semantic->name) {
            $desc[] = $semantic->name;
        }
        if (isset($semantic->doc->value)) {
            $desc[] = $semantic->doc->value;
        }

        return implode(', ', $desc);
    }
}

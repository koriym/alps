<?php

declare(strict_types=1);

namespace Koriym\Alps;

use Koriym\Alps\Exception\DuplicatedIdException;
use Koriym\Alps\Exception\NoTypeException;
use function file_exists;
use function file_get_contents;
use function json_decode;
use function property_exists;
use function serialize;

final class Alps extends AbstractAlps
{
    /**
     * {@inheritdoc}
     */
    public $semantics;

    /**
     * {@inheritdoc}
     */
    public $rels;

    /**
     * @var array
     */
    private $descriptors;

    public function __construct(string $alpsFile)
    {
        if (! file_exists($alpsFile)) {
            throw new \RuntimeException($alpsFile);
        }
        $json = json_decode((string) file_get_contents($alpsFile));
        $props = $json->alps->descriptor;
        $this->initDescriptor($props);
    }

    private function initDescriptor(array $props) : void
    {
        foreach ($props as $prop) {
            if (! $prop instanceof \stdClass) {
                throw new \RuntimeException;
            }
            /* @var \stdClass $prop */
            if (property_exists($prop, 'href')) {
                continue;
            }
            if (! property_exists($prop, 'type')) {
                throw new NoTypeException(serialize($prop));
            }
            if ($prop->type === 'semantic') {
                $this->semantic($prop);

                continue;
            }
            if ($prop->type === 'safe' || $prop->type === 'unsafe' || $prop->type === 'idempotent') {
                $this->rel($prop);

                continue;
            }

            throw new NoTypeException(serialize($prop));
        }
    }

    private function rel(\stdClass $prop) : void
    {
        $rel = new Rel($prop);
        if (isset($this->rels[$rel->id])) {
            throw new DuplicatedIdException($rel->id);
        }
        $this->descriptors[$rel->id] = $this->rels[$rel->id] = $rel;
        if (property_exists($prop, 'descriptor')) {
            $this->initDescriptor($prop->descriptor);
        }
    }

    private function semantic(\stdClass $prop) : void
    {
        $semantic = new Semantic($prop);
        if (isset($this->semantics[$semantic->id])) {
            throw new DuplicatedIdException($semantic->id);
        }
        $this->descriptors[$semantic->id] = $this->semantics[$semantic->id] = $semantic;
        if (property_exists($prop, 'descriptor')) {
            $this->initDescriptor($prop->descriptor);
        }
    }
}

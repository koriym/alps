<?php

declare(strict_types=1);

namespace Koriym\Alps;

use function json_encode;
use Koriym\Alps\Exception\NoIdException;
use Koriym\Alps\Exception\NoSemanticException;
use function property_exists;

final class Semantic
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $type;

    /**
     * @var array
     */
    public $doc;

    /**
     * @var string
     */
    public $def;

    public function __construct(\stdClass $prop)
    {
        if (! property_exists($prop, 'id')) {
            throw new NoIdException((string) json_encode($prop));
        }
        $this->id = $prop->id;
        if (! property_exists($prop, 'type')) {
            throw new NoSemanticException((string) json_encode($prop));
        }
        $this->type = $prop->type;
        $this->doc = $prop->doc ?? ['value' => ''];
        $this->name = $prop->name ?? '';
        $this->def = $prop->def ?? '';
    }
}

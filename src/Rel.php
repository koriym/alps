<?php

declare(strict_types=1);

namespace Koriym\Alps;

use Koriym\Alps\Exception\NoIdException;
use Koriym\Alps\Exception\NoSemanticException;
use function json_encode;
use function property_exists;

final class Rel extends \stdClass
{
    public $id;

    public $rt;

    public $type;

    public $name;

    public $doc;

    public function __construct(\stdClass $prop)
    {
        if (! property_exists($prop, 'id')) {
            throw new NoIdException((string) json_encode($prop));
        }
        $this->id = $prop->id;
        if (! property_exists($prop, 'type')) {
            throw new NoSemanticException((string) json_encode($prop));
        }
        if (property_exists($prop, 'name')) {
            $this->name = $prop->name;
        }
        if (property_exists($prop, 'rt')) {
            $this->rt = $prop->rt;
        }
        $this->type = $prop->type;
        if (property_exists($prop, 'doc')) {
            $this->doc = $prop->doc;
        }
    }
}

<?php

declare(strict_types=1);

namespace Koriym\Alps;

use Koriym\Alps\Exception\NoIdException;
use Koriym\Alps\Exception\NoSemanticException;
use function json_encode;
use function property_exists;

final class Rel extends \stdClass
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $rt;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $name;

    /**
     * @var array
     */
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
        $this->type = $prop->type;
        $this->rt = $prop->rt ?? '';
        $this->doc = $prop->doc ?? ['value' => ''];
        $this->name = $prop->name ?? '';
        $this->def = $prop->def ?? '';
    }
}

<?php

namespace PHPSA\Node\Scalar;

/**
 * Null node extension
 */
class Nil extends \PhpParser\Node\Scalar
{
    /** @var null */
    public $value;

    /**
     * @param null $value
     * @param array $attributes Additional attributes
     */
    public function __construct($value = null, array $attributes = array())
    {
        parent::__construct($attributes);
        $this->value = $value;
    }

    //@codeCoverageIgnoreStart
    /**
     * @return array
     */
    public function getSubNodeNames(): array
    {
        return ['value'];
    }
    //@codeCoverageIgnoreEnd

    /**
     * Gets the type of the node.
     *
     * @return string Type of the node
     */
    public function getType(): string
    {
        return 'Scalar_Nil';
    }
}

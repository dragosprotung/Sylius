<?php

namespace spec\Sylius\Bundle\SettingsBundle\Schema;

use PHPSpec2\ObjectBehavior;

/**
 * Schema registry spec.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class SchemaRegistry extends ObjectBehavior
{
    function it_should_be_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\SettingsBundle\Schema\SchemaRegistry');
    }

    function it_should_be_a_Sylius_settings_schema_registry()
    {
        $this->shouldImplement('Sylius\Bundle\SettingsBundle\Schema\SchemaRegistryInterface');
    }

    function it_should_initialize_schemas_array_by_default()
    {
        $this->getSchemas()->shouldReturn(array());
    }

    /**
     * @param Sylius\Bundle\SettingsBundle\Schema\SchemaInterface $schema
     */
    function it_should_register_schema_properly($schema)
    {
        $this->hasSchema('general')->shouldReturn(false);
        $this->registerSchema('general', $schema);
        $this->hasSchema('general')->shouldReturn(true);
    }

    /**
     * @param Sylius\Bundle\SettingsBundle\Schema\SchemaInterface $schema
     */
    function it_should_unregister_schema_properly($schema)
    {
        $this->registerSchema('general', $schema);
        $this->hasSchema('general')->shouldReturn(true);

        $this->unregisterSchema('general');
        $this->hasSchema('general')->shouldReturn(false);
    }

    /**
     * @param Sylius\Bundle\SettingsBundle\Schema\SchemaInterface $schema
     */
    function it_should_retrieve_registered_schema_by_namespace($schema)
    {
        $this->registerSchema('general', $schema);
        $this->getSchema('general')->shouldReturn($schema);
    }

    function it_should_complain_if_trying_to_retrieve_non_existing_schema()
    {
        $this
            ->shouldThrow('InvalidArgumentException')
            ->duringGetSchema('security-settings')
        ;
    }
}

<?php

namespace spec\Bounoable\Quest;

use Exception;
use PhpSpec\ObjectBehavior;
use Bounoable\Quest\MissionType;
use Bounoable\Quest\MissionTypeManager;

class MissionTypeManagerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(MissionTypeManager::class);
    }

    function it_registers_mission_types(MissionType $type)
    {
        $this->shouldThrow(Exception::class)->duringResolve('type-name');
        $this->shouldThrow(Exception::class)->duringResolve('type-name-closure');
        $this->register('type-name', $type);
        $this->register('type-name-closure', function () use ($type) {
            return $type->getWrappedObject();
        });
        $this->resolve('type-name')->shouldReturn($type);
        $this->resolve('type-name-closure')->shouldReturn($type);
    }
}

<?php

namespace spec\Bounoable\Quest;

use Exception;
use PhpSpec\ObjectBehavior;
use Bounoable\Quest\RewardType;
use Bounoable\Quest\RewardTypeManager;

class RewardTypeManagerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(RewardTypeManager::class);
    }

    function it_registers_reward_types(RewardType $type)
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

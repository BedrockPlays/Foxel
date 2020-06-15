<?php

declare(strict_types=1);

namespace pocketmine\entity\projectile;

class FishingHook extends Projectile {
    public const NETWORK_ID = self::FISHING_HOOK;

    /** @var float $gravity */
    protected $gravity = 0.07;

    /** @var float $width */
    public $width = 0.2;
    /** @var float $height */
    public $height = 0.2;

    public function onUpdate(int $currentTick): bool {
        $hasUpdate = parent::onUpdate($currentTick);

        if($this->isUnderwater()) {
            $this->setMotion($this->getMotion()->subtract(0, $this->gravity * -0.04));
            $hasUpdate = true;
        }

        return $hasUpdate;
    }

    /**
     * @return float
     */
    public function getBaseDamage(): float {
        return 0;
    }
}
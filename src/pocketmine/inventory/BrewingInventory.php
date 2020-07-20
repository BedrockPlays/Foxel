<?php

declare(strict_types=1);

namespace pocketmine\inventory;

use pocketmine\network\mcpe\protocol\types\WindowTypes;
use pocketmine\tile\BrewingStand;

/**
 * Class BrewingInventory
 * @package pocketmine\inventory
 */
class BrewingInventory extends ContainerInventory {

    /** @var BrewingStand $holder */
    protected $holder;

    public function __construct(BrewingStand $holder) {
        parent::__construct($holder);
    }

    /**
     * @return string
     */
    public function getName(): string {
        return "BrewingStand";
    }

    /**
     * @return int
     */
    public function getDefaultSize(): int {
        return 5;
    }

    /**
     * @return int
     */
    public function getNetworkType(): int {
        return WindowTypes::BREWING_STAND;
    }
}
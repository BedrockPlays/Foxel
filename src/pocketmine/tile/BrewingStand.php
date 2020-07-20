<?php

declare(strict_types=1);

namespace pocketmine\tile;

use pocketmine\inventory\BrewingInventory;
use pocketmine\inventory\Inventory;
use pocketmine\inventory\InventoryEventProcessor;
use pocketmine\inventory\InventoryHolder;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\nbt\tag\CompoundTag;

/**
 * Class BrewingStand
 * @package pocketmine\tile
 */
class BrewingStand extends Spawnable implements InventoryHolder, Container, Nameable {
    use NameableTrait {
        addAdditionalSpawnData as addNameSpawnData;
    }
    use ContainerTrait;

    public const MAX_BREW_TIME = 400;

    /** @var BrewingInventory $inventory */
    protected $inventory;

    /** @var int $brewTime */
    private $brewTime = self::MAX_BREW_TIME;

    public function __construct(Level $level, CompoundTag $nbt) {
        parent::__construct($level, $nbt);
    }

    protected function readSaveData(CompoundTag $nbt): void {
        $this->inventory = new BrewingInventory($this);

        $this->inventory->setEventProcessor(new class($this) implements InventoryEventProcessor {
            /** @var BrewingStand */
            private $brewing;

            public function __construct(BrewingStand $brewing){
                $this->brewing = $brewing;
            }

            public function onSlotChange(Inventory $inventory, int $slot, Item $oldItem, Item $newItem) : ?Item{
                $this->brewing->scheduleUpdate();
                return $newItem;
            }
        });
        // TODO
    }

    protected function writeSaveData(CompoundTag $nbt): void {
        // TODO
    }

    public function close(): void {
        if(!$this->closed){
            $this->inventory->removeAllViewers(true);
            $this->inventory = null;

            parent::close();
        }
    }

    public function getInventory() {
        return $this->inventory;
    }

    public function getRealInventory() {
        return $this->getInventory();
    }

    public function getDefaultName(): string {
        return "BrewingStand";
    }

    public function onUpdate(): bool {
        if($this->closed) {
            return false;
        }

        $this->timings->startTiming();

        $packets = [];
        $output = $this->server->getCraftingManager()->getBrewingOutput();

        $this->brewTime--;
        return true;
    }
}
<?php

namespace pocketmine\inventory;

use pocketmine\inventory\InventoryEventProcessor;
use pocketmine\inventory\Inventory;
use pocketmine\item\Item;
use pocketmine\tile\BrewingStand;

class BrewingInventoryEventProcessor implements InventoryEventProcessor {

	/** @var BrewingStand */
	private $brewing;

	public function __construct(BrewingStand $brewing) {
		$this->brewing = $brewing;
	}

	public function onSlotChange(Inventory $inventory, int $slot, Item $oldItem, Item $newItem) {
		$this->brewing->scheduleUpdate();
		return $newItem;
	}

}

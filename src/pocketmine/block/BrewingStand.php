<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\TieredTool;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\tile\Tile;
use pocketmine\tile\BrewingStand as TileBrewingStand;

class BrewingStand extends Transparent{

	protected $id = self::BREWING_STAND_BLOCK;

	protected $itemId = Item::BREWING_STAND;

	public function __construct(int $meta = 0){
		$this->meta = $meta;
	}

	public function getName() : string{
		return "Brewing Stand";
	}

	public function getHardness() : float{
		return 0.5;
	}

	public function getToolType() : int{
		return BlockToolType::TYPE_PICKAXE;
	}

	public function getToolHarvestLevel() : int{
		return TieredTool::TIER_WOODEN;
	}

	public function getVariantBitmask() : int{
		return 0;
	}

	public function place(Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, Player $player = null): bool {
        $faces = [
            0 => 4,
            1 => 2,
            2 => 5,
            3 => 3
        ];

        $this->getLevel()->setBlock($blockReplace, $this, true, true);
        $this->meta = $faces[$player instanceof Player ? $player->getDirection() : 0];

        Tile::createTile(Tile::BREWING_STAND, $blockClicked->getLevel(), TileBrewingStand::createNBT($this, $face, $item, $player));
        return true;
    }

    public function onActivate(Item $item, Player $player = null): bool {
        if($player instanceof Player){
            $brewing = $this->getLevel()->getTile($this);
            if(!($brewing instanceof TileBrewingStand)){
                $brewing = Tile::createTile(Tile::BREWING_STAND, $this->getLevel(), TileBrewingStand::createNBT($this));
                if(!($brewing instanceof TileBrewingStand)){
                    return true;
                }
            }

            if(!$brewing->canOpenWith($item->getCustomName())){
                return true;
            }

            $player->addWindow($brewing->getInventory());
        }

        return true;
    }
}

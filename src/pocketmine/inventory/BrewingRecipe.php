<?php

declare(strict_types=1);

namespace pocketmine\inventory;

use pocketmine\item\Item;
use pocketmine\network\mcpe\protocol\types\PotionTypeRecipe;

/**
 * Class BrewingRecipe
 * @package pocketmine\inventory
 */
class BrewingRecipe implements Recipe {

    /** @var int $input */
    public $input;
    /** @var int $output */
    public $output;
    /** @var int $ingredient */
    public $ingredient;

    public function __construct(int $inputPotionType, int $ingredient, int $outputPotionType) {
        $this->input = $inputPotionType;
        $this->ingredient = $ingredient;
        $this->output = $outputPotionType;
    }

    /**
     * @return int
     */
    public function getInput(): int {
        return $this->input;
    }

    /**
     * @return int
     */
    public function getOutput(): int {
        return $this->output;
    }

    /**
     * @return int
     */
    public function getIngredient(): int {
        return $this->ingredient;
    }

    /**
     * @return PotionTypeRecipe
     */
    public function toPotionTypeRecipe(): PotionTypeRecipe {
        return new PotionTypeRecipe(Item::POTION, $this->getInput(), $this->getIngredient(), 0, Item::POTION, $this->getOutput());
    }

    /**
     * @param CraftingManager $manager
     */
    public function registerToCraftingManager(CraftingManager $manager): void {
        $manager->registerBrewingRecipe($this);
    }
}
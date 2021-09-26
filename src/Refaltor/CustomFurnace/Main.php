<?php

namespace Refaltor\CustomFurnace;

use pocketmine\crafting\FurnaceRecipe;
use pocketmine\crafting\FurnaceType;
use pocketmine\item\Item;
use pocketmine\item\ItemIdentifier;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase
{
    protected function onLoad(): void {
        $this->saveDefaultConfig();
        $array = $this->getConfig()->getAll();
        foreach ($array['recipes'] as $name => $values) {
            $this->registerFurnace($values['input'], $values['result']);
        }
    }

    public function registerFurnace(string $input, string $result): void {
        $input = explode(':', $input);
        $result = explode(':', $result);
        $furnaceRecipe = new FurnaceRecipe(
            new Item(new ItemIdentifier($result[0], $result[1])),
            new Item(new ItemIdentifier($input[0], $input[1]))
        );
        $manager = $this->getServer()->getCraftingManager()->getFurnaceRecipeManager(FurnaceType::FURNACE());
        $manager->register($furnaceRecipe);
    }
}
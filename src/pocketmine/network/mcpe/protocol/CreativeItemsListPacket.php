<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

use pocketmine\item\Item;
use pocketmine\network\mcpe\NetworkSession;
use pocketmine\network\mcpe\protocol\types\CreativeItemsMapping;
use const pocketmine\RESOURCE_PATH;

/**
 * Class CreativeItemsListPacket
 * @package pocketmine\network\mcpe\protocol
 */
class CreativeItemsListPacket extends DataPacket {

    public const NETWORK_ID = ProtocolInfo::CREATIVE_ITEMS_LIST_PACKET;

    protected $creativeItemsData = "";

    protected function decodePayload() {
        // TODO: Decode payload method
    }

    protected function encodePayload() {
        $data = unserialize(base64_decode(file_get_contents(RESOURCE_PATH . "vanilla/creative_items_data.dat")));
        $this->putVarInt(count($data));
        foreach ($data as $i => [$id, $damage]) {
            $this->putVarInt($i + 1);
            $this->putSlot(Item::get($id, $damage));
        }
    }

    public function handle(NetworkSession $session): bool {
        return false;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Jarne
 * Date: 14.05.16
 * Time: 12:23
 */

namespace surva\AllSigns\Tasks;

use surva\AllSigns\AllSigns;
use pocketmine\level\Level;
use pocketmine\scheduler\PluginTask;
use pocketmine\tile\Sign;

class SignUpdate extends PluginTask {
    /* @var AllSigns */
    private $allSigns;

    public function __construct(AllSigns $allSigns) {
        $this->allSigns = $allSigns;

        parent::__construct($allSigns);
    }

    public function onRun(int $currentTick) {
        foreach($this->getAllSigns()->getServer()->getLevels() as $level) {
            foreach($level->getTiles() as $tile) {
                if($tile instanceof Sign) {
                    $text = $tile->getText();

                    if($text[0] == $this->getAllSigns()->getConfig()->get("worldtext")) {
                        $level = $this->getAllSigns()->getServer()->getLevelByName($text[1]);

                        if($level instanceof Level) {
                            $tile->setText($text[0], $text[1], $text[2], count($level->getPlayers()) . " " . $this->getAllSigns()->getConfig()->get("players"));
                        } else {
                            $tile->setText($text[0], $text[1], $text[2], $this->getAllSigns()->getConfig()->get("error"));
                        }
                    }
                }
            }
        }
    }

    /**
     * @return AllSigns
     */
    public function getAllSigns(): AllSigns {
        return $this->allSigns;
    }
}

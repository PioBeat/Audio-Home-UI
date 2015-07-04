<?php

/*

 */

/**
 * Description of SoundController
 * Class for controlling the sound volume using alsa.
 *
 * @author Dome
 */
class SoundController {
    public static function volumeUp() {
        $volume = self::getCurrentVolume();
        $volume += 10;
        if ($volume >= 160)
            return;
        exec("amixer set Speaker " . $volume);
        echo "New Volume: " . $volume;
    }
    
    public static function volumeDown() {
        $volume = self::getCurrentVolume();
        $volume -= 10;
        if($volume <= 0) return;
        exec("amixer set Speaker " . $volume);
        echo "New Volume: " . $volume;
    }
    
    public static function mute() {
        exec("amixer set Speaker 0");
    }
    
    /**
     * Returns the current volumen
     * @return int current volume
     */
    public static function getCurrentVolume() {
        exec("amixer scontents | grep Playback", $output);
        return (int)substr($output[2], 23, 4);
    }
}

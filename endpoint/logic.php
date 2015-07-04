<?php

/**
 * Ajax-Endpoint for various controller classes controlling the sound and the 
 * tools for playing music.
 */
include_once '../control/SoundController.php';
include_once '../control/IMusicControl.php';
include_once '../control/MPDController.php';

if (isset($_POST['action']) && !empty($_POST['action'])) {
    $m = new MPDController();
    
    if ($_POST['action'] == "current-playing") {
        //var_dump($m->getCurrentPlaying());
        echo $m->getCurrentPlaying()[0];
    }

    if ($_POST['action'] == "stream-start") {
        $m->createPlaylist();
        $m->loadPlaylist();
        $m->play(null);
    }
    if ($_POST['action'] == "playspecific" && isset($_POST['index'])) {
        $index = $_POST['index'];
        (int) $index += 1;
        $m->play($index);
        echo "start playing=" . $index;
    }
    if ($_POST['action'] == "stop") {
        $m->stop();
    }
    if ($_POST['action'] == "liststreams") {
        echo json_encode($m->listPlaylist());
    }
    
    if ($_POST['action'] == "add-radio-stream" && isset($_POST['link']) && isset($_POST['name'])) {
//        echo "link gesendet: ". $_POST['link'];
        $m->addRadioStreamUrl($_POST['name'], $_POST['link']);
        echo json_encode($m->listPlaylist());
    }

    //Soundcontrol
    if ($_POST['action'] == "plus") {
        SoundController::volumeUp();
    }

    if ($_POST['action'] == "minus") {
        SoundController::volumeDown();
    }

    if ($_POST['action'] == "mute") {
        SoundController::mute();
    }
    
    //MP3
    if ($_POST['action'] == "mp3list") {
        $m->listAllSongs();
    }
    if ($_POST['action'] == "mp3-play") {
        $m->loadMP3();
        $m->play(null);
    }
    if ($_POST['action'] == "mp3-stop") {
        $m->stop();
    }
    if ($_POST['action'] == "mp3-next") {
        $m->nextSong();
    }
    if ($_POST['action'] == "mp3-prev") {
        $m->prevSong();
    }
}
?>
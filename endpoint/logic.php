<?php

/**
 * Ajax-Endpoint for various controller classes controlling the sound and the
 * tools for playing music.
 */
include_once '../control/SoundController.php';
include_once '../control/IMusicControl.php';
include_once '../control/MPDController.php';
//echo "endpoint-logic " . $_GET['code'];
if ( isset( $_POST['code'] ) && ! empty( $_POST['code'] ) ) {
	$m = new MPDController();

	if ( $_POST['code'] == "current-playing" ) {
//        var_dump($m->getCurrentPlaying());
		if ( is_array( $m->getCurrentPlaying() ) && count( $m->getCurrentPlaying() ) > 0 ) {
			echo $m->getCurrentPlaying()[0];
		} else {
			echo "No song currently playing";
		}
	}

	if ( $_POST['code'] == "init-playlist" ) {
		$m->initPlaylist();
	}

	if ( $_POST['code'] == "stream-start" ) {
		$m->createPlaylist();
		$m->loadPlaylist();

		//$m->play( null );
		return json_encode( "OK" );
	}
	if ( $_POST['code'] == "playspecific" && isset( $_POST['index'] ) ) {
		$index = $_POST['index'];
		(int) $index += 1;
		$m->play( $index );
		echo "start playing=" . $index;
	}
	if ( $_POST['code'] == "stop" ) {
		$m->stop();
	}
	if ( $_POST['code'] == "mp3-pause" ) {
		$m->pause();
	}
	if ( $_POST['code'] == "mp3-resume" ) {
		$m->resume();
	}

	if ( $_POST['code'] == "liststreams" ) {
		echo json_encode( $m->listPlaylist() );
	}

	if ( $_POST['code'] == "add-radio-stream" && isset( $_POST['link'] ) && isset( $_POST['name'] ) ) {
//        echo "link gesendet: ". $_POST['link'];
		$m->addRadioStreamUrl( $_POST['name'], $_POST['link'] );
		echo json_encode( $m->listPlaylist() );
	}

	//Soundcontrol
	if ( $_POST['code'] == "plus" ) {
		SoundController::volumeUp();
	}

	if ( $_POST['code'] == "minus" ) {
		SoundController::volumeDown();
	}

	if ( $_POST['code'] == "mute" ) {
		SoundController::mute();
	}

	//MP3
	if ( $_POST['code'] == "mp3list" ) {
		echo json_encode( $m->listAllSongs() );
	}
	if ( $_POST['code'] == "mp3-play" ) {
		$m->loadMP3();
		//$m->play( null );
	}
	if ( $_POST['code'] == "mp3-stop" ) {
		$m->stop();
	}
	if ( $_POST['code'] == "mp3-next" ) {
		$m->nextSong();
	}
	if ( $_POST['code'] == "mp3-prev" ) {
		$m->prevSong();
	}
}
exit();
?>
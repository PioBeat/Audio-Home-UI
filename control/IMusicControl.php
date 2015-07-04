<?php



/**
 *
 * @author Dome
 */
interface IMusicControl { 
    /**
     * Starts the daemon/tool for playing music
     */
    function start();
    
    /**
     * Kills the process that is in charge for playing music
     */
    function shutdown();
    
    /**
     * List all available songs in the configured music directory
     */
    function listAllSongs();
    
    function play($songNumber);
    function stop();
    
    function nextSong();
    function prevSong();
    
    function getCurrentPlaying();
    
    /**
     * should be used if mp3 is activated
     * only load music files (mp3, ...) and exclude radio streams
     */
    function loadMP3();
    /**
     * should be used if radio is activated
     * loads the playlist into the player
     */
    function loadPlaylist();

    /**
     * Adds stream to radio-stream file
     * @param type $url
     */
    function addRadioStreamUrl($name, $url);
    
    /**
     * Loads stream list file (json format) and returns it as array
     */
    function loadStreamList();
    /**
     * simply creates the playlist from the radio-streams file
     * dont do anything further with it
     */
    function createPlaylist();

    
    function listPlaylist();
}

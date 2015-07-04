<?php

/*

 */

/**
 * Description of MPDController
 *
 * @author Dome
 */
class MPDController implements IMusicControl {

    private $playlistdir;
    private $filename;
    private $filepath;
    private $streamList;
    private $server;

    public function __construct() {
        $this->playlistdir = "/mnt/mpd/radiostreams";
        $this->filename = "playlist.m3u";
        $this->filepath = $this->playlistdir . "/" . $this->filename;
        $this->streamList = "./radio-streams.json";
        $this->getServer();
    }

    /**
     * Trys do read the server ip from the config file.
     * If it´s not there, than the current server ip from which the script is
     * executed will be used.
     */
    private function getServer() {
        try {
            if (($this->server = file_get_contents("../mpd-server")) === FALSE) {
                throw new Exception("no config file");
            }
        } catch (Exception $ex) {
            $this->server = $_SERVER['SERVER_ADDR'];
        }
        return $this->server;
    }

    public function shutdown() {
        //or cat /var/run/mpd.pid if configured in mpd.cfg
        exec("pidof mpd", $pid, $ret);
        //var_dump($pid);
        //echo $ret;
        if ($ret != 0) {
            echo "error: mpd cannot be killed because it hasn't started.";
            return;
        }

        exec("kill " . $pid[0], $null, $ret);
        //echo "kill: mpd pid=" . $pid[0] . "<br/>";
        echo $ret;
    }

    public function start() {
        exec("/etc/init.d/mpd start", $output, $ret);
        //var_dump($output);
        echo $ret;
    }

    public function listAllSongs() {
        exec("mpc -h ". $this->server  ." update");
        ob_start();
        passthru("mpc -h " . $this->server . " ls");
        $data = ob_get_contents();
        ob_clean();
        $data = explode("\n", $data);
        echo json_encode($data);
    }

    public function nextSong() {
        exec("mpc -h " . $this->server . " next");
    }

    public function play($songNumber) {
        if ($songNumber == null) {
            exec("mpc -h " . $this->server . " play");
        } else {
            exec("mpc -h " . $this->server . " play " . (int) $songNumber);
        }
    }

    public function prevSong() {
        exec("mpc -h " . $this->server . " prev");
    }

    public function stop() {
        exec("mpc -h " . $this->server . " stop");
    }

    /**
     * 
     * @param type $url
     */
    public function addRadioStreamUrl($name, $url) {
        $rsl = $this->loadStreamList();
        $entry = array();
        $entry["name"] = $name;
        $entry["url"] = $url;
        array_push($rsl, $entry);
        file_put_contents(realpath(dirname(__FILE__) . "/../" . $this->streamList), json_encode($rsl));
        $this->createPlaylist();
        $this->loadPlaylist();
    }

    public function createPlaylist() {
        unlink($this->filepath);
        $sc = array();
        array_push($sc, "#EXTM3U");
        $streams = $this->loadStreamList();
        foreach ($streams as $key => $value) {
            array_push($sc, "#EXTINF:-1," . $value["name"]);
            array_push($sc, $value["url"]);
        }
//        var_dump($sc);
        $playlist = implode("\n", $sc);
//        echo $playlist;
        file_put_contents($this->filepath, $playlist);
    }

    public function loadStreamList() {
        $contents = file_get_contents(realpath(dirname(__FILE__) . "/../" . $this->streamList));
        $streams = json_decode($contents, true);
        return $streams;
    }

    public function loadPlaylist() {
        exec("mpc -h " . $this->server . " clear");
        exec("mpc -h " . $this->server . " load " . $this->filename);
    }

    public function listPlaylist() {
        exec("mpc -h " . $this->server . " playlist " . $this->filename, $output, $ret);
        return $output;
    }

    public function loadMP3() {
        exec("mpc -h " . $this->server . " clear");
        exec("mpc -h " . $this->server . " listall | mpc -h 192.168.0.5 add");
        exec("mpc -h " . $this->server . " update");
    }

    public function getCurrentPlaying() {
        exec("mpc -h " . $this->server . " current", $output);
        return $output;
    }

}

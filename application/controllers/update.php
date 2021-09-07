<?php

class Update extends CI_Controller {
    protected $_repo = "hrms.nusa";

    function __construct() {
        parent::__construct();

        $this->load->model(["master/m_akses"]);
        $this->load->library(["template"]);
        $nik = trim($this->session->userdata("nik"));
        $userinfo = $this->m_akses->q_user_check()->row_array();
        $level_akses = strtoupper(trim($userinfo["level_akses"]));
        if(empty($nik) || empty($level_akses) || !in_array($_SERVER["REMOTE_ADDR"], ["127.0.0.1", "::1"])) {
            redirect("dashboard");
        }
    }

    function index() {
        $data["title"] = "Update Website";
        $this->template->display("v_update", $data);
    }

    function exec() {
        if(is_null($_SERVER["HTTP_REFERER"])) {
            redirect("dashboard");
        }

        $filelog = APPPATH . "migrations/logs/git.txt";
        file_put_contents($filelog, date("Y-m-d H:i:s") . "\n\n");
        $arr = [
            "status" => "false"
        ];

        $command = "git remote set-url origin https://nusantaragroup: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@github.com/itcenternusantaragroup/" . $this->_repo;
        file_put_contents($filelog, "BEGIN EXECUTING \"$command\"...\n\n", FILE_APPEND);
        exec($command, $result);
        file_put_contents($filelog, json_encode($result, JSON_PRETTY_PRINT) . "\n\n", FILE_APPEND);

        $command = "git fetch";
        file_put_contents($filelog, "BEGIN EXECUTING \"$command\"...\n\n", FILE_APPEND);
        exec($command, $result);
        file_put_contents($filelog, json_encode($result, JSON_PRETTY_PRINT) . "\n\n", FILE_APPEND);

        $command = "git status -uno";
        file_put_contents($filelog, "BEGIN EXECUTING \"$command\"...\n\n", FILE_APPEND);
        exec($command, $result);
        file_put_contents($filelog, json_encode($result, JSON_PRETTY_PRINT) . "\n\n", FILE_APPEND);

        if(!strpos(implode("\n", $result), "up to date")) {
            $command = "git reset --hard origin/main";
            file_put_contents($filelog, "BEGIN EXECUTING \"$command\"...\n\n", FILE_APPEND);
            exec($command, $result);
            file_put_contents($filelog, json_encode($result, JSON_PRETTY_PRINT) . "\n\n", FILE_APPEND);
            $arr = [
                "status" => "true"
            ];
        }
        ob_start();
        $this->load->library(["migration"]);
        if($this->migration->current() === TRUE && $arr["status"] == "false") {
            $arr = [
                "status" => "false"
            ];
        } else if($this->migration->current() === FALSE) {
            $arr = [
                "status" => "error"
            ];
        } else {
            $arr = [
                "status" => "true"
            ];
        }
        ob_end_clean();

        echo json_encode($arr);
    }
}	

<?php

    class Email_reader {

        // imap server connection
        public $conn;

        // inbox storage and inbox message count
        public $inbox;
        private $msg_cnt;

        // email login credentials
        private $server = 'yourserver.com';
        private $user   = 'email@yourserver.com';
        private $pass   = 'yourpassword';
        private $port   = 143; // adjust according to server settings

        // connect to the server and get the inbox emails
        function __construct() {
            $this->connect();
            $this->inbox();
        }

        // close the server connection
        function close() {
            $this->inbox = array();
            $this->msg_cnt = 0;

            imap_close($this->conn);
        }

        // open the server connection
        // the imap_open function parameters will need to be changed for the particular server
        // these are laid out to connect to a Dreamhost IMAP server
        function connect() {
            $this->conn = imap_open('{'.$this->server.'/notls}', $this->user, $this->pass);
        }

        // move the message to a new folder
        function move($msg_index, $folder='INBOX.Processed') {
            // move on server
            imap_mail_move($this->conn, $msg_index, $folder);
            imap_expunge($this->conn);

            // re-read the inbox
            $this->inbox();
        }

        // get a specific message (1 = first email, 2 = second email, etc.)
        function get($msg_index=NULL) {
            if (count($this->inbox) <= 0) {
                return array();
            }
            elseif ( ! is_null($msg_index) && isset($this->inbox[$msg_index])) {
                return $this->inbox[$msg_index];
            }

            return $this->inbox[0];
        }
    }
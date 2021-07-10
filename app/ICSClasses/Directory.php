<?php

    namespace App\ICSClasses;

    class Directory {

        public $path = [
            'announcements' => '/files/announcements/',
            'events' => '/files/events/',
            'students' => '/files/students/',
            'faculty' => '/files/faculty/',
            'ics_logo' => '/files/ics_logo/',
            'admin' => '/files/admin/',
            'submitted_homeworks' => '/files/homeworks/submitted_homeworks/',
            'send_homeworks' => '/files/homeworks/send_homeworks/'
        ];

        public function getPath($loc){
            return public_path().$this->path[$loc];
        }
    }
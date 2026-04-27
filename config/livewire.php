<?php
return [
    'temporary_file_upload' => [
        'disk' => 'local',
        'rules' => ['required', 'file', 'max:51200'],
        'directory' => 'livewire-tmp',
    ],
];

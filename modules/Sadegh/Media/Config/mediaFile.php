<?php

return [
    "MediaTypeServieces" => [
        "image" => [
            "extensions" => [
                "png","jpg","jpeg"
            ],
            "handler" => \Sadegh\Media\Services\ImageFileService::class,
        ],
        "video" => [
            "extensions" => [
                "avi","mp4","mkv"
        ],
            "handler" => \Sadegh\Media\Services\videoFileService::class,
    ],
        "zip" => [
            "extensions" => [
                "zip","rar","tar"
            ],
            "handler" => \Sadegh\Media\Services\ZipFileService::class
        ]

]
];
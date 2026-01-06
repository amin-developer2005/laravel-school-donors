<?php

namespace App\Enums;

enum ProjectStatus: string
{
    public const string PENDING = "در دست اجرا";
    public const string COMPLETED = "کامل شده";
    public const string CANCELED = "کنسل شده";
}

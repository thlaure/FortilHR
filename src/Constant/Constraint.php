<?php

namespace App\Constant;

class Constraint
{
    public const REGEX_GENERIC_TEXT = "/^[\\p{Ll}\\p{Lu}\\p{M}\\p{P}\\p{Sc}\\p{N}\\s\r\n\\(\\)\\/°\\+=]+$/iu";
    public const REGEX_TITLE = "/^[\\s\\p{Ll}\\p{Lu}\\p{M}\\-']+$/iu";
    public const REGEX_IMAGE = "/^[\\p{Ll}\\p{Lu}\\p{M}\\p{P}\\p{Sc}\\p{N}\\s\(\\)\\/\\+=]+$/iu";
    public const REGEX_LINK  = "/^[\\p{Ll}\\p{Lu}\\p{M}\\p{P}\\p{Sc}\\p{N}\\s\(\\)\\/\\+=]+$/iu";
    public const REGEX_PHP_EXTENSION = "/php\d*/iu";

    public const IMAGE_MAX_FILE_SIZE = 5 * 1024 * 1024; // 5 MB
    public const IMAGE_ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'];
    public const IMAGE_ALLOWED_MIME_TYPES = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/avif'];

    public const FILE_FORBIDDEN_EXTENSIONS = ['phtml', 'php', 'cgi', 'exe', 'pl', 'asp', 'aspx', 'shtml', 'shtm', 'fcgi', 'fpl', 'jsp', 'htm', 'html', 'wml'];
}

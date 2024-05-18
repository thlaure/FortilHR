<?php

namespace App\Constant;

class Constraint
{
    public const REGEX_GENERIC_TEXT = "/^[\\p{Ll}\\p{Lu}\\p{M}\\p{P}\\p{Sc}\\p{N}\\s\r\n\\(\\)\\/°\\+=]+$/iu";
    public const REGEX_TITLE = "/^[\\s\\p{Ll}\\p{Lu}\\p{M}\\-']+$/iu";
    public const REGEX_IMAGE = "/^[\\p{Ll}\\p{Lu}\\p{M}\\p{P}\\p{Sc}\\p{N}\\s\(\\)\\/\\+=]+$/iu";
    public const REGEX_LINK  = "/^[\\p{Ll}\\p{Lu}\\p{M}\\p{P}\\p{Sc}\\p{N}\\s\(\\)\\/\\+=]+$/iu";
}

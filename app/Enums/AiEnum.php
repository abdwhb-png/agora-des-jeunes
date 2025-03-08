<?php

namespace App\Enums;

enum AiEnum: string
{
    case OPENAI = 'open_ai';
    case GROQ = 'groq';
    case GROK = 'grok';
}

<?php

return [
    /**
     * This is your API key from Chat GPT.
     */
    'api_key' => env('OPENAI_API_KEY'),

    /**
     * Count of symbols, allowed to generate on ChatGPT per request.
     */
    'max_tokens' => env('OPENAI_MAX_TOKENS', 256),
];
<?php declare(strict_types=1);

namespace Back1ng\ChatGPTLaravelIgnition\Solutions;

use Back1ng\ChatGPTLaravelIgnition\Enums\GPTModelEnum;
use InvalidArgumentException;
use OpenAI;
use Spatie\Ignition\Contracts\BaseSolution;
use Spatie\Ignition\Contracts\HasSolutionsForThrowable;
use Throwable;

final class ChatGPTSolution implements HasSolutionsForThrowable
{
    public function canSolve(Throwable $throwable): bool
    {
        return true;
    }

    public function getSolutions(Throwable $throwable): array
    {
        return [
            BaseSolution::create('ChatGPT Suggestion')
                ->setSolutionDescription($this->getSolutionDescription($throwable)),
        ];
    }

    public function getSolutionDescription(Throwable $throwable): string
    {
        $apiKey = config('back1ng-laravel-ignition.api_key');
        $maxTokens = config('back1ng-laravel-ignition.max_tokens');

        if (! is_string($apiKey)) {
            throw new InvalidArgumentException('Incorrect Api Key given.');
        }

        if (! is_int($maxTokens)) {
            throw new InvalidArgumentException("Incorrect Max Tokens given.");
        }

        $requestString = sprintf(
            'How can I fix this error in PHP? %s %s %s',
            get_class($throwable),
            $throwable->getMessage(),
            $throwable->getTraceAsString()
        );

        $client = OpenAI::client($apiKey);

        $result = $client->completions()->create([
            'model' => GPTModelEnum::davinci->value,
            'prompt' => $requestString,
            'max_tokens' => $maxTokens,
        ]);

        return $result['choices'][0]['text'];
    }
}

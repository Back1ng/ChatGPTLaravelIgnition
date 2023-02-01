<?php declare(strict_types=1);

namespace Back1ng\ChatGPTLaravelIgnition\Solutions;

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

        if (! is_string($apiKey)) {
            throw new InvalidArgumentException('Incorrect Api Key given.');
        }

        $requestString = sprintf(
            'How can I fix this error in PHP? %s %s %s',
            get_class($throwable),
            $throwable->getMessage(),
            $throwable->getTraceAsString()
        );

        $client = OpenAI::client($apiKey);

        $result = $client->completions()->create([
            'model' => 'text-davinci-003',
            'prompt' => $requestString,
            'max_tokens' => 256,
        ]);

        return $result['choices'][0]['text'];
    }
}

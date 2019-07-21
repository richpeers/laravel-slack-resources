<?php

namespace Richpeers\LaravelSlackResources\Exceptions;

use Exception;

class SlackResourceException extends Exception
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function render()
    {
        // formatted for slack to display error
        return response()->json([
            'text' => 'Use: `/resource https://valid.url optional-tag`',
            'attachments' => [
                (object)[
                    'text' => $this->getMessage()
                ]
            ]
        ], 200);
    }
}

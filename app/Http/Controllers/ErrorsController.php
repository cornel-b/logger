<?php

namespace App\Http\Controllers;

use App\Models\AlternativeGymUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log as LogFacade;

class ErrorsController extends Controller
{
    public function divisionByZero(): float|int
    {
        $numerator = 10;
        $denominator = 0;

        return $numerator / $denominator;
    }

    public function malformedJson()
    {
        $badJson = '{"name": "John", "age": 30,}';

        return json_decode($badJson, true, 512, JSON_THROW_ON_ERROR);
    }

    public function carbonError(): ?Carbon
    {
        return Carbon::createFromFormat('Y-m-d', 'not-a-date');
    }

    /**
     * Test undefined variable error
     */
    public function undefinedVariable(): int
    {
        return $undefinedVariable + 10;
    }

    public function arrayIndexError(): string
    {
        $array = ['a', 'b', 'c'];

        return $array[10];
    }

    public function alternativeDatabaseError(): void
    {
        AlternativeGymUser::all();
    }

    public function logOnly(Request $request)
    {
        LogFacade::debug('Debug message from controller');
        LogFacade::info('Info message from controller');
        LogFacade::warning('Warning message from controller');
        LogFacade::error('Error message from controller');

        return response()->json([
            'message' => 'Logs have been created',
        ]);
    }
}

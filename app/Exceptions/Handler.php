namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    // Overstyr den eksisterende `invalidJson` metode
    protected function invalidJson($request, ValidationException $exception)
    {
        return response()->json([
            'message' => 'Validation error',
            'errors' => $exception->errors(),
        ], 422);
    }
}

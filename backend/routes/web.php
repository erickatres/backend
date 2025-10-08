    <?php

    use Illuminate\Support\Facades\Route;

    Route::get('/', function () {
        return response()->json([
            'status' => 'success',
            'message' => 'Laravel backend is running 🚀'
        ]);
    });

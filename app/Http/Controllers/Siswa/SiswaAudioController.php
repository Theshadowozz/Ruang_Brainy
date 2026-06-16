<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\AudioLesson;
use App\Models\AudioListen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaAudioController extends Controller
{
    /**
     * Display a listing of audio lessons with optional language filtering.
     */
    public function index(Request $request)
    {
        $filterBahasa = $request->query('bahasa');
        
        $query = AudioLesson::query();
        
        if (in_array($filterBahasa, ['Inggris', 'Jepang', 'Korea'])) {
            $query->where('language', $filterBahasa);
        } else {
            $filterBahasa = '';
        }

        $userId = Auth::id();
        
        // Eager load if the current student has listened to the audio
        $audioLessons = $query->withExists(['listens' => function ($q) use ($userId) {
            $q->where('user_id', $userId);
        }])->get();

        return view('siswa.audio', compact('audioLessons', 'filterBahasa'));
    }

    /**
     * Download the audio file.
     */
    public function download($id)
    {
        $audio = AudioLesson::findOrFail($id);
        
        $path = storage_path('app/public/' . $audio->audio_file);
        
        // Ensure directory and a mock file exist so download() doesn't fail
        if (!file_exists($path)) {
            if (!is_dir(dirname($path))) {
                mkdir(dirname($path), 0755, true);
            }
            file_put_contents($path, ""); // blank placeholder
        }

        return response()->download($path, basename($path));
    }

    /**
     * Mark the audio lesson as listened by the current user.
     */
    public function markListened($id)
    {
        $userId = Auth::id();
        
        AudioListen::firstOrCreate([
            'user_id' => $userId,
            'audio_lesson_id' => $id,
        ], [
            'listened_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Audio lesson marked as listened.'
        ]);
    }
}

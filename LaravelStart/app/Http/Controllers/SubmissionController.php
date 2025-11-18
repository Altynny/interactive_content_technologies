<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SubmissionController extends Controller
{

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'message' => $validated['message'],
            'created_at' => now()->toDateTimeString(),
        ];

        $filename = now()->format('Ymd_His') . '_' . Str::random(6) . '.json';
        $path = "submissions/{$filename}";
        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        try {
            Storage::put($path, $json);
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['file' => 'Не удалось сохранить данные: ' . $e->getMessage()]);
        }

        return redirect()->route('form.show')->with('success', 'Данные успешно сохранены.');
    }

    public function listSubmissions()
    {
        $files = Storage::files('submissions');
        $rows = [];

        foreach ($files as $file) {
            $content = Storage::get($file);
            $decoded = json_decode($content, true);
            if ($decoded) {
                $decoded['_filename'] = basename($file);
                $rows[] = $decoded;
            }
        }

        usort($rows, function ($a, $b) {
            return strcmp($b['created_at'] ?? '', $a['created_at'] ?? '');
        });

        return view('submissions', ['rows' => $rows]);
    }
}

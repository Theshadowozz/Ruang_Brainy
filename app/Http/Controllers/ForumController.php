<?php

namespace App\Http\Controllers;

use App\Models\ForumReply;
use App\Models\ForumTopic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class ForumController extends Controller
{
    public function storeTopic(Request $request): RedirectResponse
    {
        if (! Schema::hasTable('forum_topics')) {
            return redirect(url()->previous() . '#forum-diskusi')
                ->withErrors(['forum' => 'Tabel forum belum ada. Jalankan php artisan migrate terlebih dahulu.']);
        }

        $validated = $request->validate([
            'category' => ['required', Rule::in(array_keys(ForumTopic::categories()))],
            'title' => ['required', 'string', 'max:120'],
            'body' => ['required', 'string', 'max:2000'],
        ]);

        ForumTopic::create([
            ...$validated,
            'user_id' => $request->user()->id,
        ]);

        return redirect(url()->previous() . '#forum-diskusi')
            ->with('forum_success', 'Topik diskusi berhasil dikirim.');
    }

    public function storeReply(Request $request, ForumTopic $forumTopic): RedirectResponse
    {
        if (! Schema::hasTable('forum_replies')) {
            return redirect(url()->previous() . '#forum-diskusi')
                ->withErrors(['forum' => 'Tabel balasan forum belum ada. Jalankan php artisan migrate terlebih dahulu.']);
        }

        $validated = $request->validate([
            'body' => ['required', 'string', 'max:1500'],
        ]);

        ForumReply::create([
            'forum_topic_id' => $forumTopic->id,
            'user_id' => $request->user()->id,
            'body' => $validated['body'],
        ]);

        return redirect(url()->previous() . '#forum-diskusi')
            ->with('forum_success', 'Balasan diskusi berhasil dikirim.');
    }
}

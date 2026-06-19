<?php

namespace App\Http\Controllers;

use App\Models\DiscussionMessage;
use App\Models\DiscussionTopic;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DiscussionController extends Controller
{
    public function index(Request $request): View
    {
        $activeCategory = $this->validCategory($request->query('category'));
        $user = $request->user();
        $rolePrefix = $this->rolePrefix($user);

        $topics = DiscussionTopic::query()
            ->where('category', $activeCategory)
            ->with(['user', 'messages.user'])
            ->withCount('messages')
            ->latest('updated_at')
            ->get();

        $categoryCounts = DiscussionTopic::query()
            ->selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category')
            ->all();

        return view('discussions.index', [
            'activeCategory' => $activeCategory,
            'categories' => DiscussionTopic::CATEGORIES,
            'categoryCounts' => $categoryCounts,
            'layout' => $this->layoutFor($user),
            'rolePrefix' => $rolePrefix,
            'topics' => $topics,
        ]);
    }

    public function live(Request $request)
    {
        $activeCategory = $this->validCategory($request->query('category'));
        $user = $request->user();
        $rolePrefix = $this->rolePrefix($user);

        $topics = DiscussionTopic::query()
            ->where('category', $activeCategory)
            ->with(['user', 'messages.user'])
            ->withCount('messages')
            ->latest('updated_at')
            ->get();

        $html = view('discussions.partials.topics', [
            'activeCategory' => $activeCategory,
            'activeLabel' => DiscussionTopic::CATEGORIES[$activeCategory],
            'rolePrefix' => $rolePrefix,
            'topics' => $topics,
        ])->render();

        return response()->json([
            'html' => $html,
            'topic_count' => $topics->count(),
            'updated_at' => now()->toIso8601String(),
        ]);
    }

    public function storeTopic(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category' => ['required', 'string', 'in:' . implode(',', array_keys(DiscussionTopic::CATEGORIES))],
            'title' => ['required', 'string', 'max:140'],
            'body' => ['required', 'string', 'max:5000'],
        ]);

        $topic = DiscussionTopic::create([
            'user_id' => Auth::id(),
            'category' => $validated['category'],
            'title' => $validated['title'],
        ]);

        DiscussionMessage::create([
            'discussion_topic_id' => $topic->id,
            'user_id' => Auth::id(),
            'body' => $validated['body'],
        ]);

        return redirect()
            ->route($this->rolePrefix($request->user()) . '.diskusi.index', ['category' => $validated['category']])
            ->with('success', 'Topik diskusi berhasil dikirim.');
    }

    public function storeMessage(Request $request, DiscussionTopic $topic): RedirectResponse
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'max:5000'],
        ]);

        DiscussionMessage::create([
            'discussion_topic_id' => $topic->id,
            'user_id' => Auth::id(),
            'body' => $validated['body'],
        ]);

        $topic->touch();

        return redirect()
            ->route($this->rolePrefix($request->user()) . '.diskusi.index', ['category' => $topic->category])
            ->with('success', 'Balasan berhasil dikirim.');
    }

    private function validCategory(?string $category): string
    {
        if ($category && array_key_exists($category, DiscussionTopic::CATEGORIES)) {
            return $category;
        }

        return DiscussionTopic::CATEGORY_BRAINY;
    }

    private function layoutFor(User $user): string
    {
        if ($user->isAdmin()) {
            return 'layouts.admin';
        }

        if ($user->isTutor()) {
            return 'layouts.tutor';
        }

        return 'layouts.siswa';
    }

    private function rolePrefix(User $user): string
    {
        if ($user->isAdmin()) {
            return 'admin';
        }

        if ($user->isTutor()) {
            return 'tutor';
        }

        return 'siswa';
    }
}

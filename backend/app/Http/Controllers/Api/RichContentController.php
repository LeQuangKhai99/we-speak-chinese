<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\CommonSentence;
use App\Models\HskListeningTest;
use App\Models\VideoLecture;
use App\Models\CustomVocabulary;
use App\Models\UserProgress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RichContentController extends ApiController
{
    /**
     * Get all common conversational sentences.
     */
    public function getCommonSentences(Request $request): JsonResponse
    {
        $sentences = CommonSentence::all();
        return $this->successResponse($sentences, 'Common sentences retrieved successfully.');
    }

    /**
     * Get HSK Part 1 Listening tests (describe photo).
     */
    public function getHskListeningTests(Request $request): JsonResponse
    {
        $tests = HskListeningTest::all();
        return $this->successResponse($tests, 'HSK listening tests retrieved successfully.');
    }

    /**
     * Get YouTube video lectures.
     */
    public function getVideoLectures(Request $request): JsonResponse
    {
        $videos = VideoLecture::all();
        return $this->successResponse($videos, 'Video lectures retrieved successfully.');
    }

    /**
     * Get user learning stats.
     */
    public function getUserStats(Request $request): JsonResponse
    {
        $userId = $request->user()->id;

        // 1. Words learned from standard sets
        $learnedWordsCount = UserProgress::where('user_id', $userId)
            ->where('status', 'learned')
            ->count();

        // 2. Custom vocabularies created
        $customVocabCount = CustomVocabulary::where('user_id', $userId)->count();

        // 3. User streak
        // We can reuse the streak logic from VocabController, or query directly here.
        // Let's implement the query directly for simplicity and robustness.
        $streak = $this->calculateUserStreak($userId);

        return $this->successResponse([
            'learned_words_count' => $learnedWordsCount,
            'custom_vocab_count' => $customVocabCount,
            'streak' => $streak,
        ], 'User stats retrieved successfully.');
    }

    /**
     * Get custom vocabularies list.
     */
    public function getCustomVocabularies(Request $request): JsonResponse
    {
        $userId = $request->user()->id;
        $vocab = CustomVocabulary::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
        return $this->successResponse($vocab, 'Custom vocabularies retrieved successfully.');
    }

    /**
     * Save custom vocabulary word.
     */
    public function saveCustomVocabulary(Request $request): JsonResponse
    {
        $request->validate([
            'hanzi' => 'required|string|max:100',
            'pinyin' => 'required|string|max:100',
            'meaning' => 'required|string|max:255',
            'example' => 'nullable|string|max:255',
            'example_pinyin' => 'nullable|string|max:255',
            'example_meaning' => 'nullable|string|max:255',
        ]);

        $userId = $request->user()->id;

        $vocab = CustomVocabulary::create([
            'user_id' => $userId,
            'hanzi' => $request->input('hanzi'),
            'pinyin' => $request->input('pinyin'),
            'meaning' => $request->input('meaning'),
            'example' => $request->input('example'),
            'example_pinyin' => $request->input('example_pinyin'),
            'example_meaning' => $request->input('example_meaning'),
            'status' => 'learned', // Mark as learned upon creation
        ]);

        return $this->successResponse($vocab, 'Custom vocabulary saved successfully.');
    }

    /**
     * Calculate user streak count based on user progress dates.
     */
    private function calculateUserStreak(int $userId): int
    {
        $dates = UserProgress::where('user_id', $userId)
            ->selectRaw('DATE(created_at) as date')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->pluck('date')
            ->toArray();

        if (empty($dates)) {
            return 0;
        }

        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));

        if (!in_array($today, $dates) && !in_array($yesterday, $dates)) {
            return 0;
        }

        $currentDate = in_array($today, $dates) ? $today : $yesterday;
        $streak = 0;

        while (in_array($currentDate, $dates)) {
            $streak++;
            $currentDate = date('Y-m-d', strtotime($currentDate . ' -1 day'));
        }

        return $streak;
    }
}

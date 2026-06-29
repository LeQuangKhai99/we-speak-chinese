<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\VocabSet;
use App\Models\VocabGroup;
use App\Models\Vocabulary;
use App\Models\UserProgress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VocabController extends ApiController
{
    /**
     * Get all vocab sets with groups and the user's progress.
     */
    public function index(Request $request): JsonResponse
    {
        $userId = $request->user()->id;

        // Fetch sets with groups and eager load their vocabularies
        $sets = VocabSet::with(['groups.vocabularies'])->get();

        $result = $sets->map(function ($set) use ($userId) {
            $totalWords = 0;
            $totalLearned = 0;

            $groups = $set->groups->map(function ($group) use ($userId, &$totalWords, &$totalLearned) {
                $wordsCount = $group->vocabularies->count();
                $totalWords += $wordsCount;

                // Count learned words for this user in this group
                $learnedCount = UserProgress::where('user_id', $userId)
                    ->whereIn('vocabulary_id', $group->vocabularies->pluck('id'))
                    ->where('status', 'learned')
                    ->count();
                
                $totalLearned += $learnedCount;

                return [
                    'id' => $group->id,
                    'index' => $group->index,
                    'name' => $group->name,
                    'desc' => $group->desc,
                    'words' => $wordsCount,
                    'learned' => $learnedCount,
                ];
            });

            return [
                'id' => $set->id,
                'levelCode' => $set->code,
                'title' => $set->title,
                'subtitle' => $set->subtitle,
                'color' => $set->color,
                'wordsCount' => $totalWords,
                'learnedCount' => $totalLearned,
                'groupsCount' => $groups->count(),
                'groups' => $groups,
            ];
        });

        $data = [
            'sets' => $result,
            'streak' => $this->calculateStreak($userId),
        ];

        return $this->successResponse($data, 'Vocabulary sets retrieved successfully.');
    }

    /**
     * Calculate user streak count based on study dates.
     */
    private function calculateStreak(int $userId): int
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

        // If not studied today AND not yesterday, streak resets to 0
        if (!in_array($today, $dates) && !in_array($yesterday, $dates)) {
            return 0;
        }

        // Start checking back consecutive days starting from today or yesterday
        $currentDate = in_array($today, $dates) ? $today : $yesterday;
        $streak = 0;

        while (in_array($currentDate, $dates)) {
            $streak++;
            $currentDate = date('Y-m-d', strtotime($currentDate . ' -1 day'));
        }

        return $streak;
    }

    /**
     * Get words list inside a group.
     */
    public function groupWords(Request $request, $groupId): JsonResponse
    {
        $group = VocabGroup::findOrFail($groupId);
        $words = $group->vocabularies;

        return $this->successResponse($words, 'Vocabulary words retrieved successfully.');
    }

    /**
     * Save user learning progress.
     */
    public function saveProgress(Request $request): JsonResponse
    {
        $request->validate([
            'vocabulary_ids' => 'required|array',
            'vocabulary_ids.*' => 'required|integer|exists:vocabularies,id',
        ]);

        $userId = $request->user()->id;
        $vocabularyIds = $request->input('vocabulary_ids');

        foreach ($vocabularyIds as $vocabId) {
            UserProgress::updateOrCreate(
                [
                    'user_id' => $userId,
                    'vocabulary_id' => $vocabId,
                ],
                [
                    'status' => 'learned',
                    'created_at' => now(), // Force update timestamp to count as studied today
                ]
            );
        }

        return $this->successResponse(null, 'Progress saved successfully.');
    }
}

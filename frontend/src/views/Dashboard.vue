<template>
  <DashboardLayout>
    <div class="space-y-8 pb-12">
      <!-- Streak & Tiến độ Banner -->
      <div class="relative overflow-hidden bg-slate-900/60 backdrop-blur-xl border border-slate-800 rounded-3xl p-6 md:p-8 flex flex-col lg:flex-row items-center justify-between gap-6">
        <!-- Orange/Flame Gradient Glow Behind -->
        <div class="absolute -left-12 -top-12 w-64 h-64 bg-amber-500/10 rounded-full blur-3xl"></div>
        <div class="absolute right-12 bottom-0 w-80 h-80 bg-indigo-500/10 rounded-full blur-3xl"></div>

        <!-- Left Content: Streak -->
        <div class="flex items-center space-x-6 relative z-10 w-full lg:w-auto">
          <!-- Animated Flame Icon -->
          <div class="w-16 h-16 shrink-0 bg-amber-500/10 border border-amber-500/20 rounded-2xl flex items-center justify-center shadow-lg shadow-amber-500/5 animate-pulse">
            <svg class="w-10 h-10 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />
            </svg>
          </div>
          <div>
            <div class="flex items-center space-x-2">
              <h2 class="text-2xl md:text-3xl font-extrabold text-white">Chuỗi {{ streak }} ngày học!</h2>
            </div>
            <p class="text-sm text-slate-400 mt-1">Cố lên – học thêm <span class="text-amber-400 font-semibold">20 từ</span> nữa để hoàn thành mục tiêu hôm nay 🎯</p>
            
            <!-- Tuần lễ theo dõi -->
            <div class="flex items-center space-x-2 mt-4">
              <div v-for="day in weekDays" :key="day.label" class="flex flex-col items-center">
                <span class="text-[10px] text-slate-500 font-semibold uppercase tracking-wider">{{ day.label }}</span>
                <div class="w-8 h-8 rounded-full border mt-1.5 flex items-center justify-center text-xs font-semibold transition-all"
                  :class="day.isToday ? 'bg-indigo-600 border-indigo-500 text-white shadow-md shadow-indigo-600/30' : 'bg-slate-950 border-slate-800 text-slate-400'">
                  {{ day.date }}
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Right Content: Actions -->
        <div class="flex items-center space-x-4 relative z-10 w-full lg:w-auto shrink-0 justify-end">
          <button
            @click="testApi"
            class="px-4 py-3 bg-slate-950 hover:bg-slate-800 border border-slate-800 hover:border-slate-700 text-slate-300 hover:text-white text-sm font-medium rounded-2xl transition duration-150 flex items-center cursor-pointer"
          >
            <svg class="w-4 h-4 mr-2 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            Lịch sử API
          </button>
          
          <button
            @click="openWheel"
            class="px-6 py-3.5 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-400 hover:to-orange-500 text-white text-sm font-bold rounded-2xl shadow-lg shadow-orange-600/20 hover:shadow-orange-600/30 transition duration-150 flex items-center transform hover:-translate-y-0.5 cursor-pointer animate-pulse"
          >
            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Vòng quay từ vựng
          </button>
        </div>
      </div>

      <!-- Main Layout: Grid and Sidebar -->
      <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Cards Column -->
        <div class="lg:col-span-3 space-y-6">
          <div class="flex items-center justify-between border-b border-slate-800 pb-4">
            <div>
              <h3 class="text-xl font-bold text-white">Học phần từ vựng của bạn</h3>
              <p class="text-xs text-slate-400 mt-1">
                Đã học được {{ totalWordsLearned }} từ · {{ vocabSets.length }} học phần có sẵn
              </p>
            </div>
            <div class="flex items-center space-x-2">
              <span class="text-xs px-2.5 py-1 bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 rounded-full font-semibold">Tất cả bài học</span>
            </div>
          </div>

          <!-- Loading state -->
          <div v-if="loading" class="py-20 text-center bg-slate-900/10 border border-slate-900 rounded-3xl">
            <div class="w-8 h-8 border-4 border-indigo-500/20 border-t-indigo-500 rounded-full animate-spin mx-auto mb-3"></div>
            <p class="text-xs text-slate-500">Đang tải danh sách bài học và tiến trình của bạn...</p>
          </div>

          <!-- Vocabulary Sets Grid -->
          <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div
              v-for="set in vocabSets"
              :key="set.id"
              @click="openSetDetails(set)"
              class="group relative overflow-hidden bg-slate-900/30 hover:bg-slate-900/60 border border-slate-800 hover:border-slate-700/60 rounded-3xl p-6 transition-all duration-300 transform hover:-translate-y-1 cursor-pointer flex flex-col justify-between"
            >
              <!-- Card Top Decoration color bar -->
              <div class="absolute left-0 top-0 bottom-0 w-2.5 rounded-l-3xl" :style="{ backgroundColor: set.color }"></div>

              <div class="pl-3 space-y-4">
                <!-- Icon/Badge Header -->
                <div class="flex items-center justify-between">
                  <div class="w-12 h-12 rounded-2xl flex items-center justify-center font-black text-lg border"
                    :style="{
                      backgroundColor: set.color + '15',
                      borderColor: set.color + '30',
                      color: set.color
                    }">
                    {{ set.levelCode }}
                  </div>
                  <span class="text-xs text-slate-400 bg-slate-950 px-2.5 py-1 rounded-xl border border-slate-800 group-hover:border-slate-700 font-semibold transition-all">
                    {{ set.wordsCount }} từ
                  </span>
                </div>

                <!-- Info -->
                <div>
                  <h4 class="text-lg font-bold text-white group-hover:text-indigo-300 transition-colors flex items-center">
                    {{ set.title }}
                    <svg class="w-4 h-4 ml-1.5 opacity-0 group-hover:opacity-100 transition-opacity text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                    </svg>
                  </h4>
                  <p class="text-xs text-slate-400 mt-1.5 line-clamp-2 leading-relaxed">
                    {{ set.subtitle }}
                  </p>
                </div>

                <!-- Progress Meter -->
                <div class="pt-2">
                  <div class="flex justify-between items-center text-[10px] text-slate-500 font-semibold mb-1">
                    <span>{{ set.groupsCount }} nhóm từ</span>
                    <span>Đã học {{ set.learnedCount }}/{{ set.wordsCount }}</span>
                  </div>
                  <!-- Progress bar track -->
                  <div class="w-full h-1.5 bg-slate-950 border border-slate-800 rounded-full overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-500" :style="{ backgroundColor: set.color, width: `${(set.learnedCount / (set.wordsCount || 1)) * 100}%` }"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Sidebar Column (Leaderboard) -->
        <div class="space-y-6">
          <div class="bg-slate-900/40 border border-slate-800 rounded-3xl p-6 flex flex-col gap-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
              <h3 class="font-bold text-white flex items-center">
                <svg class="w-5 h-5 text-amber-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                Bảng xếp hạng
              </h3>
            </div>

            <!-- Filters -->
            <div class="grid grid-cols-3 gap-1 bg-slate-950 p-1 rounded-2xl border border-slate-800">
              <button
                v-for="period in ['week', 'month', 'all']"
                :key="period"
                @click="leaderboardPeriod = period"
                class="py-2 text-[11px] font-bold rounded-xl transition-all uppercase tracking-wider cursor-pointer"
                :class="leaderboardPeriod === period ? 'bg-slate-900 text-indigo-400 border border-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-300'"
              >
                {{ period === 'week' ? 'Tuần' : period === 'month' ? 'Tháng' : 'Tất cả' }}
              </button>
            </div>

            <!-- User Leaderboard List -->
            <div class="space-y-3.5">
              <div
                v-for="(user, index) in filteredLeaderboard"
                :key="user.name"
                class="flex items-center justify-between p-3 rounded-2xl border transition-all"
                :class="user.isCurrent ? 'bg-indigo-600/10 border-indigo-500/20' : 'bg-slate-950/40 border-slate-900'"
              >
                <div class="flex items-center space-x-3">
                  <!-- Rank Badge -->
                  <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-black"
                    :class="index === 0 ? 'bg-amber-500 text-slate-950' : index === 1 ? 'bg-slate-300 text-slate-950' : index === 2 ? 'bg-orange-400 text-slate-950' : 'text-slate-500'">
                    {{ index + 1 }}
                  </div>
                  <!-- Avatar initials -->
                  <div class="w-8 h-8 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-xs text-slate-300 font-bold uppercase">
                    {{ user.name.slice(0,2) }}
                  </div>
                  <div>
                    <h5 class="text-xs font-bold text-slate-200">{{ user.name }}</h5>
                    <span class="text-[10px] text-slate-500">{{ user.sessions }} lượt học</span>
                  </div>
                </div>
                <div class="text-right">
                  <span class="text-xs font-black text-indigo-400">{{ user.words }} từ</span>
                </div>
              </div>
            </div>

            <!-- Leaderboard Footer Banner -->
            <div class="bg-indigo-600/10 border border-indigo-500/20 rounded-2xl p-4 flex items-center space-x-3 text-indigo-400">
              <span class="text-xl">🏆</span>
              <p class="text-[11px] font-semibold leading-relaxed">
                Bạn đang dẫn đầu lượt học hôm nay. Tiếp tục duy trì phong độ nhé!
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Spin & Learn Modal -->
    <Transition name="fade">
      <div v-if="showWheelModal" class="fixed inset-0 z-50 flex items-center justify-center p-6">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-md" @click="closeWheel"></div>

        <!-- Modal Content Container -->
        <div class="relative bg-slate-900 border border-slate-800 rounded-3xl p-8 max-w-lg w-full shadow-2xl flex flex-col items-center">
          <button @click="closeWheel" class="absolute top-6 right-6 text-slate-500 hover:text-slate-300 transition-colors">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
          </button>

          <h3 class="text-2xl font-black text-white text-center mb-1">Vòng quay từ vựng</h3>
          <p class="text-xs text-slate-400 text-center mb-8">Thử vận may để nhận ngẫu nhiên một thẻ từ vựng chữ Hán!</p>

          <!-- Interactive Custom CSS Spinner Wheel -->
          <div class="relative w-64 h-64 mb-8">
            <!-- Spinner Pointer Arrow -->
            <div class="absolute -top-3 left-1/2 -translate-x-1/2 w-6 h-6 z-20 text-amber-500 drop-shadow-md">
              <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                <path d="M12 21l-8-14h16z" />
              </svg>
            </div>

            <!-- Spinning Wheel Circle -->
            <div
              class="w-full h-full rounded-full border-4 border-slate-800 relative overflow-hidden transition-transform duration-4000 cubic-bezier-out-back shadow-2xl"
              :style="{ transform: `rotate(${wheelAngle}deg)` }"
            >
              <!-- Colored pie segments (8 slices) -->
              <div
                v-for="(word, i) in spinnerWords"
                :key="word.hanzi"
                class="absolute top-0 left-0 w-full h-full origin-center"
                :style="{ transform: `rotate(${i * 45}deg)` }"
              >
                <!-- Segment slice line border -->
                <div class="absolute top-0 left-1/2 w-0.5 h-1/2 bg-slate-800 origin-bottom"></div>
                <!-- Word content label in segment slice -->
                <div class="absolute top-8 left-1/2 -translate-x-1/2 text-center select-none" style="transform: rotate(22.5deg); transform-origin: top center;">
                  <span class="text-sm font-black tracking-wide" :style="{ color: segmentColors[i % segmentColors.length] }">
                    {{ word.hanzi }}
                  </span>
                </div>
              </div>
            </div>

            <!-- Central Hub Button -->
            <button
              @click="spinWheel"
              :disabled="spinning"
              class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-16 h-16 rounded-full bg-gradient-to-r from-amber-500 to-orange-500 text-slate-950 font-black text-xs border-4 border-slate-900 shadow-xl flex items-center justify-center uppercase tracking-widest cursor-pointer disabled:opacity-50"
            >
              QUAY
            </button>
          </div>

          <!-- Spun Result Visualizer Flashcard -->
          <div v-if="currentWord" class="w-full bg-slate-950/60 border border-slate-800 rounded-2xl p-6 text-center animate-fade-in">
            <span class="text-xs px-2.5 py-0.5 bg-amber-500/10 text-amber-400 border border-amber-500/20 rounded-full font-bold uppercase tracking-wider">
              Từ vựng HSK {{ currentWord.level }}
            </span>
            <!-- Hanzi characters -->
            <h4 class="text-5xl font-black text-white mt-4 tracking-wider font-chinese">{{ currentWord.hanzi }}</h4>
            <!-- Pinyin pronunciation -->
            <p class="text-lg font-bold text-indigo-400 mt-2 font-sans">{{ currentWord.pinyin }}</p>
            <!-- Vietnamese meaning translation -->
            <p class="text-sm text-slate-300 mt-2 font-medium bg-slate-900/60 py-2.5 px-4 rounded-xl border border-slate-800">
              {{ currentWord.meaning }}
            </p>
          </div>
        </div>
      </div>
    </Transition>

    <!-- Vocabulary Set Details Modal -->
    <Transition name="fade">
      <div v-if="selectedSet" class="fixed inset-0 z-50 flex items-center justify-center p-6">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-md" @click="selectedSet = null"></div>

        <!-- Modal Container -->
        <div class="relative bg-slate-900 border border-slate-800 rounded-3xl p-8 max-w-2xl w-full shadow-2xl overflow-hidden flex flex-col">
          <!-- Decor Header Color Bar -->
          <div class="absolute top-0 left-0 right-0 h-2" :style="{ backgroundColor: selectedSet.color }"></div>

          <!-- Close -->
          <button @click="selectedSet = null" class="absolute top-6 right-6 text-slate-500 hover:text-slate-300 transition-colors">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
          </button>

          <!-- Set Meta Header -->
          <div class="flex items-center space-x-4 mt-2">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center font-black text-xl border"
              :style="{
                backgroundColor: selectedSet.color + '15',
                borderColor: selectedSet.color + '30',
                color: selectedSet.color
              }">
              {{ selectedSet.levelCode }}
            </div>
            <div>
              <h3 class="text-xl font-bold text-white">{{ selectedSet.title }}</h3>
              <p class="text-xs text-slate-400 mt-1">{{ selectedSet.subtitle }}</p>
            </div>
          </div>

          <!-- List of groups/chapters -->
          <div class="mt-8 space-y-4 max-h-[350px] overflow-y-auto pr-2">
            <div
              v-for="group in selectedSet.groups"
              :key="group.id"
              @click="startPractice(group.id)"
              class="flex items-center justify-between p-4 bg-slate-950/40 hover:bg-slate-950 border border-slate-800 hover:border-slate-700 rounded-2xl transition duration-150 cursor-pointer group/row"
            >
              <div class="flex items-center space-x-4">
                <div class="w-10 h-10 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center text-xs font-bold text-slate-400">
                  {{ group.index }}
                </div>
                <div>
                  <h5 class="text-sm font-bold text-slate-200 group-hover/row:text-indigo-400 transition-colors">{{ group.name }}</h5>
                  <p class="text-xs text-slate-500 mt-0.5">{{ group.desc }}</p>
                </div>
              </div>
              <div class="flex items-center space-x-3">
                <span v-if="group.learned === group.words && group.words > 0" class="text-xs font-semibold text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 px-2.5 py-1 rounded-xl">
                  Hoàn thành
                </span>
                <span v-else class="text-xs text-slate-400 bg-slate-900 border border-slate-800 px-2.5 py-1 rounded-xl">
                  Đã học {{ group.learned }}/{{ group.words }} từ
                </span>
                <span class="text-slate-600 group-hover/row:text-indigo-400 transition-colors">
                  <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </span>
              </div>
            </div>
          </div>

          <!-- Action Footer -->
          <div class="flex items-center justify-end space-x-3 border-t border-slate-800 pt-6 mt-8">
            <button @click="selectedSet = null" class="px-5 py-2.5 bg-slate-950 border border-slate-800 text-slate-400 hover:text-white rounded-xl text-sm font-semibold cursor-pointer">
              Đóng
            </button>
            <button
              v-if="selectedSet.groups && selectedSet.groups.length > 0"
              @click="startPractice(selectedSet.groups[0].id)"
              class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-sm font-bold shadow-md shadow-indigo-600/10 cursor-pointer"
            >
              Bắt đầu luyện tập
            </button>
          </div>
        </div>
      </div>
    </Transition>

    <!-- Hidden API Response Modal for testing -->
    <Transition name="fade">
      <div v-if="apiResponse" class="fixed inset-0 z-50 flex items-center justify-center p-6">
        <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-md" @click="apiResponse = null"></div>
        <div class="relative bg-slate-900 border border-slate-800 rounded-3xl p-6 max-w-lg w-full shadow-2xl">
          <button @click="apiResponse = null" class="absolute top-6 right-6 text-slate-500 hover:text-slate-300">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
          </button>
          <h4 class="text-base font-bold text-white mb-2">Trạng thái kết nối API</h4>
          <pre class="text-xs font-mono text-slate-300 p-4 bg-slate-950 rounded-xl overflow-x-auto border border-slate-800 mt-4">{{ JSON.stringify(apiResponse, null, 2) }}</pre>
        </div>
      </div>
    </Transition>
  </DashboardLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import DashboardLayout from '@/layouts/DashboardLayout.vue'
import api from '@/services/api'
import type { ApiResponse } from '@/types'

const router = useRouter()

// Vocab sets reactive data
const vocabSets = ref<any[]>([])
const streak = ref(0)
const loading = ref(true)

// Environment/API Check state
const apiResponse = ref<any>(null)
const testApi = async () => {
  try {
    const response = await api.get('/profile')
    apiResponse.value = response.data
  } catch (error: any) {
    apiResponse.value = error.response ? error.response.data : { success: false, message: error.message }
  }
}

// Calculate total words learned across all sets
const totalWordsLearned = computed(() => {
  return vocabSets.value.reduce((sum, set) => sum + (set.learnedCount || 0), 0)
})

// Fetch all vocab sets from backend
onMounted(async () => {
  try {
    const response = await api.get<ApiResponse<any>>('/vocab-sets')
    vocabSets.value = response.data.data.sets
    streak.value = response.data.data.streak
  } catch (error) {
    console.error('Failed to load vocab sets from API:', error)
  } finally {
    loading.value = false
  }
})

// Navigation to Practice
const startPractice = (groupId: number) => {
  selectedSet.value = null
  router.push(`/practice/${groupId}`)
}

// Week Tracker
const weekDays = [
  { label: 'T2', date: '29', isToday: true },
  { label: 'T3', date: '30', isToday: false },
  { label: 'T4', date: '01', isToday: false },
  { label: 'T5', date: '02', isToday: false },
  { label: 'T6', date: '03', isToday: false },
  { label: 'T7', date: '04', isToday: false },
  { label: 'CN', date: '05', isToday: false },
]

// Leaderboard list
const leaderboardPeriod = ref('week')
const leaderboardUsers = [
  // Week data
  { name: 'thanhvi', sessions: 4, words: 38, isCurrent: false, period: 'week' },
  { name: 'Lê Khánh', sessions: 3, words: 25, isCurrent: true, period: 'week' },
  { name: 'Hoàng Trần', sessions: 2, words: 18, isCurrent: false, period: 'week' },
  // Month data
  { name: 'thanhvi', sessions: 18, words: 198, isCurrent: false, period: 'month' },
  { name: 'Lê Khánh', sessions: 15, words: 154, isCurrent: true, period: 'month' },
  { name: 'Nguyễn Tiến', sessions: 12, words: 110, isCurrent: false, period: 'month' },
  // All data
  { name: 'thanhvi', sessions: 48, words: 540, isCurrent: false, period: 'all' },
  { name: 'Lê Khánh', sessions: 42, words: 482, isCurrent: true, period: 'all' },
  { name: 'Nguyễn Tiến', sessions: 35, words: 390, isCurrent: false, period: 'all' },
]

const filteredLeaderboard = computed(() => {
  return leaderboardUsers.filter(u => u.period === leaderboardPeriod.value)
})

// Modal Set Details Interaction
const selectedSet = ref<any | null>(null)
const openSetDetails = (set: any) => {
  selectedSet.value = set
}

// Spin & Learn Interaction
const showWheelModal = ref(false)
const spinning = ref(false)
const wheelAngle = ref(0)
const currentWord = ref<any>(null)

const spinnerWords = [
  { hanzi: '学习', pinyin: 'Xuéxí', meaning: 'Học tập / Nghiên cứu', level: '1' },
  { hanzi: '朋友', pinyin: 'Péngyǒu', meaning: 'Bạn bè / Chiến hữu', level: '1' },
  { hanzi: '喜欢', pinyin: 'Xǐhuan', meaning: 'Thích / Ưa chuộng', level: '1' },
  { hanzi: '汉字', pinyin: 'Hànzì', meaning: 'Chữ Hán / Hán tự', level: '2' },
  { hanzi: '舒服', pinyin: 'Shūfu', meaning: 'Dễ chịu / Thoải mái', level: '3' },
  { hanzi: '机会', pinyin: 'Jīhuì', meaning: 'Cơ hội / Thời cơ', level: '4' },
  { hanzi: '精彩', pinyin: 'Jīngcǎi', meaning: 'Tuyệt vời / Đặc sắc', level: '5' },
  { hanzi: '幽默', pinyin: 'Yōumò', meaning: 'Hài hước / Hóm hỉnh', level: '6' },
]

const segmentColors = ['#10B981', '#3B82F6', '#F59E0B', '#F97316', '#8B5CF6', '#EC4899', '#06B6D4', '#6366F1']

const openWheel = () => {
  showWheelModal.value = true
  currentWord.value = null
}

const closeWheel = () => {
  if (spinning.value) return // Prevent closing while spinning
  showWheelModal.value = false
}

const spinWheel = () => {
  if (spinning.value) return
  spinning.value = true
  currentWord.value = null

  // Calculate random rotations and offset (random slice index from 0 to 7)
  const randomIndex = Math.floor(Math.random() * spinnerWords.length)
  
  // Cumulative angle calculation.
  // Wheel moves counter-clockwise to index selection.
  // Target segment position angle: segment angle is 360 - (index * 45) - 22.5 (center of segment)
  const targetAngle = 360 - (randomIndex * 45) - 22.5
  
  // Total spins (min 4 full spins = 1440 degrees)
  const spins = 1440
  const totalRotation = wheelAngle.value + spins + targetAngle - (wheelAngle.value % 360)

  wheelAngle.value = totalRotation

  setTimeout(() => {
    spinning.value = false
    currentWord.value = spinnerWords[randomIndex]
  }, 4000) // Duration of CSS spin transition
}
</script>

<style scoped>
.cubic-bezier-out-back {
  transition-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1.1);
}

.duration-4000 {
  transition-duration: 4000ms;
}

.animate-spin-slow {
  animation: spin 8s linear infinite;
}

@keyframes spin {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}

.animate-fade-in {
  animation: fadeIn 0.4s ease-out forwards;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.25s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.font-chinese {
  font-family: 'Noto Sans SC', 'Microsoft YaHei', sans-serif;
}
</style>

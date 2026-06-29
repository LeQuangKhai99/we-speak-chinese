<template>
  <DashboardLayout>
    <div class="space-y-8 pb-12 max-w-2xl mx-auto">
      <!-- Header Section -->
      <div class="border-b border-slate-800 pb-5 flex items-center justify-between">
        <div>
          <h2 class="text-2xl font-black text-white">Luyện Nghe Tả Tranh</h2>
          <p class="text-xs text-slate-400 mt-1">Luyện tập nghe mô tả và chọn câu trả lời mô tả chính xác nhất bức tranh</p>
        </div>
      </div>

      <!-- Test Status / Stats Bar -->
      <div v-if="questions.length > 0 && !testFinished" class="bg-slate-900/60 border border-slate-850 p-4 rounded-2xl flex items-center justify-between">
        <span class="text-sm font-bold text-slate-300">
          Câu hỏi {{ currentQuizIndex + 1 }} / {{ questions.length }}
        </span>

        <div class="flex items-center space-x-3">
          <span class="text-xs px-3 py-1.5 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 rounded-xl font-bold">
            Đúng: {{ correctCount }}
          </span>
          <span class="text-xs px-3 py-1.5 bg-rose-500/10 text-rose-400 border border-rose-500/20 rounded-xl font-bold">
            Sai: {{ wrongCount }}
          </span>
        </div>
      </div>

      <!-- Main Question Container -->
      <div v-if="loading" class="py-20 text-center">
        <div class="w-8 h-8 border-4 border-indigo-500/20 border-t-indigo-500 rounded-full animate-spin mx-auto mb-3"></div>
        <p class="text-xs text-slate-500">Đang tải đề thi HSK...</p>
      </div>

      <!-- Completed Screen -->
      <div v-else-if="testFinished" class="bg-slate-900/40 border border-slate-800 rounded-3xl p-8 text-center space-y-6 animate-fade-in shadow-2xl">
        <div class="w-20 h-20 bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 rounded-full flex items-center justify-center text-4xl mx-auto shadow-lg shadow-indigo-500/5">
          🏆
        </div>
        <div>
          <h2 class="text-2xl font-black text-white">Hoàn thành bài luyện nghe!</h2>
          <p class="text-sm text-slate-400 mt-2">
            Bạn đã hoàn thành xuất sắc tất cả các câu hỏi nghe tả tranh HSK Part 1.
          </p>
        </div>

        <div class="grid grid-cols-2 gap-4 max-w-sm mx-auto pt-2">
          <div class="bg-slate-950 border border-slate-850 p-4 rounded-2xl">
            <span class="text-xs text-slate-500 font-semibold block uppercase">Đúng</span>
            <span class="text-2xl font-black text-emerald-400 block mt-1">{{ correctCount }}</span>
          </div>
          <div class="bg-slate-950 border border-slate-850 p-4 rounded-2xl">
            <span class="text-xs text-slate-500 font-semibold block uppercase">Sai</span>
            <span class="text-2xl font-black text-rose-400 block mt-1">{{ wrongCount }}</span>
          </div>
        </div>

        <button
          @click="restartTest"
          class="px-8 py-3.5 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-2xl text-sm transition-all shadow-lg shadow-indigo-600/20 cursor-pointer"
        >
          Luyện tập lại
        </button>
      </div>

      <!-- Question Active Board -->
      <div v-else-if="currentQuestion" class="space-y-6 animate-fade-in">
        <!-- Photo display -->
        <div class="relative w-full h-80 bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-xl flex items-center justify-center">
          <img
            :src="currentQuestion.image_path"
            class="w-full h-full object-cover"
            alt="HSK Tả Tranh"
          />
        </div>

        <!-- Audio Player Timeline component -->
        <div class="bg-slate-900/40 border border-slate-800 rounded-2xl p-4 flex items-center space-x-4 shadow-md">
          <!-- Play / Pause btn -->
          <button
            @click="toggleAudio"
            class="w-12 h-12 shrink-0 bg-indigo-600 hover:bg-indigo-500 text-white rounded-full flex items-center justify-center transition duration-150 cursor-pointer shadow-md shadow-indigo-600/10"
          >
            <svg v-if="!isPlaying" class="w-5 h-5 fill-current ml-0.5" viewBox="0 0 24 24">
              <path d="M8 5v14l11-7z" />
            </svg>
            <svg v-else class="w-5 h-5 fill-current" viewBox="0 0 24 24">
              <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z" />
            </svg>
          </button>

          <!-- Timeline Slider -->
          <div class="flex-1 space-y-1">
            <div class="w-full bg-slate-950 h-1.5 border border-slate-800 rounded-full overflow-hidden relative">
              <div
                class="h-full bg-indigo-500 transition-all duration-100"
                :style="{ width: `${(audioProgress / audioDuration) * 100}%` }"
              ></div>
            </div>
            <div class="flex items-center justify-between text-[10px] text-slate-500 font-bold font-mono">
              <span>0:0{{ Math.floor(audioProgress) }}</span>
              <span>0:05</span>
            </div>
          </div>
        </div>

        <!-- Prompt Text -->
        <div class="text-center font-bold text-slate-300 text-sm py-2">
          🎧 Nghe và chọn đúng mô tả về bức ảnh
        </div>

        <!-- Multiple Choice Options -->
        <div class="grid grid-cols-1 gap-3">
          <button
            v-for="opt in ['A', 'B', 'C', 'D']"
            :key="opt"
            @click="selectOption(opt)"
            :disabled="selectedOption !== null"
            class="w-full p-4 rounded-2xl border text-left text-sm font-semibold transition duration-150 flex items-center justify-between cursor-pointer"
            :class="getOptionClass(opt)"
          >
            <div class="flex items-center space-x-3">
              <span class="w-6 h-6 rounded-full bg-slate-950 border border-slate-800 flex items-center justify-center text-xs font-bold"
                :class="selectedOption === opt ? 'bg-indigo-600 border-indigo-500 text-white' : 'text-slate-400'">
                {{ opt }}
              </span>
              <span class="font-chinese">{{ getOptionText(opt) }}</span>
            </div>

            <!-- Result icon -->
            <span v-if="selectedOption !== null">
              <svg v-if="opt === currentQuestion.correct_option" class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
              </svg>
              <svg v-else-if="opt === selectedOption && opt !== currentQuestion.correct_option" class="w-5 h-5 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </span>
          </button>
        </div>

        <!-- Option Feedback block -->
        <Transition name="fade">
          <div v-if="selectedOption !== null" class="rounded-2xl p-5 border text-left"
            :class="isCorrect ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-rose-500/10 border-rose-500/20 text-rose-400'">
            <div class="flex items-center justify-between">
              <span class="text-xs font-bold uppercase tracking-wider">
                {{ isCorrect ? 'Chính xác!' : 'Rất tiếc, chưa đúng!' }}
              </span>
              <button
                @click="speak(currentQuestion.audio_text)"
                class="w-8 h-8 rounded-lg bg-slate-950 hover:bg-slate-800 border border-slate-800 text-indigo-400 hover:text-white flex items-center justify-center cursor-pointer transition"
                title="Đọc lại đáp án đúng"
              >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                </svg>
              </button>
            </div>
            <!-- Solution details -->
            <p class="font-chinese font-bold text-white mt-3 text-lg leading-relaxed">{{ currentQuestion.audio_text }}</p>
            <p class="text-sm font-medium mt-1 text-slate-300">
              Dịch nghĩa: {{ getCorrectOptionMeaning() }}
            </p>
          </div>
        </Transition>

        <!-- Navigation Footer -->
        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-900">
          <button
            @click="resetSelection"
            :disabled="selectedOption === null"
            class="px-5 py-3 bg-slate-950 border border-slate-800 hover:border-slate-700 text-slate-400 hover:text-white rounded-xl text-sm font-semibold cursor-pointer disabled:opacity-40"
          >
            Làm lại
          </button>
          <button
            @click="nextQuestion"
            :disabled="selectedOption === null"
            class="px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl text-sm transition-all shadow-lg shadow-indigo-600/10 cursor-pointer disabled:opacity-40"
          >
            {{ currentQuizIndex === questions.length - 1 ? 'Xem kết quả' : 'Câu tiếp' }}
          </button>
        </div>
      </div>
    </div>
  </DashboardLayout>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import DashboardLayout from '@/layouts/DashboardLayout.vue'
import api from '@/services/api'
import type { ApiResponse } from '@/types'

// States
const questions = ref<any[]>([])
const loading = ref(true)
const currentQuizIndex = ref(0)
const selectedOption = ref<string | null>(null)
const testFinished = ref(false)

// Scores
const correctCount = ref(0)
const wrongCount = ref(0)

// Audio simulation states
const isPlaying = ref(false)
const audioProgress = ref(0)
const audioDuration = 5 // HSK audio reads sentence typically takes ~5s
let audioInterval: any = null

const currentQuestion = computed(() => {
  return questions.value[currentQuizIndex.value] || null
})

const isCorrect = computed(() => {
  if (selectedOption.value === null || !currentQuestion.value) return false
  return selectedOption.value === currentQuestion.value.correct_option
})

// Fetch listening tests
onMounted(async () => {
  try {
    const response = await api.get<ApiResponse<any[]>>('/hsk-listening-tests')
    questions.value = response.data.data
  } catch (error) {
    console.error('Failed to load listening tests:', error)
  } finally {
    loading.value = false
  }
})

// Audio control functions
const toggleAudio = () => {
  if (!currentQuestion.value) return
  
  if (isPlaying.value) {
    pauseAudio()
  } else {
    playAudio()
  }
}

const playAudio = () => {
  isPlaying.value = true
  // Speak using Speech Synthesis
  speak(currentQuestion.value.audio_text)

  // Start ticker timeline animation
  if (audioProgress.value >= audioDuration) {
    audioProgress.value = 0
  }

  audioInterval = setInterval(() => {
    if (audioProgress.value < audioDuration) {
      audioProgress.value += 0.2
    } else {
      pauseAudio()
      audioProgress.value = audioDuration
    }
  }, 200)
}

const pauseAudio = () => {
  isPlaying.value = false
  if ('speechSynthesis' in window) {
    window.speechSynthesis.cancel()
  }
  if (audioInterval) {
    clearInterval(audioInterval)
    audioInterval = null
  }
}

const speak = (text: string) => {
  if ('speechSynthesis' in window) {
    window.speechSynthesis.cancel()
    const utterance = new SpeechSynthesisUtterance(text)
    utterance.lang = 'zh-CN'
    window.speechSynthesis.speak(utterance)
  }
}

// Option selector helpers
const getOptionText = (opt: string) => {
  if (!currentQuestion.value) return ''
  return currentQuestion.value[`option_${opt.toLowerCase()}`]
}

const getCorrectOptionMeaning = () => {
  if (!currentQuestion.value) return ''
  const opt = currentQuestion.value.correct_option.toLowerCase()
  return currentQuestion.value[`option_${opt}_meaning`]
}

const selectOption = (opt: string) => {
  selectedOption.value = opt
  pauseAudio()

  if (opt === currentQuestion.value.correct_option) {
    correctCount.value++
  } else {
    wrongCount.value++
  }
}

const getOptionClass = (opt: string) => {
  if (selectedOption.value === null) {
    return 'bg-slate-950 hover:bg-slate-900 border-slate-800 text-slate-300 hover:text-white'
  }
  
  // Highlighting correct choice
  if (opt === currentQuestion.value.correct_option) {
    return 'bg-emerald-500/10 border-emerald-500/30 text-emerald-400'
  }

  // Highlighting wrong selection
  if (opt === selectedOption.value) {
    return 'bg-rose-500/10 border-rose-500/30 text-rose-400'
  }

  return 'bg-slate-950 border-slate-900 text-slate-650 opacity-40'
}

// Control buttons
const resetSelection = () => {
  selectedOption.value = null
  audioProgress.value = 0
}

const nextQuestion = () => {
  selectedOption.value = null
  audioProgress.value = 0
  
  if (currentQuizIndex.value < questions.value.length - 1) {
    currentQuizIndex.value++
  } else {
    testFinished.value = true
  }
}

const restartTest = () => {
  currentQuizIndex.value = 0
  correctCount.value = 0
  wrongCount.value = 0
  selectedOption.value = null
  testFinished.value = false
  audioProgress.value = 0
}
</script>

<style scoped>
.font-chinese {
  font-family: 'Noto Sans SC', 'Microsoft YaHei', sans-serif;
}
.animate-fade-in {
  animation: fadeIn 0.4s ease-out forwards;
}
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(8px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>

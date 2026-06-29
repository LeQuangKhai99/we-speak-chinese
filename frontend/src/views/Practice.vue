<template>
  <div class="min-h-screen bg-slate-950 text-slate-100 flex flex-col justify-between">
    <!-- Header -->
    <header class="h-16 border-b border-slate-800 bg-slate-900/30 backdrop-blur-md flex items-center justify-between px-6">
      <div class="flex items-center space-x-4">
        <button
          @click="handleBack"
          class="p-2 text-slate-400 hover:text-white hover:bg-slate-800 rounded-xl transition duration-150 cursor-pointer"
        >
          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
        </button>
        <span class="text-sm font-bold text-slate-200">Phòng luyện tập</span>
      </div>

      <!-- Header progress indicators -->
      <div v-if="step !== 'completed'" class="flex items-center space-x-3 text-xs text-slate-400 font-semibold bg-slate-950 px-3.5 py-1.5 rounded-full border border-slate-800">
        <span class="uppercase tracking-wider">{{ step === 'flashcards' ? 'Thẻ ghi nhớ' : 'Trắc nghiệm' }}</span>
        <span class="text-slate-700">|</span>
        <span v-if="step === 'flashcards'">Thẻ {{ currentIndex + 1 }} / {{ words.length }}</span>
        <span v-else-if="step === 'quiz'">Câu {{ currentQuizIndex + 1 }} / {{ quizQuestions.length }}</span>
      </div>
    </header>

    <!-- Main Container -->
    <main class="flex-1 max-w-xl w-full mx-auto px-6 py-12 flex flex-col justify-center">
      <div v-if="loading" class="text-center py-20">
        <div class="w-10 h-10 border-4 border-indigo-500/20 border-t-indigo-500 rounded-full animate-spin mx-auto mb-4"></div>
        <p class="text-slate-400 text-sm">Đang tải danh sách từ vựng...</p>
      </div>

      <!-- Step 1: Flashcards -->
      <div v-else-if="step === 'flashcards' && currentWord" class="space-y-8 animate-fade-in">
        <!-- Flashcard (Flip Card) -->
        <div
          @click="flipCard"
          class="relative h-80 w-full bg-slate-900 border border-slate-800 hover:border-slate-700 rounded-3xl cursor-pointer transition-all duration-300 shadow-2xl overflow-hidden select-none flex flex-col items-center justify-center p-8 text-center"
        >
          <!-- Accent Line -->
          <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>

          <!-- Flip Helper Badge -->
          <div class="absolute bottom-6 text-[10px] uppercase tracking-widest text-slate-500 font-bold">
            Chạm thẻ để lật nghĩa
          </div>

          <!-- Speech Audio Button -->
          <button
            @click.stop="speak((isFlipped && currentWord.example) ? currentWord.example : currentWord.hanzi)"
            class="absolute top-6 right-6 w-10 h-10 bg-slate-950 hover:bg-slate-800 border border-slate-800 hover:border-slate-700 rounded-xl flex items-center justify-center text-slate-400 hover:text-white transition cursor-pointer"
            :title="isFlipped ? 'Đọc câu ví dụ' : 'Phát âm từ'"
          >
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
            </svg>
          </button>

          <!-- Card Front: Hanzi -->
          <div v-if="!isFlipped" class="space-y-2">
            <h2 class="text-6xl font-black text-white tracking-wider font-chinese">{{ currentWord.hanzi }}</h2>
            <p class="text-sm text-slate-500 mt-2">Chạm để xem giải nghĩa</p>
          </div>

          <!-- Card Back: Pinyin & Meaning -->
          <div v-else class="space-y-4 w-full">
            <div>
              <span class="text-sm font-bold text-indigo-400 uppercase tracking-widest">{{ currentWord.pinyin }}</span>
              <h3 class="text-3xl font-black text-white mt-1">{{ currentWord.meaning }}</h3>
            </div>
            
            <!-- Example sentence block -->
            <div v-if="currentWord.example" class="bg-slate-950/80 border border-slate-800/80 rounded-2xl p-4 text-left max-w-sm mx-auto">
              <p class="text-sm font-semibold text-slate-200 font-chinese leading-relaxed flex items-center justify-between">
                <span>{{ currentWord.example }}</span>
                <button
                  @click.stop="speak(currentWord.example)"
                  class="p-1.5 bg-slate-900 border border-slate-800 hover:bg-slate-800 text-slate-400 hover:text-white rounded-lg transition cursor-pointer shrink-0 ml-2"
                  title="Speak Sentence"
                >
                  <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                  </svg>
                </button>
              </p>
              <p class="text-xs text-indigo-400 mt-0.5">{{ currentWord.example_pinyin }}</p>
              <p class="text-[11px] text-slate-400 mt-1 border-t border-slate-800/50 pt-1">{{ currentWord.example_meaning }}</p>
            </div>
          </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex items-center justify-between gap-4">
          <button
            @click="prevCard"
            :disabled="currentIndex === 0"
            class="px-5 py-3 bg-slate-950 border border-slate-800 disabled:opacity-30 text-slate-300 hover:text-white rounded-xl text-sm font-semibold cursor-pointer"
          >
            Lùi lại
          </button>
          
          <button
            @click="nextCard"
            class="px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-sm font-bold shadow-lg shadow-indigo-600/10 cursor-pointer"
          >
            {{ currentIndex === words.length - 1 ? 'Làm trắc nghiệm' : 'Thẻ tiếp theo' }}
          </button>
        </div>
      </div>

      <!-- Step 2: Interactive Quiz -->
      <div v-else-if="step === 'quiz' && currentQuestion" class="space-y-6 animate-fade-in">
        <!-- Question Card -->
        <div class="bg-slate-900 border border-slate-800 rounded-3xl p-8 text-center relative overflow-hidden shadow-xl">
          <div class="absolute top-0 left-0 right-0 h-1 bg-slate-800">
            <!-- Progress Bar -->
            <div class="h-full bg-indigo-500 transition-all duration-300" :style="{ width: `${((currentQuizIndex) / quizQuestions.length) * 100}%` }"></div>
          </div>

          <span class="text-[10px] px-2.5 py-0.5 bg-slate-950 text-slate-505 border border-slate-800 rounded-full font-bold uppercase tracking-wider text-indigo-400">
            Thử thách Trắc nghiệm
          </span>

          <h3 class="text-sm font-semibold text-slate-400 mt-4">{{ currentQuestion.questionText }}</h3>
          
          <h2 class="text-5xl font-black text-white mt-2 tracking-wide font-chinese">
            {{ currentQuestion.questionSubject }}
          </h2>
        </div>

        <!-- Options list -->
        <div class="grid grid-cols-1 gap-3.5">
          <button
            v-for="option in currentQuestion.options"
            :key="option"
            @click="selectOption(option)"
            :disabled="quizSelectedOption !== null"
            class="w-full p-4 rounded-2xl text-left text-sm font-semibold border transition duration-150 flex items-center justify-between cursor-pointer"
            :class="getOptionClass(option)"
          >
            <span>{{ option }}</span>
            
            <!-- Result Icons -->
            <span v-if="quizSelectedOption !== null">
              <svg v-if="option === currentQuestion.correctAnswer" class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
              </svg>
              <svg v-else-if="option === quizSelectedOption && option !== currentQuestion.correctAnswer" class="w-5 h-5 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </span>
          </button>
        </div>
      </div>

      <!-- Step 3: Completed Screen -->
      <div v-else-if="step === 'completed'" class="space-y-8 text-center animate-fade-in">
        <div class="bg-slate-900 border border-slate-800 rounded-3xl p-8 shadow-xl space-y-6">
          <div class="w-20 h-20 bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 rounded-full flex items-center justify-center text-4xl mx-auto shadow-lg shadow-indigo-500/5">
            🎉
          </div>
          <div>
            <h2 class="text-2xl font-black text-white">Hoàn thành bài học!</h2>
            <p class="text-sm text-slate-400 mt-1.5 leading-relaxed">
              Chúc mừng! Bạn đã hoàn thành việc ôn tập từ vựng và xuất sắc vượt qua bài test.
            </p>
          </div>

          <!-- Stats Grid -->
          <div class="grid grid-cols-2 gap-4">
            <div class="bg-slate-950 border border-slate-850 p-4 rounded-2xl text-center">
              <span class="text-xs text-slate-500 font-semibold uppercase tracking-wider block">Điểm trắc nghiệm</span>
              <span class="text-2xl font-black text-indigo-400 block mt-1">
                {{ quizScore }} / {{ quizQuestions.length }}
              </span>
            </div>
            <div class="bg-slate-950 border border-slate-850 p-4 rounded-2xl text-center">
              <span class="text-xs text-slate-500 font-semibold uppercase tracking-wider block">Từ đã thuộc</span>
              <span class="text-2xl font-black text-emerald-400 block mt-1">+{{ words.length }}</span>
            </div>
          </div>

          <!-- Synchronizing indicator -->
          <div v-if="savingProgress" class="flex items-center justify-center text-xs text-slate-500 space-x-2">
            <div class="w-4.5 h-4.5 border-2 border-indigo-500/20 border-t-indigo-500 rounded-full animate-spin"></div>
            <span>Đang lưu trữ tiến trình vào đám mây...</span>
          </div>
          <div v-else class="text-xs text-emerald-500 font-semibold flex items-center justify-center space-x-1.5">
            <span>✓</span>
            <span>Tiến độ đã được đồng bộ với máy chủ.</span>
          </div>
        </div>

        <button
          @click="finishSession"
          :disabled="savingProgress"
          class="w-full py-4 bg-indigo-600 hover:bg-indigo-500 disabled:opacity-50 text-white font-bold rounded-2xl text-sm transition shadow-lg shadow-indigo-600/25 cursor-pointer"
        >
          Quay lại Bảng điều khiển
        </button>
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import api from '@/services/api'
import type { ApiResponse } from '@/types'

const route = useRoute()
const router = useRouter()

const groupId = route.params.groupId as string

// States
const loading = ref(true)
const savingProgress = ref(false)
const words = ref<any[]>([])
const step = ref<'flashcards' | 'quiz' | 'completed'>('flashcards')

// Flashcard index
const currentIndex = ref(0)
const isFlipped = ref(false)

const currentWord = computed(() => {
  return words.value[currentIndex.value] || null
})

// Quiz states
const currentQuizIndex = ref(0)
const quizScore = ref(0)
const quizQuestions = ref<any[]>([])
const quizSelectedOption = ref<string | null>(null)

const currentQuestion = computed(() => {
  return quizQuestions.value[currentQuizIndex.value] || null
})

// Web Speech Speech Synthesis
const speak = (text: string) => {
  if ('speechSynthesis' in window) {
    // Cancel any ongoing speaking
    window.speechSynthesis.cancel()
    const utterance = new SpeechSynthesisUtterance(text)
    utterance.lang = 'zh-CN' // Set to Chinese standard
    window.speechSynthesis.speak(utterance)
  }
}

// Fetch vocabulary words inside the group
onMounted(async () => {
  try {
    const response = await api.get<ApiResponse<any[]>>(`/vocab-groups/${groupId}/words`)
    words.value = response.data.data
  } catch (error) {
    console.error('Failed to fetch group vocabularies:', error)
    router.push('/dashboard')
  } finally {
    loading.value = false
  }
})

// Flashcard Actions
const flipCard = () => {
  isFlipped.value = !isFlipped.value
}

const nextCard = () => {
  isFlipped.value = false
  if (currentIndex.value < words.value.length - 1) {
    currentIndex.value++
  } else {
    // Transition to quiz step
    generateQuiz()
    step.value = 'quiz'
  }
}

const prevCard = () => {
  isFlipped.value = false
  if (currentIndex.value > 0) {
    currentIndex.value--
  }
}

// Quiz Generation Helper
const generateQuiz = () => {
  const generated: any[] = []
  
  // Construct a fallback distractor pool from all words
  const distractorPool = words.value.map(w => w.meaning)
  const distractorHanziPool = words.value.map(w => w.hanzi)

  words.value.forEach((word) => {
    // 50% chance of either meaning matching or pinyin matching question types
    const isMeaningQuestion = Math.random() > 0.5
    
    let questionText = ''
    let questionSubject = ''
    let correctAnswer = ''
    let options: string[] = []

    if (isMeaningQuestion) {
      questionText = 'Chọn nghĩa tiếng Việt chính xác của từ:'
      questionSubject = word.hanzi
      correctAnswer = word.meaning

      // Grab 3 random wrong meanings
      const filteredPool = distractorPool.filter(m => m !== correctAnswer)
      const shuffled = filteredPool.sort(() => 0.5 - Math.random()).slice(0, 3)
      options = [...shuffled, correctAnswer].sort(() => 0.5 - Math.random())
    } else {
      questionText = 'Từ nào sau đây mang ý nghĩa và phiên âm:'
      questionSubject = `${word.pinyin} (${word.meaning})`
      correctAnswer = word.hanzi

      // Grab 3 random wrong Hanzis
      const filteredPool = distractorHanziPool.filter(h => h !== correctAnswer)
      const shuffled = filteredPool.sort(() => 0.5 - Math.random()).slice(0, 3)
      options = [...shuffled, correctAnswer].sort(() => 0.5 - Math.random())
    }

    generated.push({
      wordId: word.id,
      questionText,
      questionSubject,
      correctAnswer,
      options
    })
  })

  // Shuffle and limit to max 5 questions
  quizQuestions.value = generated.sort(() => 0.5 - Math.random()).slice(0, 5)
  currentQuizIndex.value = 0
  quizScore.value = 0
}

// Quiz Interaction Actions
const selectOption = (option: string) => {
  quizSelectedOption.value = option
  
  if (option === currentQuestion.value.correctAnswer) {
    quizScore.value++
  }

  // Advance to next question after delay
  setTimeout(async () => {
    quizSelectedOption.value = null
    if (currentQuizIndex.value < quizQuestions.value.length - 1) {
      currentQuizIndex.value++
    } else {
      // Completed, sync with backend
      step.value = 'completed'
      await syncProgress()
    }
  }, 1500)
}

const getOptionClass = (option: string) => {
  if (quizSelectedOption.value === null) {
    return 'bg-slate-950 hover:bg-slate-900 border-slate-800 text-slate-300 hover:text-white'
  }
  
  // Highlighting correct option
  if (option === currentQuestion.value.correctAnswer) {
    return 'bg-emerald-500/10 border-emerald-500/30 text-emerald-400 shadow-md shadow-emerald-500/5'
  }

  // Highlighting wrong selection
  if (option === quizSelectedOption.value) {
    return 'bg-rose-500/10 border-rose-500/30 text-rose-400 shadow-md shadow-rose-500/5'
  }

  return 'bg-slate-950 border-slate-900 text-slate-600 opacity-60'
}

// Sync progress with backend
const syncProgress = async () => {
  savingProgress.value = true
  const vocabIds = words.value.map(w => w.id)
  try {
    await api.post('/user-progress', { vocabulary_ids: vocabIds })
  } catch (error) {
    console.error('Failed to sync user learning progress:', error)
  } finally {
    savingProgress.value = false
  }
}

// Finish session
const finishSession = () => {
  router.push('/dashboard')
}

// Back action
const handleBack = () => {
  if (confirm('Bạn có chắc chắn muốn thoát? Tiến trình luyện tập của nhóm này sẽ không được lưu lại.')) {
    router.push('/dashboard')
  }
}
</script>

<style scoped>
.font-chinese {
  font-family: 'Noto Sans SC', 'Microsoft YaHei', sans-serif;
}

.animate-fade-in {
  animation: fadeIn 0.3s ease-out forwards;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(6px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Animations for flips */
.perspective-1000 {
  perspective: 1000px;
}
</style>

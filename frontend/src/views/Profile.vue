<template>
  <DashboardLayout>
    <div class="space-y-8 pb-12">
      <!-- Header Section -->
      <div class="border-b border-slate-800 pb-5">
        <h2 class="text-2xl font-black text-white">Thống Kê & Cá Nhân</h2>
        <p class="text-xs text-slate-400 mt-1">Theo dõi tiến độ học tập và tạo danh sách từ vựng cá nhân của bạn</p>
      </div>

      <!-- Stats Grid -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Stat Item: Standard Vocab -->
        <div class="bg-slate-900/40 border border-slate-800 rounded-3xl p-6 flex items-center space-x-4">
          <div class="w-12 h-12 bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 rounded-2xl flex items-center justify-center text-xl font-bold">
            📚
          </div>
          <div>
            <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wider block">Từ vựng hệ thống</span>
            <span class="text-2xl font-black text-white block mt-0.5">{{ stats.learned_words_count }} từ</span>
            <span class="text-[10px] text-slate-400 block mt-0.5">Đã ghi nhớ thành công</span>
          </div>
        </div>

        <!-- Stat Item: Custom Vocab -->
        <div class="bg-slate-900/40 border border-slate-800 rounded-3xl p-6 flex items-center space-x-4">
          <div class="w-12 h-12 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-2xl flex items-center justify-center text-xl font-bold">
            ✍️
          </div>
          <div>
            <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wider block">Từ vựng cá nhân</span>
            <span class="text-2xl font-black text-white block mt-0.5">{{ stats.custom_vocab_count }} từ</span>
            <span class="text-[10px] text-slate-400 block mt-0.5">Người dùng tự tạo thêm</span>
          </div>
        </div>

        <!-- Stat Item: Streak -->
        <div class="bg-slate-900/40 border border-slate-800 rounded-3xl p-6 flex items-center space-x-4">
          <div class="w-12 h-12 bg-amber-500/10 border border-amber-500/20 text-amber-500 rounded-2xl flex items-center justify-center text-xl font-bold animate-pulse">
            🔥
          </div>
          <div>
            <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wider block">Chuỗi ngày học</span>
            <span class="text-2xl font-black text-white block mt-0.5">{{ stats.streak }} ngày</span>
            <span class="text-[10px] text-slate-400 block mt-0.5">Duy trì học tập đều đặn</span>
          </div>
        </div>
      </div>

      <!-- Action Panel & Custom Vocabulary -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Side: Creator Form Button -->
        <div class="lg:col-span-1 space-y-6">
          <div class="bg-slate-900/40 border border-slate-800 rounded-3xl p-6 space-y-5">
            <div>
              <h3 class="font-bold text-white">Quản lý bài học</h3>
              <p class="text-xs text-slate-400 mt-1 leading-relaxed">
                Tự tạo thẻ từ vựng mới để lưu trữ và ôn tập theo ý muốn cá nhân của bạn.
              </p>
            </div>

            <button
              @click="showCreateModal = true"
              class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-2xl shadow-lg shadow-emerald-600/15 transition duration-150 flex items-center justify-center cursor-pointer"
            >
              <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
              </svg>
              Tạo từ vựng riêng
            </button>
          </div>
        </div>

        <!-- Right Side: Custom Vocab Cards List -->
        <div class="lg:col-span-2 space-y-6">
          <div class="border-b border-slate-900 pb-3 flex items-center justify-between">
            <h3 class="font-bold text-white">Danh sách từ đã tạo</h3>
            <span class="text-xs text-slate-400 bg-slate-900 border border-slate-800 px-3 py-1 rounded-xl">
              {{ customWords.length }} từ vựng tự tạo
            </span>
          </div>

          <!-- Loading cards -->
          <div v-if="loadingWords" class="py-12 text-center bg-slate-900/10 border border-slate-850 rounded-2xl">
            <div class="w-6 h-6 border-3 border-indigo-500/20 border-t-indigo-500 rounded-full animate-spin mx-auto mb-2"></div>
            <p class="text-xs text-slate-500">Đang tải thẻ từ vựng...</p>
          </div>

          <!-- Cards grid -->
          <div v-else-if="customWords.length > 0" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div
              v-for="word in customWords"
              :key="word.id"
              class="bg-slate-900/40 border border-slate-800/80 rounded-2xl p-5 flex flex-col justify-between space-y-4 hover:border-slate-700 transition"
            >
              <div class="space-y-1.5">
                <div class="flex items-center justify-between">
                  <h4 class="text-2xl font-bold text-white font-chinese tracking-wide">{{ word.hanzi }}</h4>
                  <button
                    @click="speak(word.hanzi)"
                    class="p-1 bg-slate-950 hover:bg-slate-800 border border-slate-850 text-indigo-400 hover:text-white rounded-lg transition"
                    title="Nghe phát âm"
                  >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                    </svg>
                  </button>
                </div>
                <p class="text-xs font-semibold text-indigo-400 font-sans">{{ word.pinyin }}</p>
                <p class="text-sm text-slate-200 mt-1 font-semibold">{{ word.meaning }}</p>
              </div>

              <!-- Optional example -->
              <div v-if="word.example" class="bg-slate-950/50 border border-slate-900 p-3 rounded-xl text-left">
                <p class="text-xs font-semibold text-slate-300 font-chinese">{{ word.example }}</p>
                <p class="text-[10px] text-indigo-400/90 font-sans mt-0.5">{{ word.example_pinyin }}</p>
                <p class="text-[10px] text-slate-400 mt-1 pt-1 border-t border-slate-900/60">{{ word.example_meaning }}</p>
              </div>
            </div>
          </div>

          <!-- Empty list -->
          <div v-else class="py-16 text-center border border-dashed border-slate-850 rounded-2xl bg-slate-900/10">
            <p class="text-slate-500 text-xs">Bạn chưa tạo thẻ từ vựng riêng nào. Hãy nhấn "Tạo từ vựng riêng" phía bên trái!</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Create Custom Word Dialog Modal -->
    <Transition name="fade">
      <div v-if="showCreateModal" class="fixed inset-0 z-50 flex items-center justify-center p-6">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-md" @click="showCreateModal = false"></div>

        <!-- Dialog Content -->
        <div class="relative bg-slate-900 border border-slate-800 rounded-3xl p-8 max-w-md w-full shadow-2xl space-y-6">
          <button @click="showCreateModal = false" class="absolute top-6 right-6 text-slate-500 hover:text-slate-300">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
          </button>

          <div>
            <h3 class="text-lg font-bold text-white">Thêm Từ Vựng Mới</h3>
            <p class="text-xs text-slate-400 mt-1">Nhập thông tin từ vựng của bạn để ghi nhớ</p>
          </div>

          <!-- Form inputs -->
          <form @submit.prevent="saveWord" class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label for="hanzi" class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5">Chữ Hán</label>
                <input
                  id="hanzi"
                  v-model="form.hanzi"
                  type="text"
                  required
                  placeholder="学习"
                  class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-sm text-slate-100 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                />
              </div>

              <div>
                <label for="pinyin" class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5">Phiên âm</label>
                <input
                  id="pinyin"
                  v-model="form.pinyin"
                  type="text"
                  required
                  placeholder="xuéxí"
                  class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-sm text-slate-100 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                />
              </div>
            </div>

            <div>
              <label for="meaning" class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5">Nghĩa tiếng Việt</label>
              <input
                id="meaning"
                v-model="form.meaning"
                type="text"
                required
                placeholder="Học tập / Nghiên cứu"
                class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-sm text-slate-100 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
              />
            </div>

            <!-- Example Section -->
            <div class="border-t border-slate-850 pt-4 space-y-4">
              <span class="text-xs font-semibold text-slate-400 block">Ví dụ mẫu (Tùy chọn)</span>
              
              <div>
                <label for="example" class="block text-[10px] font-bold uppercase tracking-wider text-slate-450 mb-1.5">Câu ví dụ</label>
                <input
                  id="example"
                  v-model="form.example"
                  type="text"
                  placeholder="我喜欢学习汉语。"
                  class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-850 rounded-xl text-sm text-slate-100 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                />
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label for="example_pinyin" class="block text-[10px] font-bold uppercase tracking-wider text-slate-450 mb-1.5">Phiên âm ví dụ</label>
                  <input
                    id="example_pinyin"
                    v-model="form.example_pinyin"
                    type="text"
                    placeholder="Wǒ xǐhuan xuéxí Hànyǔ."
                    class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-850 rounded-xl text-sm text-slate-100 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                  />
                </div>

                <div>
                  <label for="example_meaning" class="block text-[10px] font-bold uppercase tracking-wider text-slate-450 mb-1.5">Dịch nghĩa ví dụ</label>
                  <input
                    id="example_meaning"
                    v-model="form.example_meaning"
                    type="text"
                    placeholder="Tôi thích học tiếng Trung."
                    class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-850 rounded-xl text-sm text-slate-100 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                  />
                </div>
              </div>
            </div>

            <!-- Action buttons -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-850">
              <button
                type="button"
                @click="showCreateModal = false"
                class="px-5 py-2.5 bg-slate-950 border border-slate-800 text-slate-400 hover:text-white rounded-xl text-xs font-semibold cursor-pointer"
              >
                Hủy bỏ
              </button>
              <button
                type="submit"
                :disabled="saving"
                class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-bold shadow-md shadow-indigo-600/10 cursor-pointer disabled:opacity-40"
              >
                {{ saving ? 'Đang lưu...' : 'Thêm từ' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </Transition>
  </DashboardLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import DashboardLayout from '@/layouts/DashboardLayout.vue'
import api from '@/services/api'
import type { ApiResponse } from '@/types'

// Stats
const stats = ref({
  learned_words_count: 0,
  custom_vocab_count: 0,
  streak: 0,
})

// Custom vocab
const customWords = ref<any[]>([])
const loadingWords = ref(true)
const showCreateModal = ref(false)
const saving = ref(false)

const form = ref({
  hanzi: '',
  pinyin: '',
  meaning: '',
  example: '',
  example_pinyin: '',
  example_meaning: '',
})

// Load user stats and custom vocab
onMounted(async () => {
  await fetchStats()
  await fetchCustomWords()
})

const fetchStats = async () => {
  try {
    const response = await api.get<ApiResponse<any>>('/user-stats')
    stats.value = response.data.data
  } catch (error) {
    console.error('Failed to load stats:', error)
  }
}

const fetchCustomWords = async () => {
  loadingWords.value = true
  try {
    const response = await api.get<ApiResponse<any[]>>('/custom-vocabularies')
    customWords.value = response.data.data
  } catch (error) {
    console.error('Failed to load custom vocab:', error)
  } finally {
    loadingWords.value = false
  }
}

const saveWord = async () => {
  saving.value = true
  try {
    await api.post('/custom-vocabularies', form.value)
    showCreateModal.value = false
    
    // Reset form
    form.value = {
      hanzi: '',
      pinyin: '',
      meaning: '',
      example: '',
      example_pinyin: '',
      example_meaning: '',
    }

    // Refresh data lists
    await fetchStats()
    await fetchCustomWords()
  } catch (error) {
    console.error('Failed to save word:', error)
  } finally {
    saving.value = false
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
</script>

<style scoped>
.font-chinese {
  font-family: 'Noto Sans SC', 'Microsoft YaHei', sans-serif;
}
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.25s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>

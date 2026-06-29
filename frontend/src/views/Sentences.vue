<template>
  <DashboardLayout>
    <div class="space-y-8 pb-12">
      <!-- Header Section -->
      <div class="border-b border-slate-800 pb-5">
        <h2 class="text-2xl font-black text-white">Luyện Mẫu Câu</h2>
        <p class="text-xs text-slate-400 mt-1">Học nói các mẫu câu giao tiếp tiếng Trung thông dụng nhất chia theo chủ đề</p>
      </div>

      <!-- Categories Tabs -->
      <div class="flex items-center space-x-2 border-b border-slate-900 pb-2 overflow-x-auto">
        <button
          v-for="cat in categories"
          :key="cat"
          @click="selectedCategory = cat"
          class="px-5 py-2 text-xs font-bold rounded-full transition-all tracking-wide whitespace-nowrap cursor-pointer"
          :class="selectedCategory === cat ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'bg-slate-900 text-slate-400 hover:text-slate-200 border border-slate-800'"
        >
          {{ cat }}
        </button>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="py-20 text-center">
        <div class="w-8 h-8 border-4 border-indigo-500/20 border-t-indigo-500 rounded-full animate-spin mx-auto mb-3"></div>
        <p class="text-xs text-slate-500">Đang tải danh sách mẫu câu...</p>
      </div>

      <!-- Sentences List -->
      <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div
          v-for="sentence in filteredSentences"
          :key="sentence.id"
          class="bg-slate-900/40 hover:bg-slate-900/80 border border-slate-800 hover:border-slate-700/60 rounded-2xl p-5 flex items-center justify-between transition duration-200 group"
        >
          <div class="space-y-2 flex-1 pr-4">
            <!-- Chinese Characters -->
            <h4 class="text-xl font-bold text-white font-chinese tracking-wide group-hover:text-indigo-400 transition-colors">
              {{ sentence.chinese }}
            </h4>
            <!-- Pinyin -->
            <p class="text-xs font-semibold text-indigo-400 font-sans tracking-wide">
              {{ sentence.pinyin }}
            </p>
            <!-- Vietnamese Meaning -->
            <p class="text-sm text-slate-300 leading-relaxed font-medium bg-slate-950/40 py-1.5 px-3 rounded-lg border border-slate-950">
              {{ sentence.meaning }}
            </p>
          </div>

          <!-- Play button -->
          <button
            @click="speak(sentence.chinese)"
            class="w-12 h-12 shrink-0 bg-slate-950 hover:bg-slate-800 border border-slate-800 hover:border-slate-700 text-indigo-400 hover:text-white rounded-xl flex items-center justify-center transition duration-150 cursor-pointer shadow-md"
            title="Nghe phát âm"
          >
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
            </svg>
          </button>
        </div>
      </div>
    </div>
  </DashboardLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import DashboardLayout from '@/layouts/DashboardLayout.vue'
import api from '@/services/api'
import type { ApiResponse } from '@/types'

const sentences = ref<any[]>([])
const loading = ref(true)
const selectedCategory = ref('Tất cả')

// Fetch sentences on mount
onMounted(async () => {
  try {
    const response = await api.get<ApiResponse<any[]>>('/common-sentences')
    sentences.value = response.data.data
  } catch (error) {
    console.error('Failed to load sentences:', error)
  } finally {
    loading.value = false
  }
})

// Categories filters list
const categories = computed(() => {
  const cats = new Set(sentences.value.map(s => s.category))
  return ['Tất cả', ...Array.from(cats)]
})

// Filter sentences based on active tab
const filteredSentences = computed(() => {
  if (selectedCategory.value === 'Tất cả') {
    return sentences.value
  }
  return sentences.value.filter(s => s.category === selectedCategory.value)
})

// TTS Voice synthesis helper
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
</style>

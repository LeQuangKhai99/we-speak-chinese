<template>
  <DashboardLayout>
    <div class="space-y-8 pb-12">
      <!-- Header Section -->
      <div class="border-b border-slate-800 pb-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
          <h2 class="text-2xl font-black text-white">Video Bài Giảng</h2>
          <p class="text-xs text-slate-400 mt-1">Học tiếng Trung qua các chuỗi video bài giảng tuyển chọn từ cơ bản đến nâng cao</p>
        </div>

        <!-- Level Selector Filter -->
        <div class="flex items-center space-x-2 bg-slate-900 border border-slate-800 p-1.5 rounded-2xl shrink-0">
          <button
            v-for="lvl in ['Tất cả', 'Sơ cấp', 'Trung cấp', 'Cao cấp']"
            :key="lvl"
            @click="selectedLevel = lvl"
            class="px-4 py-2 text-xs font-bold rounded-xl transition duration-150 cursor-pointer"
            :class="selectedLevel === lvl ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-400 hover:text-slate-200'"
          >
            {{ lvl }}
          </button>
        </div>
      </div>

      <!-- Categories Tabs -->
      <div class="flex items-center space-x-2 border-b border-slate-900 pb-2 overflow-x-auto">
        <button
          v-for="cat in ['Tổng hợp', 'Từ vựng', 'Ngữ pháp', 'Luyện nghe', 'Luyện nói']"
          :key="cat"
          @click="selectedCategory = cat"
          class="px-5 py-2.5 text-xs font-bold rounded-full transition-all tracking-wide whitespace-nowrap cursor-pointer"
          :class="selectedCategory === cat ? 'bg-indigo-600 text-white shadow-md' : 'bg-slate-900 text-slate-400 hover:text-slate-200 border border-slate-800'"
        >
          {{ cat }}
        </button>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="py-20 text-center">
        <div class="w-8 h-8 border-4 border-indigo-500/20 border-t-indigo-500 rounded-full animate-spin mx-auto mb-3"></div>
        <p class="text-xs text-slate-505">Đang tải thư viện video...</p>
      </div>

      <!-- Videos Grid -->
      <div v-else-if="filteredVideos.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="video in filteredVideos"
          :key="video.id"
          @click="playVideo(video)"
          class="group bg-slate-900/30 hover:bg-slate-900/60 border border-slate-800 hover:border-slate-700 rounded-2xl overflow-hidden cursor-pointer transition-all duration-300 transform hover:-translate-y-1"
        >
          <!-- Video Thumbnail Image container -->
          <div class="relative aspect-video bg-slate-950 overflow-hidden">
            <img
              :src="video.thumbnail_url"
              class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
              alt="Video Thumbnail"
            />
            
            <!-- Dark overlay & play button -->
            <div class="absolute inset-0 bg-slate-950/40 group-hover:bg-slate-950/20 transition-all flex items-center justify-center">
              <div class="w-12 h-12 rounded-full bg-indigo-600 text-white flex items-center justify-center shadow-lg transform group-hover:scale-110 transition duration-300 shadow-indigo-600/30">
                <svg class="w-5 h-5 fill-current ml-0.5" viewBox="0 0 24 24">
                  <path d="M8 5v14l11-7z" />
                </svg>
              </div>
            </div>

            <!-- Video Count badge -->
            <span class="absolute bottom-3 right-3 bg-slate-950/80 backdrop-blur-md px-2.5 py-1 rounded-lg text-[10px] font-bold text-white border border-slate-800">
              {{ video.video_count }} bài học
            </span>

            <!-- Level badge -->
            <span class="absolute top-3 left-3 px-2 py-0.5 rounded text-[10px] font-black uppercase text-slate-950 shadow-md"
              :style="getLevelBadgeStyle(video.level)">
              {{ video.level === 'Sơ cấp' ? 'SC' : video.level === 'Trung cấp' ? 'TC' : 'CC' }}
            </span>
          </div>

          <!-- Video content text -->
          <div class="p-5 space-y-2">
            <h4 class="text-sm font-bold text-slate-200 group-hover:text-indigo-400 transition-colors line-clamp-2 leading-relaxed">
              {{ video.title }}
            </h4>
            <div class="flex items-center justify-between text-[11px] text-slate-500 font-semibold pt-1 border-t border-slate-900">
              <span>Chủ đề: {{ video.category }}</span>
              <span>Cấp độ HSK: {{ video.level }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty state -->
      <div v-else class="py-20 text-center border border-dashed border-slate-850 rounded-2xl">
        <p class="text-slate-500 text-sm">Không tìm thấy video nào khớp với điều kiện lọc.</p>
      </div>
    </div>

    <!-- Video Modal Player Popup -->
    <Transition name="fade">
      <div v-if="activeVideo" class="fixed inset-0 z-50 flex items-center justify-center p-6">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-slate-950/90 backdrop-blur-md" @click="closeVideo"></div>

        <!-- Video box container -->
        <div class="relative bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden max-w-3xl w-full shadow-2xl flex flex-col">
          <!-- Header title bar -->
          <div class="p-5 border-b border-slate-850 flex items-center justify-between bg-slate-900/60">
            <h3 class="text-sm font-bold text-slate-200 truncate pr-6">{{ activeVideo.title }}</h3>
            <button @click="closeVideo" class="text-slate-400 hover:text-slate-200 cursor-pointer">
              <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>

          <!-- YouTube Embed Iframe container -->
          <div class="aspect-video w-full bg-black">
            <iframe
              :src="`https://www.youtube.com/embed/${activeVideo.youtube_id}?autoplay=1`"
              class="w-full h-full"
              frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen
            ></iframe>
          </div>
        </div>
      </div>
    </Transition>
  </DashboardLayout>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import DashboardLayout from '@/layouts/DashboardLayout.vue'
import api from '@/services/api'
import type { ApiResponse } from '@/types'

// States
const videos = ref<any[]>([])
const loading = ref(true)
const selectedCategory = ref('Tổng hợp')
const selectedLevel = ref('Tất cả')
const activeVideo = ref<any | null>(null)

// Load videos
onMounted(async () => {
  try {
    const response = await api.get<ApiResponse<any[]>>('/video-lectures')
    videos.value = response.data.data
  } catch (error) {
    console.error('Failed to load videos:', error)
  } finally {
    loading.value = false
  }
})

// Filter grid
const filteredVideos = computed(() => {
  return videos.value.filter((vid) => {
    const matchesCat = vid.category === selectedCategory.value
    const matchesLvl = selectedLevel.value === 'Tất cả' || vid.level === selectedLevel.value
    return matchesCat && matchesLvl
  })
})

const playVideo = (vid: any) => {
  activeVideo.value = vid
}

const closeVideo = () => {
  activeVideo.value = null
}

// Level color styling badge helper
const getLevelBadgeStyle = (level: string) => {
  switch (level) {
    case 'Sơ cấp':
      return { backgroundColor: '#10B981' } // emerald
    case 'Trung cấp':
      return { backgroundColor: '#3B82F6' } // blue
    default:
      return { backgroundColor: '#8B5CF6' } // purple
  }
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.25s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>

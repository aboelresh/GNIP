<template>
    <Head title="الرئيسية" />
    <AppLayout>
        <div class="max-w-7xl mx-auto px-4 py-8">

            <!-- Header -->
            <div class="mb-8 flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-2xl font-semibold">آخر القصص</h1>
                    <p class="text-sm mt-1" style="color: var(--muted);">
                        {{ stories.total ?? 0 }} قصة من {{ sourcesCount }} مصدر
                    </p>
                </div>
                <div class="live-badge">
                    <span class="live-dot"></span>
                    مباشر
                </div>
            </div>

            <!-- Category Filters -->
            <div class="flex gap-2 mb-4 flex-wrap">
                <button
                    @click="filterBy('category', null)"
                    class="filter-chip"
                    :class="{ active: !filters.category }"
                >الكل</button>
                <button
                    v-for="cat in categories"
                    :key="cat.slug"
                    @click="filterBy('category', cat.slug)"
                    class="filter-chip"
                    :class="{ active: filters.category === cat.slug }"
                >{{ getCatName(cat.name) }}</button>
            </div>

            <!-- Language Filters -->
            <div class="flex gap-2 mb-8">
                <button
                    v-for="lang in languages"
                    :key="lang.code ?? 'all'"
                    @click="filterBy('language', lang.code)"
                    class="lang-chip"
                    :class="{ active: filters.language === lang.code }"
                >{{ lang.label }}</button>
            </div>

            <!-- Stories Grid -->
            <div v-if="stories.data?.length" class="stories-grid">
                <StoryCard v-for="story in stories.data" :key="story.id" :story="story" />
            </div>

            <div v-else class="empty-state">
                <div class="text-4xl mb-4">📰</div>
                <p style="color: var(--muted);">لا توجد قصص متاحة</p>
            </div>

            <!-- Pagination -->
            <div v-if="stories.last_page > 1" class="flex justify-center gap-2 mt-10 flex-wrap">
                <button
                    v-for="page in stories.last_page"
                    :key="page"
                    @click="goToPage(page)"
                    class="page-btn"
                    :class="{ active: page === stories.current_page }"
                >{{ page }}</button>
            </div>

        </div>
    </AppLayout>
</template>

<script setup>
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import StoryCard from '@/Components/StoryCard.vue'

const props = defineProps({
    stories:      Object,
    categories:   Array,
    sourcesCount: Number,
})

const filters = reactive({
    category: new URLSearchParams(window.location.search).get('category'),
    language: new URLSearchParams(window.location.search).get('language'),
})

const languages = [
    { code: null,  label: 'الكل' },
    { code: 'ar',  label: 'عربي' },
    { code: 'en',  label: 'English' },
    { code: 'fr',  label: 'Français' },
]

function getCatName(name) {
    if (typeof name === 'object') return name?.ar ?? name?.en ?? ''
    return name ?? ''
}

function filterBy(key, value) {
    filters[key] = value
    const params = {}
    if (filters.category) params.category = filters.category
    if (filters.language) params.language = filters.language
    router.get('/', params, { preserveState: true, replace: true })
}

function goToPage(page) {
    const params = { page }
    if (filters.category) params.category = filters.category
    if (filters.language) params.language = filters.language
    router.get('/', params, { preserveState: true })
}
</script>

<style scoped>
.live-badge {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: var(--green);
    background: rgba(63,185,80,0.1);
    border: 1px solid rgba(63,185,80,0.3);
    padding: 4px 12px;
    border-radius: 20px;
}
.live-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--green);
    animation: pulse 2s infinite;
}
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.3; }
}
.filter-chip {
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-family: inherit;
    border: 1px solid var(--border);
    background: transparent;
    color: var(--muted);
    cursor: pointer;
    transition: all 0.15s;
}
.filter-chip:hover, .filter-chip.active {
    border-color: var(--accent);
    color: var(--accent);
    background: rgba(31,111,235,0.1);
}
.lang-chip {
    padding: 4px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-family: inherit;
    border: 1px solid var(--border);
    background: transparent;
    color: var(--muted);
    cursor: pointer;
    transition: all 0.15s;
}
.lang-chip:hover, .lang-chip.active {
    background: var(--surface2);
    color: var(--text);
}
.stories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 16px;
}
.empty-state {
    text-align: center;
    padding: 80px 20px;
}
.page-btn {
    width: 36px; height: 36px;
    border-radius: 6px;
    border: 1px solid var(--border);
    background: transparent;
    color: var(--muted);
    cursor: pointer;
    font-family: inherit;
    font-size: 13px;
    transition: all 0.15s;
}
.page-btn:hover, .page-btn.active {
    background: var(--accent);
    border-color: var(--accent);
    color: #fff;
}
</style>
<template>
    <Head title="النشرات" />
    <AppLayout>
        <div class="max-w-4xl mx-auto px-4 py-8">

            <div class="mb-8">
                <h1 class="text-2xl font-semibold">النشرات الإخبارية</h1>
                <p class="text-sm mt-1" style="color: var(--muted);">
                    نشرات يومية مُولَّدة بالذكاء الاصطناعي
                </p>
            </div>

            <!-- Type Filters -->
            <div class="flex gap-2 mb-8">
                <button
                    v-for="t in types"
                    :key="t.code"
                    @click="filterType(t.code)"
                    class="filter-chip"
                    :class="{ active: currentType === t.code }"
                >{{ t.label }}</button>
            </div>

            <!-- Briefings List -->
            <div v-if="briefings?.length" class="briefings-list">
                <Link
                    v-for="briefing in briefings"
                    :key="briefing.id"
                    :href="`/briefings/${briefing.id}`"
                    class="briefing-card"
                >
                    <div class="briefing-header">
                        <span class="briefing-type">{{ typeLabel(briefing.type) }}</span>
                        <span class="briefing-date">{{ formatDate(briefing.published_at) }}</span>
                    </div>
                    <h2 class="briefing-title">{{ getTitle(briefing.title) }}</h2>
                    <div class="briefing-stats">
                        <span>{{ briefing.stories_count }} قصة</span>
                        <span>{{ briefing.sources_count }} مصدر</span>
                    </div>
                </Link>
            </div>

            <div v-else class="empty-state">
                <div class="text-4xl mb-4">📋</div>
                <p style="color: var(--muted);">لا توجد نشرات متاحة</p>
            </div>

        </div>
    </AppLayout>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
    briefings: Object,
    type: String,
})

const currentType = ref(props.type ?? null)

const types = [
    { code: null,    label: 'الكل' },
    { code: 'daily', label: 'يومية' },
]

function filterType(type) {
    currentType.value = type
    router.get('/briefings', type ? { type } : {}, { replace: true })
}

function typeLabel(type) {
    const map = { daily: 'يومية', weekly: 'أسبوعية', monthly: 'شهرية' }
    return map[type] ?? type
}

function getTitle(title) {
    if (!title) return ''
    if (typeof title === 'object') return title?.ar ?? title?.en ?? ''
    try { return JSON.parse(title)?.ar ?? JSON.parse(title)?.en ?? title }
    catch { return title }
}

function formatDate(date) {
    if (!date) return ''
    return new Date(date).toLocaleDateString('ar-EG', {
        year: 'numeric', month: 'long', day: 'numeric'
    })
}
</script>

<style scoped>
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
.briefings-list { display: flex; flex-direction: column; gap: 12px; }
.briefing-card {
    display: block;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 16px;
    color: var(--text);
    transition: border-color 0.15s;
}
.briefing-card:hover { border-color: var(--accent); }
.briefing-header {
    display: flex; align-items: center;
    justify-content: space-between; margin-bottom: 8px;
}
.briefing-type {
    font-size: 11px; padding: 2px 8px; border-radius: 4px;
    background: rgba(31,111,235,0.15); color: var(--accent);
}
.briefing-date { font-size: 12px; color: var(--muted); }
.briefing-title { font-size: 16px; font-weight: 500; margin: 0 0 10px; line-height: 1.5; }
.briefing-stats { display: flex; gap: 16px; font-size: 12px; color: var(--muted); }
.empty-state { text-align: center; padding: 80px 20px; }
</style>
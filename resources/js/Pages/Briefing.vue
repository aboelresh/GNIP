<template>
    <Head :title="briefing.title ?? 'نشرة إخبارية'" />
    <AppLayout>
        <div class="max-w-3xl mx-auto px-4 py-8">

            <Link href="/briefings" class="back-link">← النشرات</Link>

            <div class="mt-6 mb-4 flex items-center gap-3 flex-wrap">
                <span class="type-badge">{{ typeLabel(briefing.type) }}</span>
                <span class="text-sm" style="color: var(--muted);">{{ formatDate(briefing.published_at) }}</span>
            </div>

            <h1 class="briefing-title">{{ getLocalized(briefing.title) }}</h1>

            <div class="briefing-stats">
                <span>{{ briefing.stories_count }} قصة</span>
                <span>{{ briefing.articles_count }} مقال</span>
                <span>{{ briefing.sources_count }} مصدر</span>
                <span v-if="briefing.period_start">
                    {{ briefing.period_start }} ← {{ briefing.period_end }}
                </span>
            </div>

            <!-- Stories -->
            <div v-if="briefing.stories?.length" class="mt-8">
                <h2 class="section-title">القصص المشمولة</h2>
                <div class="stories-list">
                    <Link
                        v-for="story in briefing.stories"
                        :key="story.slug"
                        :href="`/stories/${story.slug}`"
                        class="story-item"
                    >
                        {{ story.title }}
                    </Link>
                </div>
            </div>

        </div>
    </AppLayout>
</template>

<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

defineProps({ briefing: Object })
const page = usePage()
const locale = computed(() => page.props.locale ?? 'ar')

function getLocalized(field) {
    if (!field) return ''
    if (typeof field === 'object') return field?.[locale.value] ?? field?.ar ?? field?.en ?? ''
    try {
        const parsed = JSON.parse(field)
        return parsed?.[locale.value] ?? parsed?.ar ?? parsed?.en ?? field
    } catch { return field }
}

function typeLabel(type) {
    const map = { daily: 'يومية', weekly: 'أسبوعية', monthly: 'شهرية' }
    return map[type] ?? type
}

function formatDate(date) {
    if (!date) return ''
    return new Date(date).toLocaleDateString('ar-EG', {
        year: 'numeric', month: 'long', day: 'numeric'
    })
}
</script>

<style scoped>
.back-link { font-size: 13px; color: var(--muted); transition: color 0.15s; }
.back-link:hover { color: var(--text); }
.type-badge {
    font-size: 11px; padding: 3px 10px; border-radius: 20px;
    background: rgba(31,111,235,0.15); color: var(--accent);
}
.briefing-title {
    font-size: 22px; font-weight: 600; line-height: 1.5; margin: 8px 0 16px;
}
.briefing-stats {
    display: flex; gap: 16px; flex-wrap: wrap;
    font-size: 13px; color: var(--muted);
    padding-bottom: 24px; border-bottom: 1px solid var(--border);
}
.section-title {
    font-size: 15px; font-weight: 600; color: var(--accent); margin-bottom: 12px;
}
.stories-list { display: flex; flex-direction: column; gap: 8px; }
.story-item {
    display: block;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 12px 16px;
    font-size: 14px;
    color: var(--text);
    transition: border-color 0.15s;
}
.story-item:hover { border-color: var(--accent); }
</style>
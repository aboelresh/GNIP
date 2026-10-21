<template>
    <Link :href="`/stories/${story.slug}`" class="story-card">

        <div class="card-header">
            <span v-if="story.category?.name" class="category-badge">
                {{ getCategoryName(story.category.name) }}
            </span>
            <span class="text-xs" style="color: var(--muted);">
                {{ timeAgo(story.last_updated_at) }}
            </span>
        </div>

        <h2 class="card-title">{{ getTitle(story.title) }}</h2>

        <p v-if="story.summary" class="card-summary">{{ getSummary(story.summary) }}</p>

        <div class="card-footer">
            <div class="flex items-center justify-between">
                <span class="sources-count">
                    {{ story.sources_count ?? story.articles_count ?? 0 }} مصدر
                </span>
                <div class="flex items-center gap-2">
                    <span v-if="story.is_trending" class="trending-badge">🔥 رائج</span>
                    <span v-if="story.evidence_level" class="evidence-badge" :class="`ev-${story.evidence_level}`">
                        {{ evidenceLabel(story.evidence_level) }}
                    </span>
                </div>
            </div>
        </div>

    </Link>
</template>

<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
const props = defineProps({ story: Object })
const page = usePage()
const locale = computed(() => page.props.locale ?? 'ar')

function getCategoryName(name) {
    if (!name) return ''
    const l = locale.value
    if (typeof name === 'object') return name?.[l] ?? name?.ar ?? name?.en ?? ''
    try {
        const parsed = JSON.parse(name)
        return parsed?.[l] ?? parsed?.ar ?? parsed?.en ?? name
    } catch { return name }
}

function getTitle(title) {
    if (!title) return ''
    const l = locale.value
    if (typeof title === 'object') return title?.[l] ?? title?.ar ?? title?.en ?? ''
    try {
        const parsed = JSON.parse(title)
        return parsed?.[l] ?? parsed?.ar ?? parsed?.en ?? title
    } catch { return title }
}

function getSummary(summary) {
    if (!summary) return ''
    const l = locale.value
    if (typeof summary === 'object') return summary?.[l] ?? summary?.ar ?? summary?.en ?? ''
    try {
        const parsed = JSON.parse(summary)
        return parsed?.[l] ?? parsed?.ar ?? parsed?.en ?? summary
    } catch { return summary }
}


function timeAgo(date) {
    if (!date) return ''
    const diff = Date.now() - new Date(date).getTime()
    const mins = Math.floor(diff / 60000)
    const hours = Math.floor(mins / 60)
    const days = Math.floor(hours / 24)
    if (mins < 60) return `منذ ${mins} دقيقة`
    if (hours < 24) return `منذ ${hours} ساعة`
    return `منذ ${days} يوم`
}

function evidenceLabel(level) {
    const map = { low: 'أدلة ضعيفة', medium: 'أدلة متوسطة', high: 'أدلة قوية', very_high: 'موثق' }
    return map[level] ?? ''
}

</script>

<style scoped>
.story-card {
    display: block;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 16px;
    color: var(--text);
    transition: border-color 0.15s, transform 0.1s;
}
.story-card:hover {
    border-color: var(--accent);
    transform: translateY(-1px);
}
.card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
}
.category-badge {
    font-size: 11px;
    padding: 2px 8px;
    border-radius: 4px;
    background: rgba(31,111,235,0.15);
    color: var(--accent);
}
.card-title {
    font-size: 15px;
    font-weight: 500;
    line-height: 1.6;
    margin: 0 0 8px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.card-summary {
    font-size: 13px;
    color: var(--muted);
    line-height: 1.6;
    margin: 0 0 12px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.card-footer { margin-top: auto; }
.sources-count { font-size: 12px; color: var(--muted); }
.trending-badge { font-size: 11px; color: var(--yellow); }
.evidence-badge {
    font-size: 11px;
    padding: 2px 6px;
    border-radius: 4px;
}
.ev-low { background: rgba(248,81,73,0.15); color: var(--red); }
.ev-medium { background: rgba(210,153,34,0.15); color: var(--yellow); }
.ev-high, .ev-very_high { background: rgba(63,185,80,0.15); color: var(--green); }
</style>
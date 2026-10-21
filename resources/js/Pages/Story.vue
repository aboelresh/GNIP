<template>
    <Head :title="story.title_ar ?? story.title" />
    <AppLayout>
        <div class="max-w-4xl mx-auto px-4 py-8">

            <!-- Back -->
            <Link href="/" class="back-link">
                ← العودة للرئيسية
            </Link>

            <!-- Category + Meta -->
            <div class="flex items-center gap-3 mt-6 mb-4 flex-wrap">
                <span v-if="story.category" class="category-badge">
                    {{ story.category.icon }} {{ story.category.name }}
                </span>
                <span class="meta-item">{{ story.sources_count }} مصدر</span>
                <span class="meta-item">{{ story.articles_count }} مقال</span>
                <span v-if="story.is_trending" class="trending">🔥 رائج</span>
                <span v-if="story.evidence_level" class="evidence-badge" :class="`ev-${story.evidence_level}`">
                    {{ evidenceLabel(story.evidence_level) }}
                </span>
            </div>

            <!-- Title -->
            <h1 class="story-title">{{ story.title_ar ?? story.title }}</h1>

            <!-- Summary -->
            <p v-if="story.summary" class="story-summary">{{ story.summary }}</p>

            <!-- What Happened -->
            <div v-if="story.what_happened" class="story-section">
                <h2 class="section-title">ماذا حدث؟</h2>
                <p class="section-body">{{ story.what_happened }}</p>
            </div>

            <!-- What Changed -->
            <div v-if="story.what_changed" class="story-section">
                <h2 class="section-title">ما الجديد؟</h2>
                <p class="section-body">{{ story.what_changed }}</p>
            </div>

            <!-- Sources Agree/Disagree -->
            <div v-if="story.sources_agree || story.sources_disagree" class="sources-analysis">
                <div v-if="story.sources_agree" class="analysis-box agree">
                    <h3>✅ ما تتفق عليه المصادر</h3>
                    <p>{{ story.sources_agree }}</p>
                </div>
                <div v-if="story.sources_disagree" class="analysis-box disagree">
                    <h3>⚠️ ما تختلف فيه المصادر</h3>
                    <p>{{ story.sources_disagree }}</p>
                </div>
            </div>

            <!-- Articles -->
            <div v-if="story.articles?.length" class="mt-8">
                <h2 class="section-title mb-4">التغطيات ({{ story.articles.length }})</h2>
                <div class="articles-list">
                    <a
                        v-for="article in story.articles"
                        :key="article.id"
                        :href="article.url"
                        target="_blank"
                        rel="noopener"
                        class="article-card"
                    >
                        <div class="article-header">
                            <span class="source-name">{{ article.source.name }}</span>
                            <span class="article-date">{{ formatDate(article.published_at) }}</span>
                        </div>
                        <p class="article-title">{{ article.title }}</p>
                        <div class="article-meta">
                            <span class="lang-tag">{{ article.language }}</span>
                            <span v-if="article.source.bias" class="bias-tag">{{ article.source.bias }}</span>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'

defineProps({ story: Object })

function evidenceLabel(level) {
    const map = { low: 'أدلة ضعيفة', medium: 'أدلة متوسطة', high: 'أدلة قوية', very_high: 'موثق' }
    return map[level] ?? ''
}

function formatDate(date) {
    if (!date) return ''
    return new Date(date).toLocaleDateString('ar-EG', {
        year: 'numeric', month: 'short', day: 'numeric'
    })
}
</script>

<style scoped>
.back-link { font-size: 13px; color: var(--muted); transition: color 0.15s; }
.back-link:hover { color: var(--text); }
.category-badge {
    font-size: 12px; padding: 3px 10px; border-radius: 20px;
    background: rgba(31,111,235,0.15); color: var(--accent);
}
.meta-item { font-size: 12px; color: var(--muted); }
.trending { font-size: 12px; color: var(--yellow); }
.evidence-badge {
    font-size: 11px; padding: 2px 8px; border-radius: 4px;
}
.ev-low { background: rgba(248,81,73,0.15); color: var(--red); }
.ev-medium { background: rgba(210,153,34,0.15); color: var(--yellow); }
.ev-high, .ev-very_high { background: rgba(63,185,80,0.15); color: var(--green); }
.story-title {
    font-size: 24px; font-weight: 600; line-height: 1.5; margin: 12px 0 16px;
}
.story-summary {
    font-size: 16px; color: var(--muted); line-height: 1.7; margin-bottom: 24px;
    padding-bottom: 24px; border-bottom: 1px solid var(--border);
}
.story-section { margin-bottom: 24px; }
.section-title { font-size: 15px; font-weight: 600; margin-bottom: 8px; color: var(--accent); }
.section-body { font-size: 14px; color: var(--muted); line-height: 1.7; }
.sources-analysis { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin: 24px 0; }
.analysis-box {
    padding: 16px; border-radius: 8px; font-size: 13px; line-height: 1.6;
}
.analysis-box h3 { font-size: 13px; font-weight: 600; margin: 0 0 8px; }
.analysis-box p { margin: 0; color: var(--muted); }
.agree { background: rgba(63,185,80,0.08); border: 1px solid rgba(63,185,80,0.2); }
.disagree { background: rgba(248,81,73,0.08); border: 1px solid rgba(248,81,73,0.2); }
.articles-list { display: flex; flex-direction: column; gap: 12px; }
.article-card {
    display: block; background: var(--surface); border: 1px solid var(--border);
    border-radius: 8px; padding: 14px; transition: border-color 0.15s;
}
.article-card:hover { border-color: var(--accent); }
.article-header {
    display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;
}
.source-name { font-size: 12px; font-weight: 500; color: var(--accent); }
.article-date { font-size: 11px; color: var(--muted); }
.article-title { font-size: 14px; line-height: 1.5; margin: 0 0 8px; }
.article-meta { display: flex; gap: 8px; }
.lang-tag, .bias-tag {
    font-size: 11px; padding: 2px 6px; border-radius: 4px;
    background: var(--surface2); color: var(--muted);
}
@media (max-width: 640px) {
    .sources-analysis { grid-template-columns: 1fr; }
}
</style>
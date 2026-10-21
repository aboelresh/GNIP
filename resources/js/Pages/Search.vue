<template>
    <Head title="بحث" />
    <AppLayout>
        <div class="max-w-4xl mx-auto px-4 py-8">

            <h1 class="text-2xl font-semibold mb-6">البحث</h1>

            <!-- Search Box -->
            <div class="search-box">
                <input
                    v-model="query"
                    @keyup.enter="search"
                    type="text"
                    class="search-input"
                    placeholder="ابحث في القصص والمقالات..."
                />
                <button @click="search" class="search-btn">بحث</button>
            </div>

            <!-- Results -->
            <div v-if="results" class="mt-8">

                <!-- Stories -->
                <div v-if="results.stories?.length">
                    <h2 class="results-title">القصص ({{ results.stories.length }})</h2>
                    <div class="stories-grid mt-4">
                        <StoryCard v-for="story in results.stories" :key="story.id" :story="story" />
                    </div>
                </div>

                <!-- Articles -->
                <div v-if="results.articles?.length" class="mt-8">
                    <h2 class="results-title">المقالات ({{ results.articles.length }})</h2>
                    <div class="articles-list mt-4">
                        <a
                            v-for="article in results.articles"
                            :key="article.id"
                            :href="article.url"
                            target="_blank"
                            rel="noopener"
                            class="article-card"
                        >
                            <div class="article-source">{{ article.source?.name }}</div>
                            <p class="article-title">{{ article.title }}</p>
                        </a>
                    </div>
                </div>

                <!-- No Results -->
                <div v-if="!results.stories?.length && !results.articles?.length" class="empty-state">
                    <div class="text-4xl mb-4">🔍</div>
                    <p style="color: var(--muted);">لا توجد نتائج لـ "{{ searchedQuery }}"</p>
                </div>

            </div>

            <div v-else-if="searchedQuery" class="empty-state">
                <div class="text-4xl mb-4">🔍</div>
                <p style="color: var(--muted);">لا توجد نتائج</p>
            </div>

        </div>
    </AppLayout>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import StoryCard from '@/Components/StoryCard.vue'

const props = defineProps({
    results: Object,
    query: String,
    categories: Array,
})

const query = ref(props.query ?? '')
const searchedQuery = ref(props.query ?? '')

function search() {
    if (!query.value.trim()) return
    searchedQuery.value = query.value
    router.get('/search', { q: query.value }, { preserveState: true })
}
</script>

<style scoped>
.search-box { display: flex; gap: 8px; }
.search-input {
    flex: 1;
    padding: 12px 16px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 8px;
    color: var(--text);
    font-family: inherit;
    font-size: 15px;
    outline: none;
    transition: border-color 0.15s;
}
.search-input:focus { border-color: var(--accent); }
.search-btn {
    padding: 12px 24px;
    background: var(--accent);
    border: none;
    border-radius: 8px;
    color: #fff;
    font-family: inherit;
    font-size: 14px;
    cursor: pointer;
    transition: opacity 0.15s;
}
.search-btn:hover { opacity: 0.85; }
.results-title { font-size: 16px; font-weight: 500; color: var(--muted); }
.stories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 16px;
}
.articles-list { display: flex; flex-direction: column; gap: 10px; }
.article-card {
    display: block;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 14px;
    transition: border-color 0.15s;
}
.article-card:hover { border-color: var(--accent); }
.article-source { font-size: 11px; color: var(--accent); margin-bottom: 6px; }
.article-title { font-size: 14px; line-height: 1.5; margin: 0; color: var(--text); }
.empty-state { text-align: center; padding: 80px 20px; }
</style>
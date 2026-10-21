<template>
    <Head title="إعدادات المصادر" />
    <AppLayout>
        <div class="max-w-4xl mx-auto px-4 py-8">

            <div class="mb-8">
                <h1 class="text-2xl font-semibold">إعدادات المصادر</h1>
                <p class="text-sm mt-1" style="color: var(--muted);">
                    اختر المصادر التي تريد متابعتها
                </p>
            </div>

            <!-- Stats -->
            <div class="stats-row mb-6">
                <span>{{ enabledCount }} مصدر مفعّل</span>
                <span style="color: var(--muted);">من {{ sources.length }} مصدر</span>
                <button @click="resetAll" class="reset-btn">إعادة تعيين الكل</button>
            </div>

            <!-- Sources Grid -->
            <div class="sources-grid">
                <div
                    v-for="source in sources"
                    :key="source.id"
                    class="source-card"
                    :class="{ disabled: !source.is_enabled }"
                    @click="toggle(source)"
                >
                    <div class="source-header">
                        <span class="source-name">{{ source.name }}</span>
                        <span class="toggle-indicator" :class="{ on: source.is_enabled }">
                            {{ source.is_enabled ? '✓' : '✕' }}
                        </span>
                    </div>
                    <div class="source-meta">
                        <span>{{ source.country_code }}</span>
                        <span>{{ source.language }}</span>
                        <span v-if="source.bias">{{ source.bias }}</span>
                    </div>
                </div>
            </div>

        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({ sources: Array })

const sources = ref(props.sources.map(s => ({ ...s })))

const enabledCount = computed(() => sources.value.filter(s => s.is_enabled).length)

function toggle(source) {
    source.is_enabled = !source.is_enabled
    router.put(`/preferences/sources/${source.id}`, {
        is_enabled: source.is_enabled,
    }, { preserveState: true })
}

function resetAll() {
    router.delete('/preferences/sources', {}, {
        onSuccess: () => {
            sources.value.forEach(s => s.is_enabled = true)
        },
        preserveState: true,
    })
}
</script>

<style scoped>
.stats-row {
    display: flex; align-items: center; gap: 12px;
    font-size: 14px; font-weight: 500;
}
.reset-btn {
    margin-right: auto;
    padding: 5px 14px;
    border-radius: 6px;
    border: 1px solid var(--border);
    background: transparent;
    color: var(--muted);
    font-family: inherit;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.15s;
}
.reset-btn:hover { border-color: var(--red); color: var(--red); }
.sources-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 12px;
}
.source-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 14px;
    cursor: pointer;
    transition: all 0.15s;
}
.source-card:hover { border-color: var(--accent); }
.source-card.disabled {
    opacity: 0.5;
    border-color: var(--border);
}
.source-header {
    display: flex; align-items: center;
    justify-content: space-between; margin-bottom: 8px;
}
.source-name { font-size: 14px; font-weight: 500; }
.toggle-indicator {
    width: 22px; height: 22px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; font-weight: 700;
    background: var(--surface2);
    color: var(--muted);
    transition: all 0.15s;
}
.toggle-indicator.on {
    background: rgba(63,185,80,0.2);
    color: var(--green);
}
.source-meta {
    display: flex; gap: 8px;
    font-size: 11px; color: var(--muted);
}
</style>
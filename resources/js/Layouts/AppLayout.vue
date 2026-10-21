<template>
    <div class="min-h-screen" style="background: var(--bg); color: var(--text);">

        <!-- Navbar -->
        <header class="sticky top-0 z-50 border-b" style="background: var(--surface); border-color: var(--border);">
            <div class="max-w-7xl mx-auto px-4 h-14 flex items-center justify-between">

                <Link href="/" class="flex items-center gap-2">
                    <span class="font-mono text-lg font-semibold">
                        GN<span style="color: var(--accent);">IP</span>
                    </span>
                    <span class="text-xs hidden sm:block" style="color: var(--muted);">منصة ذكاء الأخبار</span>
                </Link>

                <nav class="flex items-center gap-1">
                    <Link href="/" class="nav-link" :class="{ active: $page.url === '/' }">الرئيسية</Link>
                    <Link href="/briefings" class="nav-link" :class="{ active: $page.url.startsWith('/briefings') }">النشرات</Link>
                    <Link href="/search" class="nav-link" :class="{ active: $page.url.startsWith('/search') }">بحث</Link>
                </nav>
                <!-- Language Switcher -->
            <div class="flex items-center gap-1 mr-2">
                <button
                v-for="lang in langs"
                :key="lang.code"
                @click="setLocale(lang.code)"
                class="lang-btn"
                :class="{ active: $page.props.locale === lang.code }"
                >{{ lang.label }}</button>
            </div>

                <div class="flex items-center gap-2">
                    <template v-if="$page.props.auth?.user">
                        <Link href="/preferences/sources" class="nav-link">المصادر</Link>
                        <button @click="logout" class="btn-outline text-sm">خروج</button>
                    </template>
                    <template v-else>
                        <Link href="/login" class="btn-outline text-sm">دخول</Link>
                        <Link href="/register" class="btn-primary text-sm">إنشاء حساب</Link>
                    </template>
                </div>

            </div>
        </header>

        <!-- Flash Messages -->
        <div v-if="$page.props.flash?.success" class="flash-success">
            {{ $page.props.flash.success }}
        </div>
        <div v-if="$page.props.flash?.error" class="flash-error">
            {{ $page.props.flash.error }}
        </div>

        <!-- Content -->
        <main>
            <slot />
        </main>

        <!-- Footer -->
        <footer class="border-t mt-16 py-8" style="border-color: var(--border);">
            <div class="max-w-7xl mx-auto px-4 text-center text-xs" style="color: var(--muted);">
                GNIP · منصة ذكاء الأخبار · {{ new Date().getFullYear() }}
            </div>
        </footer>

    </div>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'

function logout() {
    router.post('/logout')
}
const langs = [
    { code: 'ar', label: 'ع' },
    { code: 'en', label: 'EN' },
    { code: 'fr', label: 'FR' },
]

function setLocale(code) {
    router.post('/locale', { locale: code }, {
        preserveScroll: true,
        preserveState: false,
    })
}
</script>

<style scoped>
.nav-link {
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 13px;
    color: var(--muted);
    transition: color 0.15s, background 0.15s;
}
.nav-link:hover, .nav-link.active {
    color: var(--text);
    background: var(--surface2);
}
.btn-outline {
    padding: 5px 14px;
    border-radius: 6px;
    border: 1px solid var(--border);
    background: transparent;
    color: var(--text);
    cursor: pointer;
    font-family: inherit;
    font-size: 13px;
    transition: background 0.15s;
}
.btn-outline:hover { background: var(--surface2); }
.btn-primary {
    padding: 5px 14px;
    border-radius: 6px;
    border: 1px solid var(--accent);
    background: var(--accent);
    color: #fff;
    cursor: pointer;
    font-family: inherit;
    font-size: 13px;
    transition: opacity 0.15s;
}
.btn-primary:hover { opacity: 0.85; }
.flash-success {
    background: rgba(63,185,80,0.1);
    border-bottom: 1px solid rgba(63,185,80,0.3);
    color: var(--green);
    padding: 10px 16px;
    text-align: center;
    font-size: 13px;
}
.flash-error {
    background: rgba(248,81,73,0.1);
    border-bottom: 1px solid rgba(248,81,73,0.3);
    color: var(--red);
    padding: 10px 16px;
    text-align: center;
    font-size: 13px;
}
.lang-btn {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 11px;
    font-family: monospace;
    border: 1px solid var(--border);
    background: transparent;
    color: var(--muted);
    cursor: pointer;
    transition: all 0.15s;
}
.lang-btn:hover, .lang-btn.active {
    background: var(--surface2);
    color: var(--text);
    border-color: var(--accent);
}
</style>
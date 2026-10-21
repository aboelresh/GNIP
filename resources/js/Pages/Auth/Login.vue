<template>
    <Head title="تسجيل الدخول" />
    <div class="auth-page">
        <div class="auth-card">
            <div class="auth-logo">
                GN<span style="color: var(--accent);">IP</span>
            </div>
            <h1 class="auth-title">تسجيل الدخول</h1>

            <form @submit.prevent="submit">
                <div class="form-group">
                    <label>البريد الإلكتروني</label>
                    <input
                        v-model="form.email"
                        type="email"
                        class="form-input"
                        :class="{ error: errors.email }"
                        placeholder="example@email.com"
                        dir="ltr"
                    />
                    <span v-if="errors.email" class="error-msg">{{ errors.email }}</span>
                </div>

                <div class="form-group">
                    <label>كلمة المرور</label>
                    <input
                        v-model="form.password"
                        type="password"
                        class="form-input"
                        :class="{ error: errors.password }"
                        placeholder="••••••••"
                    />
                    <span v-if="errors.password" class="error-msg">{{ errors.password }}</span>
                </div>

                <button type="submit" class="submit-btn" :disabled="loading">
                    {{ loading ? 'جاري الدخول...' : 'دخول' }}
                </button>
            </form>

            <p class="auth-link">
                ليس لديك حساب؟
                <Link href="/register">إنشاء حساب</Link>
            </p>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { router, usePage } from '@inertiajs/vue3'

const page = usePage()
const errors = ref({})
const loading = ref(false)

const form = reactive({
    email: '',
    password: '',
})

function submit() {
    loading.value = true
    errors.value = {}

    router.post('/login', form, {
        onError: (e) => { errors.value = e },
        onFinish: () => { loading.value = false },
    })
}
</script>

<style scoped>
.auth-page {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bg);
    padding: 20px;
}
.auth-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 40px;
    width: 100%;
    max-width: 400px;
}
.auth-logo {
    font-family: monospace;
    font-size: 28px;
    font-weight: 700;
    text-align: center;
    margin-bottom: 8px;
}
.auth-title {
    font-size: 18px;
    font-weight: 500;
    text-align: center;
    margin: 0 0 28px;
    color: var(--muted);
}
.form-group {
    margin-bottom: 16px;
}
.form-group label {
    display: block;
    font-size: 13px;
    color: var(--muted);
    margin-bottom: 6px;
}
.form-input {
    width: 100%;
    padding: 10px 12px;
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: 6px;
    color: var(--text);
    font-family: inherit;
    font-size: 14px;
    outline: none;
    transition: border-color 0.15s;
}
.form-input:focus { border-color: var(--accent); }
.form-input.error { border-color: var(--red); }
.error-msg { font-size: 12px; color: var(--red); margin-top: 4px; display: block; }
.submit-btn {
    width: 100%;
    padding: 12px;
    background: var(--accent);
    border: none;
    border-radius: 6px;
    color: #fff;
    font-family: inherit;
    font-size: 15px;
    cursor: pointer;
    margin-top: 8px;
    transition: opacity 0.15s;
}
.submit-btn:hover { opacity: 0.85; }
.submit-btn:disabled { opacity: 0.5; cursor: not-allowed; }
.auth-link {
    text-align: center;
    font-size: 13px;
    color: var(--muted);
    margin-top: 20px;
}
.auth-link a { color: var(--accent); }
</style>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GNIP — Global News Intelligence Platform</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: #0f1117;
            color: #e2e8f0;
            min-height: 100vh;
        }

        header {
            background: #1a1f2e;
            border-bottom: 1px solid #2d3748;
            padding: 16px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            font-size: 20px;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.5px;
        }

        .logo span { color: #667eea; }

        .header-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .ai-status {
            font-size: 12px;
            color: #68d391;
            font-weight: 600;
        }

        /* Search Bar */
        .search-wrapper {
            flex: 1;
            max-width: 500px;
            margin: 0 40px;
            position: relative;
        }

        .search-input {
            width: 100%;
            background: #0f1117;
            border: 1px solid #2d3748;
            color: #e2e8f0;
            padding: 10px 16px 10px 40px;
            border-radius: 10px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
        }

        .search-input:focus { border-color: #667eea; }
        .search-input::placeholder { color: #4a5568; }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #4a5568;
            font-size: 14px;
        }

        .search-results {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            right: 0;
            background: #1a1f2e;
            border: 1px solid #2d3748;
            border-radius: 10px;
            max-height: 400px;
            overflow-y: auto;
            z-index: 200;
            display: none;
        }

        .search-result-item {
            padding: 12px 16px;
            border-bottom: 1px solid #2d3748;
            cursor: pointer;
            transition: background 0.15s;
        }

        .search-result-item:hover { background: #0f1117; }
        .search-result-item:last-child { border-bottom: none; }
        .search-result-title { font-size: 13px; font-weight: 600; color: #e2e8f0; }
        .search-result-meta { font-size: 11px; color: #4a5568; margin-top: 3px; }

        .container { max-width: 1400px; margin: 0 auto; padding: 30px 40px; }

        /* Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 12px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: #1a1f2e;
            border: 1px solid #2d3748;
            border-radius: 10px;
            padding: 18px;
        }

        .stat-label { font-size: 11px; color: #4a5568; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 6px; }
        .stat-value { font-size: 28px; font-weight: 800; color: #fff; }
        .stat-sub { font-size: 11px; color: #4a5568; margin-top: 4px; }

        /* Section */
        .section { margin-bottom: 40px; }
        .section-header { display: flex; align-items: center; gap: 10px; margin-bottom: 16px; }
        .section-title { font-size: 16px; font-weight: 700; color: #e2e8f0; }
        .section-count { background: #2d3748; color: #718096; font-size: 11px; padding: 3px 10px; border-radius: 20px; }

        /* Egypt highlight */
        .egypt-banner {
            background: linear-gradient(135deg, #1a2744, #1a1f2e);
            border: 1px solid #2d4a8a;
            border-radius: 12px;
            padding: 20px 24px;
            margin-bottom: 40px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .egypt-flag { font-size: 36px; }

        .egypt-title { font-size: 16px; font-weight: 700; color: #90cdf4; margin-bottom: 4px; }
        .egypt-sub { font-size: 13px; color: #4a6fa5; }

        .egypt-articles { display: flex; flex-direction: column; gap: 8px; flex: 1; }

        .egypt-article {
            background: #0f1117;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13px;
            cursor: pointer;
            transition: background 0.15s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .egypt-article:hover { background: #1a2744; }
        .egypt-source { font-size: 11px; color: #4a6fa5; font-weight: 600; flex-shrink: 0; }

        /* Sources */
        .sources-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 10px;
        }

        .source-card {
            background: #1a1f2e;
            border: 1px solid #2d3748;
            border-radius: 10px;
            padding: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .source-initial {
            width: 38px;
            height: 38px;
            border-radius: 8px;
            background: #2d3748;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 15px;
            color: #a0aec0;
            flex-shrink: 0;
        }

        .source-name { font-size: 13px; font-weight: 600; color: #e2e8f0; }
        .source-meta { display: flex; gap: 5px; margin-top: 4px; flex-wrap: wrap; }

        .badge {
            font-size: 10px;
            padding: 2px 7px;
            border-radius: 20px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .badge-lang { background: #2d3748; color: #718096; }
        .badge-green { background: #1a472a; color: #68d391; }
        .badge-blue { background: #1a365d; color: #63b3ed; }
        .badge-red { background: #742a2a; color: #fc8181; }
        .badge-purple { background: #44337a; color: #d6bcfa; }
        .badge-yt { background: #7a1a1a; color: #fc8181; }
        .badge-eg { background: #1a3a2a; color: #68d391; }

        /* Articles */
        .articles-grid {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .article-card {
            background: #1a1f2e;
            border: 1px solid #2d3748;
            border-radius: 10px;
            padding: 14px 18px;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 14px;
            align-items: start;
            cursor: pointer;
            transition: border-color 0.2s;
            text-decoration: none;
        }

        .article-card:hover { border-color: #4a5568; }

        .article-title { font-size: 14px; font-weight: 600; color: #e2e8f0; margin-bottom: 5px; line-height: 1.4; }
        .article-desc { font-size: 12px; color: #4a5568; margin-bottom: 8px; line-height: 1.5; }
        .article-meta { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
        .article-source { font-size: 12px; font-weight: 700; color: #667eea; }
        .article-time { font-size: 11px; color: #4a5568; }
        .article-img { width: 90px; height: 65px; object-fit: cover; border-radius: 8px; background: #2d3748; }
        .ai-summary { font-size: 12px; color: #90cdf4; margin-top: 8px; padding: 8px 12px; background: #0f1117; border-radius: 6px; border-left: 2px solid #667eea; line-height: 1.5; }

        /* Stories */
        .stories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
            gap: 14px;
        }

        .story-card {
            background: #1a1f2e;
            border: 1px solid #2d3748;
            border-radius: 12px;
            overflow: hidden;
            transition: border-color 0.2s;
            cursor: pointer;
        }

        .story-card:hover { border-color: #667eea; }
        .story-img { width: 100%; height: 160px; object-fit: cover; }
        .story-body { padding: 14px; }
        .story-badges { display: flex; gap: 6px; margin-bottom: 10px; flex-wrap: wrap; align-items: center; }
        .story-title { font-size: 14px; font-weight: 700; color: #e2e8f0; line-height: 1.4; margin-bottom: 8px; }
        .story-summary { font-size: 12px; color: #718096; line-height: 1.5; margin-bottom: 10px; }
        .story-footer { display: flex; gap: 12px; font-size: 11px; color: #4a5568; border-top: 1px solid #2d3748; padding-top: 10px; flex-wrap: wrap; }

        /* Filters */
        .filter-row { display: flex; gap: 8px; margin-bottom: 16px; flex-wrap: wrap; align-items: center; }
        .filter-btn { background: #1a1f2e; border: 1px solid #2d3748; color: #718096; padding: 7px 14px; border-radius: 8px; cursor: pointer; font-size: 12px; transition: all 0.2s; }
        .filter-btn:hover, .filter-btn.active { background: #667eea; border-color: #667eea; color: white; }

        /* Loading */
        .loading { text-align: center; color: #4a5568; padding: 30px; font-size: 13px; }
        .spinner { width: 20px; height: 20px; border: 2px solid #2d3748; border-top-color: #667eea; border-radius: 50%; animation: spin 0.8s linear infinite; margin: 0 auto 10px; }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* Evidence */
        .ev-high { color: #68d391; background: #68d39122; }
        .ev-moderate { color: #f6ad55; background: #f6ad5522; }
        .ev-low { color: #fc8181; background: #fc818122; }
        .ev-unverified { color: #718096; background: #71809622; }
    </style>
</head>
<body>

<header>
    <div class="logo">GN<span>IP</span></div>

    <div class="search-wrapper">
        <span class="search-icon">🔍</span>
        <input class="search-input" id="main-search" placeholder="Search news, events, topics..." oninput="handleSearch(this.value)">
        <div class="search-results" id="search-results"></div>
    </div>

    <div class="header-right">
        <span class="ai-status" id="ai-status">AI: checking...</span>
    </div>
</header>

<div class="container">

    <!-- Stats -->
    <div class="stats-grid" id="stats-grid">
        <div class="loading"><div class="spinner"></div></div>
    </div>

    <!-- Egypt Section -->
    <div class="egypt-banner">
        <div class="egypt-flag">🇪🇬</div>
        <div style="flex:1">
            <div class="egypt-title">أخبار مصر</div>
            <div class="egypt-sub">آخر الأخبار المتعلقة بمصر</div>
            <div class="egypt-articles" id="egypt-articles" style="margin-top:12px;">
                <div class="loading" style="padding:10px 0"><div class="spinner"></div></div>
            </div>
        </div>
    </div>

    <!-- Trending Stories -->
    <div class="section">
        <div class="section-header">
            <div class="section-title">Trending Stories</div>
            <span class="section-count" id="stories-count">...</span>
        </div>
        <div class="stories-grid" id="stories-grid">
            <div class="loading"><div class="spinner"></div></div>
        </div>
    </div>

    <!-- Sources -->
    <div class="section">
        <div class="section-header">
            <div class="section-title">News Sources</div>
            <span class="section-count" id="sources-count">...</span>
        </div>
        <div class="sources-grid" id="sources-grid">
            <div class="loading"><div class="spinner"></div></div>
        </div>
    </div>

    <!-- Articles -->
    <div class="section">
        <div class="section-header">
            <div class="section-title">Latest Articles</div>
            <span class="section-count" id="articles-count">...</span>
        </div>
        <div class="filter-row">
            <button class="filter-btn active" onclick="filterLang('all',this)">All Languages</button>
            <button class="filter-btn" onclick="filterLang('en',this)">English</button>
            <button class="filter-btn" onclick="filterLang('ar',this)">العربية</button>
            <button class="filter-btn" onclick="filterLang('fr',this)">Français</button>
            <button class="filter-btn" onclick="filterLang('it',this)">Italiano</button>
            <button class="filter-btn" onclick="filterLang('es',this)">Español</button>
        </div>
        <div class="articles-grid" id="articles-grid">
            <div class="loading"><div class="spinner"></div></div>
        </div>
    </div>

</div>

<script>
const API = 'http://127.0.0.1:8000/api/v1';
let currentLang = 'all';
let searchTimer = null;

const biasMap = {
    'center':'badge-green','center-left':'badge-blue','center-right':'badge-red',
    'left':'badge-blue','right':'badge-red','state':'badge-purple','unknown':'badge-lang'
};

const evMap = {
    'high':'ev-high','moderate':'ev-moderate','low':'ev-low','unverified':'ev-unverified'
};

async function api(path) {
    const r = await fetch(API + path);
    return r.json();
}

function ago(d) {
    const s = Math.floor((Date.now() - new Date(d)) / 1000);
    if (s < 60) return s + 's ago';
    if (s < 3600) return Math.floor(s/60) + 'm ago';
    if (s < 86400) return Math.floor(s/3600) + 'h ago';
    return Math.floor(s/86400) + 'd ago';
}

// ── Dashboard ──────────────────────────────────────────
async function loadDashboard() {
    const { data: d } = await api('/dashboard');
    document.getElementById('ai-status').textContent =
        'AI: ' + (d.ai.available_providers[0] || 'offline');

    document.getElementById('stats-grid').innerHTML = `
        <div class="stat-card">
            <div class="stat-label">Articles</div>
            <div class="stat-value">${d.articles.total.toLocaleString()}</div>
            <div class="stat-sub">Processed: ${d.articles.processed} · Raw: ${d.articles.raw}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Active Sources</div>
            <div class="stat-value">${d.sources.active}</div>
            <div class="stat-sub">Total: ${d.sources.total}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Stories</div>
            <div class="stat-value">${d.stories.total}</div>
            <div class="stat-sub">Trending: ${d.stories.trending}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Languages</div>
            <div class="stat-value">${Object.keys(d.languages).length}</div>
            <div class="stat-sub">${Object.entries(d.languages).map(([l,c])=>l.toUpperCase()+':'+c).join(' · ')}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Categories</div>
            <div class="stat-value">${d.categories}</div>
            <div class="stat-sub">Briefings: ${d.briefings}</div>
        </div>
    `;
}

// ── Egypt Section ──────────────────────────────────────
async function loadEgypt() {
    const { data } = await api('/articles?country=EG&per_page=5&lang=ar');
    if (!data || !data.length) {
        document.getElementById('egypt-articles').innerHTML =
            '<div style="font-size:13px;color:#4a5568;">No Egyptian news yet. Add Egyptian sources to see content here.</div>';
        return;
    }
    document.getElementById('egypt-articles').innerHTML = data.map(a => `
        <a class="egypt-article" href="${a.url}" target="_blank">
            <span class="egypt-source">${a.source?.name ?? ''}</span>
            <span style="font-size:13px;color:#e2e8f0;flex:1">${a.title}</span>
            <span style="font-size:11px;color:#4a5568;flex-shrink:0">${ago(a.published_at)}</span>
        </a>
    `).join('');
}

// ── Stories ────────────────────────────────────────────
async function loadStories() {
    const { data } = await api('/stories/trending/list?limit=6');
    document.getElementById('stories-count').textContent = data.length + ' trending';

    if (!data.length) {
        document.getElementById('stories-grid').innerHTML =
            '<div class="loading">No trending stories yet.</div>';
        return;
    }

    document.getElementById('stories-grid').innerHTML = data.map(s => `
        <div class="story-card">
            ${s.image_url ? `<img class="story-img" src="${s.image_url}" onerror="this.style.display='none'">` : ''}
            <div class="story-body">
                <div class="story-badges">
                    ${s.category ? `<span class="badge badge-lang">${s.category.name}</span>` : ''}
                    <span class="badge ${evMap[s.evidence_level] || ''}" style="font-size:10px;padding:2px 8px;border-radius:20px;">${s.evidence_level}</span>
                    ${s.is_trending ? '<span style="font-size:11px;color:#fc8181;font-weight:700;">TRENDING</span>' : ''}
                </div>
                <div class="story-title">${s.title}</div>
                ${s.summary ? `<div class="story-summary">${s.summary.substring(0,180)}...</div>` : ''}
                <div class="story-footer">
                    <span>${s.articles_count} articles</span>
                    <span>${s.sources_count} sources</span>
                    <span>${(s.countries||[]).join(', ')||'Global'}</span>
                    <span>Score: ${s.evidence_score}/100</span>
                </div>
                <div style="display:flex;gap:5px;margin-top:8px;">
                    ${(s.languages||[]).map(l=>`<span class="badge badge-lang">${l.toUpperCase()}</span>`).join('')}
                </div>
            </div>
        </div>
    `).join('');
}

// ── Sources ────────────────────────────────────────────
async function loadSources() {
    const { data, meta } = await api('/sources');
    document.getElementById('sources-count').textContent = meta.total + ' sources';
    document.getElementById('sources-grid').innerHTML = data.map(s => `
        <div class="source-card">
            <div class="source-initial">${[...s.name][0]}</div>
            <div style="flex:1;min-width:0">
                <div class="source-name">${s.name}</div>
                <div class="source-meta">
                    <span class="badge badge-lang">${s.language.toUpperCase()}</span>
                    <span class="badge ${biasMap[s.bias]||'badge-lang'}">${s.bias}</span>
                    ${s.slug.includes('yt') || s.type === 'digital' && s.website_url.includes('youtube') ? '<span class="badge badge-yt">YT</span>' : ''}
                    ${s.country_code === 'EG' ? '<span class="badge badge-eg">EG</span>' : ''}
                    ${!s.is_active ? '<span class="badge badge-red">Inactive</span>' : ''}
                </div>
                <div style="font-size:11px;color:#4a5568;margin-top:3px;">
                    ${s.reliability_score}/100 reliability · ${s.articles_count} articles
                </div>
            </div>
        </div>
    `).join('');
}

// ── Articles ───────────────────────────────────────────
async function loadArticles(lang = 'all', search = '') {
    document.getElementById('articles-grid').innerHTML =
        '<div class="loading"><div class="spinner"></div></div>';

    let url = '/articles?per_page=20';
    if (lang !== 'all') url += '&language=' + lang;
    url += '&lang=' + (lang === 'all' ? 'en' : lang);
    if (search) url += '&q=' + encodeURIComponent(search);

    const { data, meta } = await api(url);
    document.getElementById('articles-count').textContent =
        (meta?.total || 0).toLocaleString() + ' articles';

    if (!data?.length) {
        document.getElementById('articles-grid').innerHTML =
            '<div class="loading">No articles found.</div>';
        return;
    }

    document.getElementById('articles-grid').innerHTML = data.map(a => `
        <a class="article-card" href="${a.url}" target="_blank">
            <div>
                <div class="article-title">${a.title}</div>
                ${a.description ? `<div class="article-desc">${a.description.substring(0,150)}...</div>` : ''}
                <div class="article-meta">
                    <span class="article-source">${a.source?.name ?? ''}</span>
                    <span class="badge badge-lang">${(a.language||'').toUpperCase()}</span>
                    ${a.category?.name ? `<span class="badge badge-green">${a.category.name}</span>` : ''}
                    ${a.country_code === 'EG' ? '<span class="badge badge-eg">EG</span>' : ''}
                    <span class="article-time">${ago(a.published_at)}</span>
                </div>
                ${a.ai_summary ? `<div class="ai-summary">AI: ${a.ai_summary}</div>` : ''}
            </div>
            ${a.image_url ? `<img class="article-img" src="${a.image_url}" onerror="this.style.display='none'">` : ''}
        </a>
    `).join('');
}

// ── Search ─────────────────────────────────────────────
function handleSearch(val) {
    clearTimeout(searchTimer);
    const box = document.getElementById('search-results');

    if (!val.trim()) { box.style.display = 'none'; return; }

    searchTimer = setTimeout(async () => {
        const { data } = await api('/articles?q=' + encodeURIComponent(val) + '&per_page=6');
        if (!data?.length) { box.style.display = 'none'; return; }

        box.style.display = 'block';
        box.innerHTML = data.map(a => `
            <a class="search-result-item" href="${a.url}" target="_blank">
                <div class="search-result-title">${a.title}</div>
                <div class="search-result-meta">${a.source?.name ?? ''} · ${(a.language||'').toUpperCase()} · ${ago(a.published_at)}</div>
            </a>
        `).join('');
    }, 400);
}

document.addEventListener('click', e => {
    if (!e.target.closest('.search-wrapper')) {
        document.getElementById('search-results').style.display = 'none';
    }
});

function filterLang(lang, btn) {
    currentLang = lang;
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    loadArticles(lang);
}

// ── Init ───────────────────────────────────────────────
Promise.all([loadDashboard(), loadEgypt(), loadStories(), loadSources(), loadArticles()]);
</script>
</body>
</html>
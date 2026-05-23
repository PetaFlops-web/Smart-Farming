<?php
session_start();
// Redirect if not logged in
if (empty($_SESSION['admin_user'])) {
    header('Location: login.php');
    exit;
}

$page_title = 'Chatbot AI';
$active     = 'chatbot';

require_once 'includes/header.php';
?>

<style>
  /* ── Chat layout ── */
  .chat-wrap {
    display: flex;
    height: calc(100vh - 145px);
    gap: 0;
    border-radius: 18px;
    overflow: hidden;
    border: 1px solid rgba(255,255,255,0.08);
    background: rgba(255,255,255,0.02);
  }

  /* ── Sidebar history ── */
  .chat-history {
    width: 240px;
    flex-shrink: 0;
    border-right: 1px solid rgba(255,255,255,0.07);
    display: flex;
    flex-direction: column;
    background: rgba(0,0,0,0.15);
  }
  .chat-history-header {
    padding: 18px 16px 12px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.25);
    border-bottom: 1px solid rgba(255,255,255,0.06);
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .new-chat-btn {
    background: rgba(140,90,60,0.2);
    border: 1px solid rgba(140,90,60,0.35);
    color: #C08552;
    border-radius: 7px;
    padding: 4px 10px;
    font-size: 11px;
    font-weight: 600;
    cursor: pointer;
    font-family: 'Outfit', sans-serif;
    transition: all 0.2s;
  }
  .new-chat-btn:hover { background: rgba(140,90,60,0.35); }
  .history-list { flex: 1; overflow-y: auto; padding: 8px 0; }
  .history-item {
    padding: 9px 16px;
    font-size: 13px;
    color: rgba(255,255,255,0.45);
    cursor: pointer;
    border-radius: 0;
    transition: all 0.15s;
    display: flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .history-item:hover { background: rgba(255,255,255,0.04); color: rgba(255,255,255,0.75); }
  .history-item.active-chat { background: rgba(140,90,60,0.12); color: #C08552; }
  .history-item i { font-size: 11px; flex-shrink: 0; }

  /* ── Main chat area ── */
  .chat-main {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
  }
  .chat-header {
    padding: 16px 24px;
    border-bottom: 1px solid rgba(255,255,255,0.06);
    display: flex;
    align-items: center;
    gap: 12px;
    background: rgba(255,255,255,0.01);
  }
  .ai-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: linear-gradient(135deg, #8C5A3C, #C08552);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
  }
  .chat-header-info h2 { font-size: 15px; font-weight: 600; color: #fff; }
  .chat-header-info p  { font-size: 12px; color: rgba(255,255,255,0.35); margin-top: 1px; }
  .status-dot {
    width: 7px; height: 7px; border-radius: 50%;
    background: #4ade80;
    display: inline-block;
    margin-right: 4px;
    box-shadow: 0 0 6px #4ade80;
  }

  /* ── Messages ── */
  .messages-area {
    flex: 1;
    overflow-y: auto;
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    scroll-behavior: smooth;
  }
  .messages-area::-webkit-scrollbar { width: 4px; }
  .messages-area::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.08); border-radius: 4px; }

  /* Empty state */
  .empty-state {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 14px;
    color: rgba(255,255,255,0.2);
    text-align: center;
    padding: 40px;
  }
  .empty-state i { font-size: 40px; color: rgba(192,133,82,0.3); }
  .empty-state h3 { font-size: 17px; font-weight: 600; color: rgba(255,255,255,0.35); }
  .empty-state p { font-size: 13px; line-height: 1.6; max-width: 340px; }

  /* Suggested prompts */
  .suggestions {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    justify-content: center;
    margin-top: 8px;
  }
  .suggestion-chip {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.1);
    color: rgba(255,255,255,0.5);
    border-radius: 100px;
    padding: 6px 14px;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.2s;
    font-family: 'Outfit', sans-serif;
  }
  .suggestion-chip:hover { background: rgba(140,90,60,0.12); border-color: rgba(140,90,60,0.3); color: #C08552; }

  /* Message bubbles */
  .msg-row {
    display: flex;
    gap: 12px;
    animation: fadeUp 0.25s ease;
  }
  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(8px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  .msg-row.user-row { flex-direction: row-reverse; }
  .msg-avatar {
    width: 32px; height: 32px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; font-weight: 600; flex-shrink: 0;
    margin-top: 2px;
  }
  .msg-avatar.ai-av  { background: linear-gradient(135deg,#8C5A3C,#C08552); color: #fff; }
  .msg-avatar.usr-av { background: rgba(255,255,255,0.1); color: rgba(255,255,255,0.7); }
  .msg-bubble {
    max-width: 72%;
    padding: 12px 16px;
    border-radius: 14px;
    font-size: 14px;
    line-height: 1.65;
  }
  .ai-bubble {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.08);
    color: rgba(255,255,255,0.88);
    border-top-left-radius: 4px;
  }
  .user-bubble {
    background: linear-gradient(135deg, rgba(140,90,60,0.25), rgba(192,133,82,0.15));
    border: 1px solid rgba(140,90,60,0.3);
    color: #fff;
    border-top-right-radius: 4px;
  }
  .msg-time {
    font-size: 10px;
    color: rgba(255,255,255,0.2);
    margin-top: 5px;
    text-align: right;
  }
  .msg-row.user-row .msg-time { text-align: left; }

  /* Typing indicator */
  .typing-indicator {
    display: flex;
    align-items: center;
    gap: 4px;
    padding: 12px 16px;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 14px;
    border-top-left-radius: 4px;
    width: fit-content;
  }
  .typing-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: rgba(255,255,255,0.35);
    animation: typingBounce 1.2s infinite;
  }
  .typing-dot:nth-child(2) { animation-delay: 0.2s; }
  .typing-dot:nth-child(3) { animation-delay: 0.4s; }
  @keyframes typingBounce {
    0%, 80%, 100% { transform: translateY(0); opacity: 0.35; }
    40%           { transform: translateY(-5px); opacity: 1; }
  }

  /* ── Input area ── */
  .input-area {
    padding: 16px 24px 20px;
    border-top: 1px solid rgba(255,255,255,0.06);
    background: rgba(0,0,0,0.1);
  }
  .input-row {
    display: flex;
    gap: 10px;
    align-items: flex-end;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 14px;
    padding: 10px 14px;
    transition: border-color 0.2s;
  }
  .input-row:focus-within { border-color: rgba(140,90,60,0.5); box-shadow: 0 0 0 3px rgba(140,90,60,0.08); }
  #chatInput {
    flex: 1;
    background: transparent;
    border: none;
    outline: none;
    color: #fff;
    font-family: 'Outfit', sans-serif;
    font-size: 14px;
    resize: none;
    max-height: 140px;
    line-height: 1.5;
    padding: 2px 0;
  }
  #chatInput::placeholder { color: rgba(255,255,255,0.25); }
  #sendBtn {
    width: 36px; height: 36px;
    border-radius: 10px;
    background: linear-gradient(135deg,#8C5A3C,#C08552);
    border: none;
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    font-size: 14px;
    flex-shrink: 0;
    transition: all 0.2s;
    align-self: flex-end;
  }
  #sendBtn:hover:not(:disabled) { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(140,90,60,0.4); }
  #sendBtn:disabled { opacity: 0.4; cursor: not-allowed; transform: none; }
  .input-footer {
    margin-top: 8px;
    font-size: 11px;
    color: rgba(255,255,255,0.2);
    text-align: center;
  }

  /* ── Mobile ── */
  @media (max-width: 768px) {
    .chat-history { display: none; }
    .chat-wrap { border-radius: 12px; }
    .msg-bubble { max-width: 88%; }
  }
</style>

<div class="chat-wrap">

  <!-- Sidebar: chat history -->
  <div class="chat-history">
    <div class="chat-history-header">
      Riwayat
      <button class="new-chat-btn" onclick="newChat()">+ Baru</button>
    </div>
    <div class="history-list" id="historyList">
      <!-- filled by JS -->
    </div>
  </div>

  <!-- Main chat -->
  <div class="chat-main">

    <div class="chat-header">
      <div class="ai-avatar"><i class="fas fa-robot"></i></div>
      <div class="chat-header-info">
        <h2>AGGRO Assistant</h2>
        <p><span class="status-dot"></span>Online · Siap membantu</p>
      </div>
    </div>

    <div class="messages-area" id="messagesArea">
      <div class="empty-state" id="emptyState">
        <i class="fas fa-robot"></i>
        <h3>Halo, <?= htmlspecialchars($_SESSION['admin_user'] ?? 'Admin') ?>!</h3>
        <p>Saya siap membantu Anda mengelola toko AGGRO. Tanyakan apa saja tentang produk, pesanan, atau strategi bisnis.</p>
        <div class="suggestions">
          <button class="suggestion-chip" onclick="useSuggestion(this)">📦 Cara menambah produk baru</button>
          <button class="suggestion-chip" onclick="useSuggestion(this)">📊 Analisis penjualan bulan ini</button>
          <button class="suggestion-chip" onclick="useSuggestion(this)">💡 Tips meningkatkan konversi</button>
          <button class="suggestion-chip" onclick="useSuggestion(this)">🚀 Strategi promosi produk</button>
        </div>
      </div>
    </div>

    <div class="input-area">
      <div class="input-row">
        <textarea id="chatInput" rows="1" placeholder="Tulis pesan..." onkeydown="handleKey(event)" oninput="autoResize(this)"></textarea>
        <button id="sendBtn" onclick="sendMessage()"><i class="fas fa-paper-plane"></i></button>
      </div>
      <div class="input-footer">Tekan Enter untuk kirim · Shift+Enter untuk baris baru</div>
    </div>

  </div>
</div>

<script>
  // ── State ──────────────────────────────────────────────────────────────────
  let conversations = JSON.parse(localStorage.getItem('aggro_chats') || '[]');
  let currentId     = null;
  let isLoading     = false;

  const SYSTEM_PROMPT = `Kamu adalah AGGRO Assistant, asisten AI untuk admin toko AGGRO — sebuah brand streetwear/lifestyle.
Tugas kamu: membantu admin mengelola produk, memahami pesanan, memberikan saran bisnis, dan menjawab pertanyaan seputar operasional toko.
Bahasa: Indonesia (gunakan bahasa formal namun ramah).
Jangan pernah memperkenalkan diri sebagai Claude atau AI buatan Anthropic; cukup sebagai "AGGRO Assistant".
Jawab secara ringkas, jelas, dan berikan contoh konkret bila perlu.`;

  // ── Init ───────────────────────────────────────────────────────────────────
  renderHistory();
  if (conversations.length > 0) loadConversation(conversations[0].id);

  // ── Helpers ────────────────────────────────────────────────────────────────
  function now() {
    return new Date().toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit' });
  }
  function uid() { return Date.now().toString(36) + Math.random().toString(36).slice(2); }

  function saveConversations() {
    localStorage.setItem('aggro_chats', JSON.stringify(conversations));
  }

  function currentConv() { return conversations.find(c => c.id === currentId); }

  // ── History sidebar ────────────────────────────────────────────────────────
  function renderHistory() {
    const list = document.getElementById('historyList');
    list.innerHTML = '';
    if (conversations.length === 0) {
      list.innerHTML = '<div style="padding:16px;font-size:12px;color:rgba(255,255,255,0.2);text-align:center">Belum ada percakapan</div>';
      return;
    }
    conversations.forEach(conv => {
      const el = document.createElement('div');
      el.className = 'history-item' + (conv.id === currentId ? ' active-chat' : '');
      el.innerHTML = `<i class="fas fa-message"></i> ${escHtml(conv.title)}`;
      el.onclick = () => loadConversation(conv.id);
      list.appendChild(el);
    });
  }

  function loadConversation(id) {
    currentId = id;
    const conv  = currentConv();
    const area  = document.getElementById('messagesArea');
    const empty = document.getElementById('emptyState');

    area.innerHTML = '';
    if (empty) empty.remove();

    conv.messages.forEach(m => appendBubble(m.role, m.content, m.time, false));
    area.scrollTop = area.scrollHeight;
    renderHistory();
  }

  function newChat() {
    currentId = null;
    const area  = document.getElementById('messagesArea');
    area.innerHTML = '';

    const empty = document.createElement('div');
    empty.className = 'empty-state';
    empty.id = 'emptyState';
    empty.innerHTML = `
      <i class="fas fa-robot"></i>
      <h3>Percakapan Baru</h3>
      <p>Tanyakan apa saja tentang produk, pesanan, atau strategi bisnis AGGRO.</p>
      <div class="suggestions">
        <button class="suggestion-chip" onclick="useSuggestion(this)">📦 Cara menambah produk baru</button>
        <button class="suggestion-chip" onclick="useSuggestion(this)">📊 Analisis penjualan bulan ini</button>
        <button class="suggestion-chip" onclick="useSuggestion(this)">💡 Tips meningkatkan konversi</button>
        <button class="suggestion-chip" onclick="useSuggestion(this)">🚀 Strategi promosi produk</button>
      </div>`;
    area.appendChild(empty);
    renderHistory();
    document.getElementById('chatInput').focus();
  }

  // ── Render bubbles ─────────────────────────────────────────────────────────
  function appendBubble(role, text, time, scroll = true) {
    const empty = document.getElementById('emptyState');
    if (empty) empty.remove();

    const area = document.getElementById('messagesArea');
    const row  = document.createElement('div');
    row.className = 'msg-row ' + (role === 'user' ? 'user-row' : '');

    const avatarHtml = role === 'user'
      ? `<div class="msg-avatar usr-av"><?= strtoupper(substr($_SESSION['admin_user'] ?? 'A', 0, 1)) ?></div>`
      : `<div class="msg-avatar ai-av"><i class="fas fa-robot"></i></div>`;

    const bubbleClass = role === 'user' ? 'user-bubble' : 'ai-bubble';

    row.innerHTML = `
      ${role !== 'user' ? avatarHtml : ''}
      <div>
        <div class="msg-bubble ${bubbleClass}">${formatText(text)}</div>
        <div class="msg-time">${time}</div>
      </div>
      ${role === 'user' ? avatarHtml : ''}
    `;

    area.appendChild(row);
    if (scroll) area.scrollTop = area.scrollHeight;
    return row;
  }

  function showTyping() {
    const empty = document.getElementById('emptyState');
    if (empty) empty.remove();

    const area = document.getElementById('messagesArea');
    const row  = document.createElement('div');
    row.className = 'msg-row';
    row.id = 'typingRow';
    row.innerHTML = `
      <div class="msg-avatar ai-av"><i class="fas fa-robot"></i></div>
      <div class="typing-indicator">
        <div class="typing-dot"></div>
        <div class="typing-dot"></div>
        <div class="typing-dot"></div>
      </div>`;
    area.appendChild(row);
    area.scrollTop = area.scrollHeight;
  }

  function removeTyping() {
    const el = document.getElementById('typingRow');
    if (el) el.remove();
  }

  // Basic markdown-lite formatting
  function formatText(t) {
    return escHtml(t)
      .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
      .replace(/\*(.*?)\*/g, '<em>$1</em>')
      .replace(/`(.*?)`/g, '<code style="background:rgba(255,255,255,0.08);padding:1px 5px;border-radius:4px;font-size:13px">$1</code>')
      .replace(/\n/g, '<br>');
  }

  function escHtml(s) {
    return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
  }

  // ── Send message ───────────────────────────────────────────────────────────
  async function sendMessage() {
    if (isLoading) return;
    const input = document.getElementById('chatInput');
    const text  = input.value.trim();
    if (!text) return;

    input.value = '';
    input.style.height = 'auto';
    isLoading = true;
    document.getElementById('sendBtn').disabled = true;

    // Create or get conversation
    if (!currentId) {
      const conv = {
        id: uid(),
        title: text.slice(0, 38) + (text.length > 38 ? '…' : ''),
        messages: [],
        created: Date.now()
      };
      conversations.unshift(conv);
      currentId = conv.id;
      saveConversations();
      renderHistory();
    }

    const conv    = currentConv();
    const msgTime = now();

    // Save & show user message
    conv.messages.push({ role: 'user', content: text, time: msgTime });
    saveConversations();
    appendBubble('user', text, msgTime);
    showTyping();

    // Build API messages (no system role in messages array for claude API)
    const apiMessages = conv.messages
      .filter(m => m.role !== 'system')
      .map(m => ({ role: m.role, content: m.content }));

    try {
      const res = await fetch('https://api.anthropic.com/v1/messages', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          model: 'claude-sonnet-4-20250514',
          max_tokens: 1000,
          system: SYSTEM_PROMPT,
          messages: apiMessages
        })
      });

      const data = await res.json();

      if (!res.ok) throw new Error(data.error?.message || 'API error');

      const reply = data.content.map(b => b.type === 'text' ? b.text : '').join('');
      const replyTime = now();

      removeTyping();
      conv.messages.push({ role: 'assistant', content: reply, time: replyTime });
      saveConversations();
      appendBubble('assistant', reply, replyTime);

    } catch (err) {
      removeTyping();
      const errTime = now();
      const errMsg  = '⚠️ Gagal menghubungi AI: ' + err.message;
      conv.messages.push({ role: 'assistant', content: errMsg, time: errTime });
      saveConversations();
      appendBubble('assistant', errMsg, errTime);
    }

    isLoading = false;
    document.getElementById('sendBtn').disabled = false;
    input.focus();
  }

  // ── Keyboard & helpers ────────────────────────────────────────────────────
  function handleKey(e) {
    if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
  }

  function autoResize(el) {
    el.style.height = 'auto';
    el.style.height = Math.min(el.scrollHeight, 140) + 'px';
  }

  function useSuggestion(btn) {
    const input = document.getElementById('chatInput');
    // Strip emoji prefix
    input.value = btn.textContent.replace(/^[^\s]+\s/, '').trim();
    input.focus();
    sendMessage();
  }
</script>

<?php require_once 'includes/footer.php'; ?>
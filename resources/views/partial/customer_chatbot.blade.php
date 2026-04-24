@once
    <style>
        .eh-chatbot-shell {
            position: fixed;
            right: 18px;
            top: 50%;
            bottom: auto;
            transform: translateY(-50%);
            z-index: 10060;
            font-family: "Inter", "Segoe UI", sans-serif;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            pointer-events: none;
        }

        .eh-chatbot-launcher {
            position: relative;
            width: 58px;
            height: 58px;
            border: 0;
            border-radius: 50%;
            background: linear-gradient(180deg, #57adf7 0%, #3f97ef 100%);
            color: #fff;
            box-shadow: 0 18px 35px rgba(49, 126, 212, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transform: none;
            transition: transform 180ms ease, box-shadow 180ms ease, background 180ms ease;
            pointer-events: auto;
        }

        .eh-chatbot-launcher:hover {
            transform: translateX(-2px);
            box-shadow: 0 22px 38px rgba(49, 126, 212, 0.42);
        }

        .eh-chatbot-launcher svg {
            width: 22px;
            height: 22px;
            stroke: currentColor;
            stroke-width: 2.1;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .eh-chatbot-launcher.is-open {
            width: 58px;
            height: 58px;
            margin-right: 12px;
            border-radius: 50%;
            transform: none;
        }

        .eh-chatbot-launcher.is-open .eh-chatbot-launcher-open {
            display: none;
        }

        .eh-chatbot-launcher-close {
            display: none;
            width: 24px;
            height: 24px;
        }

        .eh-chatbot-launcher.is-open .eh-chatbot-launcher-close {
            display: block;
        }

        .eh-chatbot-launcher-open {
            width: 26px;
            height: 26px;
            display: block;
        }

        .eh-chatbot-panel {
            position: static;
            width: 345px;
            height: min(640px, calc(100vh - 112px));
            margin: 0 12px 14px auto;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 24px 54px rgba(20, 38, 77, 0.24);
            overflow: hidden;
            flex-direction: column;
            display: flex;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transform: translateY(18px) scale(0.98);
            transform-origin: bottom right;
            transition: opacity 220ms ease, transform 220ms ease, visibility 220ms ease;
        }

        .eh-chatbot-panel.is-open {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
            transform: translateY(0) scale(1);
        }

        .eh-chatbot-home {
            display: flex;
            flex: 1;
            flex-direction: column;
            min-height: 0;
        }

        .eh-chatbot-home.is-hidden,
        .eh-chatbot-chat.is-hidden {
            display: none;
        }

        .eh-chatbot-home-top {
            min-height: 360px;
            padding: 28px 24px 20px;
            background: linear-gradient(180deg, #58aaf2 0%, #4d9eed 100%);
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .eh-chatbot-home-top::before {
            content: "";
            position: absolute;
            inset: -10% -35% auto auto;
            width: 210px;
            height: 210px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.18) 0%, rgba(255, 255, 255, 0) 68%);
            pointer-events: none;
        }

        .eh-chatbot-home-top::after {
            content: "";
            position: absolute;
            left: -18%;
            bottom: -26%;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.14) 0%, rgba(255, 255, 255, 0) 72%);
            pointer-events: none;
        }

        .eh-chatbot-topbar,
        .eh-chatbot-chatbar {
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .eh-chatbot-avatar-wrap {
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
            flex: 1;
        }

        .eh-chatbot-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(180deg, #ececec 0%, #d8d8d8 100%);
            position: relative;
            flex: 0 0 auto;
        }

        .eh-chatbot-avatar::before {
            content: "";
            position: absolute;
            top: 7px;
            left: 50%;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: #f6f6f6;
            transform: translateX(-50%);
        }

        .eh-chatbot-avatar::after {
            content: "";
            position: absolute;
            left: 50%;
            bottom: 6px;
            width: 22px;
            height: 12px;
            border-radius: 12px 12px 9px 9px;
            background: #f6f6f6;
            transform: translateX(-50%);
        }

        .eh-chatbot-hero-copy {
            position: absolute;
            left: 24px;
            right: 24px;
            bottom: 72px;
            z-index: 1;
        }

        .eh-chatbot-hero-copy h3 {
            margin: 0 0 12px;
            color: #fff;
            font-size: 28px;
            font-weight: 800;
            line-height: 1.1;
        }

        .eh-chatbot-hero-copy p {
            margin: 0;
            color: #fff;
            font-size: 17px;
            font-weight: 600;
            line-height: 1.4;
        }

        .eh-chatbot-icon-btn {
            width: 34px;
            height: 34px;
            border: 0;
            background: transparent;
            color: inherit;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            opacity: 0.95;
            cursor: pointer;
            transition: transform 160ms ease, opacity 160ms ease, color 160ms ease;
        }

        .eh-chatbot-icon-btn:hover {
            transform: translateX(-1px);
            opacity: 1;
        }

        .eh-chatbot-icon-btn svg {
            width: 22px;
            height: 22px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        #ehChatbotBack {
            width: 42px;
            height: 42px;
            margin-left: 0;
            border-radius: 12px;
            background: linear-gradient(180deg, #ffffff 0%, #f5f9ff 100%);
            box-shadow: 0 10px 22px rgba(48, 84, 141, 0.14);
            align-self: center;
            border: 0;
            transform: translateY(-6px);
        }

        #ehChatbotBack svg {
            width: 28px;
            height: 28px;
            stroke-width: 2.2;
        }

        #ehChatbotBack:hover {
            transform: translateY(-6px);
            opacity: 1;
            background: linear-gradient(180deg, #ffffff 0%, #edf5ff 100%);
        }

        .eh-chatbot-home-card {
            margin: -36px 18px 0;
            padding: 18px 20px;
            border-radius: 16px;
            border: 1px solid #d9e2ef;
            background: #fff;
            box-shadow: 0 8px 22px rgba(34, 52, 84, 0.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            position: relative;
            z-index: 1;
            transition: transform 180ms ease, box-shadow 180ms ease;
        }

        .eh-chatbot-home-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(34, 52, 84, 0.12);
        }

        .eh-chatbot-home-card strong {
            display: block;
            color: #111827;
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .eh-chatbot-home-card span {
            display: block;
            color: #475467;
            font-size: 15px;
        }

        .eh-chatbot-start {
            width: 40px;
            height: 40px;
            border: 0;
            border-radius: 50%;
            background: rgba(58, 170, 245, 0.1);
            color: #37aef5;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 160ms ease, background 160ms ease, color 160ms ease;
        }

        .eh-chatbot-start:hover {
            background: #37aef5;
            color: #fff;
            transform: translateX(2px);
        }

        .eh-chatbot-start svg {
            width: 28px;
            height: 28px;
            stroke: currentColor;
            stroke-width: 2.4;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .eh-chatbot-tabs {
            margin-top: auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            border-top: 1px solid #e7edf5;
            border-bottom: 1px solid #e7edf5;
        }

        .eh-chatbot-tab {
            padding: 16px 10px 14px;
            border: 0;
            background: #fff;
            color: #6e7ea0;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: background 160ms ease, color 160ms ease;
        }

        .eh-chatbot-tab:hover {
            background: #f7faff;
        }

        .eh-chatbot-tab svg {
            width: 22px;
            height: 22px;
            fill: currentColor;
        }

        .eh-chatbot-tab.active {
            color: #2aa6f2;
            font-weight: 700;
        }

        .eh-chatbot-chat {
            flex: 1;
            min-height: 0;
            display: flex;
            flex-direction: column;
            background: #fff;
        }

        .eh-chatbot-chatbar {
            padding: 14px 14px;
            border-bottom: 1px solid #edf1f6;
            color: #131722;
            min-height: 72px;
            align-items: center;
        }

        .eh-chatbot-chatbar .eh-chatbot-icon-btn {
            color: #7383a3;
        }

        .eh-chatbot-chat-title {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
            flex: 1;
            margin: 0 10px;
        }

        .eh-chatbot-chat-title strong {
            color: #111827;
            font-size: 16px;
            font-weight: 700;
            white-space: nowrap;
        }

        .eh-chatbot-chat-scroll {
            flex: 1;
            min-height: 0;
            overflow-y: auto;
            padding: 10px 14px 14px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            scrollbar-width: thin;
            scrollbar-color: #c7d7ee transparent;
        }

        .eh-chatbot-chat-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .eh-chatbot-chat-scroll::-webkit-scrollbar-thumb {
            background: #c7d7ee;
            border-radius: 999px;
        }

        .eh-chatbot-chat-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .eh-chatbot-option-card {
            width: 100%;
            max-width: 100%;
            border-radius: 14px;
            background: linear-gradient(180deg, #f4f7fc 0%, #eef3fb 100%);
            overflow: hidden;
            border: 1px solid #e6ebf3;
            align-self: stretch;
            padding: 0;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.7);
        }

        .eh-chatbot-option-card h4 {
            margin: 0;
            padding: 16px 16px 12px;
            color: #111827;
            font-size: 16px;
            font-weight: 600;
        }

        .eh-chatbot-option {
            width: 100%;
            display: block;
            margin: 0;
            border: 0;
            border-top: 1px solid #cad5e4;
            border-radius: 0;
            background: #fff;
            color: #2aa6f2;
            font-size: 13px;
            font-weight: 600;
            line-height: 1.35;
            padding: 14px 16px;
            text-align: center;
            cursor: pointer;
            text-decoration: none;
            transition: background 160ms ease, color 160ms ease, text-decoration-color 160ms ease;
        }

        .eh-chatbot-option:hover {
            background: #f9fbff;
            color: #1f9cf0;
            text-decoration: underline;
        }

        .eh-chatbot-intro {
            max-width: 100%;
            padding: 16px 18px;
            border-radius: 16px;
            background: linear-gradient(180deg, #f4f7fc 0%, #eef3fb 100%);
            color: #111827;
            font-size: 15px;
            line-height: 1.5;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.8);
        }

        .eh-chatbot-intro.is-compact {
            max-width: 78%;
            padding: 14px 16px;
        }

        .eh-chatbot-message {
            max-width: min(74%, 252px);
            padding: 12px 15px;
            border-radius: 16px;
            font-size: 14px;
            line-height: 1.35;
            white-space: pre-wrap;
            word-break: break-word;
            box-shadow: 0 10px 18px rgba(24, 38, 69, 0.08);
            animation: eh-chatbot-message-in 180ms ease;
        }

        .eh-chatbot-message.user {
            align-self: flex-end;
            background: linear-gradient(180deg, #56abf4 0%, #469ef0 100%);
            color: #fff;
            border-bottom-right-radius: 8px;
        }

        .eh-chatbot-message.assistant {
            align-self: flex-start;
            background: #f2f5fa;
            color: #1d2433;
            border-bottom-left-radius: 8px;
        }

        .eh-chatbot-compose {
            padding: 10px 14px 12px;
            border-top: 1px solid #dde4ee;
            background: linear-gradient(180deg, #fff 0%, #fbfcff 100%);
        }

        .eh-chatbot-form {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .eh-chatbot-input {
            flex: 1;
            border: 0;
            padding: 8px 0;
            color: #23314f;
            font-size: 14px;
            background: transparent;
        }

        .eh-chatbot-input::placeholder {
            color: #8996b3;
        }

        .eh-chatbot-input:focus {
            outline: none;
        }

        .eh-chatbot-send {
            width: 30px;
            height: 30px;
            border: 0;
            border-radius: 50%;
            background: transparent;
            color: #c6ccd9;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 160ms ease, background 160ms ease, color 160ms ease;
        }

        .eh-chatbot-send.is-ready {
            color: #fff;
            background: linear-gradient(180deg, #56abf4 0%, #469ef0 100%);
            box-shadow: 0 10px 18px rgba(58, 152, 239, 0.26);
        }

        .eh-chatbot-send.is-ready:hover {
            transform: translateX(2px);
        }

        .eh-chatbot-send svg,
        .eh-chatbot-compose-icons svg {
            width: 20px;
            height: 20px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .eh-chatbot-compose-bottom {
            display: none;
        }

        @keyframes eh-chatbot-message-in {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 575px) {
            .eh-chatbot-shell {
                right: 12px;
                top: 50%;
                bottom: auto;
                transform: translateY(-50%);
            }

            .eh-chatbot-panel {
                position: static;
                width: 312px;
                height: min(560px, calc(100vh - 88px));
                margin-bottom: 10px;
            }

            .eh-chatbot-launcher {
                width: 54px;
                height: 54px;
            }

            .eh-chatbot-launcher.is-open {
                width: 54px;
                height: 54px;
                margin-right: 8px;
            }

            .eh-chatbot-home-top {
                min-height: 250px;
                padding: 22px 18px 18px;
            }

            .eh-chatbot-hero-copy h3 {
                font-size: 22px;
            }

            .eh-chatbot-hero-copy p {
                font-size: 15px;
            }

            .eh-chatbot-home-card {
                margin: -24px 12px 0;
                padding: 14px 16px;
            }
        }

        @media (min-width: 576px) and (max-width: 991px) {
            .eh-chatbot-panel {
                position: static;
                width: 330px;
                height: min(610px, calc(100vh - 104px));
                margin-right: 10px;
            }

            .eh-chatbot-launcher {
                width: 56px;
                height: 56px;
            }
        }
    </style>

    <div class="eh-chatbot-shell" id="ehChatbotShell">
        <div class="eh-chatbot-panel" id="ehChatbotPanel" aria-live="polite">
            <div class="eh-chatbot-home" id="ehChatbotHome">
                <div class="eh-chatbot-home-top">
                    <div class="eh-chatbot-topbar">
                        <div class="eh-chatbot-avatar-wrap">
                            <div class="eh-chatbot-avatar" aria-hidden="true"></div>
                        </div>
                    </div>

                    <div class="eh-chatbot-hero-copy">
                        <h3>Hi there 👋</h3>
                        <p>Welcome to our website. Ask us anything 🎉</p>
                    </div>
                </div>

                <div class="eh-chatbot-home-card">
                    <div>
                        <strong>Chat with us</strong>
                        <span>We reply immediately</span>
                    </div>
                    <button type="button" class="eh-chatbot-start" id="ehChatbotStart" aria-label="Start chat">
                        <svg viewBox="0 0 24 24">
                            <path d="M5 12h14"></path>
                            <path d="M13 6l6 6-6 6"></path>
                        </svg>
                    </button>
                </div>

                <div class="eh-chatbot-tabs">
                    <button type="button" class="eh-chatbot-tab active" id="ehChatbotHomeTab">
                        <svg viewBox="0 0 24 24">
                            <path d="M4 10.5L12 4l8 6.5V20a1 1 0 0 1-1 1h-4.5v-6h-5v6H5a1 1 0 0 1-1-1z"></path>
                        </svg>
                        <span>Home</span>
                    </button>
                    <button type="button" class="eh-chatbot-tab" id="ehChatbotChatTab">
                        <svg viewBox="0 0 24 24">
                            <path d="M5 6.5A2.5 2.5 0 0 1 7.5 4h9A2.5 2.5 0 0 1 19 6.5v7A2.5 2.5 0 0 1 16.5 16H9l-4 4v-13.5z"></path>
                        </svg>
                        <span>Chat</span>
                    </button>
                </div>

            </div>

            <div class="eh-chatbot-chat is-hidden" id="ehChatbotChat">
                <div class="eh-chatbot-chatbar">
                    <button type="button" class="eh-chatbot-icon-btn" id="ehChatbotBack" aria-label="Back to home">
                        <svg viewBox="0 0 24 24">
                            <path d="M15 18l-6-6 6-6"></path>
                        </svg>
                    </button>

                    <div class="eh-chatbot-chat-title">
                        <div class="eh-chatbot-avatar" aria-hidden="true"></div>
                        <strong>Hi there 👋</strong>
                    </div>

                </div>

                <div class="eh-chatbot-chat-scroll" id="ehChatbotMessages">
                    <div class="eh-chatbot-intro is-compact">
                        Hi! Welcome to Executor Hub.
                    </div>

                    <div class="eh-chatbot-intro">
                        I’m here to help with any questions you may have about wills, trusts, LPAs, and estate planning. How can I assist you today
                    </div>

                    <div class="eh-chatbot-option-card" id="ehChatbotOptions">
                        <h4>Choose Options</h4>
                        <button type="button" class="eh-chatbot-option" data-question="What is Executor Hub and how does it help?">
                            What is Executor Hub and how does it help?
                        </button>
                        <button type="button" class="eh-chatbot-option" data-question="How much does Executor Hub cost?">
                            How much does Executor Hub cost?
                        </button>
                        <button type="button" class="eh-chatbot-option" data-question="What does an executor do, and do I need probate?">
                            What does an executor do, and do I need probate?
                        </button>
                    </div>
                </div>

                <div class="eh-chatbot-compose">
                    <form class="eh-chatbot-form" id="ehChatbotForm">
                        <input class="eh-chatbot-input" id="ehChatbotInput" type="text" maxlength="1000" autocomplete="off" placeholder="Enter your message..." />
                        <button class="eh-chatbot-send" id="ehChatbotSend" type="submit" aria-label="Send message">
                            <svg viewBox="0 0 24 24">
                                <path d="M4 20l16-8L4 4l3 8-3 8z"></path>
                            </svg>
                        </button>
                    </form>

                    <div class="eh-chatbot-compose-bottom"></div>
                </div>
            </div>
        </div>

        <button type="button" class="eh-chatbot-launcher" id="ehChatbotToggle" aria-label="Open chat">
            <svg viewBox="0 0 24 24" class="eh-chatbot-launcher-open" aria-hidden="true">
                <path d="M7 10h10"></path>
                <path d="M7 14h6"></path>
                <path d="M5 6h14a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H9l-4 3v-3H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2z"></path>
            </svg>
            <svg viewBox="0 0 24 24" class="eh-chatbot-launcher-close" id="ehChatbotToggleIcon">
                <path d="M18 6L6 18"></path>
                <path d="M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const panel = document.getElementById('ehChatbotPanel');
            const toggle = document.getElementById('ehChatbotToggle');
            const toggleIcon = document.getElementById('ehChatbotToggleIcon');
            const home = document.getElementById('ehChatbotHome');
            const chat = document.getElementById('ehChatbotChat');
            const start = document.getElementById('ehChatbotStart');
            const back = document.getElementById('ehChatbotBack');
            const homeTab = document.getElementById('ehChatbotHomeTab');
            const chatTab = document.getElementById('ehChatbotChatTab');
            const form = document.getElementById('ehChatbotForm');
            const input = document.getElementById('ehChatbotInput');
            const send = document.getElementById('ehChatbotSend');
            const messages = document.getElementById('ehChatbotMessages');
            const options = document.getElementById('ehChatbotOptions');
            let isSending = false;

            function setLauncherIcon(open) {
                toggle.classList.toggle('is-open', open);
                toggle.setAttribute('aria-label', open ? 'Close chat' : 'Open chat');
            }

            function openPanel() {
                panel.classList.add('is-open');
                setLauncherIcon(true);
            }

            function closePanel() {
                panel.classList.remove('is-open');
                setLauncherIcon(false);
            }

            function showHome() {
                chat.classList.add('is-hidden');
                home.classList.remove('is-hidden');
                homeTab.classList.add('active');
                chatTab.classList.remove('active');
            }

            function showChat() {
                home.classList.add('is-hidden');
                chat.classList.remove('is-hidden');
                homeTab.classList.remove('active');
                chatTab.classList.add('active');
                requestAnimationFrame(function () {
                    input.focus();
                    messages.scrollTop = messages.scrollHeight;
                });
            }

            function addMessage(role, text) {
                const message = document.createElement('div');
                message.className = 'eh-chatbot-message ' + role;
                message.textContent = text;
                messages.appendChild(message);
                messages.scrollTop = messages.scrollHeight;
                return message;
            }

            function updateSendState() {
                send.classList.toggle('is-ready', input.value.trim().length > 0 && !isSending);
            }

            async function askQuestion(question) {
                if (!question || isSending) {
                    return;
                }

                isSending = true;
                updateSendState();
                showChat();

                if (options) {
                    options.style.display = 'none';
                }

                addMessage('user', question);
                const loading = addMessage('assistant', 'Typing...');

                try {
                    const response = await fetch('{{ route('knowledge_chat.ask') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ message: question })
                    });

                    const data = await response.json();
                    loading.textContent = data.message || 'I could not answer that right now.';
                } catch (error) {
                    loading.textContent = 'I could not answer that right now. Please try again in a moment.';
                } finally {
                    isSending = false;
                    updateSendState();
                    input.focus();
                }
            }

            toggle.addEventListener('click', function () {
                panel.classList.contains('is-open') ? closePanel() : openPanel();
            });

            start.addEventListener('click', function () {
                openPanel();
                showChat();
            });

            back.addEventListener('click', showHome);
            chatTab.addEventListener('click', function () {
                openPanel();
                showChat();
            });
            homeTab.addEventListener('click', showHome);

            form.addEventListener('submit', function (event) {
                event.preventDefault();

                const question = input.value.trim();
                if (!question) {
                    return;
                }

                input.value = '';
                updateSendState();
                askQuestion(question);
            });

            input.addEventListener('input', updateSendState);

            document.querySelectorAll('.eh-chatbot-option').forEach(function (button) {
                button.addEventListener('click', function () {
                    askQuestion(button.getAttribute('data-question'));
                });
            });

            closePanel();
            showHome();
            updateSendState();
        });
    </script>
@endonce


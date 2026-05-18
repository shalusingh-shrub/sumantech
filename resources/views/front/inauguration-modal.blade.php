@if(!empty($activeInauguration))
    <div
        id="inaugurationModal"
        class="inauguration-modal"
        data-event-id="{{ $activeInauguration->id }}"
        data-verify-url="{{ route('inauguration.verify', $activeInauguration) }}"
        data-applause-url="{{ asset('assets/audio/applause.mp3') }}"
        role="dialog"
        aria-modal="true"
        aria-labelledby="inaugurationTitle"
    >
        <canvas id="inaugurationConfetti" class="inauguration-confetti" aria-hidden="true"></canvas>
        <div class="inauguration-dialog position-{{ $activeInauguration->message_position ?? 'middle' }} align-{{ $activeInauguration->content_align ?? 'center' }}">
            <img src="{{ $activeInauguration->posterUrl() }}" alt="{{ $activeInauguration->title ?: 'Inauguration poster' }}" class="inauguration-poster">
            <div class="inauguration-content">
                <div class="inauguration-copy">
                    <h2 id="inaugurationTitle">{{ $activeInauguration->title ?: 'Website Inauguration' }}</h2>
                    <p>{{ $activeInauguration->message }}</p>
                    <div class="inauguration-launch">
                        <div class="launch-label">Inaugurate Now</div>
                        <form id="inaugurationForm" autocomplete="off">
                            <input type="password" id="inaugurationPassword" class="form-control" placeholder="Enter inauguration password" required>
                            <button type="submit" class="btn btn-success">Launch</button>
                        </form>
                        <div id="inaugurationError" class="inauguration-error" aria-live="polite"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        body.inauguration-locked { overflow: hidden; }
        .inauguration-modal {
            position: fixed;
            inset: 0;
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background: rgba(8, 20, 32, 0.82);
            backdrop-filter: blur(8px);
        }
        .inauguration-modal.is-hidden { display: none; }
        .inauguration-modal.is-celebrating {
            pointer-events: none;
            background: transparent;
            backdrop-filter: none;
        }
        .inauguration-modal.is-celebrating .inauguration-dialog { display: none; }
        .inauguration-dialog {
            position: relative;
            z-index: 2;
            width: min(920px, 100%);
            height: min(760px, calc(100vh - 48px));
            min-height: 520px;
            overflow: hidden;
            border-radius: 8px;
            background: #0f172a;
            box-shadow: 0 28px 80px rgba(0, 0, 0, 0.35);
        }
        .inauguration-poster {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .inauguration-content {
            position: relative;
            z-index: 2;
            width: 100%;
            height: 100%;
            display: flex;
            padding: 32px;
            overflow: hidden;
        }
        .inauguration-dialog.position-top .inauguration-content { align-items: flex-start; }
        .inauguration-dialog.position-middle .inauguration-content { align-items: center; }
        .inauguration-dialog.position-bottom .inauguration-content { align-items: flex-end; }
        .inauguration-dialog.align-left .inauguration-content { justify-content: flex-start; text-align: left; }
        .inauguration-dialog.align-center .inauguration-content { justify-content: center; text-align: center; }
        .inauguration-dialog.align-right .inauguration-content { justify-content: flex-end; text-align: right; }
        .inauguration-copy {
            width: min(540px, 100%);
            max-height: 100%;
            overflow: auto;
            padding: 24px;
            border-radius: 8px;
            color: #fff;
            background: rgba(4, 18, 30, 0.44);
            backdrop-filter: blur(3px);
        }
        .inauguration-copy h2 {
            margin: 0 0 14px;
            color: #fff;
            font-size: 2rem;
            line-height: 1.2;
            letter-spacing: 0;
            text-shadow: 0 2px 14px rgba(0, 0, 0, 0.5);
        }
        .inauguration-copy p {
            margin: 0;
            color: #f8fafc;
            line-height: 1.7;
            white-space: pre-line;
            text-shadow: 0 1px 10px rgba(0, 0, 0, 0.55);
        }
        .inauguration-launch { margin-top: 24px; }
        .launch-label {
            margin-bottom: 10px;
            color: #fff;
            font-weight: 800;
            text-shadow: 0 1px 10px rgba(0, 0, 0, 0.55);
        }
        #inaugurationForm {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 10px;
        }
        .align-center #inaugurationForm { margin-inline: auto; }
        .align-right #inaugurationForm { margin-left: auto; }
        .inauguration-error {
            min-height: 22px;
            margin-top: 8px;
            color: #fecaca;
            font-size: 0.92rem;
            font-weight: 600;
            text-shadow: 0 1px 8px rgba(0, 0, 0, 0.65);
        }
        .inauguration-confetti {
            position: fixed;
            inset: 0;
            z-index: 1;
            pointer-events: none;
        }
        @media (max-width: 767.98px) {
            .inauguration-modal {
                align-items: flex-start;
                padding: 12px;
                overflow: auto;
            }
            .inauguration-dialog {
                width: 100%;
                height: calc(100vh - 24px);
                min-height: 560px;
            }
            .inauguration-content { padding: 16px; }
            .inauguration-copy { padding: 18px; }
            .inauguration-copy h2 { font-size: 1.45rem; }
            #inaugurationForm { grid-template-columns: 1fr; }
        }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = document.getElementById('inaugurationModal');
        if (!modal) return;

        var eventId = modal.dataset.eventId;
        var storageKey = 'inauguration.completed.' + eventId;

        if (window.sessionStorage && sessionStorage.getItem(storageKey) === '1') {
            modal.classList.add('is-hidden');
            return;
        }

        var form = document.getElementById('inaugurationForm');
        var password = document.getElementById('inaugurationPassword');
        var error = document.getElementById('inaugurationError');
        var button = form.querySelector('button[type="submit"]');

        document.body.classList.add('inauguration-locked');
        setTimeout(function () { password.focus(); }, 120);

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            error.textContent = '';
            button.disabled = true;
            button.textContent = 'Launching...';

            fetch(modal.dataset.verifyUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ password: password.value })
            })
                .then(function (response) {
                    return response.json().then(function (data) {
                        if (!response.ok) throw data;
                        return data;
                    });
                })
                .then(function () {
                    if (window.sessionStorage) {
                        sessionStorage.setItem(storageKey, '1');
                    }

                    modal.classList.add('is-celebrating');
                    document.body.classList.remove('inauguration-locked');
                    playInaugurationApplause(function (duration) {
                        runInaugurationConfetti(duration);

                        setTimeout(function () {
                            modal.classList.add('is-hidden');
                        }, duration);
                    });
                })
                .catch(function (data) {
                    error.textContent = data.message || 'Please enter the correct password.';
                    password.select();
                })
                .finally(function () {
                    button.disabled = false;
                    button.textContent = 'Launch';
                });
        });

        function playInaugurationApplause(onReady) {
            var duration = 25000;
            var audio = new Audio(modal.dataset.applauseUrl);
            var started = false;

            audio.preload = 'auto';
            audio.volume = 1;

            function start() {
                if (started) return;
                started = true;
                onReady(duration);
            }

            audio.addEventListener('playing', start, { once: true });
            audio.addEventListener('error', start, { once: true });

            var playPromise = audio.play();
            if (playPromise && typeof playPromise.catch === 'function') {
                playPromise.catch(start);
            }

            setTimeout(start, 800);
        }

        function runInaugurationConfetti(duration) {
            var canvas = document.getElementById('inaugurationConfetti');
            var ctx = canvas.getContext('2d');
            var colors = ['#f97316', '#22c55e', '#0ea5e9', '#facc15', '#ec4899', '#ffffff'];
            var pieces = [];
            var startedAt = performance.now();

            function resize() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            }

            resize();
            window.addEventListener('resize', resize, { once: true });

            for (var i = 0; i < 180; i++) {
                pieces.push({
                    x: Math.random() * canvas.width,
                    y: -20 - Math.random() * canvas.height * 0.4,
                    r: 4 + Math.random() * 7,
                    c: colors[Math.floor(Math.random() * colors.length)],
                    vx: -3 + Math.random() * 6,
                    vy: 4 + Math.random() * 7,
                    spin: Math.random() * 8
                });
            }

            function frame(now) {
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                pieces.forEach(function (piece) {
                    piece.x += piece.vx;
                    piece.y += piece.vy;
                    piece.vy += 0.05;

                    if (piece.y > canvas.height + 30) {
                        piece.x = Math.random() * canvas.width;
                        piece.y = -30 - Math.random() * 120;
                        piece.vx = -3 + Math.random() * 6;
                        piece.vy = 4 + Math.random() * 7;
                    }

                    ctx.save();
                    ctx.translate(piece.x, piece.y);
                    ctx.rotate((now / 1000) * piece.spin);
                    ctx.fillStyle = piece.c;
                    ctx.fillRect(-piece.r / 2, -piece.r / 2, piece.r, piece.r * 1.6);
                    ctx.restore();
                });

                if (now - startedAt < duration) {
                    requestAnimationFrame(frame);
                } else {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                }
            }

            requestAnimationFrame(frame);
        }
    });
    </script>
@endif

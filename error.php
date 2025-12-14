<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/icons/thumbnail.png" type="image/png">
    <title>Galaxy Explorer - Access Denied</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        .astronot {
            position: absolute;
            left: 78vw;
            top: 68vh;
            width: 60px;
            z-index: 100;
            opacity: 0.7;
            animation: astronot-float-circle 8s linear infinite;
            pointer-events: none;
            filter: drop-shadow(0 4px 16px #0008);
            filter: blur(1px);
            transition: opacity 1s;
        }

        @keyframes astronot-float-circle {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            8% {
                transform: translate(8px, 12px) scale(1.01);
            }

            16% {
                transform: translate(16px, 20px) scale(1.02);
            }

            25% {
                transform: translate(24px, 24px) scale(1.03);
            }

            33% {
                transform: translate(32px, 20px) scale(1.04);
            }

            41% {
                transform: translate(38px, 12px) scale(1.05);
            }

            50% {
                transform: translate(40px, 0px) scale(1.06);
            }

            58% {
                transform: translate(38px, -12px) scale(1.05);
            }

            66% {
                transform: translate(32px, -20px) scale(1.04);
            }

            75% {
                transform: translate(24px, -24px) scale(1.03);
            }

            83% {
                transform: translate(16px, -20px) scale(1.02);
            }

            91% {
                transform: translate(8px, -12px) scale(1.01);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        @keyframes astronot-fade {
            0% {
                opacity: 0.8;
            }

            90% {
                opacity: 0.8;
            }

            100% {
                opacity: 0;
            }
        }

        .asteroid {
            position: absolute;
            top: 20%;
            left: -200px;
            width: 300px;
            z-index: 30;
            animation: asteroid-float 25s linear infinite, asteroid-spin 2.5s linear infinite;
            pointer-events: auto;
            cursor: pointer;
        }

        @keyframes asteroid-float {
            0% {
                left: -200px;
                top: 20%;
            }

            60% {
                top: 30%;
            }

            100% {
                left: 110vw;
                top: 35%;
            }
        }

        @keyframes asteroid-spin {
            0% {
                transform: rotate(0deg) scale(1);
            }

            100% {
                transform: rotate(360deg) scale(1);
            }
        }

        h1.title.inner-shadow {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            z-index: 20;
            text-align: center;
            font-size: 50px;
        }

        .subtitle.inner-shadow {
            position: absolute;
            left: 50%;
            top: calc(50% + 60px);
            transform: translateX(-50%);
            z-index: 20;
            font-size: 18px;
            white-space: nowrap;
        }

        .btn-go-back {
            position: absolute;
            left: 50%;
            bottom: 6vh;
            transform: translateX(-50%);
            z-index: 120;
            display: inline-block;
            padding: 16px 40px;
            font-size: 18px;
            color: #000;
            text-decoration: none;
            letter-spacing: 0.5px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.25);
            border-radius: 50px;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            cursor: pointer;
            transition: all 0.4s ease;
            font-family: 'Star Jedi', sans-serif;
        }

        .btn-go-back:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: #fff;
            box-shadow:
                0 0 40px #c3770c,
                0 12px 40px rgba(0, 0, 0, 0.5);
            text-shadow: 0 0 20px #c3770c;
        }
    </style>
</head>

<body>
    <div class="container login-page">
        <div class="bg"></div>

        <img src="assets/images/bg/planet1.webp" class="planet planet1">
        <img src="assets/images/bg/planet4.webp" class="planet planet4">
        <img src="assets/images/bg/planet2.webp" class="planet planet2">
        <img src="assets/images/bg/planet3.webp" class="planet planet3">

        <h1 class="title inner-shadow">Access Denied</h1>
        <p class="subtitle inner-shadow">Please make sure you are logged in with the correct account.</p>
        <a href="index.php" class="btn-go-back inner-shadow">Back to Home</a>
    </div>

    <img src="assets/images/astronot.webp" class="astronot">
    <img src="assets/images/comet.png" class="asteroid">
</body>
<script>
    function randomAsteroidPath(asteroid) {
        const topStart = Math.floor(Math.random() * 60);
        const topMid = topStart + Math.floor(Math.random() * 20) + 10;
        const topEnd = topMid + Math.floor(Math.random() * 20) + 5;
        const leftStart = -200;
        const leftEnd = 110;
        const keyframesName = 'asteroid-float-' + Math.floor(Math.random() * 1000000);
        const styleTag = document.createElement('style');
        styleTag.innerHTML = `@keyframes ${keyframesName} {\n`
            + `0% { left: ${leftStart}px; top: ${topStart}%; }\n`
            + `60% { top: ${topMid}%; }\n`
            + `100% { left: ${leftEnd}vw; top: ${topEnd}%; }\n`
            + `}`;
        document.head.appendChild(styleTag);
        asteroid.style.animation = `${keyframesName} 25s linear infinite, asteroid-spin 2.5s linear infinite`;
        setTimeout(() => { styleTag.remove(); }, 30000);
    }
    function randomAsteroidPath(asteroid) {
        const cs = getComputedStyle(asteroid);
        let currentLeft = parseFloat(cs.left);
        let currentTop = parseFloat(cs.top);
        if (Number.isNaN(currentLeft) || Number.isNaN(currentTop)) {
            const rect = asteroid.getBoundingClientRect();
            currentLeft = rect.left + window.scrollX;
            currentTop = rect.top + window.scrollY;
        }

        asteroid.style.left = currentLeft + 'px';
        asteroid.style.top = currentTop + 'px';
        asteroid.style.setProperty('animation', 'asteroid-spin 2.5s linear infinite', 'important');

        if (asteroid._moveAnim) {
            try { asteroid._moveAnim.cancel(); } catch (e) { }
        }

        const vw = window.innerWidth;
        const vh = window.innerHeight;
        const goRight = Math.random() < 0.5;
        const endLeft = goRight ? vw + 220 : -300;
        const deltaTop = (Math.random() * 0.4 - 0.2) * vh;
        const endTop = clamp(currentTop + deltaTop, 0.05 * vh, 0.95 * vh);
        const midLeft = (currentLeft + endLeft) / 2 + (Math.random() * 100 - 50);
        const midTop = (currentTop + endTop) / 2 + (Math.random() * 80 - 40);
        const duration = 20000 + Math.random() * 15000;

        const keyframes = [
            { left: currentLeft + 'px', top: currentTop + 'px', offset: 0 },
            { left: midLeft + 'px', top: midTop + 'px', offset: 0.5 },
            { left: endLeft + 'px', top: endTop + 'px', offset: 1 }
        ];
        const anim = asteroid.animate(keyframes, {
            duration,
            easing: 'linear',
            iterations: 1,
            fill: 'forwards'
        });
        asteroid._moveAnim = anim;
    }

    function clamp(v, min, max) { return Math.min(Math.max(v, min), max); }

    document.addEventListener('DOMContentLoaded', function () {
        const asteroid = document.querySelector('.asteroid');
        if (asteroid) {
            asteroid.style.cursor = 'pointer';
            const handler = function (e) {
                e.preventDefault();
                e.stopPropagation();
                randomAsteroidPath(asteroid);
            };
            asteroid.addEventListener('pointerdown', handler);
            asteroid.addEventListener('touchstart', handler, { passive: false });
            asteroid.addEventListener('click', handler);
        }
    });
</script>

</html>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>註冊成功</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .success-icon {
            color: #4CAF50;
            font-size: 48px;
            margin-bottom: 20px;
        }
        .message {
            color: #333;
            margin-bottom: 30px;
        }
        .countdown {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 20px;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .success-check {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            border-radius: 50%;
            background-color: #4CAF50;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .success-check::after {
            content: '✓';
            font-size: 50px;
            color: white;
        }
        .animate {
            animation: fadeInUp 0.5s ease-out;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-check animate"></div>
        <h2 class="animate">註冊成功！</h2>
        <div class="message animate">
            <p>您的帳戶已經成功創建。</p>
            <p>感謝您的註冊！</p>
        </div>
        <div class="countdown animate">
            <p>頁面將在 <span id="timer">5</span> 秒後自動跳轉到登入頁面</p>
        </div>
        <div class="animate">
            <a href="index.html" class="btn">立即登入</a>
        </div>
    </div>

    <script>
        // 倒數計時
        let timeLeft = 5;
        const timerElement = document.getElementById('timer');
        
        const countdownTimer = setInterval(() => {
            timeLeft--;
            timerElement.textContent = timeLeft;
            
            if (timeLeft <= 0) {
                clearInterval(countdownTimer);
                window.location.href = 'index.html';
            }
        }, 1000);

        // 添加動畫效果
        const elements = document.querySelectorAll('.animate');
        elements.forEach((element, index) => {
            element.style.animationDelay = `${index * 0.2}s`;
        });
    </script>
</body>
</html>
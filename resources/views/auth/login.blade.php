<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            display: flex;
            height: 100vh;
        }
        .left {
            flex: 1;
            background-color: #A8BCA1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-align: center;
            padding: 40px;
        }
        .left h1 {
            font-size: 36px;
            margin-bottom: 10px;
        }
        .left p {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .left button {
            padding: 12px 24px;
            background-color: #fff;
            color: #6B8F71;
            border: none;
            border-radius: 25px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }
        .left button:hover {
            background-color: #f1f1f1;
        }
        .right {
            flex: 1;
            background-color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .form-box {
            width: 80%;
            max-width: 350px;
        }
        /* Tiêu đề đăng nhập */
        h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 32px;
            font-weight: bold;
            color: #1b6928;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        /* Ô nhập liệu */
        input {
            width: 100%;
            padding: 14px;         
            font-size: 16px;       
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 10px;  
            transition: border-color 0.3s;
            box-sizing: border-box; 
        }
        input:focus {
            border-color: #A8BCA1; 
            outline: none;
        }
        button {
            width: 100%;
            padding: 16px;
            font-size: 18px;
            background-color: #6B8F71;
            color: #fff;
            border: none;
            border-radius: 30px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background-color: #557A5E;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #888; 
            text-decoration: none;
            font-size: 13px; 
        }
        a b {
            color: #6B8F71; 
        }
        a:hover b {
            text-decoration: underline;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }

        .invalid-feedback {
            color: #d9534f;
            font-size: 12px;
            margin-top: -10px;
            margin-bottom: 10px;
            display: block;
        }
        
        input.is-invalid {
            border-color: #d9534f;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="left">
            <h1>BerryNice</h1>
            <p>Một phút đặt lịch, cả ngày thư thái"</p>
            <button>Khám phá ngay</button>
        </div>
        <div class="right">
            <div class="form-box">
                <h2>Đăng nhập</h2>

                @if(session('error'))
                    <p class="error">{{ session('error') }}</p>
                @endif

                <form method="POST" action="/login">
                    @csrf

                    <label>Email:</label>
                    <input type="email" name="email" value="{{ old('email') }}" 
                        class="{{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="Nhập email của bạn">
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror

                    <label>Mật khẩu:</label>
                    <input type="password" name="password" 
                        class="{{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="Nhập mật khẩu">
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror

                    <button type="submit">Đăng nhập</button>
                </form>
                
                <a href="/register">Chưa có tài khoản? <b>Đăng ký ngay</b></a>
            </div>
        </div>
    </div>

</body>
</html>
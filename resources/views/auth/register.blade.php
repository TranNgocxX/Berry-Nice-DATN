<!DOCTYPE html>
<html>
<head>
    <title>Đăng ký</title>
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
            max-width: 400px;
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 32px;
            font-weight: bold;
            color: #1b6928;
        }
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
        <p>Đăng ký ngay để trải nghiệm dịch vụ tiện lợi, nhanh chóng và thư giãn mỗi ngày</p>
        <button>Khám phá thêm</button>
    </div>
    <div class="right">
        <div class="form-box">
            <h2>Tạo tài khoản mới</h2>
            <form method="POST" action="/register">
                @csrf
                
                <input name="name" value="{{ old('name') }}" class="{{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="Họ tên">
                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror

                <input name="email" type="email" value="{{ old('email') }}" class="{{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="Email">
                @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror

                <input name="password" type="password" class="{{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="Mật khẩu">
                @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror

                <input name="password_confirmation" type="password" placeholder="Nhập lại mật khẩu">
                
                <button type="submit">Đăng ký</button>
            </form>
            <a href="/login">Đã có tài khoản? <b>Đăng nhập ngay</b></a>
        </div>
    </div>
</div>

</body>
</html>

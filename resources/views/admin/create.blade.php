<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Admin - SDA Church Management</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 48px 40px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.4);
        }

        .logo {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #4f8ef7, #7366ff);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            box-shadow: 0 8px 24px rgba(79,142,247,0.4);
        }

        .logo-icon svg {
            width: 32px;
            height: 32px;
            fill: white;
        }

        h1 {
            color: #ffffff;
            font-size: 1.8rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 6px;
        }

        .subtitle {
            color: rgba(255,255,255,0.5);
            text-align: center;
            font-size: 0.9rem;
            margin-bottom: 36px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .name-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        label {
            display: block;
            color: rgba(255,255,255,0.7);
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 8px;
            letter-spacing: 0.02em;
        }

        input {
            width: 100%;
            padding: 12px 16px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 10px;
            color: #ffffff;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            outline: none;
        }

        input:focus {
            border-color: #4f8ef7;
            background: rgba(79,142,247,0.1);
            box-shadow: 0 0 0 3px rgba(79,142,247,0.15);
        }

        input::placeholder {
            color: rgba(255,255,255,0.25);
        }

        .error-message {
            color: #ff6b6b;
            font-size: 0.8rem;
            margin-top: 5px;
        }

        .btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #4f8ef7, #7366ff);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 12px;
            transition: all 0.2s ease;
            letter-spacing: 0.03em;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79,142,247,0.5);
        }

        .btn:active {
            transform: translateY(0);
        }

        .alert-success {
            background: rgba(72,199,142,0.15);
            border: 1px solid rgba(72,199,142,0.3);
            color: #48c78e;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .alert-error {
            background: rgba(255,107,107,0.15);
            border: 1px solid rgba(255,107,107,0.3);
            color: #ff6b6b;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<div class="card">
    <div class="logo">
        <div class="logo-icon">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z"/>
            </svg>
        </div>
        <h1>Create Admin</h1>
        <p class="subtitle">SDA Church Management System</p>
    </div>

    @if (session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert-error">
            <ul style="list-style: none;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.store') }}">
        @csrf

        <div class="name-row">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input
                    type="text"
                    id="first_name"
                    name="first_name"
                    placeholder="John"
                    value="{{ old('first_name') }}"
                    required
                    autofocus
                />
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input
                    type="text"
                    id="last_name"
                    name="last_name"
                    placeholder="Smith"
                    value="{{ old('last_name') }}"
                    required
                />
            </div>
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input
                type="text"
                id="username"
                name="username"
                placeholder="admin_user"
                value="{{ old('username') }}"
                required
            />
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input
                type="email"
                id="email"
                name="email"
                placeholder="admin@sdachurch.com"
                value="{{ old('email') }}"
                required
            />
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="••••••••"
                required
            />
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                placeholder="••••••••"
                required
            />
        </div>

        <button type="submit" class="btn">Create Admin Account</button>
    </form>
</div>

</body>
</html>

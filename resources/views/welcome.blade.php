 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('images/background1.png');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Arial', sans-serif;
            margin: 0;
        }
        .container {
            display: flex;
            max-width: 800px;
            width: 100%;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .form-section, .advertisement {
            flex: 1;
            padding: 2rem;
            box-sizing: border-box;
        }
        .form-section {
            border-right: 1px solid #ddd;
            text-align: center;
        }
        .form-section h2 {
            margin-bottom: 1.25rem;
            font-size: 24px;
            color: #333;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #555;
            font-weight: 600;
        }
        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-group input:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            outline: none;
        }
        .btn {
            width: 100%;
            padding: 0.75rem;
            border: none;
            border-radius: 8px;
            background: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.3s ease;
        }
        .btn:hover {
            background: #0056b3;
            transform: scale(1.02);
        }
        .btn:focus {
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        .forgot-password {
            text-align: right;
            margin-top: 0.5rem;
        }
        .forgot-password a {
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .forgot-password a:hover {
            color: #0056b3;
        }
        .advertisement {
            background: #f9f9f9;
            border-left: 1px solid #ddd;
            color: #333;
            font-size: 14px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 50%; /* Adjust width as needed */
        }
        .advertisement img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 1rem;
        }
        .footer {
            text-align: center;
            margin-top: 1.25rem;
            font-size: 12px;
            color: #888;
        }
        .footer a {
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .footer a:hover {
            color: #0056b3;
        }
        header {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: linear-gradient(to right, #006400, #32CD32);
            color: white;
            border-bottom: 3px solid #004d00;
        }

        header img {
            height: 60px;
            margin-top: -150px;
        }

        header h1 {
            font-size: 2em;
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

<div class="container" style="background-image: url('images/background_image.png');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;">

    <div class="form-section">
        <h2>Login</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <label for="email">{{ __('Email') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                @error('email')
                <div class="mt-2 text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group mt-4">
                <label for="password">{{ __('Password') }}</label>
                <input id="password" type="password" name="password" required autocomplete="current-password">
                @error('password')
                <div class="mt-2 text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <div class="form-group">
                <button type="submit" class="btn">
                    {{ __('Log in') }}
                </button>
            </div>
        </form>
        <div class="form-group">
            <p>Don't have an account? <a href="{{ route('register') }}" style="color: #007bff;">Register here</a></p>
        </div>


        <div class="footer">
            <p>&copy; <span id="currentYear"></span> Phage Pharmacy. All rights reserved.</p>
        </div>
    </div>
    <div class="advertisement" style="background-image: url('images/background_image.png');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;">
        <img id="adImage" src="" alt="Advertisement">
        <strong><p id="adMessage">Loading advertisement...</p></strong>
    </div>
</div>

<script>
    const advertisements = [
        {
            message: "Your work saves lives!",
            image: "images/background.png"
        },
        {
            message: "Health start with you.",
            image: "images/background.png"
        },
        {
            message: "Precision, Care, Impact.",
            image: "images/background.png"
        },
        {
            message: "Care beyond prescriptions!",
            image: "images/background.png"
        },
    ];

    let currentIndex = 0;

    function showAdvertisement(index) {
        const ad = advertisements[index];
        document.getElementById('adImage').src = ad.image;
        document.getElementById('adMessage').textContent = ad.message;
    }

    function nextAdvertisement() {
        currentIndex = (currentIndex + 1) % advertisements.length;
        showAdvertisement(currentIndex);
    }

    // Initialize the first advertisement
    showAdvertisement(currentIndex);

    // Change advertisement every 5 seconds
    setInterval(nextAdvertisement, 5000);

    // Set the current year in the footer
    document.getElementById('currentYear').textContent = new Date().getFullYear();
</script>
</body>
</html>


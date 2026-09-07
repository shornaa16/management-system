<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f1f3f6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            margin: 0;
        }

        .login-card {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 480px;
            padding: 35px 30px 25px 30px;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-label {
            font-size: 0.88rem;
            font-weight: 500;
            color: #4a5568;
            margin-bottom: 6px;
        }

        .form-control {
            padding: 9px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-size: 0.95rem;
            background-color: #fff;
        }

        .form-control:focus {
            border-color: #7c3aed;
            box-shadow: 0 0 0 1px #7c3aed;
            outline: none;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            border-radius: 4px;
            border: 1px solid #cbd5e1;
            margin-top: 0;
        }

        .form-check-label {
            font-size: 0.88rem;
            color: #64748b;
            margin-left: 6px;
        }

        .forgot-link {
            color: #475569;
            text-decoration: underline;
            font-size: 0.88rem;
            font-weight: 500;
        }

        .forgot-link:hover {
            color: #1e293b;
        }

        .btn-login {
            background-color: #6d28d9;
            border: none;
            color: #ffffff;
            font-weight: 700;
            padding: 8px 22px;
            border-radius: 6px;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }

        .btn-login:hover {
            background-color: #5b21b6;
            color: #ffffff;
        }
    </style>
</head>
<body>

<div class="d-flex flex-column align-items-center w-100 px-3">
    <!-- Circle Logo -->
    <div class="logo-container">
        <svg width="75" height="75" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="50" cy="50" r="45" stroke="#333333" stroke-width="2.5" fill="none"/>
            <circle cx="50" cy="50" r="36" stroke="#333333" stroke-width="1.5" stroke-dasharray="5 3" fill="none"/>
            <text x="50%" y="42%" dominant-baseline="middle" text-anchor="middle" font-size="9" font-weight="600" fill="#333333" letter-spacing="1">YOUR</text>
            <text x="50%" y="54%" dominant-baseline="middle" text-anchor="middle" font-size="12" font-weight="bold" fill="#333333" letter-spacing="1">LOGO</text>
            <text x="50%" y="65%" dominant-baseline="middle" text-anchor="middle" font-size="5.5" fill="#555555" letter-spacing="0.5">COULD BE HERE</text>
        </svg>
    </div>

    <!-- Login Card -->
    <div class="login-card">
        <form method="POST" action="<?php echo e(route('login')); ?>">
            <?php echo csrf_field(); ?>

            <div class="mb-3">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" required autofocus>
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                <input id="password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="mb-4 d-flex align-items-center">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                <label class="form-check-label" for="remember">
                    Remember me
                </label>
            </div>

            <div class="d-flex justify-content-end align-items-center gap-3 mt-2">
                <?php if(Route::has('password.request')): ?>
                    <a class="forgot-link" href="<?php echo e(route('password.request')); ?>">
                        Forgot your password?
                    </a>
                <?php endif; ?>
                <button type="submit" class="btn btn-login">
                    LOG IN
                </button>
            </div>
        </form>
    </div>
</div>

</body>
</html><?php /**PATH C:\Users\USER\Downloads\supplier-purchase-app\supplier-purchase-app\resources\views/auth/login.blade.php ENDPATH**/ ?>
@extends('layouts.admin')
@section('title', 'Crear Usuario')
@section('content')
<style>
  :root{
    --bg:#f4f6f8;
    --card:#ffffff;
    --text:#222;
    --muted:#6b7280;
    --primary:#1f4cd6;
    --primary-hover:#183db0;
    --danger:#c53030;
    --border:#e5e7eb;
    --ring:#9db3ff;
  }
  .page-wrap{max-width:760px;margin:40px auto;padding:0 16px}
  .card{
    background:var(--card);
    border:1px solid var(--border);
    border-radius:12px;
    box-shadow:0 6px 18px rgba(0,0,0,.06);
    overflow:hidden;
  }
  .card-hd{padding:18px 22px;border-bottom:1px solid var(--border);background:#fafafa}
  .card-title{margin:0;font-size:22px;color:var(--text);font-weight:700}
  .card-sub{margin:6px 0 0;color:var(--muted);font-size:14px}
  .card-bd{padding:24px 22px}
  .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:16px}
  @media (max-width:640px){.grid-2{grid-template-columns:1fr}}
  .form-field{margin-bottom:16px}
  .form-label{display:block;font-weight:600;color:#374151;margin-bottom:8px}
  .form-input{
    width:100%;height:40px;padding:8px 12px;border:1px solid var(--border);border-radius:8px;
    font-size:15px;transition:border-color .15s, box-shadow .15s, background .15s;
    background:#fff;color:var(--text);
  }
  .form-input:focus{
    outline:none;border-color:var(--primary);
    box-shadow:0 0 0 3px var(--ring);
    background:#fff;
  }
  .help{font-size:12px;color:var(--muted);margin-top:6px}
  .error{color:var(--danger);font-size:13px;margin-top:6px}
  .checkline{display:flex;align-items:center;gap:10px;margin:8px 0 4px}
  .btnrow{display:flex;justify-content:flex-end;gap:10px;margin-top:8px}
  .btn{
    display:inline-flex;align-items:center;justify-content:center;
    padding:10px 16px;border-radius:8px;border:1px solid transparent;
    font-weight:600;cursor:pointer;transition:background .15s, border-color .15s, color .15s, transform .02s;
    text-decoration:none;
  }
  .btn:active{transform:translateY(1px)}
  .btn-primary{background:var(--primary);color:#fff}
  .btn-primary:hover{background:var(--primary-hover)}
  .btn-secondary{background:#fff;color:#374151;border-color:var(--border)}
  .btn-secondary:hover{background:#f3f4f6}
  .req::after{content:" *";color:var(--danger);font-weight:700}
</style>

<div class="page-wrap">
  <div class="card">
    <div class="card-hd">
      <h1 class="card-title">Crear nuevo usuario</h1>
      <p class="card-sub">Completa los campos para registrar un usuario en el sistema.</p>
    </div>

    <div class="card-bd">
      <form method="post" action="{{ route('admin.users.store') }}" novalidate>
        @csrf

        <div class="form-field">
          <label for="name" class="form-label req">Nombre completo</label>
          <input id="name" name="name" type="text" value="{{ old('name') }}" class="form-input" placeholder="Ej. Yael Romero" autocomplete="name">
          @error('name')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="form-field">
          <label for="email" class="form-label req">Correo electrónico</label>
          <input id="email" name="email" type="email" value="{{ old('email') }}" class="form-input" placeholder="correo@ejemplo.com" autocomplete="email">
          @error('email')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="grid-2">
          <div class="form-field">
            <label for="password" class="form-label req">Contraseña</label>
            <input id="password" name="password" type="password" class="form-input" placeholder="Mínimo 8 caracteres" autocomplete="new-password">
            @error('password')<div class="error">{{ $message }}</div>@enderror
          </div>

          <div class="form-field">
            <label for="password_confirmation" class="form-label req">Confirmar contraseña</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="form-input" placeholder="Repite la contraseña" autocomplete="new-password">
          </div>
        </div>

        <div class="checkline">
          <input id="is_admin" name="is_admin" type="checkbox" value="1" {{ old('is_admin') ? 'checked' : '' }}>
          <label for="is_admin">Otorgar acceso de administrador</label>
        </div>
        <div class="help">Podrás cambiar este permiso más tarde desde la edición del usuario.</div>

        <div class="btnrow">
          <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancelar</a>
          <button type="submit" class="btn btn-primary">Guardar usuario</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

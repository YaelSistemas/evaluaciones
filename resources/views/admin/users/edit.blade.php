@extends('layouts.admin')
@section('title', 'Editar Usuario')
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
  .error{color:var(--danger);font-size:13px;margin-top:6px}
  .checkline{display:flex;align-items:center;gap:10px;margin:12px 0}
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

  /* Toggle switch */
  .switch {
    position: relative; display: inline-block;
    width: 46px; height: 24px;
  }
  .switch input {opacity: 0; width: 0; height: 0;}
  .slider {
    position: absolute; cursor: pointer;
    top: 0; left: 0; right: 0; bottom: 0;
    background-color: #ccc; transition: .3s;
    border-radius: 34px;
  }
  .slider:before {
    position: absolute; content: "";
    height: 18px; width: 18px;
    left: 3px; bottom: 3px;
    background-color: white; transition: .3s;
    border-radius: 50%;
  }
  input:checked + .slider {background-color: var(--primary);}
  input:checked + .slider:before {transform: translateX(22px);}
</style>

<div class="page-wrap">
  <div class="card">
    <div class="card-hd">
      <h1 class="card-title">Editar usuario</h1>
      <p class="card-sub">Modifica la información del usuario seleccionado.</p>
    </div>

    <div class="card-bd">
      <form method="post" action="{{ route('admin.users.update',$user) }}" novalidate>
        @csrf
        @method('PATCH')

        <div class="form-field">
          <label for="name" class="form-label">Nombre completo</label>
          <input id="name" name="name" type="text" value="{{ old('name',$user->name) }}" class="form-input">
          @error('name')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="form-field">
          <label for="email" class="form-label">Correo electrónico</label>
          <input id="email" name="email" type="email" value="{{ old('email',$user->email) }}" class="form-input">
          @error('email')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="grid-2">
          <div class="form-field">
            <label for="password" class="form-label">Nueva contraseña</label>
            <input id="password" name="password" type="password" class="form-input" placeholder="Dejar vacío si no deseas cambiarla">
            @error('password')<div class="error">{{ $message }}</div>@enderror
          </div>

          <div class="form-field">
            <label for="password_confirmation" class="form-label">Confirmar nueva contraseña</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="form-input">
          </div>
        </div>

        {{-- Toggle Usuario activo --}}
        <div class="checkline">
          <label for="is_active" class="form-label" style="margin-bottom:0">Usuario activo</label>
          <label class="switch">
            <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active',$user->is_active) ? 'checked' : '' }}>
            <span class="slider"></span>
          </label>
        </div>

        {{-- Checkbox Admin --}}
        <div class="checkline">
          <input id="is_admin" name="is_admin" type="checkbox" value="1" {{ old('is_admin',$user->is_admin) ? 'checked' : '' }}>
          <label for="is_admin">Usuario administrador</label>
        </div>

        <div class="btnrow">
          <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancelar</a>
          <button type="submit" class="btn btn-primary">Actualizar</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
